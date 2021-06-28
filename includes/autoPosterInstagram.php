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
      $post_link = get_the_permalink(isset($postID));
      $attachImage = get_option('instagram_config')['auto_img_ig'];
      $page_id = get_option('instagram_config')['page_id'];
      $post_title = $post->post_title;
      $pageAccessToken = get_option('instagram_config')['access_token'];
      $image_url = 'https://pbs.twimg.com/profile_images/734721751997919232/YJXhKMYp_400x400.jpg';
      if($attachImage == 'si'){ 
        $thumbID = get_post_thumbnail_id( $postID );
        $image_url = wp_get_attachment_image_url( $thumbID, 'full');
      }

      if(!empty($post_link) && $post->post_status == 'publish') {
      $response = wp_safe_remote_post( self::$api_url . self::$instagram_id . '/media?image_url=' . $image_url . '&caption=' . $post_title . '&access_token=' . $pageAccessToken , array(
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

 $autoinstagram = get_option('instagram_config')['auto_post_ig'];

 if($autoinstagram == 'si'){
   add_action('init', 'Instagram::init');
   add_action('save_post', 'Instagram::post_ig');
 } 

?>