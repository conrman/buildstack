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

		$io->write("<info>Setting up theme</info>");
		$theme =$io->ask("<info>Which theme would you like to use?[<comment>material, mmc</comment>]</info>");
		shell_exec("wp theme activate " . $theme);

		$io->write("<info>Removing default stuff</info>");
		shell_exec("wp post delete $(wp post list --post_type='post' --format=ids)");

		$io->write("<info>Setting up wpadmin user</info>");
		shell_exec("wp user create wpadmin wpadmin@mailmmc.com --role=administrator --user_pass=happy2012");
	}

}
?>