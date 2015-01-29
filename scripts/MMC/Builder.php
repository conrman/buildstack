<?php

namespace MMC;

use Composer\Script\Event;

class Builder {


	public static function buildProject(Event $event) {
		$root = dirname(dirname(__DIR__));
		$composer = $event->getComposer();
		$io = $event->getIO();

		$io->write("<info>Restarting Apache</info>");
		shell_exec("sudo apachectl restart");

		$io->write("<info>Creating Database</info>");
		shell_exec("wp db create");

		$io->write("<info>Setting up Wordpress Core</info>");
		// Get Site URL and Title
		$site_url = $io->ask("<info>What is the Site URL?</info>[<comment>project-name.dev</comment>]");
		shell_exec("wp core install --url=$site_url --title=NewProject --admin_user=wpadmin --admin_password=happy2012 --admin_email=webadmin@mailmmc.com");

		$io->write("<info>Setting up theme</info>");
		$theme = $io->ask("<info>What theme would you like to use?</info>[<comment>mmc</comment>]", "mmc");
		shell_exec("wp theme activate $theme");

		// Run NPM
		$run_npm = $io->ask("<info>Would you like to run npm install?</info>[<comment>Y, n</comment>]", true);

		if ($run_npm) {
			$npm = shell_exec("npm install && cd web/app/themes/$theme/ && npm install");
			if ($npm) {
				// Setup Gulp
				$gulp = file_get_contents($root . "/web/app/themes/$theme/gulpfile.js");
				$gulp = str_replace('{{site_url}}', $url, $gulp);
				file_put_contents($root . "/web/app/themes/$theme/gulpfile.js", $gulp);

				// Setup Flightplan
				$flightplan = file_get_contents($root . '/flightplan.js');
				$flightplan = str_replace('{{project_acronym}}', $project_acronym, $flightplan);
				$gulp = str_replace('{{theme}}', $theme, $flightplan);
				file_put_contents($root . '/flightplan.js', $flightplan);	
			}
		}

		$io->write("<info>Removing Default WP Stuff</info>");
		shell_exec("wp post delete $(wp post list --post_type='post' --format=ids)");

		$io->write("<info>Activating Plugins</info>");
		shell_exec("wp plugin active --all && wp plugin update --all");

		$io->write("<info>Setup Default Pages</info>");
		shell_exec("wp post create --post_type=page --post_title='Home'");
		shell_exec("wp post create --post_type=page --post_title='Amenities'");
		shell_exec("wp post create --post_type=page --post_title='Floor Plans'");
		shell_exec("wp post create --post_type=page --post_title='Location'");
		shell_exec("wp post create --post_type=page --post_title='Gallery'");
		shell_exec("wp post create --post_type=page --post_title='Contact'");

		// Write script to get post id's and create menu
		// $io->write("<info>Setup Default Navigation</info>");
		// shell_exec("wp menu item add-post");

	}

}
?>