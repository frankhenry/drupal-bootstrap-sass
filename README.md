# Template for Drupal 8 projects including a Bootstrap Sass subtheme

This project template provides a [Composer](https://getcomposer.org/) starter kit for building a Drupal 8 website that includes a Bootstrap Sass subtheme and Font Awesome. The subtheme is in a separate project ([frankhenry/fc-bootstrap](https://github.com/frankhenry/fc-bootstrap)) that is included in the `composer.json` of this project template. The template also installs more modules than the standard template, and uses a different, but convenient, method of managing environment-specific settings files. Those differences aside, it's the same as the [officially supported drupal-composer/drupal-project](https://github.com/drupal-composer/drupal-project) project on GitHub. 

## Usage

First you need to [install composer](https://getcomposer.org/doc/00-intro.md#installation-linux-unix-osx).

> Note: The instructions below refer to the [global composer installation](https://getcomposer.org/doc/00-intro.md#globally).
You might need to replace `composer` with `php composer.phar` (or similar) 
for your setup.

After that you can create the project:

```
composer create-project frankhenry/drupal-bootstrap-sass --repository='{"type":"git", "url":"git@bitbucket.org:fhenry99/drupal-bootstrap-sass.git"}' _sitename_ --no-interaction --stability=dev
```

If you want to add further modules to your installation, you can do so with `composer require ...`:

```
cd some-dir
composer require 'drupal/geolocation:^3.0'
```

The `composer create-project` command passes ownership of all files to the 
project that is created. You should create a new git repository, and commit 
all files not excluded by the .gitignore file.

## What does the template do?

When installing the given `composer.json` some tasks are taken care of:

* Drupal will be installed in the `web` directory.
* Custom theme will be installed in the `web/themes/custom/fc-bootstrap` directory.
* Autoloader is implemented to use the generated composer autoloader in `vendor/autoload.php`,
  instead of the one provided by Drupal (`web/vendor/autoload.php`).
* Modules (packages of type `drupal-module`) will be placed in `web/modules/contrib/`
* Theme (packages of type `drupal-theme`) will be placed in `web/themes/contrib/`
* Custom themes (packages of type `drupal-custom-theme`) will be placed in `web/themes/custom/`
* Profiles (packages of type `drupal-profile`) will be placed in `web/profiles/contrib/`
* Creates default writable version `services.yml`.
* Copies the environment-specific settings file from the `settings` folder to `sites/default/settings.php`
* Creates `web/sites/default/files`-directory.
* Latest version of drush is installed locally for use at `vendor/bin/drush`.
* Latest version of DrupalConsole is installed locally for use at `vendor/bin/drupal`.
* Creates environment variables based on your .env file. See [.env.example](.env.example).

## Settings files

There are lots of ways to manage settings files, but I find it convenient to have one for each environment. Many settings are the same in all environments, so I place those in a shared file which is then included in the environment-specific file, like so:

```php
if (file_exists(__DIR__ . '/shared.settings.php')) {
  include __DIR__ . '/shared.settings.php';
}
```

In the repo, all settings files are kept in a `settings` folder under the project root. The `sync_settings` task copies the appropriate files during deployment. Typically, the folder structure looks like this:

```
myproject
└───settings
    │   dev.settings.php
    │   local.settings.php
    │   prod.settings.php
    │   shared.settings.php
```

The file `scripts/composer` folder includes `ScriptHandler.php`, which defines a class that provides functions to copy `shared.settings.php` and the environment-specific settings file to `sites/default/settings.php`. The environment-specific file is determined by the value of the `env` parameter on the command line. For example, if the parameter is `env=test`, `test.settings.php` will be copied to `sites/default/settings.php`.

As with any Drupal setup, you'll need to create your database and add the details to the settings file. You'll also need to add a hash salt. I don't believe there is any issue with using the same value for all environments, so the setting is in `shared.settings.php`:

`$settings['hash_salt'] = '';

Use this command to generate a hash salt for your site:

`drush php-eval 'echo \Drupal\Component\Utility\Crypt::randomBytesBase64(55) . "\n";'`

It will return a value like this:

`Wq6yY3kp6yZxWj_x5sJWXpJDwcmd8wlgsoMk3_m0a3Fy7IoU2_IfW6VaB3yvtpSSeffG7AMSGg`

Add it to `shared.settings.php` so you end up with this:

`$settings['hash_salt'] = 'Wq6yY3kp6yZxWj_x5sJWXpJDwcmd8wlgsoMk3_m0a3Fy7IoU2_IfW6VaB3yvtpSSeffG7AMSGg';`

If you want to have a different hash salt for every environment, move the setting out of `shared.settings.php` and into the environment-specific settings files.


You should make all of the above changes to your settings files before running `composer create-project` but if you don't, or if you need to copy the settings file again, you can do it with this command:

`composer run-script copy-settings -- --env=test`



## Standard project documentation

The information below comes from the standard project documentation. It might not be up-to-date so please check the [source](https://github.com/drupal-composer/drupal-project) for updates.


### Updating Drupal Core

This project will attempt to keep all of your Drupal Core files up-to-date; the 
project [drupal-composer/drupal-scaffold](https://github.com/drupal-composer/drupal-scaffold) 
is used to ensure that your scaffold files are updated every time drupal/core is 
updated. If you customize any of the "scaffolding" files (commonly .htaccess), 
you may need to merge conflicts if any of your modified files are updated in a 
new release of Drupal core.

Follow the steps below to update your core files.

1. Run `composer update drupal/core webflo/drupal-core-require-dev "symfony/*" --with-dependencies` to update Drupal Core and its dependencies.
1. Run `git diff` to determine if any of the scaffolding files have changed. 
   Review the files for any changes and restore any customizations to 
  `.htaccess` or `robots.txt`.
1. Commit everything all together in a single commit, so `web` will remain in
   sync with the `core` when checking out branches or running `git bisect`.
1. In the event that there are non-trivial conflicts in step 2, you may wish 
   to perform these steps on a branch, and use `git merge` to combine the 
   updated core files with your customized files. This facilitates the use 
   of a [three-way merge tool such as kdiff3](http://www.gitshah.com/2010/12/how-to-setup-kdiff-as-diff-tool-for-git.html). This setup is not necessary if your changes are simple; 
   keeping all of your modifications at the beginning or end of the file is a 
   good strategy to keep merges easy.

### Generate composer.json from existing project

With using [the "Composer Generate" drush extension](https://www.drupal.org/project/composer_generate)
you can now generate a basic `composer.json` file from an existing project. Note
that the generated `composer.json` might differ from this project's file.


### FAQ

#### Should I commit the contrib modules I download?

Composer recommends **no**. They provide [argumentation against but also 
workrounds if a project decides to do it anyway](https://getcomposer.org/doc/faqs/should-i-commit-the-dependencies-in-my-vendor-directory.md).

#### Should I commit the scaffolding files?

The [drupal-scaffold](https://github.com/drupal-composer/drupal-scaffold) plugin can download the scaffold files (like
index.php, update.php, …) to the web/ directory of your project. If you have not customized those files you could choose
to not check them into your version control system (e.g. git). If that is the case for your project it might be
convenient to automatically run the drupal-scaffold plugin after every install or update of your project. You can
achieve that by registering `@composer drupal:scaffold` as post-install and post-update command in your composer.json:

```json
"scripts": {
    "post-install-cmd": [
        "@composer drupal:scaffold",
        "..."
    ],
    "post-update-cmd": [
        "@composer drupal:scaffold",
        "..."
    ]
},
```
#### How can I apply patches to downloaded modules?

If you need to apply patches (depending on the project being modified, a pull 
request is often a better solution), you can do so with the 
[composer-patches](https://github.com/cweagans/composer-patches) plugin.

To add a patch to drupal module foobar insert the patches section in the extra 
section of composer.json:
```json
"extra": {
    "patches": {
        "drupal/foobar": {
            "Patch description": "URL or local path to patch"
        }
    }
}
```
#### How do I switch from packagist.drupal-composer.org to packages.drupal.org?

Follow the instructions in the [documentation on drupal.org](https://www.drupal.org/docs/develop/using-composer/using-packagesdrupalorg).

#### How do I specify a PHP version ?

This project supports PHP 5.6 as minimum version (see [Drupal 8 PHP requirements](https://www.drupal.org/docs/8/system-requirements/drupal-8-php-requirements)), however it's possible that a `composer update` will upgrade some package that will then require PHP 7+.

To prevent this you can add this code to specify the PHP version you want to use in the `config` section of `composer.json`:
```json
"config": {
    "sort-packages": true,
    "platform": {
        "php": "5.6.40"
    }
},
```
