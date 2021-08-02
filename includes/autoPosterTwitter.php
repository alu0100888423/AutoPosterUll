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
      if($attachImage == 'si' && $thumbID != 0){
         $reply = self::$codebird->media_upload(array(
           'media' => $imgLink
         ));
         $image_id = $reply->media_id_string;
         $params = array(
           'status' => $message,
           'media_ids' => $image_id
           );
      }
      else if(($attachImage == 'si' && $thumbID == 0) || ($attachImage == 'no')){
        $params = array(
          'status' => $message
        );
      }
      if(!empty($post_link) && $post->post_status == 'publish') {
        self::$codebird->statuses_update($params);
      }

    }

 }

 $autoTwitter = get_option('twitter_config')['auto_tweet'];

 if($autoTwitter == 'si'){
  add_action('init', 'Twitter::init');
  add_action('save_post', 'Twitter::tweet');
 }

?>