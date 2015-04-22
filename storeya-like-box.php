<?php
/*
Plugin Name: StoreYa Like Box
Plugin URI: http://www.storeya.com/public/likebox
Description: Like Box plugin increasing your Facebook Community from day one! 
Version: 1.0
Author: StoreYa
Author URI: http://www.storeya.com/

=== VERSION HISTORY ===
02.02.15 - v1.0 - The first version

=== LEGAL INFORMATION ===
Copyright © 2013 StoreYa Feed LTD - http://www.storeya.com/

License: GPLv2 
along with this program. If not, see <http://www.gnu.org/licenses/>.
*/

add_action('wp_footer', 'slb_insert');

function slb_insert()
{
    global $current_user;
    if (get_option('slbID')) {
            
        $secret_key = get_option('slbID');
	    $sty_script = "<script>(function(e){ var t = e.createElement(\"script\"); t.src = \"//www.storeya.com/externalscript/storeyaall?sid=".$secret_key."\"; t.type = \"text/javascript\"; t.async = true;e.getElementsByTagName(\"head\")[0].appendChild(t)})(document)</script>";
	
	$script = str_replace("\"","\"",$sty_script);
        echo $script; 
    }
}


if ( is_admin() ) {
	


$plugurldir = get_option('siteurl') . '/' . PLUGINDIR . '/storeya-like-box/';
$slb_domain = 'StoreYaLikeBox';
load_plugin_textdomain($slb_domain, false, dirname( plugin_basename( __FILE__ ) ) . '/storeya-like-box/');
add_action('init', 'slb_init');

add_action('admin_notices', 'slb_admin_notice');
add_filter('plugin_action_links', 'slb_plugin_actions', 10, 2);



function slb_init()
{
    if (function_exists('current_user_can') && current_user_can('manage_options'))
        add_action('admin_menu', 'slb_add_settings_page');
    if (!function_exists('get_plugins'))
        require_once(ABSPATH . 'wp-admin/includes/plugin.php');
    $options = get_option('slbDisable');
}
function slb_settings()
{
    register_setting('storeya-like-box-group', 'slbID');
    register_setting('storeya-like-box-group', 'slbDisable');
    add_settings_section('storeya-like-box', "StoreYa Like Box", "", 'storeya-like-box-group');

}
function slb_plugin_get_version()
{
    if (!function_exists('get_plugins'))
        require_once(ABSPATH . 'wp-admin/includes/plugin.php');
    $plugin_folder = get_plugins('/' . plugin_basename(dirname(__FILE__)));
    $plugin_file   = basename((__FILE__));
    return $plugin_folder[$plugin_file]['Version'];
}


function slb_admin_notice()
{
    if (!get_option('slbID'))
        echo ('<div class="error"><p><strong>' . sprintf(__('StoreYa Like Box  is disabled. Please go to the <a href="%s">plugin page</a> and enter a valid Like Box script to enable it.'), admin_url('options-general.php?page=storeya-like-box')) . '</strong></p></div>');
}
function slb_plugin_actions($links, $file)
{
    static $this_plugin;
    if (!$this_plugin)
        $this_plugin = plugin_basename(__FILE__);
    if ($file == $this_plugin && function_exists('admin_url')) {
        $settings_link = '<a href="' . admin_url('options-general.php?page=storeya-like-box') . '">' . __('Settings', $slb_domain) . '</a>';
        array_unshift($links, $settings_link);
    }
    return ($links);
}

    function slb_add_settings_page()
    {
       global $slb_domain, $plugurldir, $storeya_options;       
	   function slb_settings_page()
        {            
?>
      <div class="wrap">
        <?php
            screen_icon();
?>
        <h2><?php
            _e('StoreYa Like Box ', $slb_domain);
?> <small><?
            echo slb_plugin_get_version();
?></small></h2>
        <div class="metabox-holder meta-box-sortables ui-sortable pointer">
          <div class="postbox" style="float:left;width:30em;margin-right:20px">
            <h3 class="hndle"><span><?php
            _e('StoreYa Like Box  - Settings', $slb_domain);
?></span></h3>
            <div class="inside" style="padding: 0 10px">
            <p style="text-align:center"><a href="http://www.storeya.com/public/likebox" target="_blank" title="<?php
            _e('Convert your visitors to paying customers with StoreYa!', $srff_domain);
?>"><img src="<?php
            echo (plugins_url( 'storeya-like-box.jpg', __FILE__ ));
?>" height="200" width="200" alt="<?php
            _e('StoreYa Logo', $srff_domain);
?>" /></a></p>
              <form method="post" action="options.php">
                <?php
            settings_fields('storeya-like-box-group');
?>
                <p><label for="slbID"><?php
            printf(__('
Enter Like Box secret key you got from %1$sIncrease your online sales today with StoreYa!%2$sStoreYa%3$s.', $slb_domain), '<strong><a href="http://www.storeya.com/public/likebox" target="_blank"  title="', '">', '</a></strong>');
?></label></p>

                  <p><textarea rows="1" cols="20" name="slbID" ><?php echo get_option('slbID');?></textarea></p>
                    <p class="submit">
                      <input type="submit" class="button-primary" value="<?php
            _e('Save Changes');
?>" />
                    </p>
                  </form>
</p>
                  <p style="font-size:smaller;color:#999239;background-color:#ffffe0;padding:0.4em 0.6em !important;border:1px solid #e6db55;-moz-border-radius:3px;-khtml-border-radius:3px;-webkit-border-radius:3px;border-radius:3px"><?php
            printf(__('Don&rsquo;t have a Like Box? No problem! %1$sKeep your visitors engaged with you in all social networks you are active on!%2$sCreate a <strong>FREE</strong> StoreYa Like Box  Now!%3$s', $slb_domain), '<a href="http://www.storeya.com/public/likebox" target="_blank" title="', '">', '</a>');
?></p>
                  </div>
                </div>

                </div>
              </div>
			  <img src="http://www.storeya.com/widgets/admin?p=WpLikeBox"/>
              <?php
        }
        add_action('admin_init', 'slb_settings');
        add_submenu_page('options-general.php', __('StoreYa Like Box ', $slb_domain), __('StoreYa Like Box ', $slb_domain), 'manage_options', 'storeya-like-box', 'slb_settings_page');
    }
    
    } else {
    if ( isset ( $_REQUEST['action'] ) && 'storeya_sync_data' == $_REQUEST['action'] ) {
	    require_once ( 'SyncManager.php' );
	     require_once ( 'StoreYaAPI.php' );
	     }
}



?>