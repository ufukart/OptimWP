<?php
/*
	Plugin Name: OptimWP
	Description: WordPress Tweak Tool. Optimize Your WordPress.
	Plugin URI: http://www.ubilisim.com/
	Version: 1.1
	Author: UfukArt
	Author URI: http://www.ubilisim.com
	Text Domain: optimwp
	Domain Path: /languages/
	License: GPL2
*/

// Security
defined( 'ABSPATH' ) or exit;

// Load plugin translations
load_plugin_textdomain('optimwp', false, dirname(plugin_basename(__FILE__)) . '/languages');

// Add to db Default values when plugin activated
function optimwp_defaults(): void {
	$optimwp_options = [
		'optimwp_disable_comments'=> 0,
		'optimwp_disable_xmlrpc'=> 1,
		'optimwp_disable_restapi'=> 1,
		'optimwp_disable_rssfeed'=> 0,
		'optimwp_disable_login_language_switcher'=> 1,
		'optimwp_disable_auto_update_core'=> 0,
		'optimwp_disable_auto_update_plugin'=> 0,
		'optimwp_disable_auto_update_theme'=> 0,
		'optimwp_disable_auto_update_translation'=> 0,
		'optimwp_disable_auto_core_update_email'=> 1,
		'optimwp_disable_auto_plugin_update_email'=> 1,
		'optimwp_disable_auto_theme_update_email'=> 1,
		'optimwp_remove_css_ver'=> 1,
		'optimwp_remove_js_ver'=> 1,
		'optimwp_remove_wp_generator'=> 1,
		'optimwp_remove_visualcomposer_generator'=> 0,
		'optimwp_remove_revslider_generator'=> 0,
		'optimwp_remove_yoastseo_comments'=> 0,
		'optimwp_remove_wpml_meta'=> 0,
		'optimwp_remove_wp_dashicons'=> 1,
		'optimwp_remove_rsd_link'=> 1,
		'optimwp_remove_shortlink'=> 1,
		'optimwp_remove_wlwmanifest_link'=> 1,
		'optimwp_disable_file_editor'=> 1,
		'optimwp_change_login_error'=> 1,
		'optimwp_remove_powered_by'=> 1,
		'optimwp_disable_auto_linking'=> 1,
		'optimwp_remove_capital'=> 1,
		'optimwp_disable_post_revisions'=>[
			'0'=> 'post',
			'1'=> 'page',
		],
	];
	update_option('optimwp_options', $optimwp_options);
}
register_activation_hook( __FILE__, 'optimwp_defaults');

// Delete from db Default values when plugin deactivated
register_deactivation_hook( __FILE__, 'optimwp_delete' );
function optimwp_delete(): void {
	delete_option('optimwp_options');
}

