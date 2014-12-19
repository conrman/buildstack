<?php
// composer run-script post-root-package-install

namespace Bedrock;

use Composer\Script\Event;

class Installer {
	public static $KEYS = array(
	                            'AUTH_KEY',
	                            'SECURE_AUTH_KEY',
	                            'LOGGED_IN_KEY',
	                            'NONCE_KEY',
	                            'AUTH_SALT',
	                            'SECURE_AUTH_SALT',
	                            'LOGGED_IN_SALT',
	                            'NONCE_SALT'
	                            );

	public static function setupEnvironment(Event $event) {
		$root = dirname(dirname(__DIR__));
		$composer = $event->getComposer();
		$io = $event->getIO();

		if (!$io->isInteractive()) {
			$generate_salts = $composer->getConfig()->get('generate-salts');
		} else {
			$generate_salts = $io->askConfirmation('<info>Generate salts and append to .env file?</info> [<comment>Y,n</comment>]? ', true);
			$project_name = $io->ask('<info>What is the name of the project? (Include hyphens) ');
			$project_acronym = $io->ask('<info>What is the acronym of the project? ');
			$db_name = $io->ask("<info>What is the DB Name?</info>[<comment>$project_name</comment>] ", $project_name);
			$db_user = $io->ask('<info>What is the DB User?</info>[<comment>root</comment>] ', 'root');
			$db_pass = $io->ask('<info>What is the DB Password?</info> ', '');
			$env = $io->ask('<info>What is the environment?</info> [<comment>development</comment>] ', 'development');
			$url = $project_name . ".dev";
			$vhost_path = $io->ask('<info>What is the path of your Apache Vhost file?</info> [<comment>/etc/apache2/extra/httpd-vhosts.conf</comment>] ', '/etc/apache2/extra/httpd-vhosts.conf');
			$system_user = trim(shell_exec('whoami'));
		}

		$salts = array_map(function ($key) {
			return sprintf("%s='%s'", $key, Installer::generate_salt());
		}, self::$KEYS);

		$env_file = "{$root}/.env";

		if (copy("{$root}/.env.example", $env_file)) {

			// Setup .env file
			file_put_contents($env_file, implode($salts, "\n"), FILE_APPEND | LOCK_EX);
			$file = file_get_contents($env_file);
			$file = str_replace(
			                    array('{{db_name}}', '{{db_user}}', '{{db_password}}', '{{env}}', '{{site_url}}'),
			                    array($db_name, $db_user, $db_pass, $env, $url),
			                    $file
			                    );
			file_put_contents($env_file, $file);

			// Setup vhost
			$vhost = file_get_contents($root . '/.vhost.example');
			$vhost = str_replace(
			                     array('{{site_url}}', '{{project_name}}', '{{user}}'),
			                     array($url, $project_name, $system_user),
			                     $vhost
			                     );
			file_put_contents($root . '/.vhost', $vhost);
			shell_exec('cat .vhost | sudo tee -a ' . $vhost_path);

			// Setup host
			$io->write("<info>Setup host file</info>");
			$host = file_get_contents($root . '/host.txt');
			$host = str_replace('{{site_url}}', $url, $host);
			file_put_contents($root . '/.host', $host);
			shell_exec('cat .host | sudo tee -a /etc/hosts');

			// Run NPM
			$npm = shell_exec('npm install && cd web/app/themes/mmc/ && npm install');

			if ($npm) {
				// Setup Gulp
				$gulp = file_get_contents($root . '/web/app/themes/mmc/gulpfile.js');
				$gulp = str_replace('{{site_url}}', $url, $gulp);
				file_put_contents($root . '/web/app/themes/mmc/gulpfile.js', $gulp);

				// Setup Flightplan
				$flightplan = file_get_contents($root . '/flightplan.js');
				$flightplan = str_replace('{{project_acronym}}', $project_acronym, $flightplan);
				file_put_contents($root . '/flightplan.js', $flightplan);
			}

			$io->write("<info>Restarting Apache</info>");
			shell_exec('sudo apachectl restart');

			$io->write("<info>Creating Database</info>");
			shell_exec("wp db create");

			$io->write("<info>Setting up theme</info>")
			shell_exec("wp theme activate mmc");

			$io->write("<info>Removing default stuff</info>")
			shell_exec("wp post delete $(wp post list --post_type='post' --format=ids)");
			
			$io->write("<info>Removing default stuff</info>")
			shell_exec("wp post delete $(wp post list --post_type='post' --format=ids)");
			
		} else {
			$io->write("<error>An error occured while copying your .env file</error>");
			return 1;
		}
	}

	/*
	 * Slightly modified/simpler version of wp_generate_password
	 * https://github.com/WordPress/WordPress/blob/cd8cedc40d768e9e1d5a5f5a08f1bd677c804cb9/wp-includes/pluggable.php#L1575
	 */
	public static function generate_salt($length = 64) {
		$chars  = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
		$chars .= '!@#$%^&*()';
		$chars .= '-_ []{}<>~`+=,.;:/?|';

		$salt = '';
		for ($i = 0; $i < $length; $i++) {
			$salt .= substr($chars, rand(0, strlen($chars) - 1), 1);
		}

		return $salt;
	}
}
