// flightplan.js
var Flightplan = require('flightplan');
var tmpDir = new Date().getTime();
var plan = new Flightplan();
var keep_releases = 5;

// INITIAL STEPS
// $ ssh-agent -a /tmp/foo
// $ export SSH_AUTH_SOCK=/tmp/foo
// $ ssh-add /path/to/private/key (~/.ssh/id_rsa)

// configuration
plan.briefing({
	debug: false,
	destinations: {
		'staging': {
			host: 'mmcstaging.com',
			username: '',
			releases: 'deployments/',
			privateKey: process.env.HOME + '/.ssh/id_rsa'
		},
		'production': {
			host: 'hostingbymmc.com',
			username: '',
			releases: 'releases',
			privateKey: process.env.HOME + '/.ssh/id_rsa'
		}
	}
});


/// DEPLOYMENT
plan.remote('deploy', function(remote) {
	var releases_directory = plan.target.hosts[0].releases;

	remote.log('Set up remote directories');
	remote.exec('mkdir -p ' + releases_directory + '/');
	remote.exec('mkdir -p ' + releases_directory + '/shared/web/app/uploads');
	remote.exec('mkdir -p ' + releases_directory + '/releases');
	remote.exec('[[ -f ' + releases_directory + '/shared/.env ]] || touch ' + releases_directory + '/shared/.env');
	remote.exec('[[ -f ' + releases_directory + '/shared/web/.htaccess ]] || touch ' + releases_directory + '/shared/web/.htaccess');
	remote.exec('[[ -f ' + releases_directory + '/current ]] || touch ' + releases_directory + '/current');
});

// run commands on localhost
plan.local('deploy', function(local) {
	local.log('Run build');
	// local.exec('ssh-agent -a /tmp/foo && export SSH_AUTH_SOCK=/tmp/foo && ssh-add ~/.ssh/id_rsa');
	local.exec('cd web/app/themes/mmc && bower install && gulp build');

	local.log('Copy files to remote hosts');
	var filesToCopy = local.exec('find . -not -iname ".*" -and -not -path ".git/" -and -not -path "*/node_modules/*" -and -not -path "*/wp/*" -and -not -path "./vendor/*" -and -not -path "*/sass/*"', {silent: true});
	// rsync files to all the destination's hosts
	local.transfer(filesToCopy, '~/' + plan.target.hosts[0].releases + '/releases/' + tmpDir);
});

// run commands on remote hosts (destinations)
plan.remote('deploy', function(remote) {
	var releases_directory = plan.target.hosts[0].releases;
	var new_release = plan.target.hosts[0].releases + '/releases/' + tmpDir;

	remote.log('Set up shared items');
	remote.exec('ln -s ~/' + releases_directory + '/shared/.env ~/' + new_release + '/.env')
	remote.exec('ln -s ~/' + releases_directory + '/shared/web/.htaccess ' + new_release + '/web/.htaccess')
	remote.exec('rm -rf ' + new_release+ '/web/app/uploads && ln -s ~/' + releases_directory + '/shared/web/app/uploads ' + new_release + '/web/app/uploads')

	remote.log('Running composer');
	remote.exec('cd ' + new_release + ' && composer install');

	remote.log('Update current symlink');
	remote.exec('rm ~/' + releases_directory + '/current && ln -s ~/' + new_release + ' ~/' + releases_directory + '/current');

	remote.log('Cleaning up past releases');
	var releases = remote.exec('ls -x ' + releases_directory + '/releases', {silent: true});
	releases = releases.stdout.replace('\n', '  ').split('  ');

	if(releases.length > keep_releases) {
		remote.exec('cd ' + releases_directory + '/releases && rm -rf ' + releases[0]);
	}
});


/// TASK FOR SYNCING REMOTE DB WITH LOCAL DB
plan.remote('db_pull', function(remote) {
	var releases_directory = plan.target.hosts[0].releases;

	remote.log('Exporting DB');
	remote.exec('cd ' + releases_directory + '/current && wp db export flightplan_db.sql');
});

