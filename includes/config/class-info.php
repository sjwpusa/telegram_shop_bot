<?php
/**
 * Info Class File
 *
 * This file contains Info class. If you want to add default settings or meta
 * for your plugin (when it's activated) you can use from this class.
 *
 * @package    Plugin_Name_Dir\Includes\Config
 * @author     Your_Name <youremail@nomail.com>
 * @license    https://www.gnu.org/licenses/gpl-3.0.txt GNU/GPLv3
 * @link       https://yoursite.com
 * @since      1.0.0
 */

namespace Plugin_Name_Dir\Includes\Config;

/**
 * Class Info
 * If you want to add default settings or some value for options
 * for your plugin (when it's activated) you can use from this class.
 *
 * @package    Plugin_Name_Dir\Includes\Config
 * @author     Your_Name <youremail@nomail.com>
 */
class Info {

	/**
	 * Define plugin_setting_option1 property in Info class
	 *
	 * @access     public
	 * @var string $plugin_setting_option1 Define plugin setting option1 for your plugin.
	 * @since      1.0.0
	 */
	public $plugin_settings;
	/**
	 * Define plugin_setting_option2 property in Info class
	 *
	 * @access     public
	 * @var string $plugin_setting_option2 Define plugin setting option2 for your plugin.
	 * @since      1.0.0
	 */
//	public $plugin_setting_option2;
	/**
	 * Define plugin_setting_option3 property in Info class
	 *
	 * @access     public
	 * @var string $plugin_setting_option3 Define plugin setting option1 for your plugin.
	 * @since      1.0.0
	 */
//	public $plugin_setting_option3;
	/**
	 * Define plugin_setting_option4 property in Info class
	 *
	 * @access     public
	 * @var string $plugin_setting_option4 Define plugin setting option1 for your plugin.
	 * @since      1.0.0
	 */
//	public $plugin_setting_option4;

	/**
	 * Info constructor.
	 * This is used to get option values from options table and instantiate
	 * object property which is created from Info class.
	 *
	 * @access public
	 */
	public function __construct() {
		$this->plugin_settings
			= get_option( 'TSB_settings' );
//		$this->plugin_setting_option2
//			= get_option( 'plugin_name_prefix_plugin_setting_option2' );
//		$this->plugin_setting_option3
//			= get_option( 'plugin_name_prefix_plugin_setting_option3' );
//		$this->plugin_setting_option4
//			= get_option( 'plugin_name_prefix_plugin_setting_option4' );
	}

	/**
	 * Add default values for key options in plugin activation.
	 * This method will run when plugin is activated and assign default values
	 * for your key options in plugin.
	 *
	 * @access public
	 * @static
	 */
	public static function add_info_in_plugin_activation() {
		if ( ! get_option( 'TSB_settings' ) ) {
            $site_name=get_bloginfo( "name" );
		    $options=array(
		        'bot_token'=>'',
		        'request_type'=>'get_updates',
		        'start_command'=>__('Wellcome to '.$site_name.' Bot ',PLUGIN_TEXT_DOMAIN),
		        'proxy_status'=>'',
		        'google_script_url'=>'',
            );
			update_option(
				'TSB_settings',
                $options
			);
		}

//		if ( ! get_option( 'plugin_name_prefix_plugin_setting_option2' ) ) {
//			update_option(
//				'plugin_name_prefix_plugin_setting_option2',
//				'Initial value for option 2'
//			);
//		}
//
//		if ( ! get_option( 'plugin_name_prefix_plugin_setting_option3' ) ) {
//			update_option(
//				'plugin_name_prefix_plugin_setting_option3',
//				'Initial value for option 3'
//			);
//		}
//		if ( ! get_option( 'plugin_name_prefix_plugin_setting_option4' ) ) {
//			update_option(
//				'plugin_name_prefix_plugin_setting_option4',
//				'Initial value for option 4'
//			);
//		}
	}

	/**
	 * Update option values for plugin settings.
	 * With this method, you can update you key options with new values. You
	 * can use from several method to achieve this goal.
	 *
	 * @access public
	 */
	public function update_some_info() {
		update_option(
			'TSB_settings',
			$this->plugin_settings
		);
//		update_option(
//			'plugin_name_prefix_plugin_setting_option2',
//			$this->plugin_setting_option2
//		);
//		update_option(
//			'plugin_name_prefix_plugin_setting_option3',
//			$this->plugin_setting_option3
//		);
//		update_option(
//			'plugin_name_prefix_plugin_setting_option4',
//			$this->plugin_setting_option4
//		);
	}


}

