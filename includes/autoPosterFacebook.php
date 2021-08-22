<?php

require_once __DIR__ . "/facebookSettings.php";
require_once __DIR__ . "/../lib/FacebookSDK/src/Facebook/autoload.php";
error_reporting(0);

class facebook
 {
   
    // class variables

    protected static $fb;
 
    public static function init() {
      $settings = get_option('facebook_config');

      $appId = $settings['app_id'];
      $appSecret =  $settings['app_secret'];

      self::$fb = new Facebook\Facebook(array(
        'app_id' => $appId,
        'app_secret' => $appSecret,
    ));
    }

    public static function post_fc($postID) {
      $message = get_option('facebook_config')['auto_message_fc'];
      $link = get_option('facebook_config')['fc_link'];
      $post = get_post($postID);
      $post_link = get_permalink($postID);
      $post_title = $post->post_title;
      $post_content = strip_tags($post->post_content);
      $post_content = str_replace('&nbsp;','',$post_content);
      $post_content = strip_shortcodes($post_content);
       $post_author_id = $post->post_author;
       $author_name = get_the_author_meta('user_nicename', $post_author_id);
      $message = str_replace('#post_title', $post_title, $message);
      $message = str_replace('#post_content', $post_content, $message);
      $message = str_replace('#post_link', $post_link, $message);
      $message = str_replace('#author_name', $author_name, $message);

      if($link == false){
        $linkData = [
          'message' => $message,
          'link' => $post_link,
        ];
      }else{
        $linkData = [
          'message' => $message,
          'link' => $link,
        ];
      }

      $page_id = get_option('facebook_config')['id_page'];
      $pageAccessToken = get_option('facebook_config')['access_token'];
      if(!empty($post_link) && $post->post_status == 'publish') {
      $response = self::$fb->post('/'.$page_id.'/feed/', $linkData, $pageAccessToken);
      $graphNode = $response->getGraphNode();
      }
    }

    public static function schedule($postID) {
      $minutes = get_option('facebook_config')['auto_time_fc'][3];
      $minutes1 = get_option('facebook_config')['auto_time_fc'][4];
      $hours = get_option('facebook_config')['auto_time_fc'][0];
      $hours1 = get_option('facebook_config')['auto_time_fc'][1];


      if( !wp_next_scheduled( 'share_the_post_fc', $postID) ){
        wp_clear_scheduled_hook( 'share_the_post_fc');
        wp_schedule_single_event(time() + $minutes1*60+ $minutes*600+$hours*36000+$hours1*3600, 'share_the_post_fc', array($postID));
        }
    }
    
    public static function recop($postID) {
      $options_program = get_option('recop_fc');
      if(end($options_program) !== $postID){
        $elemento = array_push($options_program, $postID);
        update_option('recop_fc', $options_program);
      }
  }

    public static function programm() {
      $settings = get_option('facebook_config');
      $options_program = get_option('recop_fc');
      $time_st = $settings['auto_time_start_fc'];
      $time_en = $settings['auto_time_end_fc'];

      $arr = array_map('intval', explode(':', $time_st));
      $time_start = mktime($arr[0], $arr[1], 1, date('m'), date('d'), date('Y'));
      $arr1 = array_map('intval', explode(':', $time_en));
      $time_end = mktime($arr1[0], $arr1[1], 1, date('m'), date('d'), date('Y'));

      if(!empty($options_program) && (time()+3600 > $time_start) && (time()+3600 < $time_end)){
        $appId = $settings['app_id'];
        $appSecret =  $settings['app_secret'];
        $postID = array_shift($options_program);
        update_option('recop_fc', $options_program);

        self::$fb = new Facebook\Facebook(array(
        'app_id' => $appId,
        'app_secret' => $appSecret,
        ));

        $message = get_option('facebook_config')['auto_message_fc'];
        $link = get_option('facebook_config')['fc_link'];
        $post = get_post($postID);
        $post_link = get_permalink($postID);
        $post_title = $post->post_title;
        $post_content = strip_tags($post->post_content);
        $post_content = str_replace('&nbsp;','',$post_content);
        $post_content = strip_shortcodes($post_content);
        $post_author_id = $post->post_author;
        $author_name = get_the_author_meta('user_nicename', $post_author_id);
        $message = str_replace('#post_title', $post_title, $message);
        $message = str_replace('#post_content', $post_content, $message);
        $message = str_replace('#post_link', $post_link, $message);
        $message = str_replace('#author_name', $author_name, $message);

        if($link == false){
          $linkData = [
            'message' => $message,
            'link' => $post_link,
          ];
        }else{
          $linkData = [
            'message' => $message,
            'link' => $link,
          ];
        }

        $page_id = get_option('facebook_config')['id_page'];
        $pageAccessToken = get_option('facebook_config')['access_token'];
        if(!empty($post_link) && $post->post_status == 'publish') {
        $response = self::$fb->post('/'.$page_id.'/feed/', $linkData, $pageAccessToken);
        $graphNode = $response->getGraphNode();
        }

      }
      else{
        return;
      }
    }

 }
 
function my_cron_schedules_fc($schedules){
  $schedules["5min"] = array(
      'interval' => 5*60,
      'display' => __('Once every 5 minutes'));
  return $schedules;
}

add_filter('cron_schedules','my_cron_schedules_fc');

$array = [];
add_option('recop_fc', $array);

if( !wp_next_scheduled( 'programm_fc') ){
  wp_schedule_event(time(), '5min', 'programm_fc');
}
add_action('programm_fc', 'facebook::programm');

 $autoFacebook = get_option('facebook_config')['auto_post_fc'];
 $autoSchedule = get_option('facebook_config')['auto_schedule_fc'];
 $autoProgram = get_option('facebook_config')['auto_program_fc'];

 if(($autoFacebook == 'si') && ($autoSchedule == 'no') && ($autoProgram == 'no')){
   add_action('init', 'facebook::init');
   add_action('save_post', 'facebook::post_fc');
 }
 else if(($autoFacebook == 'si') && ($autoSchedule == 'si')){
  add_action('init', 'facebook::init');
  add_action('publish_post', 'facebook::schedule');
  add_action('share_the_post_fc', 'facebook::post_fc', 10, 1);
 }
 else if(($autoFacebook == 'si') && ($autoProgram == 'si')){
  add_action('publish_post', 'facebook::recop');
 }


?>