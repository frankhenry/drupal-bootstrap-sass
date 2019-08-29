<?php

/**
 * @file
 * Contains \FrankHenry\composer\SettingsHandler.
 */

namespace FrankHenry\composer;

use Composer\Script\Event;
use Composer\Semver\Comparator;
use DrupalFinder\DrupalFinder;
use Symfony\Component\Filesystem\Filesystem;
use Webmozart\PathUtil\Path;

class SettingsHandler {

  /*
   * Create the settings file for the current environment. The composer package has a settings folder that contains 
   * the following files:
   *
   *   dev.settings.php
   *   prod.settings.php
   *   shared.settings.php
   *   test.settings.php
   *
   * Common settings are in shared.settings.php and enviroment-specific settings are in the environment-specific file. 
   * This script reads the 'env' parameter passed on the command line and uses it to construct the name of the file to be
   * copied, e.g. if the parameter is "env=test", test.settings.php will be copied to sites/default/settings.php.
   */
  public static function customSettingsFiles(Event $event) {

    // If an environment argument is specified when the script is invoked, use it...
    $args = $event->getArguments();
    if (count($args) > 0) {
      foreach ($args as $arg) {
        if (preg_match('/^--env=(.*)$/', $arg, $matches)) {
          $env = $matches[1];
          break;
        }
      }
    }
    // ... otherwise, default to 'dev'
    if (!isset($env)) {
      $env = "dev";
    }

    $fs = new Filesystem();

    $projectRootPath = dirname(\Composer\Factory::getComposerFile());
    $settingsPath = $projectRootPath . '/settings';

    $drupalFinder = new DrupalFinder();
    $drupalFinder->locateRoot(getcwd());
    $drupalRoot = $drupalFinder->getDrupalRoot();

    $dirs = [
      'modules',
      'profiles',
      'themes',
    ];

    // Required for unit testing
    foreach ($dirs as $dir) {
      if (!$fs->exists($drupalRoot . '/'. $dir)) {
        $fs->mkdir($drupalRoot . '/'. $dir);
        $fs->touch($drupalRoot . '/'. $dir . '/.gitkeep');
      }
    }

    // Copy the settings files always, to make sure they are up to date.
    $fs->copy($settingsPath . '/shared.settings.php', $drupalRoot . '/sites/default/shared.settings.php');
    $fs->copy($settingsPath . '/' . $env . '.settings.php', $drupalRoot . '/sites/default/settings.php');
      require_once $drupalRoot . '/core/includes/bootstrap.inc';
      require_once $drupalRoot . '/core/includes/install.inc';
      $settings['config_directories'] = [
        CONFIG_SYNC_DIRECTORY => (object) [
          'value' => Path::makeRelative($drupalFinder->getComposerRoot() . '/config/sync', $drupalRoot),
          'required' => TRUE,
        ],
      ];
      drupal_rewrite_settings($settings, $drupalRoot . '/sites/default/settings.php');
      $fs->chmod($drupalRoot . '/sites/default/settings.php', 0666);
      $event->getIO()->write("Created a sites/default/settings.php file with chmod 0666");
      $fs->chmod($drupalRoot . '/sites/default/shared.settings.php', 0666);
      $event->getIO()->write("Created a sites/default/shared.settings.php file with chmod 0666");


    // Create the files directory with chmod 0777
    if (!$fs->exists($drupalRoot . '/sites/default/files')) {
      $oldmask = umask(0);
      $fs->mkdir($drupalRoot . '/sites/default/files', 0777);
      umask($oldmask);
      $event->getIO()->write("Created a sites/default/files directory with chmod 0777");
    }
  }
}
