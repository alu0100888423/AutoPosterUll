<?php

// require_once __DIR__ . "/facebookSettings.php";
require_once __DIR__ . "/../lib/FacebookSDK/src/Facebook/autoload.php";
error_reporting(0);

class Instagram
 {
   
    // class variables

    protected static $instagram_id;
    protected static $api_url;
 
    public static function init() {
      $page_id = get_option('instagram_config')['page_id'];
      $pageAccessToken = get_option('instagram_config')['access_token'];
      self::$api_url = 'https://graph.facebook.com/v11.0/';
      $response = wp_safe_remote_get( self::$api_url . $page_id . '?fields=instagram_business_account&access_token=' . $pageAccessToken );
  
      if ( is_array( $response ) && ! is_wp_error( $response ) ) {
         $body    = $response['body']; 
         error_log('INSTAGRAM BODY: ' . $body);

         $json_resp = json_decode($response['body']);
         self::$instagram_id = $json_resp->instagram_business_account->id;
         error_log('INSTAGRAM ID: ' . self::$instagram_id);
      }
    }

    public static function post_ig($postID) {
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
      $attachImage = get_option('instagram_config')['auto_img_ig'];
      $page_id = get_option('instagram_config')['page_id'];
      $post_title = $post->post_title;
      $pageAccessToken = get_option('instagram_config')['access_token'];
      $image_url = 'https://pbs.twimg.com/profile_images/734721751997919232/YJXhKMYp_400x400.jpg';
      if($attachImage == 'si'){ 
        $thumbID = get_post_thumbnail_id( $postID );
        $image_url = wp_get_attachment_image_url( $thumbID, 'original');
      }

      if(!empty($post_link) && $post->post_status == 'publish') {
      $response = wp_safe_remote_post( self::$api_url . self::$instagram_id . '/media?image_url=' . $image_url . '&caption=' . $message . '&access_token=' . $pageAccessToken , array(
        'method' => 'POST',
        'timeout' => 45,
        'redirection' => 5,
        'httpversion' => '1.0',
        'blocking' => true,
        'headers' => array(),
        'cookies' => array()
        )
     );
    }
     if ( is_wp_error( $response )) {
        $error_message = $response->get_error_message();
        error_log('CONTAINER ERROR: ' . $error_message);
     } else {
        error_log('CONTAINER BODY: ' . $response['body']);
        $json_resp = json_decode($response['body']);
        $container = $json_resp->id;
        error_log('Container: ' . $container);
     }

      $response = wp_safe_remote_post( self::$api_url . self::$instagram_id . '/media_publish?creation_id=' . $container . '&access_token=' . $pageAccessToken , array(
        'method' => 'POST',
        'timeout' => 45,
        'redirection' => 5,
        'httpversion' => '1.0',
        'blocking' => true,
        'headers' => array(),
        'cookies' => array()
        )
    );

    if ( is_wp_error( $response ) ) {
        $error_message = $response->get_error_message();
        error_log('PUBLISH INSTAGRAM ERROR: ' . $error_message);
    } else {
        error_log('PUBLISH INSTAGRAM BODY: ' . $response['body']);
    } 
  }

  public static function schedule($postID) {
    $minutes = get_option('instagram_config')['auto_time_ig'][3];
    $minutes1 = get_option('instagram_config')['auto_time_ig'][4];
    $hours = get_option('instagram_config')['auto_time_ig'][0];
    $hours1 = get_option('instagram_config')['auto_time_ig'][1];


    if( !wp_next_scheduled( 'share_the_post_ig', $postID) ){
      wp_clear_scheduled_hook( 'share_the_post_ig');
      wp_schedule_single_event(time() + $minutes1*60+ $minutes*600+$hours*36000+$hours1*3600, 'share_the_post_ig', array($postID));
      }
  }

  public static function recop($postID) {
    $options_program = get_option('recop_ig');
    if(end($options_program) !== $postID){
      $elemento = array_push($options_program, $postID);
      update_option('recop_ig', $options_program);
    }
  }

  public static function programm() {
      $settings = get_option('instagram_config');
      $options_program = get_option('recop_ig');
      $time_st = $settings['auto_time_start_ig'];
      $time_en = $settings['auto_time_end_ig'];

      $arr = array_map('intval', explode(':', $time_st));
      $time_start = mktime($arr[0], $arr[1], 1, date('m'), date('d'), date('Y'));
      $arr1 = array_map('intval', explode(':', $time_en));
      $time_end = mktime($arr1[0], $arr1[1], 1, date('m'), date('d'), date('Y'));

      if(!empty($options_program) && (time()+3600 > $time_start) && (time()+3600 < $time_end)){
        $page_id = get_option('instagram_config')['page_id'];
        $pageAccessToken = get_option('instagram_config')['access_token'];
        self::$api_url = 'https://graph.facebook.com/v11.0/';
        $response = wp_safe_remote_get( self::$api_url . $page_id . '?fields=instagram_business_account&access_token=' . $pageAccessToken );
    
        if ( is_array( $response ) && ! is_wp_error( $response ) ) {
           $body    = $response['body']; 
           error_log('INSTAGRAM BODY: ' . $body);
  
           $json_resp = json_decode($response['body']);
           self::$instagram_id = $json_resp->instagram_business_account->id;
           error_log('INSTAGRAM ID: ' . self::$instagram_id);
        }

        $postID = array_shift($options_program);
        update_option('recop_ig', $options_program);

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
        $attachImage = get_option('instagram_config')['auto_img_ig'];
        $page_id = get_option('instagram_config')['page_id'];
        $post_title = $post->post_title;
        $pageAccessToken = get_option('instagram_config')['access_token'];
        $image_url = 'https://pbs.twimg.com/profile_images/734721751997919232/YJXhKMYp_400x400.jpg';
        if($attachImage == 'si'){ 
          $thumbID = get_post_thumbnail_id( $postID );
          $image_url = wp_get_attachment_image_url( $thumbID, 'original');
        }

        if(!empty($post_link) && $post->post_status == 'publish') {
        $response = wp_safe_remote_post( self::$api_url . self::$instagram_id . '/media?image_url=' . $image_url . '&caption=' . $message . '&access_token=' . $pageAccessToken , array(
          'method' => 'POST',
          'timeout' => 45,
          'redirection' => 5,
          'httpversion' => '1.0',
          'blocking' => true,
          'headers' => array(),
          'cookies' => array()
          )
      );
      }
      if ( is_wp_error( $response )) {
          $error_message = $response->get_error_message();
          error_log('CONTAINER ERROR: ' . $error_message);
      } else {
          error_log('CONTAINER BODY: ' . $response['body']);
          $json_resp = json_decode($response['body']);
          $container = $json_resp->id;
          error_log('Container: ' . $container);
      }

        $response = wp_safe_remote_post( self::$api_url . self::$instagram_id . '/media_publish?creation_id=' . $container . '&access_token=' . $pageAccessToken , array(
          'method' => 'POST',
          'timeout' => 45,
          'redirection' => 5,
          'httpversion' => '1.0',
          'blocking' => true,
          'headers' => array(),
          'cookies' => array()
          )
      );

      if ( is_wp_error( $response ) ) {
          $error_message = $response->get_error_message();
          error_log('PUBLISH INSTAGRAM ERROR: ' . $error_message);
      } else {
          error_log('PUBLISH INSTAGRAM BODY: ' . $response['body']);
      } 
    }

  }

 }


function my_cron_schedules_ig($schedules){
  $schedules["5min"] = array(
      'interval' => 5*60,
      'display' => __('Once every 5 minutes'));
  return $schedules;
}

add_filter('cron_schedules','my_cron_schedules_ig');

$array = [];
add_option('recop_ig', $array);

if( !wp_next_scheduled( 'programm_ig') ){
  wp_schedule_event(time(), '5min', 'programm_ig');
}
add_action('programm_ig', 'Instagram::programm');


 $autoInstagram = get_option('instagram_config')['auto_post_ig'];
 $autoSchedule = get_option('instagram_config')['auto_schedule_ig'];
 $autoProgram = get_option('instagram_config')['auto_program_ig'];

 if(($autoInstagram == 'si') && ($autoSchedule == 'no') && ($autoProgram == 'no')){
  add_action('publish_post', 'Instagram::post');
 }
 else if(($autoInstagram == 'si') && ($autoSchedule == 'si')){
  add_action('publish_post', 'Instagram::schedule');
  add_action('share_the_post_ig', 'Instagram::post', 10, 1);
 }

?>