if (is_admin()) {

	// Add Settings Link To Plugins Page
	add_filter('plugin_action_links', 'optimwp_plugin_action_links', 10, 2);

	function optimwp_plugin_action_links($links, $file) {
		static $this_plugin;
		
		if (!$this_plugin) {
			$this_plugin = plugin_basename(__FILE__);
		}

		if ($file == $this_plugin) {
			$settings_link = '<a href="' . get_bloginfo('wpurl') . '/wp-admin/options-general.php?page=optimwp">'. __('Settings', 'optimwp').'</a>';
			array_unshift($links, $settings_link);
		}
		return $links;
	}

	function optimwp_plugin_row_meta( $links, $file ): array {
		if ( plugin_basename( __FILE__ ) == $file ) {
			$row_meta = [
				'sponsor' => '<a href="' . esc_url( 'https://donate.stripe.com/7sIcQlbaR4rc7qobII' ) . '" target="_blank" aria-label="' . esc_attr__( 'Plugin Additional Links', 'optimwp' ) . '"><span class="dashicons dashicons-star-filled" aria-hidden="true" style="font-size:14px;line-height:1.3"></span> ' . esc_html__( 'Sponsor', 'optimwp' ) . '</a>'
			];

			return array_merge( $links, $row_meta );
		}

		return (array) $links;
	}

	add_filter( 'plugin_row_meta', 'optimwp_plugin_row_meta', 10, 2 );

	// Add Menu To WordPress
	function optimwp_menu(): void {
		add_options_page('OptimWP Settings', 'OptimWP', 'manage_options', 'optimwp', 'optimwp_manage' );
	}
	add_action( 'admin_menu', 'optimwp_menu' );
	
	// Plugin Management Page
	function optimwp_manage(): void{
		if( isset( $_POST['action'] ) && ( $_POST['action'] == 'update' ) ){
			// Wp_nonce check
			if (!isset( $_POST['optimwp_update'] ) || ! wp_verify_nonce( $_POST['optimwp_update'], 'optimwp_update' ) ) {
				echo __('Sorry, you do not have access to this page!', 'optimwp');
				exit;
			}else{
				$optimwp_disable_comments = sanitize_text_field($_POST['optimwp_disable_comments']);
				$optimwp_disable_xmlrpc = sanitize_text_field($_POST['optimwp_disable_xmlrpc']);
				$optimwp_disable_restapi = sanitize_text_field($_POST['optimwp_disable_restapi']);
				$optimwp_disable_rssfeed = sanitize_text_field($_POST['optimwp_disable_rssfeed']);
				$optimwp_disable_login_language_switcher = sanitize_text_field($_POST['optimwp_disable_login_language_switcher']);
				$optimwp_disable_auto_update_core = sanitize_text_field($_POST['optimwp_disable_auto_update_core']);
				$optimwp_disable_auto_update_plugin = sanitize_text_field($_POST['optimwp_disable_auto_update_plugin']);
				$optimwp_disable_auto_update_theme = sanitize_text_field($_POST['optimwp_disable_auto_update_theme']);
				$optimwp_disable_auto_update_translation = sanitize_text_field($_POST['optimwp_disable_auto_update_translation']);
				$optimwp_disable_auto_core_update_email = sanitize_text_field($_POST['optimwp_disable_auto_core_update_email']);
				$optimwp_disable_auto_plugin_update_email = sanitize_text_field($_POST['optimwp_disable_auto_plugin_update_email']);
				$optimwp_disable_auto_theme_update_email = sanitize_text_field($_POST['optimwp_disable_auto_theme_update_email']);
				$optimwp_remove_css_ver = sanitize_text_field($_POST['optimwp_remove_css_ver']);
				$optimwp_remove_js_ver = sanitize_text_field($_POST['optimwp_remove_js_ver']);
				$optimwp_remove_wp_generator = sanitize_text_field($_POST['optimwp_remove_wp_generator']);
				$optimwp_remove_visualcomposer_generator = sanitize_text_field($_POST['optimwp_remove_visualcomposer_generator']);
				$optimwp_remove_revslider_generator = sanitize_text_field($_POST['optimwp_remove_revslider_generator']);
				$optimwp_remove_yoastseo_comments = sanitize_text_field($_POST['optimwp_remove_yoastseo_comments']);
				$optimwp_remove_wpml_meta = sanitize_text_field($_POST['optimwp_remove_wpml_meta']);
				$optimwp_remove_wp_dashicons = sanitize_text_field($_POST['optimwp_remove_wp_dashicons']);
				$optimwp_remove_rsd_link = sanitize_text_field($_POST['optimwp_remove_rsd_link']);
				$optimwp_remove_shortlink = sanitize_text_field($_POST['optimwp_remove_shortlink']);
				$optimwp_disable_file_editor = sanitize_text_field($_POST['optimwp_disable_file_editor']);
				$optimwp_change_login_error = sanitize_text_field($_POST['optimwp_change_login_error']);
				$optimwp_remove_powered_by = sanitize_text_field($_POST['optimwp_remove_powered_by']);
				$optimwp_remove_wlwmanifest_link = sanitize_text_field($_POST['optimwp_remove_wlwmanifest_link']);
				$optimwp_disable_auto_linking = sanitize_text_field($_POST['optimwp_disable_auto_linking']);
				$optimwp_remove_capital = sanitize_text_field($_POST['optimwp_remove_capital']);
				if(!isset($_POST['optimwp_disable_post_revisions'])){
					$optimwp_disable_post_revisions =[];
				}else{
					$optimwp_disable_post_revisions = sanitize_html_class($_POST['optimwp_disable_post_revisions']);
				}
				$optimwp_options = [
					'optimwp_disable_comments'=> $optimwp_disable_comments,
					'optimwp_disable_xmlrpc'=> $optimwp_disable_xmlrpc,
					'optimwp_disable_restapi'=> $optimwp_disable_restapi,
					'optimwp_disable_rssfeed'=> $optimwp_disable_rssfeed,
					'optimwp_disable_login_language_switcher'=> $optimwp_disable_login_language_switcher,
					'optimwp_disable_auto_update_core'=> $optimwp_disable_auto_update_core,
					'optimwp_disable_auto_update_plugin'=> $optimwp_disable_auto_update_plugin,
					'optimwp_disable_auto_update_theme'=> $optimwp_disable_auto_update_theme,
					'optimwp_disable_auto_update_translation'=> $optimwp_disable_auto_update_translation,
					'optimwp_disable_auto_core_update_email'=> $optimwp_disable_auto_core_update_email,
					'optimwp_disable_auto_plugin_update_email'=> $optimwp_disable_auto_plugin_update_email,
					'optimwp_disable_auto_theme_update_email'=> $optimwp_disable_auto_theme_update_email,
					'optimwp_remove_css_ver'=> $optimwp_remove_css_ver,
					'optimwp_remove_js_ver'=> $optimwp_remove_js_ver,
					'optimwp_remove_wp_generator'=> $optimwp_remove_wp_generator,
					'optimwp_remove_visualcomposer_generator'=> $optimwp_remove_visualcomposer_generator,
					'optimwp_remove_revslider_generator'=> $optimwp_remove_revslider_generator,
					'optimwp_remove_yoastseo_comments'=> $optimwp_remove_yoastseo_comments,
					'optimwp_remove_wpml_meta'=> $optimwp_remove_wpml_meta,
					'optimwp_remove_wp_dashicons'=> $optimwp_remove_wp_dashicons,
					'optimwp_remove_rsd_link'=> $optimwp_remove_rsd_link,
					'optimwp_remove_shortlink'=> $optimwp_remove_shortlink,
					'optimwp_remove_wlwmanifest_link'=> $optimwp_remove_wlwmanifest_link,
					'optimwp_disable_file_editor'=> $optimwp_disable_file_editor,
					'optimwp_change_login_error'=> $optimwp_change_login_error,
					'optimwp_remove_powered_by'=> $optimwp_remove_powered_by,
					'optimwp_disable_auto_linking'=> $optimwp_disable_auto_linking,
					'optimwp_remove_capital'=> $optimwp_remove_capital,
					'optimwp_disable_post_revisions'=> $optimwp_disable_post_revisions
				];
				update_option('optimwp_options', $optimwp_options);
				$message = '<div id="setting-error-settings_updated" class="notice notice-success settings-error is-dismissible"><p><strong>'.__('Settings saved.', 'optimwp').'</strong></p></div>';
			}
		}
$my_options = get_option('optimwp_options');
?>
<div class="wrap">
	<a href="<?php echo esc_url(get_admin_url());?>options-general.php?page=optimwp"><img src="<?php echo esc_url(plugin_dir_url( __FILE__ )) . 'images/optimwp.png'?>" width="150" alt="OptimWP Logo"></a>
	<?php if(isset($message)) echo wp_kses_post($message);?>
<form method="post">
	<table class="form-table" role="presentation">
		<tr>
			<th scope="row">
				<label for="optimwp_disable_comments" class="custom-control-label"><?php echo __('Disable Comments', 'optimwp');?></label>
			</th>
			<td>
				<input type="hidden" name="optimwp_disable_comments" id="optimwp_disable_comments" value="0">
				<input type="checkbox" name="optimwp_disable_comments" id="optimwp_disable_comments" value="1" <?php if(isset($my_options['optimwp_disable_comments']) && $my_options['optimwp_disable_comments']) echo esc_html('checked');?>>
				<p class="description"><?php echo __('Completely Disable WP Comment System. Remove comments metabox from dashboard, Disable support for comments and trackbacks, Close comments on the front-end, Hide existing comments, Remove comments page in menu and Remove comments links from admin bar.', 'optimwp');?></p>
			</td>
		</tr>
		<tr>
			<th scope="row">
				<label for="optimwp_disable_xmlrpc" class="custom-control-label"><?php echo __('Disable XML-RPC', 'optimwp');?></label>
			</th>
			<td>
				<input type="hidden" name="optimwp_disable_xmlrpc" id="optimwp_disable_xmlrpc" value="0">
				<input type="checkbox" name="optimwp_disable_xmlrpc" id="optimwp_disable_xmlrpc" value="1" <?php if(isset($my_options['optimwp_disable_xmlrpc']) && $my_options['optimwp_disable_xmlrpc']) echo esc_html('checked');?>>
				<p class="description"><?php echo __('XML-RPC is a core WordPress API that allows users to connect to their WordPress website using third-party apps, tools, and services. If you want to access and publish your blog remotely, then you need XML-RPC enabled.', 'optimwp');?></p>
			</td>
		</tr>
		<tr>
			<th scope="row">
				<label for="optimwp_disable_restapi" class="custom-control-label"><?php echo __('Disable REST API', 'optimwp');?></label>
			</th>
			<td>
				<input type="hidden" name="optimwp_disable_restapi" id="optimwp_disable_restapi" value="0">
				<input type="checkbox" name="optimwp_disable_restapi" id="optimwp_disable_restapi" value="1" <?php if(isset($my_options['optimwp_disable_restapi']) && $my_options['optimwp_disable_restapi']) echo esc_html('checked');?>>
				<p class="description"><?php echo __('The WordPress REST API provides an interface for applications to interact with your WordPress site by sending and receiving data as JSON (JavaScript Object Notation) objects. Keeping REST API enabled for all users is useless. It’s better to block REST API for unwanted users. This will keep REST API only for Admin.', 'optimwp');?></p>
			</td>
		</tr>
		<tr>
			<th scope="row">
				<label for="optimwp_disable_rssfeed" class="custom-control-label"><?php echo __('Disable RSS Feeds', 'optimwp');?></label>
			</th>
			<td>
				<input type="hidden" name="optimwp_disable_rssfeed" id="optimwp_disable_rssfeed" value="0">
				<input type="checkbox" name="optimwp_disable_rssfeed" id="optimwp_disable_rssfeed" value="1" <?php if(isset($my_options['optimwp_disable_rssfeed']) && $my_options['optimwp_disable_rssfeed']) echo esc_html('checked');?>>
				<p class="description"><?php echo __('Turn off the WordPress RSS Feeds for your website with 1 click. Display a custom message instead of the RSS Feeds.', 'optimwp');?></p>
			</td>
		</tr>
		<tr>
			<th scope="row">
				<label for="optimwp_disable_login_language_switcher" class="custom-control-label"><?php echo __('Disable Login Language Switcher', 'optimwp');?></label>
			</th>
			<td>
				<input type="hidden" name="optimwp_disable_login_language_switcher" id="optimwp_disable_login_language_switcher" value="0">
				<input type="checkbox" name="optimwp_disable_login_language_switcher" id="optimwp_disable_login_language_switcher" value="1" <?php if(isset($my_options['optimwp_disable_login_language_switcher']) && $my_options['optimwp_disable_login_language_switcher']) echo esc_html('checked');?>>
				<p class="description"><?php echo __('Hide the Language Switcher on the default WordPress login screen.', 'optimwp');?></p>
			</td>
		</tr>
		<tr>
			<th scope="row">
				<label for="optimwp_disable_auto_update_core" class="custom-control-label"><?php echo __('Disable Auto-Update For WP Core', 'optimwp');?></label>
			</th>
			<td>
				<input type="hidden" name="optimwp_disable_auto_update_core" id="optimwp_disable_auto_update_core" value="0">
				<input type="checkbox" name="optimwp_disable_auto_update_core" id="optimwp_disable_auto_update_core" value="1" <?php if(isset($my_options['optimwp_disable_auto_update_core']) && $my_options['optimwp_disable_auto_update_core']) echo esc_html('checked');?>>
				<p class="description"><?php echo __('Disables Auto-Update Feature For WP Core.', 'optimwp');?></p>
			</td>
		</tr>
		<tr>
			<th scope="row">
				<label for="optimwp_disable_auto_update_plugin" class="custom-control-label"><?php echo __('Disable Auto-Update For Plugins', 'optimwp');?></label>
			</th>
			<td>
				<input type="hidden" name="optimwp_disable_auto_update_plugin" id="optimwp_disable_auto_update_plugin" value="0">
				<input type="checkbox" name="optimwp_disable_auto_update_plugin" id="optimwp_disable_auto_update_plugin" value="1" <?php if(isset($my_options['optimwp_disable_auto_update_plugin']) && $my_options['optimwp_disable_auto_update_plugin']) echo esc_html('checked');?>>
				<p class="description"><?php echo __('Disables Auto-Update Feature For Plugins.', 'optimwp');?></p>
			</td>
		</tr>
		<tr>
			<th scope="row">
				<label for="optimwp_disable_auto_update_theme" class="custom-control-label"><?php echo __('Disable Auto-Update For Themes', 'optimwp');?></label>
			</th>
			<td>
				<input type="hidden" name="optimwp_disable_auto_update_theme" id="optimwp_disable_auto_update_theme" value="0">
				<input type="checkbox" name="optimwp_disable_auto_update_theme" id="optimwp_disable_auto_update_theme" value="1" <?php if(isset($my_options['optimwp_disable_auto_update_theme']) && $my_options['optimwp_disable_auto_update_theme']) echo esc_html('checked');?>>
				<p class="description"><?php echo __('Disables Auto-Update Feature For Themes.', 'optimwp');?></p>
			</td>
		</tr>
		<tr>
			<th scope="row">
				<label for="optimwp_disable_auto_update_translation" class="custom-control-label"><?php echo __('Disable Auto-Update For Translations', 'optimwp');?></label>
			</th>
			<td>
				<input type="hidden" name="optimwp_disable_auto_update_translation" id="optimwp_disable_auto_update_translation" value="0">
				<input type="checkbox" name="optimwp_disable_auto_update_translation" id="optimwp_disable_auto_update_translation" value="1" <?php if(isset($my_options['optimwp_disable_auto_update_translation']) && $my_options['optimwp_disable_auto_update_translation']) echo esc_html('checked');?>>
				<p class="description"><?php echo __('Disables Auto-Update Feature For Translations.', 'optimwp');?></p>
			</td>
		</tr>
		<tr>
			<th scope="row">
				<label for="optimwp_disable_auto_core_update_email" class="custom-control-label"><?php echo __('Disable Auto-Update Email Notifications For WP Core', 'optimwp');?></label>
			</th>
			<td>
				<input type="hidden" name="optimwp_disable_auto_core_update_email" id="optimwp_disable_auto_core_update_email" value="0">
				<input type="checkbox" name="optimwp_disable_auto_core_update_email" id="optimwp_disable_auto_core_update_email" value="1" <?php if(isset($my_options['optimwp_disable_auto_core_update_email']) && $my_options['optimwp_disable_auto_core_update_email']) echo esc_html('checked');?>>
				<p class="description"><?php echo __('WordPress, email notifications will be sent after each attempt to auto-update. You can disable email notifications for WP core auto-updates', 'optimwp');?></p>
			</td>
		</tr>
		<tr>
			<th scope="row">
				<label for="optimwp_disable_auto_plugin_update_email" class="custom-control-label"><?php echo __('Disable Auto-Update Email Notifications For Plugins', 'optimwp');?></label>
			</th>
			<td>
				<input type="hidden" name="optimwp_disable_auto_plugin_update_email" id="optimwp_disable_auto_plugin_update_email" value="0">
				<input type="checkbox" name="optimwp_disable_auto_plugin_update_email" id="optimwp_disable_auto_plugin_update_email" value="1" <?php if(isset($my_options['optimwp_disable_auto_plugin_update_email']) && $my_options['optimwp_disable_auto_plugin_update_email']) echo esc_html('checked');?>>
				<p class="description"><?php echo __('WordPress, email notifications will be sent after each attempt to auto-update a plugin. You can disable email notifications for plugins auto-updates', 'optimwp');?></p>
			</td>
		</tr>
		<tr>
			<th scope="row">
				<label for="optimwp_disable_auto_theme_update_email" class="custom-control-label"><?php echo __('Disable Auto-Update Email Notifications For Themes', 'optimwp');?></label>
			</th>
			<td>
				<input type="hidden" name="optimwp_disable_auto_theme_update_email" id="optimwp_disable_auto_theme_update_email" value="0">
				<input type="checkbox" name="optimwp_disable_auto_theme_update_email" id="optimwp_disable_auto_theme_update_email" value="1" <?php if(isset($my_options['optimwp_disable_auto_theme_update_email']) && $my_options['optimwp_disable_auto_theme_update_email']) echo esc_html('checked');?>>
				<p class="description"><?php echo __('WordPress, email notifications will be sent after each attempt to auto-update a theme. You can disable email notifications for themes auto-updates', 'optimwp');?></p>
			</td>
		</tr>
		<tr>
			<th scope="row">
				<label for="optimwp_remove_css_ver" class="custom-control-label"><?php echo __('Remove Version from Stylesheets', 'optimwp');?></label>
			</th>
			<td>
				<input type="hidden" name="optimwp_remove_css_ver" id="optimwp_remove_css_ver" value="0">
				<input type="checkbox" name="optimwp_remove_css_ver" id="optimwp_remove_css_ver" value="1" <?php if(isset($my_options['optimwp_remove_css_ver']) && $my_options['optimwp_remove_css_ver']) echo esc_html('checked');?>>
				<p class="description"><?php echo __('WordPress appends a version number to css files with query string. Having query string with the URL browser does not cache the file because the file is treated as dynamic file.', 'optimwp');?></p>
			</td>
		</tr>
		<tr>
			<th scope="row">
				<label for="optimwp_remove_js_ver" class="custom-control-label"><?php echo __('Remove Version from Scripts', 'optimwp');?></label>
			</th>
			<td>
				<input type="hidden" name="optimwp_remove_js_ver" id="optimwp_remove_js_ver" value="0">
				<input type="checkbox" name="optimwp_remove_js_ver" id="optimwp_remove_js_ver" value="1" <?php if(isset($my_options['optimwp_remove_js_ver']) && $my_options['optimwp_remove_js_ver']) echo esc_html('checked');?>>
				<p class="description"><?php echo __('WordPress appends a version number to js files with query string. Having query string with the URL browser does not cache the file because the file is treated as dynamic file.', 'optimwp');?></p>
			</td>
		</tr>
		<tr>
			<th scope="row">
				<label for="optimwp_remove_wp_generator" class="custom-control-label"><?php echo __('Remove Generator Tag From Meta', 'optimwp');?></label>
			</th>
			<td>
				<input type="hidden" name="optimwp_remove_wp_generator" id="optimwp_remove_wp_generator" value="0">
				<input type="checkbox" name="optimwp_remove_wp_generator" id="optimwp_remove_wp_generator" value="1" <?php if(isset($my_options['optimwp_remove_wp_generator']) && $my_options['optimwp_remove_wp_generator']) echo esc_html('checked');?>>
				<p class="description"><?php echo __('WordPress adds a generator tag to meta tags. You can disable it.', 'optimwp');?></p>
			</td>
		</tr>
		<tr>
			<th scope="row">
				<label for="optimwp_remove_visualcomposer_generator" class="custom-control-label"><?php echo __('Remove Visual Composer Generator Meta Tag', 'optimwp');?></label>
			</th>
			<td>
				<input type="hidden" name="optimwp_remove_visualcomposer_generator" id="optimwp_remove_visualcomposer_generator" value="0">
				<input type="checkbox" name="optimwp_remove_visualcomposer_generator" id="optimwp_remove_visualcomposer_generator" value="1" <?php if(isset($my_options['optimwp_remove_visualcomposer_generator']) && $my_options['optimwp_remove_visualcomposer_generator']) echo esc_html('checked');?>>
				<p class="description"><?php echo __('Remove Visual Composer Generator Meta Tag in WordPress Head', 'optimwp');?></p>
			</td>
		</tr>
		<tr>
			<th scope="row">
				<label for="optimwp_remove_revslider_generator" class="custom-control-label"><?php echo __('Remove Revolution Slider Generator Meta Tag', 'optimwp');?></label>
			</th>
			<td>
				<input type="hidden" name="optimwp_remove_revslider_generator" id="optimwp_remove_revslider_generator" value="0">
				<input type="checkbox" name="optimwp_remove_revslider_generator" id="optimwp_remove_revslider_generator" value="1" <?php if(isset($my_options['optimwp_remove_revslider_generator']) && $my_options['optimwp_remove_revslider_generator']) echo esc_html('checked');?>>
				<p class="description"><?php echo __('Remove Revolution Slider Generator Meta Tag in WordPress Head', 'optimwp');?></p>
			</td>
		</tr>
		<tr>
			<th scope="row">
				<label for="optimwp_remove_yoastseo_comments" class="custom-control-label"><?php echo __('Remove Yoast SEO HTML Comments', 'optimwp');?></label>
			</th>
			<td>
				<input type="hidden" name="optimwp_remove_yoastseo_comments" id="optimwp_remove_yoastseo_comments" value="0">
				<input type="checkbox" name="optimwp_remove_yoastseo_comments" id="optimwp_remove_yoastseo_comments" value="1" <?php if(isset($my_options['optimwp_remove_yoastseo_comments']) && $my_options['optimwp_remove_yoastseo_comments']) echo esc_html('checked');?>>
				<p class="description"><?php echo __('Remove All Yoast HTML Comments From Page source. Though HTML comments are not visible but these are a part of DOM tree and increase the number of DOM elements. Too many HTML comments can increase the overall size of any page. Keeping a few HTML comments may not affect your page speed. But if you have too many HTML comments, then definitely it will decrease your webpage speed.', 'optimwp');?></p>
			</td>
		</tr>
		<tr>
			<th scope="row">
				<label for="optimwp_remove_wpml_meta" class="custom-control-label"><?php echo __('Remove WPML Generator Meta', 'optimwp');?></label>
			</th>
			<td>
				<input type="hidden" name="optimwp_remove_wpml_meta" id="optimwp_remove_wpml_meta" value="0">
				<input type="checkbox" name="optimwp_remove_wpml_meta" id="optimwp_remove_wpml_meta" value="1" <?php if(isset($my_options['optimwp_remove_wpml_meta']) && $my_options['optimwp_remove_wpml_meta']) echo esc_html('checked');?>>
				<p class="description"><?php echo __('Remove WPML Generator Meta From WordPress Head', 'optimwp');?></p>
			</td>
		</tr>
		<tr>
			<th scope="row">
				<label for="optimwp_remove_wp_dashicons" class="custom-control-label"><?php echo __('Remove WordPress Dashicons', 'optimwp');?></label>
			</th>
			<td>
				<input type="hidden" name="optimwp_remove_wp_dashicons" id="optimwp_remove_wp_dashicons" value="0">
				<input type="checkbox" name="optimwp_remove_wp_dashicons" id="optimwp_remove_wp_dashicons" value="1" <?php if(isset($my_options['optimwp_remove_wp_dashicons']) && $my_options['optimwp_remove_wp_dashicons']) echo esc_html('checked');?>>
				<p class="description"><?php echo __('Dashicons is the official WordPress icon since WordPress 3.8. The dashicons.min.css script loads in front end, which seems unnecessary to some users. It only needs on the backend for dashboard icons. If you are not using any Dashicons on your page or post. Then you can disable the script from loading. It can enhance a little performance.', 'optimwp');?></p>
			</td>
		</tr>
		<tr>
			<th scope="row">
				<label for="optimwp_remove_rsd_link" class="custom-control-label"><?php echo __('Remove RSD Link From Meta', 'optimwp');?></label>
			</th>
			<td>
				<input type="hidden" name="optimwp_remove_rsd_link" id="optimwp_remove_rsd_link" value="0">
				<input type="checkbox" name="optimwp_remove_rsd_link" id="optimwp_remove_rsd_link" value="1" <?php if(isset($my_options['optimwp_remove_rsd_link']) && $my_options['optimwp_remove_rsd_link']) echo esc_html('checked');?>>
				<p class="description"><?php echo __('By default, WordPress adds a link tag is for used by blog clients in every WordPress install. If you edit your site from your browser then you don’t need this. You can disable it.', 'optimwp');?></p>
			</td>
		</tr>
		<tr>
			<th scope="row">
				<label for="optimwp_remove_shortlink" class="custom-control-label"><?php echo __('Remove Short Link From Meta', 'optimwp');?></label>
			</th>
			<td>
				<input type="hidden" name="optimwp_remove_shortlink" id="optimwp_remove_shortlink" value="0">
				<input type="checkbox" name="optimwp_remove_shortlink" id="optimwp_remove_shortlink" value="1" <?php if(isset($my_options['optimwp_remove_shortlink']) && $my_options['optimwp_remove_shortlink']) echo esc_html('checked');?>>
				<p class="description"><?php echo __('By default, WordPress adds a link like https://example.com/?p=ID to head. You can disable it.', 'optimwp');?></p>
			</td>
		</tr>
		<tr>
			<th scope="row">
				<label for="optimwp_remove_wlwmanifest_link" class="custom-control-label"><?php echo __('Remove WLW Manifest Link From Meta', 'optimwp');?></label>
			</th>
			<td>
				<input type="hidden" name="optimwp_remove_wlwmanifest_link" id="optimwp_remove_wlwmanifest_link" value="0">
				<input type="checkbox" name="optimwp_remove_wlwmanifest_link" id="optimwp_remove_wlwmanifest_link" value="1" <?php if(isset($my_options['optimwp_remove_wlwmanifest_link']) && $my_options['optimwp_remove_wlwmanifest_link']) echo esc_html('checked');?>>
				<p class="description"><?php echo __('wlwmanifest.xml is a static file with information on how Windows Live Writer can talk to WordPress. It has nothing to do with security or performance. If you just love to keep your head area net and clean then you can remove it.', 'optimwp');?></p>
			</td>
		</tr>
		<tr>
			<th scope="row">
				<label for="optimwp_disable_file_editor" class="custom-control-label"><?php echo __('Disable File Editor', 'optimwp');?></label>
			</th>
			<td>
				<input type="hidden" name="optimwp_disable_file_editor" id="optimwp_disable_file_editor" value="0">
				<input type="checkbox" name="optimwp_disable_file_editor" id="optimwp_disable_file_editor" value="1" <?php if(isset($my_options['optimwp_disable_file_editor']) && $my_options['optimwp_disable_file_editor']) echo esc_html('checked');?>>
				<p class="description"><?php echo __('WordPress allows you to edit your plugin and theme files directly through its admin panel. Although, this is dangerous because a single typo can render your website blank.', 'optimwp');?></p>
			</td>
		</tr>
		<tr>
			<th scope="row">
				<label for="optimwp_change_login_error" class="custom-control-label"><?php echo __('Change Login Error Message', 'optimwp');?></label>
			</th>
			<td>
				<input type="hidden" name="optimwp_change_login_error" id="optimwp_change_login_error" value="0">
				<input type="checkbox" name="optimwp_change_login_error" id="optimwp_change_login_error" value="1" <?php if(isset($my_options['optimwp_change_login_error']) && $my_options['optimwp_change_login_error']) echo esc_html('checked');?>>
				<p class="description"><?php echo __('Change Login Error Message in WordPress to "The username or password is incorrect.". Improve safety by hiding the specific login error information.', 'optimwp');?></p>
			</td>
		</tr>
		<tr>
			<th scope="row">
				<label for="optimwp_remove_powered_by" class="custom-control-label"><?php echo __('Remove Powered By HTTP header', 'optimwp');?></label>
			</th>
			<td>
				<input type="hidden" name="optimwp_remove_powered_by" id="optimwp_remove_powered_by" value="0">
				<input type="checkbox" name="optimwp_remove_powered_by" id="optimwp_remove_powered_by" value="1" <?php if(isset($my_options['optimwp_remove_powered_by']) && $my_options['optimwp_remove_powered_by']) echo esc_html('checked');?>>
				<p class="description"><?php echo __('Remove information about the plugins and software used by your site. E.g., X-Powered-By: PHP/7.4.1', 'optimwp');?></p>
			</td>
		</tr>
		<tr>
			<th scope="row">
				<label for="optimwp_disable_auto_linking" class="custom-control-label"><?php echo __('Disable Auto Linking of URLs', 'optimwp');?></label>
			</th>
			<td>
				<input type="hidden" name="optimwp_disable_auto_linking" id="optimwp_disable_auto_linking" value="0">
				<input type="checkbox" name="optimwp_disable_auto_linking" id="optimwp_disable_auto_linking" value="1" <?php if(isset( $my_options['optimwp_disable_auto_linking'] ) && $my_options['optimwp_disable_auto_linking']) echo esc_html('checked');?>>
				<p class="description"><?php echo __('WordPress automatically set hyperlink for the URL in comment section. Disable Auto Linking of URLs in WordPress Comments', 'optimwp');?></p>
			</td>
		</tr>
		<tr>
			<th scope="row">
				<label for="optimwp_remove_capital" class="custom-control-label"><?php echo __('Remove Capital P Dangit', 'optimwp');?></label>
			</th>
			<td>
				<input type="hidden" name="optimwp_remove_capital" id="optimwp_remove_capital" value="0">
				<input type="checkbox" name="optimwp_remove_capital" id="optimwp_remove_capital" value="1" <?php if(isset( $my_options['optimwp_remove_capital'] ) && $my_options['optimwp_disable_auto_linking']) echo esc_html('checked');?>>
				<p class="description"><?php echo __('Remove Capital P Dangit To Speed Up Website. WordPress executed a little piece of code in your every webpage for makes the letter P in the word wordpress uppercase if lowercase. It’s better to get rid of this “Capital P Dangit” for better performance.', 'optimwp');?></p>
			</td>
		</tr>
		<tr>
			<th scope="row">
				<label for="optimwp_disable_post_revisions" class="custom-control-label"><?php echo __('Disable Posts Revisions', 'optimwp');?></label>
			</th>
			<td>
				<?php
					$value = $my_options['optimwp_disable_post_revisions'];
					$post_types = get_post_types( array(), 'objects' );
					echo '<select id="optimwp_disable_post_revisions" name="optimwp_disable_post_revisions[]" multiple="multiple">';
					foreach ( $post_types as $post_type => $post ) {
						echo '<option value="' . esc_attr( $post_type ) . '" ' . selected( true, in_array( $post_type, $value ), false ) . '>' . esc_attr( $post->label ) . '</option>';
					}
					echo '</select>';
				?>
				<p class="description"><?php echo __('The WordPress revisions system stores a record of each saved draft or published update. Disable post revisions for selected post types to reduce database and server load. To select multiple post types, hold ctrl key while selecting. Do not select a post type if you are not sure about it.', 'optimwp');?></p>
			</td>
		</tr>
	</table>
	<div class="submit">
		<input type="submit" class="button button-primary" value="<?php echo __('Update', 'optimwp');?>">
	</div>
	<input type="hidden" name="action" value="update">
	<?php wp_nonce_field('optimwp_update','optimwp_update');?>
</form>
</div>
<?php
	}
}
$my_options = get_option('optimwp_options');
if(is_array($my_options)) {

	// Disable Comments
	if($my_options['optimwp_disable_comments']){
		add_action('admin_init', function () {
			// Redirect any user trying to access comments page
			global $pagenow;

			if ($pagenow === 'edit-comments.php') {
				wp_safe_redirect(admin_url());
				exit;
			}

			// Remove comments metabox from dashboard
			remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');

			// Disable support for comments and trackbacks in post types
			foreach (get_post_types() as $post_type) {
				if (post_type_supports($post_type, 'comments')) {
					remove_post_type_support($post_type, 'comments');
					remove_post_type_support($post_type, 'trackbacks');
				}
			}
		});

		// Close comments on the front-end
		add_filter('comments_open', '__return_false', 20, 2);
		add_filter('pings_open', '__return_false', 20, 2);

		// Hide existing comments
		add_filter('comments_array', '__return_empty_array', 10, 2);

		// Remove comments page in menu
		add_action('admin_menu', function () {
			remove_menu_page('edit-comments.php');
		});

		// Remove comments links from admin bar
		add_action('init', function () {
			if (is_admin_bar_showing()) {
				remove_action('admin_bar_menu', 'wp_admin_bar_comments_menu', 60);
			}
		});
	}

	// Disable XML-RPC
	if(isset($my_options['optimwp_disable_xmlrpc']) && $my_options['optimwp_disable_xmlrpc']){
		add_filter( 'xmlrpc_enabled', '__return_false' );
		add_filter( 'xmlrpc_methods', 'optimwp_remove_xmlrpc_methods' );
	}
	function optimwp_remove_xmlrpc_methods( $methods ): array {
		return array();
	}

	// Disable REST API
	if(isset($my_options['optimwp_disable_restapi']) && $my_options['optimwp_disable_restapi']){
		add_filter('json_enabled', '__return_false');
		add_filter('json_jsonp_enabled', '__return_false');
		add_filter('rest_jsonp_enabled', '__return_false');
		remove_action('wp_head', 'rest_output_link_wp_head');
		remove_action('wp_head', 'wp_oembed_add_discovery_links');
	}

	// Disable RSS FEED
	if(isset($my_options['optimwp_disable_rssfeed']) && $my_options['optimwp_disable_rssfeed']){
		// Replace all feeds with the message above.
		add_action( 'do_feed_rdf', 'optimwp_wpcode_snippet_disable_feed', 1 );
		add_action( 'do_feed_rss', 'optimwp_wpcode_snippet_disable_feed', 1 );
		add_action( 'do_feed_rss2', 'optimwp_wpcode_snippet_disable_feed', 1 );
		add_action( 'do_feed_atom', 'optimwp_wpcode_snippet_disable_feed', 1 );
		add_action( 'do_feed_rss2_comments', 'optimwp_wpcode_snippet_disable_feed', 1 );
		add_action( 'do_feed_atom_comments', 'optimwp_wpcode_snippet_disable_feed', 1 );
		// Remove links to feed from the header.
		remove_action( 'wp_head', 'feed_links_extra', 3 );
		remove_action( 'wp_head', 'feed_links', 2 );
	}
	function optimwp_wpcode_snippet_disable_feed(): void {
		wp_die(
			sprintf(
				// Translators: Placeholders for the homepage link.
				esc_html__( 'No feed available, please visit our %1$shomepage%2$s!' ),
				' <a href="' . esc_url( home_url( '/' ) ) . '">',
				'</a>'
			)
		);
	}

	// Disable Login Screen Language Switcher
	if(isset($my_options['optimwp_disable_login_language_switcher']) && $my_options['optimwp_disable_login_language_switcher']){
		add_filter( 'login_display_language_dropdown', '__return_false' );
	}

	// Disable auto-update for WP Core.
	if(isset($my_options['optimwp_disable_auto_update_core']) && $my_options['optimwp_disable_auto_update_core']){
		add_filter( 'automatic_updater_disabled', '__return_true' );
		add_filter( 'auto_update_core', '__return_false' );
	}

	// Disable auto-update for plugins.
	if(isset($my_options['optimwp_disable_auto_update_plugin']) && $my_options['optimwp_disable_auto_update_plugin']){
		add_filter( 'automatic_updater_disabled', '__return_true' );
		add_filter( 'auto_update_plugin', '__return_false' );
	}

	// Disable auto-update for themes.
	if(isset($my_options['optimwp_disable_auto_update_theme']) && $my_options['optimwp_disable_auto_update_theme']){
		add_filter( 'automatic_updater_disabled', '__return_true' );
		add_filter( 'auto_update_theme', '__return_false' );
	}

	// Disable auto-update for translations.
	if(isset($my_options['optimwp_disable_auto_update_translation']) && $my_options['optimwp_disable_auto_update_translation']){
		add_filter( 'automatic_updater_disabled', '__return_true' );
		add_filter( 'auto_update_translation', '__return_false' );
	}

	// Disable plugins auto-update email notifications.
	if(isset($my_options['optimwp_disable_auto_plugin_update_email']) && $my_options['optimwp_disable_auto_plugin_update_email']){
		add_filter( 'auto_plugin_update_send_email', '__return_false' );
	}

	// Disable WP Core auto-update email notifications.
	if(isset($my_options['optimwp_disable_auto_core_update_email']) && $my_options['optimwp_disable_auto_core_update_email']){
		add_filter( 'auto_core_update_send_email', '__return_false' );
	}

	// Disable themes auto-update email notifications.
	if(isset($my_options['optimwp_disable_auto_theme_update_email']) && $my_options['optimwp_disable_auto_theme_update_email']){
		add_filter( 'auto_theme_update_send_email', '__return_false' );
	}

	// Remove query string from CSS files
	if(isset($my_options['optimwp_remove_css_ver']) && $my_options['optimwp_remove_css_ver']){
		add_filter('style_loader_src', 'optimwp_remove_cssjs_ver',10,2);
	}

	// Remove query string from JS files
	if(isset($my_options['optimwp_remove_js_ver']) && $my_options['optimwp_remove_js_ver']){
		add_filter('script_loader_src', 'optimwp_remove_cssjs_ver',10,2);
	}

	// Remove query string from static files
	function optimwp_remove_cssjs_ver( $src ) {
		if( strpos( $src, '?ver=' ) )
			$src = remove_query_arg( 'ver', $src );
		return $src;
	}

	// Remove Wp Generator Tag
	if(isset($my_options['optimwp_remove_wp_generator']) && $my_options['optimwp_remove_wp_generator']){
		add_filter('the_generator', '__return_empty_string');
	}

	if ( ! function_exists( 'get_plugins' ) || ! function_exists( 'is_plugin_active' ) ) {
		require_once ABSPATH . 'wp-admin/includes/plugin.php';
	}

	//Plugin installed and active control
	function optimwp_check_plugin_installed( $plugin_slug ): bool {
		$installed_plugins = get_plugins();
		return array_key_exists( $plugin_slug, $installed_plugins ) || in_array( $plugin_slug, $installed_plugins, true );
	}

	function optimwp_check_plugin_active( $plugin_slug ): bool {
		if ( is_plugin_active( $plugin_slug ) ) {
			return true;
		}
		return false;
	}

	// Remove Visual Composer Generator Tag
	$installed = optimwp_check_plugin_installed( "js_composer/js_composer.php" );
	$active    = optimwp_check_plugin_active( "js_composer/js_composer.php" );
	if ( $installed && $active && isset($my_options['optimwp_remove_visualcomposer_generator']) && $my_options['optimwp_remove_visualcomposer_generator']) {
		add_filter( 'vcv:api:output:meta', '__return_null' );
	}

	// Remove Revolution Slider Generator Tag
	$installed = optimwp_check_plugin_installed( "revslider/revslider.php" );
	$active    = optimwp_check_plugin_active( "revslider/revslider.php" );
	if ( $installed && $active && isset($my_options['optimwp_remove_revslider_generator']) && $my_options['optimwp_remove_revslider_generator']) {
		add_filter('revslider_meta_generator', '__return_empty_string');
	}

	// Remove All Yoast HTML Comments From Page source
	$installed = optimwp_check_plugin_installed( "wordpress-seo/wp-seo.php" );
	$active    = optimwp_check_plugin_active( "wordpress-seo/wp-seo.php" );
	if ( $installed && $active && isset($my_options['optimwp_remove_yoastseo_comments']) && $my_options['optimwp_remove_yoastseo_comments']) {
		add_filter('wpseo_debug_markers', '__return_false');
	}

	// Remove WPML meta generator tag
	$installed = optimwp_check_plugin_installed( "sitepress-multilingual-cms/sitepress.php" );
	$active    = optimwp_check_plugin_active( "sitepress-multilingual-cms/sitepress.php" );
	if ( $installed && $active && isset($my_options['optimwp_remove_wpml_meta']) && $my_options['optimwp_remove_wpml_meta']) {
		add_action('wp_head', 'optimwp_remove_wpml_generator', 0);
	}
	function optimwp_remove_wpml_generator(): void{
		if (!empty($GLOBALS['sitepress'])) {
			remove_action(current_filter(), array($GLOBALS['sitepress'], 'meta_generator_tag'));
		}
	}

	// Remove Dashicons from Admin Bar for non-logged-in users
	if(isset($my_options['optimwp_remove_wp_dashicons']) && $my_options['optimwp_remove_wp_dashicons']){
		add_action('wp_print_styles', 'optimwp_remove_wp_dashicons', 100);
	}
	function optimwp_remove_wp_dashicons(): void{
		if (!is_admin_bar_showing() && !is_customize_preview()) {
			wp_dequeue_style('dashicons');
			wp_deregister_style('dashicons');
		}
	}	

	// Remove RSD Link
	if(isset($my_options['optimwp_remove_rsd_link']) && $my_options['optimwp_remove_rsd_link']){
		remove_action('wp_head', 'rsd_link');
	}

	// Remove Short Link
	if(isset($my_options['optimwp_remove_shortlink']) && $my_options['optimwp_remove_shortlink']){
		remove_action('wp_head', 'wp_shortlink_wp_head');
	}

	// Remove WLWManifest Link
	if(isset($my_options['optimwp_remove_wlwmanifest_link']) && $my_options['optimwp_remove_wlwmanifest_link']){
		remove_action('wp_head', 'wlwmanifest_link');
	}

	// Disable Plugin and Theme Files Edit
	if(isset($my_options['optimwp_disable_file_editor']) && $my_options['optimwp_disable_file_editor']){
		add_action('init','optimwp_disable_file_edit_action');
	}
	function optimwp_disable_file_edit_action(): void {
		define('DISALLOW_FILE_EDIT', true);
		//define('DISALLOW_FILE_MODS', true); //Maybe Later.
	}

	// Change Default Login Error Message
	if(isset($my_options['optimwp_change_login_error']) && $my_options['optimwp_change_login_error']){
		add_filter('login_errors','optimwp_change_login_errors');
	}
	function optimwp_change_login_errors(): string {
		return 'The username or password is incorrect.';
	}

	// Remove powered by HTTP header
	if(isset($my_options['optimwp_remove_powered_by']) && $my_options['optimwp_remove_powered_by']){
		add_action('wp', 'optimwp_remove_powered_by');
	}
	function optimwp_remove_powered_by(): void {
		if (function_exists('header_remove')) {
			header_remove('x-powered-by');
		}
	}

	// Disable Auto Linking of URLs in WordPress Comments
	if(isset($my_options['optimwp_disable_auto_linking']) && $my_options['optimwp_disable_auto_linking']){
		add_action('wp', 'optimwp_disable_auto_linking');
	}
	function optimwp_disable_auto_linking(): void {
		remove_filter('comment_text', 'make_clickable', 9);
	}

	// Remove Capital P Dangit To Speed Up Website
	if(isset($my_options['optimwp_remove_capital']) && $my_options['optimwp_remove_capital']){
		add_action('wp', 'optimwp_remove_capital');
	}
	function optimwp_remove_capital(): void {
		remove_filter('the_title', 'capital_P_dangit', 11);
		remove_filter('the_content', 'capital_P_dangit', 11);
		remove_filter('comment_text', 'capital_P_dangit', 31);
	}

	// Disable WP Post Revisions
	if(isset($my_options['optimwp_disable_post_revisions']) && !empty($my_options['optimwp_disable_post_revisions'])){
		add_action('admin_init', 'optimwp_disable_revisions');
	}
	function optimwp_disable_revisions(): void {
		$my_options = get_option('optimwp_options');
		$post_types = $my_options['optimwp_disable_post_revisions'];
		if (is_array($post_types) || !empty($post_types)) {
			foreach ($post_types as $post_type) {
				remove_post_type_support($post_type, 'revisions');
			}
		}
	}
}