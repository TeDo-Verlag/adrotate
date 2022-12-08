<?php
/* ------------------------------------------------------------------------------------
*  COPYRIGHT AND TRADEMARK NOTICE
*  Copyright 2008-2020 Arnan de Gans. All Rights Reserved.
*  ADROTATE is a registered trademark of Arnan de Gans.

*  COPYRIGHT NOTICES AND ALL THE COMMENTS SHOULD REMAIN INTACT.
*  By using this code you agree to indemnify Arnan de Gans from any
*  liability that might arise from its use.
------------------------------------------------------------------------------------ */

/*
if($_GET['install-adrotate']) {
	
	if(!current_user_can( 'install_plugins')) {
		wp_die(__('Sorry, you are not allowed to install plugins on this site.'));
	}

	// WordPress Administration Bootstrap
	require_once ABSPATH . 'wp-admin/admin.php';
	require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
	require_once(plugin_dir_path(__FILE__).'/adrotate-bootstrap.php');

	/// INVULLEN MET DATA VAN FORMULIER

	EMAIL VERIFIEREN
	BASIS ACTIVATIE OPSLAAN MET EMAIL, KEY, TYPE, PLATFORM
	LATER (IN BOOTSTRAP) AANVULLEN MET INSTANCE EN DATUMS ENZO

	$a = get_option('adrotate_activate');

	$a['key'] = (isset($_POST['adrotate_license_key'])) ? trim(strip_tags($_POST['adrotate_license_key'], "\t\n ")) : '';
	$a['email'] = (isset($_POST['adrotate_license_email'])) ? trim(strip_tags($_POST['adrotate_license_email'], "\t\n ")) : '';

	if(!empty($a['key']) AND !empty($a['email'])) {
		list($a['version'], $a['type'], $serial) = explode("-", $a['key'], 3);
		if(!is_email($a['email'])) {
			wp_die('Please enter a valid Email address - The one that you used for your account on ajdg.solutions when you bought AdRotate pro. You can find your license details in the order email you have received and in your account on ajdg.solutions', 'Invalid Email for license', array('link_url' => 'https://ajdg.solutions/my-account/', 'link_text' => 'Go to AJdG Solutions Account', 'back_link' => admin_url('admin.php?page=adrotate')));
		}
		$a['platform'] = strtolower(get_option('siteurl'));

		// New Licenses
		if(strtolower($a['type']) == "s") $a['type'] = "Single";
		if(strtolower($a['type']) == "d") $a['type'] = "Duo";
		if(strtolower($a['type']) == "m") $a['type'] = "Multi";
		if(strtolower($a['type']) == "u") $a['type'] = "Developer";

		if($a) adrotate_license_response('activation', $a);
	} else {
		wp_die('Please enter a valid Email address and license key - can find your license details in the order email you have received and in your account on ajdg.solutions', 'Invalid or missing license', array('link_url' => 'https://ajdg.solutions/my-account/', 'link_text' => 'Go to AJdG Solutions Account', 'back_link' => admin_url('admin.php?page=adrotate')));
	}


/// DOWNLOAD THE FILE

	//The resource that we want to download.
	$fileUrl = 'https://ajdg.solutions/api/updates/files/adrotate-bootstrap.zip';	
	//The path & filename to save to.
	$saveTo = 'path/to/wp-content/plugins/logo.png';
	
	//Open file handler.
	$fp = fopen($saveTo, 'w+');
	
	//If $fp is FALSE, something went wrong.
	if($fp === false){
	    throw new Exception('Could not open: ' . $saveTo);
	}
	
	//Create a cURL handle.
	$ch = curl_init($fileUrl);
	curl_setopt($ch, CURLOPT_FILE, $fp);
	curl_setopt($ch, CURLOPT_TIMEOUT, 20);
	curl_exec($ch);
	
	//If there was an error, throw an Exception
	if(curl_errno($ch)){
	    throw new Exception(curl_error($ch));
	}
	
	$statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	
	//Close the cURL handler.
	curl_close($ch);
	
	//Close the file handler.
	fclose($fp);
	
	if($statusCode == 200){

		require_once(ABSPATH .'/wp-admin/includes/file.php');

		$creds = request_filesystem_credentials(wp_nonce_url('admin.php?page=adrotate-media'), '', false, $saveTo, null);
	    if(!WP_Filesystem($creds)) {
			request_filesystem_credentials(wp_nonce_url('admin.php?page=adrotate-media'), '', true, $saveTo, null);
		}

		$unzipfile = unzip_file($saveTo, 'path/to/wp-content/');
		if(is_wp_error($unzipfile)) {
			adrotate_return('adrotate-media', 512); // Can not unzip file
		}

		// Delete the uploaded zip
		adrotate_unlink($saveTo);

	} else{
	    echo "Status Code: " . $statusCode;
	}
	
	
	activate_plugin( 'adrotate-bootstrap/adrotate-bootstrap.php' );
}
*/

