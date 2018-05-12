=== HTTP/2 Optimization ===
Contributors: o10n
Donate link: https://github.com/o10n-x/
Tags: http2, spdy, server push, push, service worker, cache digest, pwa
Requires at least: 4.0
Requires PHP: 5.4
Tested up to: 4.9.4
Stable tag: 0.0.41
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Advanced HTTP/2 optimization toolkit. HTTP/2 Server Push, Service Worker based Cache-Digest and more.

== Description ==

This plugin is a toolkit for HTTP/2 optimization.

The plugin provides in a complete solution for HTTP/2 Server Push, using JSON based configuration and filters to dynamicly push assets. In partnership with the PWA Optimization plugin this plugin adds a Service Worker based Cache-Digest calculation to save data transfer by pushing only assets that are not already cached in the browser.

Additional features can be requested on the [Github forum](https://github.com/o10n-x/wordpress-http2-optimization/issues).

**This plugin is a beta release.**

Documentation is available on [Github](https://github.com/o10n-x/wordpress-http2-optimization/tree/master/docs).

== Installation ==

### WordPress plugin installation

1. Upload the `http2-optimization/` directory to the `/wp-content/plugins/` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Navigate to the plugin settings page.
4. Configure HTTP/2 Optimization settings. Documentation is available on [Github](https://github.com/o10n-x/wordpress-http2-optimization/tree/master/docs).

== Screenshots ==


== Changelog ==

= 0.0.40 =
* Core update (see changelog.txt)

= 0.0.39 =
* Improved JSON editor.

= 0.0.38 =
* Core update (see changelog.txt)

= 0.0.36 =
* Bugfix: Search & Replace filter in pre HTML optimization hook not reset correctly.

= 0.0.35 =
* Improved: plugin index.

= 0.0.34 =
* Added: plugin update protection (plugin index).

= 0.0.33 =
* Improved: sanitize pushed URLs by URL encoding < and > characters.

= 0.0.31 =
* Core update (see changelog.txt)

= 0.0.24 =
* Added: JSON profile editor for all optimization modules.

= 0.0.23 =
Core update (see changelog.txt)

= 0.0.12 =
* Bugfix: uninstaller.

= 0.0.11 =
Core update (see changelog.txt)

= 0.0.10 =
* Improved JSON editor config (auto height).
* Improved Travis CI build test.
* Added Ruby RSpec + Capybara unit tests.

= 0.0.9 =
Bugfix: settings link on plugin index.

= 0.0.8 =
Core update (see changelog.txt)

= 0.0.1 =

Beta release. Please provide feedback on [Github forum](https://github.com/o10n-x/wordpress-http2-optimization/issues).

== Upgrade Notice ==

None.