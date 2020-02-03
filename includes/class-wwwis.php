<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://wordpress-webmaster.de
 * @since      1.0.0
 * @package    Wwwis
 * @subpackage Wwwis/includes
 * @author     Volkan Sah <plugin@wordpress-webmaster.de>
 */
class Wwwis {

	
	protected $loader;
	protected $plugin_name;
	protected $version;
	public function __construct() {
		if ( defined( 'WWWIS_VERSION' ) ) {
			$this->version = WWWIS_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'wwwis';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}
	private function load_dependencies() {
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wwwis-loader.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wwwis-i18n.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-wwwis-admin.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'view/class-wwwis-public.php';

		$this->loader = new Wwwis_Loader();

	}

	private function set_locale() {

		$plugin_i18n = new Wwwis_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}
	private function define_admin_hooks() {

		$plugin_admin = new Wwwis_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

	}
	private function define_public_hooks() {

		$plugin_public = new Wwwis_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
	}
	public function run() {
		$this->loader->run();
	}
	public function get_plugin_name() {
		return $this->plugin_name;
	}
	public function get_loader() {
		return $this->loader;
	}
	public function get_version() {
		return $this->version;
	}
}