plan.local('db_pull', function(local) {
	var username = plan.target.hosts[0].username;
	var host = plan.target.hosts[0].host;
	var releases_directory = plan.target.hosts[0].releases;

	local.log('Grabbing exported DB');
	local.exec('scp ' + username + '@' + host + ':' + releases_directory + '/current/flightplan_db.sql .');
	local.exec('wp db import flightplan_db.sql && rm flightplan_db.sql');
});

plan.remote('db_pull', function(remote) {
	var releases_directory = plan.target.hosts[0].releases;

	remote.log('Deleting exported DB');
	remote.exec('cd ' + releases_directory + '/current && rm flightplan_db.sql');
});


///TASK FOR SYNCING LOCAL DB WITH REMOTE DB
plan.remote('db_push', function(remote) {
	var releases_directory = plan.target.hosts[0].releases;

	remote.log('Setting up remote backup directory');
	remote.exec('mkdir -p ' + releases_directory + '/backup/db');
	remote.exec('cd ' + releases_directory + '/current && wp db export ~/' + releases_directory + '/backup/db/' + tmpDir + '.sql');

	remote.log('Cleaning up past db backups');
	var backups = remote.exec('ls -x ' + releases_directory + '/backup/db/', {silent: true});
	backups = backups.stdout.replace('\n', '  ').split('  ');

	if(backups.length > keep_releases) {
		remote.exec('cd ' + releases_directory + '/backup/db/ && rm -rf ' + backups[0]);
	}
});

plan.local('db_push', function(local) {
	var username = plan.target.hosts[0].username;
	var host = plan.target.hosts[0].host;
	var releases_directory = plan.target.hosts[0].releases;

	local.log('Exporting DB and pushing to server');
	local.exec('wp db export flightplan_db.sql && scp flightplan_db.sql ' + username + '@' + host + ':' + releases_directory + '/current');
	local.exec('rm flightplan_db.sql');
});

plan.remote('db_push', function(remote) {
	var releases_directory = plan.target.hosts[0].releases;

	remote.log('Importing DB and deleting file');
	remote.exec('cd ' + releases_directory + '/current && wp db import flightplan_db.sql && rm flightplan_db.sql');
});


/// TASK FOR SYNCING REMOTE UPLOADS WITH LOCAL UPLOADS
plan.local('uploads_pull', function(local) {
	var username = plan.target.hosts[0].username;
	var host = plan.target.hosts[0].host;
	var releases_directory = plan.target.hosts[0].releases;

	local.log('Grabbing uploaded files');
	local.exec('scp -r ' + username + '@' + host + ':' + releases_directory + '/shared/web/app/uploads/. web/app/uploads/');
});


/// TASK FOR SYNCING LOCAL UPLOADS WITH REMOTE UPLOADS
plan.remote('uploads_push', function(remote) {
	var releases_directory = plan.target.hosts[0].releases;

	remote.log('Setting up remote backup directory');
	remote.exec('mkdir -p ' + releases_directory + '/backup/uploads/' + tmpDir);
	remote.exec('cp -r ' + releases_directory + '/shared/web/app/uploads/. ' + releases_directory + '/backup/uploads/' + tmpDir);

	remote.log('Cleaning up past upload backups');
	var backups = remote.exec('ls -x ' + releases_directory + '/backup/uploads/', {silent: true});
	backups = backups.stdout.replace('\n', '  ').split('  ');

	if(backups.length > keep_releases) {
		remote.exec('cd ' + releases_directory + '/backup/uploads/ && rm -rf ' + backups[0]);
	}
});

plan.local('uploads_push', function(local) {
	var username = plan.target.hosts[0].username;
	var host = plan.target.hosts[0].host;
	var releases_directory = plan.target.hosts[0].releases;

	local.log('Uploading uploaded files');
	local.exec('scp -r web/app/uploads/. ' + username + '@' + host + ':' + releases_directory + '/shared/web/app/uploads/');
});