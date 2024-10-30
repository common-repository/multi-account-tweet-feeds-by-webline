<?php 
function wli_multi_account_tweet_feeds( $atts , $content = null ) {
		
		$path = MATF_PUBLIC . '/inc/GenerateTweets.php';
		require_once $path;
		
		$matf_options = get_option('wli_matf_options');
		
		$transname = "matfw_shortcode";
		
		if(isset($matf_options['show_avatar'])) {
			$avatar = $matf_options['show_avatar'];
		} else {
			$avatar = "off";
		}
			
		if(isset($matf_options['show_ago'])) {
			$showago = $matf_options['show_ago'];
		} else {
			$showago = "off";
		}
		
		if(isset($matf_options['show_short_time'])) {
			$shorttime = $matf_options['show_short_time'];
		} else {
			$shorttime = "off";
		}
		
		if ( isset($matf_options['show_replies']) && $matf_options['show_replies'] == "on" ) {
			$excludereplies = 'false';
		} else {
			$excludereplies = 'true';
		}
		
		if (!empty($matf_options['widget_title_color'])) {
			$titlecolor = $matf_options['widget_title_color'];
		} else {
			$titlecolor = '#000000';
		}
		
		if (!empty($matf_options['widget_header_color'])) {
			$headercolor = $matf_options['widget_header_color'];
		} else {
			$headercolor = '#2fc2ef';
		}
		
		if (!empty($matf_options['widget_height'])) {
			$widgetheight = $matf_options['widget_height'];
		} else {
			$widgetheight = '300px';
		}
		
		$tweets_args = array("title" => $matf_options['title'],
					  		"usernames" => $matf_options['usernames'],
							"count" => $matf_options['no_of_feeds_to_show'],
							"cachetime" => $matf_options['cache_time'],
							"transname" => $transname,
							"consumerkey" => $matf_options['consumer_key'],
							"consumersecret" => $matf_options['consumer_secret'],
							"accesstoken" => $matf_options['access_token'],
							"accesstokensecret" => $matf_options['access_token_secret'],
							"shorttime" => $shorttime,
							"avatar" => $avatar,
							"excludereplies" => $excludereplies,
							"showago" => $showago,
							"titlecolor" => $titlecolor,
							"headercolor" => $headercolor,
							"widgetheight" => $widgetheight
						);
		
		$html="";
		$html = generate_tweets($tweets_args);
		
		return $html;
}
add_shortcode( 'wli-multi-account-tweet-feeds', 'wli_multi_account_tweet_feeds' );
?>