=== PNG to JPG ===
Contributors: kubiq
Donate link: https://kubiq.sk
Tags: png, jpg, optimize, save space, convert, image, media
Requires at least: 3.0.1
Tested up to: 5.0
Stable tag: 3.2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Convert PNG images to JPG, free up web space and speed up your webpage

== Description ==

Convert PNG images to JPG, free up web space and speed up your webpage

<ul>
	<li>set quality of converted JPG</li>
	<li>auto convert on upload</li>
	<li>auto convert on upload only when PNG has no transparency</li>
	<li>only convert image if JPG filesize is lower than PNG filesize</li>
	<li>leave original PNG images on the server</li>
	<li>convert existing PNG image to JPG</li>
	<li>bulk convert existing PNG images to JPG</li>
	<li>conversion statistics</li>
</ul>

== Installation ==

1. Upload `png-to-jpg` directory to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress

== Changelog ==

= 3.2 =
* added support for Fancy Product Designer plugin

= 3.1 =
* tested on WP 5.0
* small cosmetic code changes

= 3.0 =
* new option: convert only if JPG will have lower filesize then PNG
* new feature: show converted images statistics
* fix: conflict when there is already JPEG with a same name as PNG
* fix: conflict when PNG name is part of another PNG name ( eg. 'xyz.png' can rename also 'abcxyz.png' )
* optimized for translations

= 2.6 =
* rename PNG image if JPG with the same name already exists

= 2.5 =
* BUG FIXED - disabled checkboxes when autodetect is disabled

= 2.4 =
* now you can disable autodetect PNG transparency

= 2.3 =
* WP 4.9.1 compatibility check
* new compatibility with Toolset Types

= 2.2 =
* Repair revslider database table detection

= 2.1 =
* Added option to leave original PNG image on server after conversion
* Repair SQL replacement query

= 2.0 =
* Replace image and thumbnails extension in database tables
* Moved from Settings to Tools submenu
* Some small fixes

= 1.2 =
* Fix generating background for transparent images (thanks @darkcobalt)

= 1.1 =
* Fix PNG transparency detection

= 1.0 =
* First version