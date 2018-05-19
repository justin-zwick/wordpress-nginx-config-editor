<?php
namespace O10n;

/**
 * Nginx Config Editor
 *
 * Advanced Nginx config editor for optimization purposes.
 *
 * @link              https://github.com/o10n-x/
 * @package           o10n
 *
 * @wordpress-plugin
 * Plugin Name:       Nginx Config Editor
 * Description:       Advanced Nginx config editor for optimization purposes.
 * Version:           0.0.2
 * Author:            Optimization.Team
 * Author URI:        https://optimization.team/
 * GitHub Plugin URI: https://github.com/o10n-x/wordpress-nginx-editor
 * Text Domain:       o10n
 * Domain Path:       /languages
 */

if (! defined('WPINC')) {
    die;
}

// abort loading during upgrades
if (defined('WP_INSTALLING') && WP_INSTALLING) {
    return;
}

// settings
$module_version = '0.0.2';
$minimum_core_version = '0.0.48';
$plugin_path = dirname(__FILE__);

// load the optimization module loader
if (!class_exists('\O10n\Module')) {
    require $plugin_path . '/core/controllers/module.php';
}

// load module
new Module(
    'nginx',
    'Nginx Config Editor',
    $module_version,
    $minimum_core_version,
    array(
        'core' => array(
            
        ),
        'admin' => array(
            'AdminNginx'
        )
    ),
    false,
    array(),
    __FILE__
);