?>
<form name="settings" id="post" method="post" action="admin.php?page=adrotate-settings&tab=misc">
<?php wp_nonce_field('adrotate_settings','adrotate_nonce_settings'); ?>
<input type="hidden" name="adrotate_settings_tab" value="<?php echo $active_tab; ?>" />

<h2><?php _e('Miscellaneous', 'adrotate'); ?></h2>
<table class="form-table">			
	<tr>
		<th valign="top"><?php _e('Widget alignment', 'adrotate'); ?></th>
		<td><label for="adrotate_widgetalign"><input type="checkbox" name="adrotate_widgetalign" id="adrotate_widgetalign" <?php if($adrotate_config['widgetalign'] == 'Y') { ?>checked="checked" <?php } ?> /> <?php _e('Check this box if your widgets do not align in your themes sidebar. (Does not always help!)', 'adrotate'); ?></label></td>
	</tr>
	<tr>
		<th valign="top"><?php _e('Widget padding', 'adrotate'); ?></th>
		<td><label for="adrotate_widgetpadding"><input type="checkbox" name="adrotate_widgetpadding" id="adrotate_widgetpadding" <?php if($adrotate_config['widgetpadding'] == 'Y') { ?>checked="checked" <?php } ?> /> <?php _e('Enable this to remove the padding (blank space) around ads in widgets. (Does not always work!)', 'adrotate'); ?></label></td>
	</tr>
	<?php if($adrotate_config['w3caching'] == "Y" AND !defined('W3TC_DYNAMIC_SECURITY')) { ?>
	<tr>
		<th valign="top"><?php _e('NOTICE:', 'adrotate'); ?></th>
		<td><span style="color:#f00;"><?php _e('You have enabled W3 Total Caching support but not defined the security hash.', 'adrotate'); ?></span><br /><br /><?php _e('AdRotate has generated the following line for you to add to your wp-config.php around line 52 (below the WordPress nonces). If you do not know how to add this line, check out the following guide;', 'adrotate'); ?> <a href="https://ajdg.solutions/manuals/adrotate-manuals/caching-support/"><?php _e('Set up W3 Total Caching', 'adrotate'); ?></a>.<br /><pre>define('W3TC_DYNAMIC_SECURITY', '<?php echo md5(rand(0,999)); ?>');</pre></td>
	</tr>
	<?php } ?>
	<tr>
		<th valign="top"><?php _e('W3 Total Caching', 'adrotate'); ?></th>
		<td><label for="adrotate_w3caching"><input type="checkbox" name="adrotate_w3caching" id="adrotate_w3caching" <?php if($adrotate_config['w3caching'] == 'Y') { ?>checked="checked" <?php } ?> /> <?php _e('Check this box if you use W3 Total Caching on your site.', 'adrotate'); ?></label></td>
	</tr>
	<tr>
		<th valign="top"><?php _e('Borlabs Cache', 'adrotate'); ?></th>
		<td><label for="adrotate_borlabscache"><input type="checkbox" name="adrotate_borlabscache" id="adrotate_borlabscache" <?php if($adrotate_config['borlabscache'] == 'Y') { ?>checked="checked" <?php } ?> /> <?php _e('Check this box if you use Borlabs Caching on your site.', 'adrotate'); ?></label></td>
	</tr>
	<tr>
		<th valign="top">&nbsp;</th>
		<td><span class="description"><?php _e('It may take a while for the ad to start rotating. The caching plugin needs to refresh the cache. This can take up to a week if not done manually.', 'adrotate'); ?> <?php _e('Caching support only works for [shortcodes] and the AdRotate Widget. If you use a PHP Snippet you need to wrap your PHP in the exclusion code yourself.', 'adrotate'); ?></span></td>
	</tr>
</table>




<p class="submit">
  	<input type="submit" name="adrotate_save_options" class="button-primary" value="<?php _e('Update Options', 'adrotate'); ?>" />
</p>
</form>