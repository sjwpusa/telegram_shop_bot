<?php
/**
 * The file is primary file to render admin page
 *
 * You can use from this file to define page (or pages) to render admin
 * panels in admin panel of WordPress (or in specific management panel for your site)
 *
 * @package    Plugin_Name_Dir\templates\admin
 * @author     Your_Name <youremail@nomail.com>
 * @license    https://www.gnu.org/licenses/gpl-3.0.txt GNU/GPLv3
 * @link       https://yoursite.com
 * @since      1.0.0
 */

use Plugin_Name_Dir\Includes\Functions\Utility;

    if(isset($_POST['tsb_settings_submit']) and  isset( $_POST['_wpnonce'] ) and  wp_verify_nonce( $_POST['_wpnonce'], 'save_tsb_settings'))
    {
        $temp=Utility::update_plugin_options($_POST);
        if (isset($temp['webhook']) and $temp['webhook'])
        {
            ?>
                <div class="notice notice-success is-dismissible">
                    <p><?php echo  __('Settings Saved And Webhook Set!',PLUGIN_TEXT_DOMAIN);?></p>
                    <button type="button" class="notice-dismiss">
                        <span class="screen-reader-text">Dismiss this notice.</span>
                    </button>
                </div>
            <?php
        }
        else if (isset($temp['get_updates']) and $temp['get_updates'])
        {
            ?>
            <div class="notice notice-success is-dismissible">
                <p><?php echo  __('Settings Saved And Get Updates Set!',PLUGIN_TEXT_DOMAIN);?></p>
                <button type="button" class="notice-dismiss">
                    <span class="screen-reader-text">Dismiss this notice.</span>
                </button>
            </div>
            <?php
        }
        else
        {
            ?>
            <div class="notice notice-success is-dismissible">
                <p><?php echo  __('Settings Saved But Your <b class="tsb-txt-red">Token Is Invalid</b>!',PLUGIN_TEXT_DOMAIN);?></p>
                <button type="button" class="notice-dismiss">
                    <span class="screen-reader-text">Dismiss this notice.</span>
                </button>
            </div>
            <?php
        }

        $TSB_options=get_option('TSB_settings');
    }
    else
    {
        $TSB_options=get_option('TSB_settings');
    }


?>
<div class="wrap wptp-wrap">
    <h1 class="wp-heading-inline"><?php echo __('Telegram shop Bot',PLUGIN_TEXT_DOMAIN);?></h1>

    <div class="nav-tab-wrapper">

        <a id="settings-wptp-tab" class="wptp-tab nav-tab nav-tab-active"><?php echo  __('settings',PLUGIN_TEXT_DOMAIN);?></a>
        <a id="proxy-wptp-tab" class="wptp-tab nav-tab"><?php echo  __('Proxy',PLUGIN_TEXT_DOMAIN);?></a>

    </div>

    <form action="" method="post">
        <?php wp_nonce_field( 'save_tsb_settings' );?>
        <div id="settings-wptp-tab-content" class="wptp-tab-content hidden" style="display: block;">
            <table>
                <tbody>
                  <tr>
                    <td>
                        <label for="api_token"><?php echo  __(' Bot API Token',PLUGIN_TEXT_DOMAIN);?></label>
                    </td>
                    <td>
                        <input type="password" name="api_token" id="api_token" value="<?php echo $TSB_options['api_token']?>" class="regular-text ltr api-token">
                        <div class="description"></div>
                    </td>
                </tr>
                  <tr class="<?php echo (!empty($TSB_options['bot_username']))? '':'hidden'; ?>">
                    <td>
                        <label for="bot_username"><?php echo  __(' Bot User Name',PLUGIN_TEXT_DOMAIN);?></label>
                    </td>
                    <td>
                        <?php
                        if ($TSB_options['bot_username']!='unauthorized')
                        {
                            ?>
                              <a href="https://t.me/<?php echo $TSB_options['bot_username']; ?>"><?php echo '@'.$TSB_options['bot_username'];?></a>
                            <?php
                        }
                        else
                        {
                           echo  __('<b class="tsb-txt-red">Token Is Invalid!</b>',PLUGIN_TEXT_DOMAIN);
                        }
                        ?>
                    </td>
                </tr>
                  <tr>
                      <td><?php echo __('Telegram Bot Request Type',PLUGIN_TEXT_DOMAIN);?></td>
                      <td>
                          <fieldset>
                              <fieldset>
                                  <label>
                                      <input type="radio" value="get_updates" name="request_type"  <?php checked($TSB_options['request_type'],'get_updates')?>> <?php echo  __('Get Update',PLUGIN_TEXT_DOMAIN);?>
                                  </label>
                                  <label>
                                      <input type="radio" value="webhook" name="request_type" <?php checked($TSB_options['request_type'],'webhook')?>  > <?php echo  __('Webhook',PLUGIN_TEXT_DOMAIN);?>
                                  </label>
                              </fieldset>
                      </td>
                  </tr>
                  <tr>
                      <th colspan="2"><?php echo __('Messages',PLUGIN_TEXT_DOMAIN);?></th>
                  </tr>
                  <tr>
                      <td>
                          <label for="start_command"><?php echo __('Start Command',PLUGIN_TEXT_DOMAIN);?><br>(<?php echo __('Welcome Message',PLUGIN_TEXT_DOMAIN);?>)</label>
                      </td>
                      <td>
                              <textarea name="start_command" id="start_command" cols="50" class="emoji" rows="4" ><?php echo $TSB_options['start_command'] ;?></textarea>
                      </td>
                  </tr>
                </tbody>

            </table>
        </div>
        <div id="proxy-wptp-tab-content" class="wptp-tab-content hidden" style="display: none;">
            <table>
                <tbody>
                <tr>
                    <th><?php echo __('DISCLAIMER',PLUGIN_TEXT_DOMAIN);?></th>
                    <td><?php echo __('Use the proxy at your own risk!',PLUGIN_TEXT_DOMAIN);?></td>
                </tr>
                <tr>
                    <td><?php echo __('Proxy',PLUGIN_TEXT_DOMAIN);?></td>
                    <td>
                        <fieldset>
                            <label>
                                <input type="radio" value="" name="proxy_status" <?php checked($TSB_options['proxy_status'],'');?> ><?php echo __('Inactive',PLUGIN_TEXT_DOMAIN);?>                             </label>
                            <label>
                                <input type="radio" value="google_script" name="proxy_status" <?php checked($TSB_options['proxy_status'],'google_script');?> > <?php echo __('Google Script',PLUGIN_TEXT_DOMAIN);?>                      </label>
                        </fieldset>
                    </td>
                </tr>
                </tbody></table>

            <table id="proxy_google_script" class="proxy-status-wptp <?php echo ($TSB_options['proxy_status']!='google_script')? 'hidden': '';?>">
                <tbody>
                <tr>
                    <td>
                        <label for="google_script_url"><?php echo __('Google Script URL',PLUGIN_TEXT_DOMAIN);?></label>
                    </td>
                    <td>
                        <input type="url" name="google_script_url" id="google_script_url" value="" class="regular-text ltr"><br>
                        <span class="description"> <?php echo __('The requests to Telegram will be sent via your Google Script.                        (See help page)',PLUGIN_TEXT_DOMAIN);?>
                        </span>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>

        <button type="submit" class="button-save" name="tsb_settings_submit">
            <span class="dashicons dashicons-yes"></span> <span><?php echo __('Save',PLUGIN_TEXT_DOMAIN);?></span>
        </button>
    </form>
</div>
