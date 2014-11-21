<?php

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

	public static function addSalts(Event $event) {
		$root = dirname(dirname(__DIR__));
		$composer = $event->getComposer();
		$io = $event->getIO();

		if (!$io->isInteractive()) {
			$generate_salts = $composer->getConfig()->get('generate-salts');
		} else {
			$generate_salts = $io->askConfirmation('<info>Generate salts and append to .env file?</info> [<comment>Y,n</comment>]? ', true);
			$project_name = $io->ask('<info>What is the name of the project? (Include hyphens) ');
			$db_name = $io->ask('<info>What is the DB Name?</info> ', 'project-name');
			$db_user = $io->ask('<info>What is the DB User?</info> ', 'root');
			$db_pass = $io->ask('<info>What is the DB Password?</info> ', '');
			$env = $io->ask('<info>What is the environment?</info> [<comment>development</comment>] ', 'development');
			$url = $io->ask('<info>What is the Site URL?</info> [<comment>project-name.dev</comment>] ', 'project-name.dev');
			$vhost_path = $io->ask('<info>What is the path of your Apache Vhost file?</info> [<comment>/etc/apache2/extra/httpd-vhosts.conf</comment>] ', '/etc/apache2/extra/httpd-vhosts.conf');
			$system_user = trim(shell_exec('whoami'));
		}

		if (!$generate_salts) {
			// return 1;
		}

		$salts = array_map(function ($key) {
			return sprintf("%s='%s'", $key, Installer::generate_salt());
		}, self::$KEYS);

		$env_file = "{$root}/.env";

		if (copy("{$root}/.env.example", $env_file)) {
			file_put_contents($env_file, implode($salts, "\n"), FILE_APPEND | LOCK_EX);
			$file = file_get_contents($env_file);

			$file = str_replace(
				array('{{db_name}}', '{{db_user}}', '{{db_password}}', '{{env}}', '{{site_url}}'),
				array($db_name, $db_user, $db_pass, $env, $url),
				$file
			);

			file_put_contents($env_file, $file);

			$vhost = file_get_contents($root . '/.vhost.example');

			$vhost = str_replace(
				array('{{site_url}}', '{{project_name}}', '{{user}}'),
				array($url, $project_name, $system_user),
				$vhost
			);

			file_put_contents($root . '/.vhost', $vhost);

			shell_exec('cat .vhost | sudo tee -a ' . $vhost_path);

		} else {
			$io->write("<error>An error occured while copying your .env file</error>");
			return 1;
		}
	}

	/**
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