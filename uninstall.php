<?php

if( !defined( 'WP_UNINSTALL_PLUGIN' ) ){
  exit();
}

global $wpdb;

$option_twitter = 'twitter_config';
$option_facebook = 'facebook_config';
$option_instagram = 'instagram_config';
$option_telegram = 'telegram_config';
$program_tw = 'recop_tw';
$program_fc = 'recop_fc';
$program_tg = 'recop_tg';
$program_ig = 'recop_ig';

delete_option($option_twitter);
delete_option($option_facebook);
delete_option($option_instagram);
delete_option($option_telegram);
delete_option($program_tw);
delete_option($program_fc);
delete_option($program_tg);
delete_option($program_ig);

//if you want to delete one table
//$wpdb->query("DROP TABLE IF EXISTS{$wpdb->prefix}nombre_tabla")

?>