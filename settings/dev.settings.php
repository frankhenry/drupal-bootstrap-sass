<?php
/**
 * @file
 * settings.php file for Drupal 8.
 */

// Include shared settings
if (file_exists(__DIR__ . '/shared.settings.php')) {
  include __DIR__ . '/shared.settings.php';
}

// Access control for update.php script.
$settings['update_free_access'] = TRUE;

// Enable local development services.
$settings['container_yamls'][] = DRUPAL_ROOT . '/sites/development.services.yml';

// Show all error messages, with backtrace information
$config['system.logging']['error_level'] = 'verbose';

// CSS and JS aggregation.
$config['system.performance']['css']['preprocess'] = FALSE;
$config['system.performance']['js']['preprocess'] = FALSE;

// Enable access to rebuild.php.
$settings['rebuild_access'] = TRUE;

// Skip file system permissions hardening.
$settings['skip_permissions_hardening'] = TRUE;

// External access proxy settings:
# $settings['http_client_config']['proxy']['http'] = 'http://proxy_user:proxy_pass@example.com:8080';
# $settings['http_client_config']['proxy']['https'] = 'http://proxy_user:proxy_pass@example.com:8080';
# $settings['http_client_config']['proxy']['no'] = ['127.0.0.1', 'localhost'];

// Reverse Proxy Configuration:
# $settings['reverse_proxy'] = TRUE;
# $settings['reverse_proxy_addresses'] = ['a.b.c.d', ...];
# $settings['reverse_proxy_trusted_headers'] = \Symfony\Component\HttpFoundation\Request::HEADER_X_FORWARDED_ALL | \Symfony\Component\HttpFoundation\Request::HEADER_FORWARDED;


// Page caching:
# $settings['omit_vary_cookie'] = TRUE;

// Cache TTL for client error (4xx) responses.
# $settings['cache_ttl_4xx'] = 3600;

// Expiration of cached forms.
# $settings['form_cache_expiration'] = 21600;

// Authorized file system operations:
# $settings['allow_authorize_operations'] = FALSE;

// Default mode for directories and files written by Drupal.
# $settings['file_chmod_directory'] = 0775;
# $settings['file_chmod_file'] = 0664;

// Public file base URL:
# $settings['file_public_base_url'] = 'http://downloads.example.com/files';

// Public file path:
# $settings['file_public_path'] = 'sites/default/files';

// Private file path:
# $settings['file_private_path'] = '';

// Session write interval:
# $settings['session_write_interval'] = 180;

// String overrides:
# $settings['locale_custom_strings_en'][''] = [
#   'forum'      => 'Discussion board',
#   '@count min' => '@count minutes',
# ];

// A custom theme for the offline page:
# $settings['maintenance_theme'] = 'bartik';

// Databases
$databases['default']['default'] = array (
  'database' => '',
  'username' => '',
  'password' => '',
  'prefix' => '',
  'host' => 'localhost',
  'port' => '3306',
  'namespace' => 'Drupal\\Core\\Database\\Driver\\mysql',
  'driver' => 'mysql',
);

// Trusted host patterns
$settings['trusted_host_patterns'] = array(
  '^.+frank\.vm$', // example: change for your site
);

// Configuration split settings
$config['config_split.config_split.dev_split']['status'] = TRUE;
$config['config_split.config_split.test_split']['status'] = FALSE;
$config['config_split.config_split.live_split']['status'] = FALSE;

// Override location of cached twig templates
$settings['php_storage']['twig']['directory'] = '/tmp/sites-caching/php';
$settings['php_storage']['twig']['secret'] = $settings['hash_salt'];

