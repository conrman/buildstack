<?php

namespace MMC;

use Composer\Script\Event;

class Builder {


	public static function buildProject(Event $event) {
		$root = dirname(dirname(__DIR__));
		$composer = $event->getComposer();
		$io = $event->getIO();

		$io->write("<info>Restarting Apache</info>");
		shell_exec('sudo apachectl restart');

		$io->write("<info>Creating Database</info>");
		shell_exec("wp db create");

		$io->write("<info>Installing Wordpress Core</info>");
		// Get Site URL and Title
		$site_url = $io->ask("<info>What is the Site URL?</info>[<comment>project-name.dev</comment>]");
		shell_exec("wp core install --url=$site_url --title=NewProject --admin_user=wpadmin --admin_password=happy2012 --admin_email=webadmin@mailmmc.com");

		$io->write("<info>Setting up theme</info>");
		shell_exec("wp theme activate mmc");

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