<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://childthemes.net/
 * @since             1.0.0
 * @package           Flat_Color_Icon8
 *
 * @wordpress-plugin
 * Plugin Name:       Flat Color Icons
 * Plugin URI:        https://github.com/childthemes/flat-color-icon8
 * Description:       WordPress plugin based on Icons8 Flat Color Icons to use in WP Editor or direct img src with generator.
 * Version:           1.0.0
 * Author:            Child Themes
 * Author URI:        http://childthemes.net/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       flat-color-icon8
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'FLAT_COLOR_PATH', trailingslashit( plugin_dir_path( dirname( __FILE__ ) ).'flat-color-icon8' ) );
define( 'FLAT_COLOR_ICON', trailingslashit( plugin_dir_url( __FILE__ ) . 'assets/icons' ) );

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Flat_Color_Icon8
 * @author     Child Themes <fauzie@childthemes.net>
 */
class Flat_Color_Icon8 {
  
  /**
   * Icon List
   */
  public $icons = array();
  
  /**
   * Class Constructor
   */
  public function __construct() {
    register_activation_hook( __FILE__, array( $this, 'load_icons' ) );
    register_deactivation_hook( __FILE__, array( $this, 'remove_icons' ) );
    add_shortcode( 'flat_color_icon', array( $this, 'flat_color_icon' ) );
    add_action( 'plugin_loaded', array( $this, 'load_plugin_textdomain' ) );
    add_action( 'init', array( $this, 'load_icons' ) );
  }
  
  /**
	 * Load the plugin text domain for translation.
	 */
	public function load_plugin_textdomain() {
		load_plugin_textdomain(
			'flat-color-icon8',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);
	}
  
  /**
   * Load All Icons from file
   */
  public function load_icons() {
    if ( false === ( $loaded_icons = get_transient( 'flat_color_icon_set', false ) ) ) {
      if ( !file_exists(FLAT_COLOR_PATH.'assets/icons.json') ) return;
      $file = file_get_contents( FLAT_COLOR_PATH.'assets/icons.json' );
      $icons = json_decode( $file, true );
      if ( empty( $icons ) ) return;
      $loaded_icons = array();
      sort( $icons );
      foreach ( $icons as $icon ) {
        if ( file_exists( FLAT_COLOR_PATH . 'assets/icons/' . $icon . '.svg' ) ) {
          $loaded_icons[] = $icon;
        }
      }
      set_transient( 'flat_color_icon_set', $loaded_icons, 365 * DAY_IN_SECONDS );
    }
    $this->icons = $loaded_icons;
  }
  
  /**
   * Clear icon transient
   */
  public function remove_icons() {
    delete_transient( 'flat_color_icon_set' );
  }
  
  /**
   * Shortcode [flat_color_icon]
   */
  public function flat_color_icon( $atts ) {
    
    extract( shortcode_atts( array(
      'icon'    => '',
      'width'   => 48,
      'height'  => 48,
      'alt'     => '',
      'class'   => ''
    ), $atts ) );
    
    if ( empty( $icon ) || !in_array( $icon, $this->icons ) ) {
      return;
    }
    $class   = explode( ' ', $class );
    $class[] = 'icons8';
    if ( file_exists( FLAT_COLOR_PATH . 'assets/icons/' . $icon . '.png' ) ) {
      $class[] = 'flat-color-icon';
    }
    $width  = !empty( $width ) ? absint( $width ) : 48;
    $height = !empty( $height ) ? absint( $height ) : 48;
    
    wp_enqueue_script( 'svgeezy', plugin_dir_url( __FILE__ ) . 'assets/js/svgeezy.min.js', array(), null, true );
    
    return '<img src="'.esc_url(FLAT_COLOR_ICON.$icon.'.svg').'" class="'.esc_attr(join(' ',$class)).'" width="'.$width.'" height="'.$height.'" alt="'.esc_attr($alt).'" />';
  }
  
} //END Class

// Immidiatelly Run the Plugin
$GLOBALS['flat_color_icon8'] = new Flat_Color_Icon8;

if ( ! function_exists( 'get_flat_color_icon_url' ) ) :
function get_flat_color_icon_url( $icon = '', $ext = 'svg' ) {
  if ( empty( $icon ) ) return false;
  $icons = $GLOBALS['flat_color_icon8']->icons;
  if ( empty( $icons ) || !in_array( $icon, $icons ) ) return false;
  return esc_url( FLAT_COLOR_ICON . $icon . '.' . $ext );
}
endif;

if ( ! function_exists( 'flat_color_icon' ) ) :
function flat_color_icon( $icon = '', $width = 48, $height = 48, $class = array() ) {
  $icon_url = get_flat_color_icon_url( sanitize_title( $icon ) );
  if ( $icon_url ) {
    $xclass = is_array( $class ) ? $class : array( $class );
    $xclass = $xclass + array( 'icons8', 'flat-color-icon' );
    echo '<img src="'.$icon_url.'" width="'.absint($width).'" height="'.absint($height).'" />';
  }
}
endif;