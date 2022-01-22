<?php
/**
 * Admin Loader.
 *
 * @package {{package}}
 */

namespace WP_Tailwind\Admin;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Admin_Loader.
 */
class Admin_Loader {

	/**
	 * Instance
	 *
	 * @access private
	 * @var object Class object.
	 * @since 0.0.1
	 */
	private static $instance;

	/**
	 * Initiator
	 *
	 * @since 0.0.1
	 * @return object initialized object of class.
	 */
	public static function get_instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Instance
	 *
	 * @access private
	 * @var string Class object.
	 * @since 0.0.1
	 */
	private $menu_slug = 'wp-tailwind';

	/**
	 * Constructor
	 *
	 * @since 0.0.1
	 */
	public function __construct() {

		$this->initialize_hooks();
	}

	/**
	 * Init Hooks.
	 *
	 * @since 0.0.1
	 * @return void
	 */
	public function initialize_hooks() {
		add_action( 'admin_menu', array( $this, 'setup_menu' ) );
		add_action( 'admin_init', array( $this, 'settings_admin_scripts' ) );
	}

	/**
	 *  Load admin scripts.
	 */
	public function settings_admin_scripts() {
		// Enqueue admin scripts.
		if ( ! empty( $_GET['page'] ) && ( $this->menu_slug === $_GET['page'] || false !== strpos( $_GET['page'], $this->menu_slug . '_' ) ) ) { //phpcs:ignore

			add_action( 'admin_enqueue_scripts', array( $this, 'styles_scripts' ) );
		}
	}

	/**
	 * Add submenu to admin Loader.
	 *
	 * @since 0.0.1
	 */
	public function setup_menu() {

		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		global $submenu;

		$menu_slug  = $this->menu_slug;
		$capability = 'manage_options';

		add_menu_page(
			'WP Tailwind',
			'WP Tailwind',
			$capability,
			$menu_slug,
			array( $this, 'render' ),
			'',
			40
		);
	}

	/**
	 * Renders the admin settings.
	 *
	 * @since 0.0.1
	 * @return void
	 */
	public function render() {

		echo '<div id="tailwind-app" class="tailwind-app"></div>';
	}

	/**
	 * Enqueues the needed CSS/JS for the builder's admin settings page.
	 *
	 * @since 0.0.1
	 */
	public function styles_scripts() {

		$localize = array(
			'current_user'   => ! empty( wp_get_current_user()->user_firstname ) ? wp_get_current_user()->user_firstname : wp_get_current_user()->display_name,
			'admin_base_url' => admin_url(),
			'plugin_dir'     => WPT_URL,
			'plugin_ver'     => WPT_VER,
			'logo_url'       => WPT_URL,
			'admin_url'      => admin_url( 'admin.php' ),
			'ajax_url'       => admin_url( 'admin-ajax.php' ),
			'home_slug'      => $this->menu_slug,
		);

		$this->settings_app_scripts( $localize );
	}

	/**
	 * Settings app scripts
	 *
	 * @param array $localize Variable names.
	 */
	public function settings_app_scripts( $localize ) {
		$handle            = 'tws-admin';
		$build_url         = WPT_URL . 'admin/build/';
		$script_asset_path = WPT_DIR . 'admin/build/' . 'TailwindApp.asset.php';
		$script_info       = file_exists( $script_asset_path ) ? include $script_asset_path	: array( 'dependencies' => array(), 'version' => WPT_VER, );

		$script_dep = array_merge( $script_info['dependencies'], array( 'updates' ) );

        // if( file_exists( $build_url . 'TailwindApp.js' ) ){

            wp_register_script(
                $handle,
                $build_url . 'TailwindApp.js',
                $script_dep,
                $script_info['version'],
                true
            );

            // wp_register_style(
            //     $handle,
            //     $build_url . 'app.css',
            //     array(),
            //     WPT_VER
            // );

            wp_enqueue_style( $handle );
		    wp_style_add_data( $handle, 'rtl', 'replace' );
        // }

		wp_enqueue_script( $handle );
		wp_localize_script( $handle, 'wpt_admin', $localize );

	}
}

Admin_Loader::get_instance();