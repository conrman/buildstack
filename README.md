# Bedrock

Bedrock is a modern WordPress stack that helps you get started with the best development tools and project structure.

# ToC

* [Quick Start](#quick-start)
* [Features](#features)
* [Required](#requirements)
* [Installation/Usage](#installationusage)
  * [via Composer](#using-create-project)
  * [Manually](#manually)
* [Deploying with Flightplan](#deploying-with-flightplan)
  * [Steps](#deployment-steps)
* [Documentation](#deploying-with-flightplan)
  * [Folder Structure](#folder-structure)
  * [Configuration Files](#configuration-files)
  * [Environment Variables](#environment-variables)
  * [Composer](#composer)
  * [Flightplan](#flightplan)
  * [WP-CLI](#wp-cli)
* [Contributing](#contributing)
* [Support](#support)

## Quick Start

run `composer -g config repositories.mmc/bedrock vcs git@bitbucket.org:mixedmediacreations/bedrock.git` to add this package to Composer.

You can then run `composer create-project mmc/bedrock <path>` to create a project (see [Installation/Usage](#installationusage) for more details).

:rage: **NOTE**: You may get a, "Permission denied (publickey)." error trying to run the above line. This is due to the fact that you do not have a SSH key setup on bitbucket, as Git != Github. Log into Bitbucket, click "manage account" in top right, click "SSH Key" to add your key. If you arent sure how to do that Github has a good tutorial [HERE](https://help.github.com/articles/generating-ssh-keys/) (Just skip step 3). 

If your Bedrock project already exists, run `composer run-script post-root-package-install` in order to set it up locally.

## Features

* Dependency management with [Composer](http://getcomposer.org)
* Automated deployments with [Flightplan](http://github.com/pstadler/flightplan)
* Better folder structure
* Easy WordPress configuration with environment specific files
* Environment variables with [Dotenv](https://github.com/vlucas/phpdotenv)

Bedrock is meant as a base for you to fork and modify to fit your needs. It is delete-key friendly and you can strip out or modify any part of it. You'll also want to customize Bedrock with settings specific to your sites/company.

Much of the philosphy behind Bedrock is inspired by the [Twelve-Factor App](http://12factor.net/) methodology including the [WordPress specific version](http://roots.io/twelve-factor-wordpress/).

Note: While this is a project from the guys behind the [Roots starter theme](http://roots.io/starter-theme/), Bedrock isn't tied to Roots in any way and works with any theme.

## Requirements

* Git
* PHP >= 5.3.2 (for Composer)
* NPM
* Bower

If you aren't interested in using a part, then you don't need its requirements either. Not deploying with Capistrano? Then don't worry about Ruby for example.

## Installation/Usage

See [Documentation](#documentation) for more details on the steps below.

### Using `create-project`

Composer's `create-project` command will automatically install the Bedrock project to a directory and run `composer install`.

The post-install script will automatically copy `.env.example` to `.env` and you'll be prompted about generating salt keys and appending them to your `.env` file.

Note: To generate salts without a prompt, run `create-project` with `-n` (non-interactive). You can also change the `generate-salts` setting in `composer.json` under `config` in your own fork. The default is `true`.

To skip the scripts completely, `create-project` can be run with `--no-scripts` to disable it.

1. Run `composer create-project roots/bedrock <path>` (`path` being the folder to install to)
2. Edit `.env` and update environment variables:
  * `DB_NAME` - Database name
  * `DB_USER` - Database user
  * `DB_PASSWORD` - Database password
  * `DB_HOST` - Database host (defaults to `localhost`)
  * `WP_ENV` - Set to environment (`development`, `staging`, `production`, etc)
  * `WP_HOME` - Full URL to WordPress home (http://example.com)
  * `WP_SITEURL` - Full URL to WordPress including subdirectory (http://example.com/wp)
3. Add theme(s)
4. Set your Nginx or Apache vhost to `/path/to/site/web/` (`/path/to/site/current/web/` if using Capistrano)
5. Access WP Admin at `http://example.com/wp/wp-admin`


### Manually

1. Clone/Fork repo
2. Run `composer install`
3. Run `composer run-script post-root-package-install` to set up environment
4. Access WP Admin at `http://example.com/wp/wp-admin`

Using Capistrano for deploys?

### Deploying with Flightplan

This can be installed manually with `npm install flightplan` but it's highly suggested you use [NPM](http://npmjs.org/) to manage them. NPM is basically the JavaScriptNode equivalent to PHP's Composer. Just as Composer manages your PHP packages/dependencies, NPM manages your JavaScript/Node gems/dependencies.

### Deployment Steps

1. Edit your `flightplan.js` environment configs to set the roles/servers and connection options.
2. run `fly deploy:<environment>`
3. Add your `.env` file to `shared/` in your `shared` path on the remote server for all the stages you use (ex: `/srv/www/example.com/shared/.env`)
4. Enjoy one-command deploys!

## Documentation

### Folder Structure

```
├── composer.json
├── config
│   ├── application.php
│   ├── environments
│   │   ├── development.php
│   │   ├── staging.php
│   │   └── production.php
│   └── application.php
├── Gemfile
├── vendor
└── web
    ├── app
    │   ├── mu-plugins
    │   ├── plugins
    │   └── themes
    ├── wp-config.php
    ├── index.php
    └── wp
```

The organization of Bedrock is similar to putting WordPress in its own subdirectory but with some improvements.

* In order not to expose sensitive files in the webroot, Bedrock moves what's required into a `web/` directory including the vendor'd `wp/` source, and the `wp-content` source.
* `wp-content` (or maybe just `content`) has been named `app` to better reflect its contents. It contains application code and not just "static content". It also matches up with other frameworks such as Symfony and Rails.
* `wp-config.php` remains in the `web/` because it's required by WP, but it only acts as a loader. The actual configuration files have been moved to `config/` for better separation.
* Capistrano configs are also located in `config/` to make it consistent.
* `vendor/` is where the Composer managed dependencies are installed to.
* `wp/` is where the WordPress core lives. It's also managed by Composer but can't be put under `vendor` due to WP limitations.


### Configuration Files

The root `web/wp-config.php` is required by WordPress and is only used to load the other main configs. Nothing else should be added to it.

`config/application.php` is the main config file that contains what `wp-config.php` usually would. Base options should be set in there.

For environment specific configuration, use the files under `config/environments`. By default there's is `development`, `staging`, and `production` but these can be whatever you require.

The environment configs are required **before** the main `application` config so anything in an environment config takes precedence over `application`.

Note: You can't re-define constants in PHP. So if you have a base setting in `application.php` and want to override it in `production.php` for example, you have a few options:

* Remove the base option and be sure to define it in every environment it's needed
* Only define the constant in `application.php` if it isn't already defined.

#### Don't want it?

You will lose the ability to define environment specific settings.

* Move all configuration into `wp-config.php`
* Manually deal with environment specific options
* Remove `config` directory

### Environment Variables

Bedrock tries to separate config from code as much as possible and environment variables are used to achieve this. The benefit is there's a single place (`.env`) to keep settings like database or other 3rd party credentials that isn't committed to your repository.

[PHP dotenv](https://github.com/vlucas/phpdotenv) is used to load the `.env` file. All variables are then available in your app by `getenv`, `$_SERVER`, or `$_ENV`.

Currently, the following env vars are required:

* `DB_USER`
* `DB_NAME`
* `DB_PASSWORD`
* `WP_HOME`
* `WP_SITEURL`

#### Don't want it?

You will lose the separation between config and code and potentially put secure credentials at risk.

* Remove `dotenv` from `composer.json` requires
* Remove `.env.example` file from root
* Remove `require_once('vendor/autoload.php');` from `wp-config.php`
* Replace all `getenv` calls with whatever method you want to set those values

### Composer

[Composer](http://getcomposer.org) is used to manage dependencies. Bedrock considers any 3rd party library as a dependency including WordPress itself and any plugins.

See these two blogs for more extensive documentation:

* [Using Composer with WordPress](http://roots.io/using-composer-with-wordpress/)
* [WordPress Plugins with Composer](http://roots.io/wordpress-plugins-with-composer/)

Screencast ($): [Using Composer With WordPress](http://roots.io/screencasts/using-composer-with-wordpress/)

#### Plugins

[WordPress Packagist](http://wpackagist.org/) is already registered in the `composer.json` file so any plugins from the [WordPress Plugin Directory](http://wordpress.org/plugins/) can easily be required.

To add a plugin, add it under the `require` directive or use `composer require <namespace>/<packagename>` from the command line. If it's from WordPress Packagist then the namespace is always `wpackagist-plugin`.

Example: `"wpackagist-plugin/akismet": "dev-trunk"`

Whenever you add a new plugin or update the WP version, run `composer update` to install your new packages.

`plugins`, and `mu-plugins` are Git ignored by default since Composer manages them. If you want to add something to those folders that *isn't* managed by Composer, you need to update `.gitignore` to whitelist them:

`!web/app/plugins/plugin-name`

Note: Some plugins may create files or folders outside of their given scope, or even make modifications to `wp-config.php` and other files in the `app` directory. These files should be added to your `.gitignore` file as they are managed by the plugins themselves, which are managed via Composer. Any modifications to `wp-config.php` that are needed should be moved into `config/application.php`. 

#### Updating WP and plugin versions

Updating your WordPress version (or any plugin) is just a matter of changing the version number in the `composer.json` file.

Then running `composer update` will pull down the new version.

#### Themes

Themes can also be managed by Composer but should only be done so under two conditions:

1. You're using a parent theme that won't be modified at all
2. You want to separate out your main theme and use that as a standalone package

Under most circumstances we recommend NOT doing #2 and instead keeping your main theme as part of your app's repository.

Just like plugins, WPackagist maintains a Composer mirror of the WP theme directory. To require a theme, just use the `wpackagist-theme` namespace.

#### Don't want it?

Composer integration is the biggest part of Bedrock, so if you were going to remove it there isn't much point in using Bedrock.

### Flightplan

[Flightplan](http://github.com/pstadler/flightplan) is a node.js library for streamlining application deployment or systems administration tasks. It will let you deploy or sync/push your database and uploads in one command:

* Deploy: `fly deploy:<environment>`
* Push DB: `fly db_push:<environment>`
* Pull DB: `fly db_pull:<environemnt>`
* Push Uploads: `fly uploads_push:<environment>`
* Pull Uploads: `fly uploads_pull:<environment>`

Composer support is built-in so when you run a deploy, `composer install` is automatically run.

#### Don't want it?

You will lose the one-command deploys and built-in integration with Composer. Another deploy method will be needed as well.

* Remove `flightplan.js`

### wp-cron

Bedrock disables the internal WP Cron via `define('DISABLE_WP_CRON', true);`. If you keep this setting, you'll need to manually set a cron job like the following in your crontab file:

`*/5 * * * * curl http://example.com/wp/wp-cron.php`

## WP-CLI

Bedrock works with [WP-CLI](http://wp-cli.org/) just like any other WordPress project would. Previously we required WP-CLI in our `composer.json` file as a dependency. This has been removed since WP-CLI now recommends installing it globally with a `phar` file. It also caused conflicts if you tried using a global install.

The `wp` command will automatically pick up Bedrock's subdirectory install as long as you run commands from within the project's directory (or deeper). Bedrock includes a `wp-cli.yml` file that sets the `path` option to `web/wp`. Use this config file for any further [configuration](http://wp-cli.org/config/).

## Contributing

Everyone is welcome to help [contribute](CONTRIBUTING.md) and improve this project. There are several ways you can contribute:

* Reporting issues (please read [issue guidelines](https://github.com/necolas/issue-guidelines))
* Suggesting new features
* Writing or refactoring code
* Fixing [issues](https://bitbucket.org/mixedmediacreations/bedrock/issues)
* Replying to questions on the [forum](http://discourse.roots.io/)

## Support

Use the [Roots Discourse](http://discourse.roots.io/) forum to ask questions and get support.