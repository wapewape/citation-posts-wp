<?php

/**
 *
 * The plugin bootstrap file
 *
 * This file is responsible for starting the plugin using the main plugin class file.
 *
 * @since 0.0.1
 * @package mc_citation
 *
 * @wordpress-plugin
 * Plugin Name:     MC Citation
 * Description:     Add citation text
 * Version:         0.0.1
 * Author:          William Peñaloza
 * Author URI:      https://www.william.cl
 * License:         GPL-2.0+
 * License URI:     http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:     mc-citation
 * Domain Path:     /lang
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( 'Direct access not permitted.' );
}

if ( ! class_exists( 'mc_citation' ) ) {

	/*
	 * main mc_citation class
	 *
	 * @class mc_citation
	 * @since 0.0.1
	 */
	class mc_citation {

		/*
		 * mc_citation plugin version
		 *
		 * @var string
		 */
		public $version = '4.7.5';

		/**
		 * The single instance of the class.
		 *
		 * @var mc_citation
		 * @since 0.0.1
		 */
		protected static $instance = null;

		/**
		 * Main mc_citation instance.
		 *
		 * @since 0.0.1
		 * @static
		 * @return mc_citation - main instance.
		 */
		public static function instance() {
			if ( is_null( self::$instance ) ) {
				self::$instance = new self();
			}
			return self::$instance;
		}

		/**
		 * mc_citation class constructor.
		 */
		public function __construct() {
			$this->load_plugin_textdomain();
			$this->define_constants();
			$this->includes();
			$this->define_actions();
		}

		public function load_plugin_textdomain() {
			load_plugin_textdomain( 'plugin-name', false, basename( dirname( __FILE__ ) ) . '/lang/' );
		}

		/**
		 * Include required core files
		 */
		public function includes() {
            // Example
//			require_once __DIR__ . '/includes/loader.php';

			// Load custom functions and hooks
//			require_once __DIR__ . '/includes/includes.php';
		}

		/**
		 * Get the plugin path.
		 *
		 * @return string
		 */
		public function plugin_path() {
			return untrailingslashit( plugin_dir_path( __FILE__ ) );
		}


		/**
		 * Define mc_citation constants
		 */
		private function define_constants() {
			define( 'mc_citation_PLUGIN_FILE', __FILE__ );
			define( 'mc_citation_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );
			define( 'mc_citation_VERSION', $this->version );
			define( 'mc_citation_PATH', $this->plugin_path() );
		}

		/**
		 * Define mc_citation actions
		 */
		public function define_actions() {
			//
		}

		/**
		 * Define mc_citation menus
		 */
		public function define_menus() {
            //
		}
		
	}
	
function add_meta_box_citation() {
	add_meta_box( 'meta-box-id', __( 'Citation', 'tutorialeswp' ), 'metaBoxCitation', 'post' );
}
add_action( 'add_meta_boxes', 'add_meta_box_citation' );


function metaBoxCitation( $post ) {
	$citation = get_post_meta( $post->ID, 'citation', true );
	wp_nonce_field( 'my_meta_box_nonce', 'meta_box_nonce' );
    wp_editor( $citation, 'metabox_id', $settings = array('textarea_name'=>'citation') );

}

function saveMetaBoxCitation( $post_id ) {
	if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
	if( !isset( $_POST['meta_box_nonce'] ) || !wp_verify_nonce( $_POST['meta_box_nonce'], 'my_meta_box_nonce' ) ) return;
	if( !current_user_can( 'edit_post' ) ) return;
	if( isset( $_POST['citation'] ) )
	$clearText = $_POST['citation'];
	update_post_meta( $post_id, 'citation', $clearText );
	
}
add_action( 'save_post', 'saveMetaBoxCitation' );


function getCitation($atts) {
   
	$params = shortcode_atts( array(
		'post_id'        => '',
	), $atts );

	$citation = get_post_meta( $params['post_id'], 'citation', true );
	return $citation;
}
add_shortcode('mc-citacion', 'getCitation');	

	$mc_citation = new mc_citation();
}
