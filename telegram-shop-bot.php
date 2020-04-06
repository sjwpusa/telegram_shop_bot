<?php
/**
 * Plugin Name:      Telegram Shop Bot
 * Plugin URI:        https://jbyte.ir/projects
 * Description:       This plugin connect your product to telegram bot
 * Version:           1.2.2
 * Author:            Saeed Jamali
 * Author URI:         https://jbyte.ir/abute
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */

/*Define your namespaces here by use keyword*/

use Plugin_Name_Dir\Includes\Init\Core;
use Plugin_Name_Dir\Includes\Init\Constant;
use Plugin_Name_Dir\Includes\Init\Activator;
use Plugin_Name_Dir\Includes\Uninstall\Deactivator;
use Plugin_Name_Dir\Includes\Uninstall\Uninstall;

/**
 * If this file is called directly, then abort execution.
 */
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

/**
 * Class TSB
 *
 * This class is primary file of plugin which is used from
 * singletone design pattern.
 *
 * @package    TSB
 * @author    saeed_jamali <saeed131913@gmail.com>
 * @see        Plugin_Name_Dir\Includes\Init\Core Class
 * @see        Plugin_Name_Dir\Includes\Init\Constant Class
 * @see        Plugin_Name_Dir\Includes\Init\Activator Class
 * @see        Plugin_Name_Dir\Includes\Uninstall\Deactivator Class
 * @see        Plugin_Name_Dir\Includes\Uninstall\Uninstall Class
 */
class TSB {
	/**
	 * Instance property of TSB Class.
	 * This is a property in your plugin primary class. You will use to create
	 * one object from TSB_Plugin class in whole of program execution.
	 *
	 * @access private
	 * @var    TSB $instance create only one instance from plugin primary class
	 * @static
	 */
	private static $instance;

	/**
	 * TSB constructor.
	 * It defines related constant, include autoloader class, register activation hook,
	 * deactivation hook and uninstall hook and call Core class to run dependencies for plugin
	 *
	 * @access private
	 */
	private function __construct() {
		/**
		 * Currently plugin and database version.
		 * Rename this for your plugin and update it as you release new versions.
		 */
		define( 'TSB_VERSION', '1.0.1' );
		/**
		 * Define database version
		 *
		 * You can use from this constant to apply your changes in updates or
		 * activate plugin again
		 */
		define( 'TSB_DB_VERSION', 1 );



        /**
         * Include composer autoload
         */
        $composer_autoload_path = 'vendor/autoload.php';
        require_once trailingslashit( plugin_dir_path( __FILE__ ) ) . $composer_autoload_path;


		/*Define Autoloader class for plugin*/
		$autoloader_path = 'includes/class-autoloader.php';
		/**
		 * Include autoloader class to load all of classes inside this plugin
		 */
		require_once trailingslashit( plugin_dir_path( __FILE__ ) ) . $autoloader_path;


		/*Define required constant for plugin*/
		Constant::define_constant();

		/**
		 * Register activation hook.
		 * Register activation hook for this plugin by invoking activate_plugin_name
		 * in Plugin_Name_Plugin class.
		 *
		 * @param string   $file     path to the plugin file.
		 * @param callback $function The function to be run when the plugin is activated.
		 */
		register_activation_hook(
			__FILE__,
			array( $this, 'activate_TSB' )
		);
		/**
		 * Register deactivation hook.
		 * Register deactivation hook for this plugin by invoking deactivate_plugin_name
		 * in Plugin_Name_Plugin class.
		 *
		 * @param string   $file     path to the plugin file.
		 * @param callback $function The function to be run when the plugin is deactivated.
		 */
		register_deactivation_hook(
			__FILE__,
			array( $this, 'deactivate_TSB' )
		);
		/**
		 * Register deactivation hook.
		 * Register deactivation hook for this plugin by invoking deactivate_plugin_name
		 * in Plugin_Name_Plugin class.
		 *
		 * @param string   $file     path to the plugin file.
		 * @param callback $function The function to be run when the plugin is deactivated.
		 */
		register_uninstall_hook(
			__FILE__,
			array( 'Plugin_Name_Plugin', 'uninstall_TSB' )
		);

		self::run_TSB_plugin();
	}

	/**
	 * Load Core plugin class.
	 *
	 * @access public
	 * @since  1.0.0
	 */
	public static function run_TSB_plugin() {
		$plugin = new Core();
		$plugin->run();
	}

	/**
	 * Create an instance from Plugin_Name_Plugin class.
	 *
	 * @access public
	 * @since  1.0.0
	 * @return TSB
	 */
	public static function instance() {
		if ( is_null( ( self::$instance ) ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Call uninstall method.
	 * This function calls uninstall method from Uninstall class.
	 * You can use from this method to run every thing you need when plugin is uninstalled.
	 *
	 * @access public
	 * @since  1.0.0
	 */
	public static function uninstall_TSB() {
		Uninstall::uninstall();
	}

	/**
	 * Call activate method.
	 * This function calls activate method from Activator class.
	 * You can use from this method to run every thing you need when plugin is activated.
	 *
	 * @access public
	 * @since  1.0.0
	 * @see Plugin_Name_Dir\Includes\Init\Activator Class
	 */
	public function activate_TSB() {
		Activator::activate();
	}

	/**
	 * Call deactivate method.
	 * This function calls deactivate method from Dectivator class.
	 * You can use from this method to run every thing you need when plugin is deactivated.
	 *
	 * @access public
	 * @since  1.0.0
	 */
	public function deactivate_TSB() {
		Deactivator::deactivate();
	}
}

TSB::instance();




