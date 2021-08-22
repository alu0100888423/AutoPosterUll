<?php

require_once __DIR__ . "/twitterSettings.php";
error_reporting(0);

class Twitter
 {
   
    // class variables

    protected static $codebird;
 
    public static function init() {
      $settings = get_option('twitter_config');

      $apiKey = $settings['api_key'];
      $apiSecret =  $settings['api_key_secret'];
      $accessToken =  $settings['access_token'];
      $accessTokenSecret =  $settings['access_token_secret'];

      \Codebird\Codebird::setConsumerKey($apiKey, $apiSecret);
      self::$codebird = \Codebird\Codebird::getInstance();
      self::$codebird->setToken($accessToken, $accessTokenSecret); 
    }

    public static function tweet($postID) {
      $message = get_option('twitter_config')['auto_message'];
      $attachImage = get_option('twitter_config')['auto_img'];
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
      $thumbID = get_post_thumbnail_id( $postID );
      $imgLink = wp_get_attachment_image_url( $thumbID, 'original');

      if($attachImage == 'si' && $thumbID != ""){
         $reply = self::$codebird->media_upload(array(
           'media' => $imgLink
         ));
         $image_id = $reply->media_id_string;
         $params = array(
           'status' => $message,
           'media_ids' => $image_id
           );
      }
      else if(($attachImage == 'si' && $thumbID == "") || ($attachImage == 'no')){
        $params = array(
          'status' => $message
        );
      }
    if(!empty($post_link) && $post->post_status == 'publish') {
        self::$codebird->statuses_update($params);
      }

    }

    public static function schedule($postID) {
      $minutes = get_option('twitter_config')['auto_time'][3];
      $minutes1 = get_option('twitter_config')['auto_time'][4];
      $hours = get_option('twitter_config')['auto_time'][0];
      $hours1 = get_option('twitter_config')['auto_time'][1];


      if( !wp_next_scheduled( 'share_the_post', $postID) ){
        wp_clear_scheduled_hook( 'share_the_post');
        wp_schedule_single_event(time() + $minutes1*60+ $minutes*600+$hours*36000+$hours1*3600, 'share_the_post', array($postID));
        }
    }

    public static function recop($postID) {
        $options_program = get_option('recop_tw');
        if(end($options_program) !== $postID){
          $elemento = array_push($options_program, $postID);
          update_option('recop_tw', $options_program);
        }
    }

    public static function programm() {
      $settings = get_option('twitter_config');
      $options_program = get_option('recop_tw');
      $time_st = $settings['auto_time_start'];
      $time_en = $settings['auto_time_end'];

      $arr = array_map('intval', explode(':', $time_st));
      $time_start = mktime($arr[0], $arr[1], 1, date('m'), date('d'), date('Y'));
      $arr1 = array_map('intval', explode(':', $time_en));
      $time_end = mktime($arr1[0], $arr1[1], 1, date('m'), date('d'), date('Y'));

      if(!empty($options_program) && (time()+3600 > $time_start) && (time()+3600 < $time_end)){
        $apiKey = $settings['api_key'];
        $apiSecret =  $settings['api_key_secret'];
        $accessToken =  $settings['access_token'];
        $accessTokenSecret =  $settings['access_token_secret'];
  
        \Codebird\Codebird::setConsumerKey($apiKey, $apiSecret);
        self::$codebird = \Codebird\Codebird::getInstance();
        self::$codebird->setToken($accessToken, $accessTokenSecret);

        $postID = array_shift($options_program);
        update_option('recop_tw', $options_program);
        
        $message = get_option('twitter_config')['auto_message'];
        $attachImage = get_option('twitter_config')['auto_img'];
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
        $thumbID = get_post_thumbnail_id( $postID );
        $imgLink = wp_get_attachment_image_url( $thumbID, 'original');
         
        if($attachImage == 'si' && $thumbID != ""){
          $reply = self::$codebird->media_upload(array(
            'media' => $imgLink
          ));
          $image_id = $reply->media_id_string;
          $params = array(
            'status' => $message,
            'media_ids' => $image_id
            );
       }
       else if(($attachImage == 'si' && $thumbID == "") || ($attachImage == 'no')){
         $params = array(
           'status' => $message
         );
       }
       if(!empty($post_link) && $post->post_status == 'publish') {
        self::$codebird->statuses_update($params);
       }
      }
      else{
        return;
      }
    }
  }

  function my_cron_schedules($schedules){
    $schedules["5min"] = array(
        'interval' => 5*60,
        'display' => __('Once every 5 minutes'));
  return $schedules;
  }
  
  add_filter('cron_schedules','my_cron_schedules');

  $array = [];
  add_option('recop_tw', $array);

  if( !wp_next_scheduled( 'programm_tw') ){
    wp_schedule_event(time(), '5min', 'programm_tw');
  }
  add_action('programm_tw', 'Twitter::programm');

  $autoTwitter = get_option('twitter_config')['auto_tweet'];
  $autoSchedule = get_option('twitter_config')['auto_schedule'];
  $autoProgram = get_option('twitter_config')['auto_program'];

  if(($autoTwitter == 'si') && ($autoSchedule == 'no') && ($autoProgram == 'no')){
    add_action('init', 'Twitter::init');
    add_action('publish_post', 'Twitter::tweet');
   }
   else if(($autoTwitter == 'si') && ($autoSchedule == 'si')){
    add_action('init', 'Twitter::init');
    add_action('publish_post', 'Twitter::schedule');
    add_action('share_the_post', 'Twitter::tweet', 10, 1);
   }
   else if(($autoTwitter == 'si') && ($autoProgram == 'si')){
    add_action('publish_post', 'Twitter::recop');
   }

?>
