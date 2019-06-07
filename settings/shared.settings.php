<?php
/**
 * @file
 * Shared settings.php file for Drupal 8.
 */

// Install with the 'standard' profile for this example.
$settings['install_profile'] = 'standard';

// The hash_salt should be a unique random value for each application.
$settings['hash_salt'] = '';

// Deployment identifier
$settings['deployment_identifier'] = \Drupal::VERSION;

// Assertions
assert_options(ASSERT_ACTIVE, FALSE);
\Drupal\Component\Assertion\Handle::register();

// Fast 404 pages:
$config['system.performance']['fast_404']['exclude_paths'] = '/\/(?:styles)|(?:system\/files)\//';
$config['system.performance']['fast_404']['paths'] = '/\.(?:txt|png|gif|jpe?g|css|js|ico|swf|flv|cgi|bat|pl|dll|exe|asp)$/i';
$config['system.performance']['fast_404']['html'] = '<!DOCTYPE html><html><head><title>404 Not Found</title></head><body><h1>Not Found</h1><p>The requested URL "@path" was not found on this server.</p></body></html>';

// Load services definition file.
$settings['container_yamls'][] = $app_root . '/' . $site_path . '/services.yml';

// The default list of directories that will be ignored by Drupal's file API.
$settings['file_scan_ignore_directories'] = [
  'node_modules',
  'bower_components',
];

// The default number of entities to update in a batch process.
$settings['entity_update_batch_size'] = 50;

// Entity update backup.
$settings['entity_update_backup'] = TRUE;

// Load local development override configuration, if available.
if (file_exists($app_root . '/' . $site_path . '/settings.local.php')) {
  include $app_root . '/' . $site_path . '/settings.local.php';
}
$config_directories['sync'] = '../config/sync';

