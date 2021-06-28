<?php

if( !defined( 'WP_UNINSTALL_PLUGIN' ) ){
  exit();
}

global $wpdb;

$option_twitter = 'twitter_config';
$option_facebook = 'facebook_config';
$option_instagram = 'instagram_config';
delete_option($option_twitter);
delete_option($option_facebook);
delete_option($option_instagram;

//if you want to delete one table
//$wpdb->query("DROP TABLE IF EXISTS{$wpdb->prefix}nombre_tabla")

?>