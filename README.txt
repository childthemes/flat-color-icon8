=== Plugin Name ===
Contributors: fauzievolute
Donate link: http://childthemes.net/
Tags: shortcode, tools, icon, svg, editor, icon set, 
Requires at least: 4.0.0
Tested up to: 4.6.1
Stable tag: 1.0.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

WordPress plugin based on Icons8 Flat Color Icons to use in WP Editor or direct img src with generator.

== Description ==

WordPress plugin based on Icons8 Flat Color Icons to use in WP Editor or direct img src with generator.

Credits to: http://icons8.com/c/flat-color-icons

Quick Use:
- Open any WP Editor supported with shortcode
- Add shortcode [flat_color_icon] with attribute icon="<icon name>"

Shortcode Example:
[flat_color_icon icon="flash_on" width="48" height="48" alt="Flash Zip" class="alignleft"]
At front-end, this will converted as HTML image.

For Theme Developer:
- Get array of icons : `<?php print_r( $GLOBALS['flat_color_icon8']->icons ); ?>`
- Get full path URL the icon : `<?php echo get_flat_color_icon_url( '<icon name>' ); ?>`
- Echo the image via function : `<?php flat_color_icon( '<icon name>' ); ?>`

== Installation ==

Manual Installation:

1. Upload `flat-color-icon8.zip` to the `/wp-content/plugins/` directory
1. Extract the `flat-color-icon8.zip` file
1. Activate the plugin through the 'Plugins' menu in WordPress

== Screenshots ==

1. This screen shot description corresponds to screenshot-1.(png|jpg|jpeg|gif). Note that the screenshot is taken from
the /assets directory or the directory that contains the stable readme.txt (tags or trunk). Screenshots in the /assets
directory take precedence. For example, `/assets/screenshot-1.png` would win over `/tags/4.3/screenshot-1.png`
(or jpg, jpeg, gif).
2. This is the second screen shot

== Changelog ==

= 1.0 =
* Initial Release.