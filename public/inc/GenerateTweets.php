<?php 
/**
 *  twitter_format_feeds() is used to parse @usernames, #hashtags,media and URLs into links .
 *
 *  @since    			1.0.1
 *
 *  @return             $tweet
 *  @var                $tweet
 *  @author             Weblineindia
 *
 */
function twitter_format_feeds( $tweet ) {
	$text = $tweet->text;
	$entities = isset( $tweet->entities ) ? $tweet->entities : array();
	$replacements = array();

	if ( isset( $entities->urls ) ) {
		foreach ( $entities->urls as $url ) {
			list( $start, $end ) = $url->indices;
			$replacements[$start] = array(
					$start,
					$end,
					"<a href=\"{$url->url}\" title=\"{$url->expanded_url}\" class=\"twitter_inner_a\" target=\"_blank\">{$url->display_url}</a>" );
		}
	}

	if ( isset( $entities->hashtags ) ) {
		foreach ( $entities->hashtags as $hashtag ) {
			list( $start, $end ) = $hashtag->indices;
			$replacements[$start] = array(
					$start,
					$end,
					"<a href=\"https://twitter.com/hashtag/{$hashtag->text}?src=hash\" class=\"twitter_inner_a\" target=\"_blank\">#{$hashtag->text}</a>" );
		}
	}

	if ( isset( $entities->user_mentions ) ) {
		foreach ( $entities->user_mentions as $mention ) {
			list( $start, $end ) = $mention->indices;
			$replacements[$start] = array(
					$start,
					$end,
					"<a href=\"https://twitter.com/{$mention->screen_name}\" class=\"twitter_inner_a\" target=\"_blank\">@{$mention->screen_name}</a>" );
		}
	}

	if ( isset( $entities->media ) ) {
		foreach ( $entities->media as $media ) {
			list( $start, $end ) = $media->indices;
			$replacements[$start] = array(
				$start,
				$end,
				"<a href=\"{$media->url}\" class=\"twitter_inner_a\" target=\"_blank\">{$media->display_url}</a>" );
		}
	}

	// sort in reverse order by start location
	krsort( $replacements );

	foreach ( $replacements as $replace_data ) {
		list( $start, $end, $replace_text ) = $replace_data;
		$text = mb_substr( $text, 0, $start, 'UTF-8' ) . $replace_text . mb_substr( $text, $end, NULL, 'UTF-8' );
	}

	return $text;
}
		
/**
 *  time_ago() is used to convert date to time duration.
 *
 *  @since    			1.0.1
 *
 *  @return             $date
 *  @var                $date
 *  @author             Weblineindia
 *
 */
function time_ago( $date ) {
	if ( empty( $date ) ) {
		return "No date provided";
	}

	$periods = array( "second", "minute", "hour", "day", "week", "month", "year", "decade" );
	$lengths = array( "60", "60", "24", "7", "4.35", "12", "10" );
	$now = time();
	$unix_date = strtotime( $date );

	// check validity of date
	if ( empty( $unix_date ) ) {
		return "Bad date";
	}

	// is it future date or past date
	if ( $now > $unix_date ) {
		$difference = $now - $unix_date;
		$tense = "ago";
	} else {
		$difference = $unix_date - $now;
		$tense = "from now";
	}

	for ( $j = 0; $difference >= $lengths[$j] && $j < count( $lengths ) - 1; $j++ ) {
		$difference /= $lengths[$j];
	}

	$difference = round( $difference );

	if ( $difference != 1 ) {
		$periods[$j] .= "s";
	}

	return "$difference $periods[$j] {$tense}";
}

/**
 *  sort_tweets() is used to sort tweets based on datetime.
 *
 *  @since    			1.0.1
 *
 *  @return             $tweets
 *  @var                $tweets
 *  @author             Weblineindia
 *
 */
function sort_tweets( $date1, $date2 ) {
	$date1 = new DateTime( $date1->created_at );
	$date2 = new DateTime( $date2->created_at );

	if ( $date1 == $date2 ) {
		return 0;
	} else {
		if ( $date1 > $date2 ) {
			return - 1;
		} else {
			return 1;
		}
	}
}

/**
 *  generate_tweets() is used to display tweets.
 *
 *  @since    			1.0.3
 *
 *  @return             $tweets_args
 *  @var                $tweets
 *  @author             Weblineindia
 *
 */
function generate_tweets($tweets_args) {
	
	extract($tweets_args);
	
	$html = '';
	$html .= '<div class="twitter_box">';
	$html .='<div class="twitter_header" style="background-color:'.$headercolor.';">';
	$html .='<img src="'.MATF_URL.'/public/assets/images/twitter_icon.png" alt="" class="twitter_icon" />';
	
	if ( ! empty( $title ) ) {
		$html .='<div class="twitter_title" style="color:'.$titlecolor.';">' . $title . '</div>';
	} else {
		$html .='<div class="twitter_title" style="color:'.$titlecolor.';">Twitter Feeds</div>';
	}
	
	$html .='</div>';
	$html .='<div class="twitter_content" style="height:'.$widgetheight.';">';
		
		if ( ! empty( $usernames ) && ! empty( $consumerkey ) && ! empty( $consumersecret ) && ! empty( $accesstoken ) && ! empty( $accesstokensecret ) ) {
			// Load Twitter class
				
			if ( false === ( $tweets = get_transient( $transname ) ) ) {
				
				$path = MATF_PUBLIC . '/inc/matf-twitteroauth/matf-twitteroauth.php';
				require_once $path;
				
				// Create the connection
				$connection = new MultiTwitterOAuth( $consumerkey, $consumersecret, $accesstoken, $accesstokensecret );
					
				// Migrate over to SSL/TLS
				$connection->ssl_verifypeer = FALSE;
					
				$connection->content_type = 'application/x-www-form-urlencoded';
					
				$count_users = 0;
				$userArray = explode( ',', $usernames );
				foreach ( $userArray as $user ) {
					$tweet_array[$count_users] = $connection->get(
							'https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=' . $user . '&count=' . $count .
							'&exclude_replies=' . $excludereplies );
					$count_users++;
				}
					
				if ( ! empty( $tweet_array ) ) {
					foreach ( $tweet_array as $tweet_array_key => $tweet_array_value ) {
						if ( ! isset( $tweet_array_value->error ) ) {
							foreach ( $tweet_array_value as $tweet_key => $tweet_value ) {
								$tweets[] = $tweet_value;
							}
						}
					}
					usort( $tweets, "sort_tweets" );
				}
					
				set_transient( $transname, $tweets, $cachetime * MINUTE_IN_SECONDS );
			}
			
			if ( ! empty( $tweets ) ) {
				foreach ( $tweets as $key => $tweet ) {

					//Skip if tweets not exists
					if( empty( $tweet->id ) || empty( $tweet->user->screen_name ) ) continue;

					$html .='<div class="twitter_box01" onclick="window.open(https://twitter.com/'.$tweet->user->screen_name.'/status/'.$tweet->id.')">';
					if($avatar == "on") {
						$html .='<div class="twitter_pic">';
						$html .='<a href="https://twitter.com/'.$tweet->user->screen_name.'" target="_blank">
										<img src="'.$tweet->user->profile_image_url_https.'" alt="'.$tweet->user->name.'">';
						$html .='</a>';
						$html .='</div>';
			
						$class = 'class="twitter_details_right"';
					}
					else {
						$class = 'class="twitter_details_right01"';
					}
					$html .='<div '.$class.'>';
					$html .='<div class="twitter_small_ttl">';
					$date = new DateTime( $tweet->created_at );
					$html .='<span class="twitter_fullname"><a href="https://twitter.com/' . $tweet->user->screen_name .
					'" target="_blank">' . $tweet->user->name . '</a></span>';
					$html .='<span class="twitter_screenname"><a href="https://twitter.com/' . $tweet->user->screen_name .
					'" target="_blank">@' . $tweet->user->screen_name . '</a></span>';
					$html .='<span class="twitter_desc">'.twitter_format_feeds( $tweet ).'</span>';
					if ( $showago == "on" ) {
						$html .='<span class="twitter_datetime"><a href="https://twitter.com/' . $tweet->user->screen_name .
						'/status/' . $tweet->id . '" target="_blank" title="">' .
						time_ago( $tweet->created_at ) . '</a></span>';
					}
					if ( $shorttime == "on" ) {
						$html .='<span class="twitter_datetime"><a href="https://twitter.com/' . $tweet->user->screen_name .
						'/status/' . $tweet->id . '" target="_blank" title="' . $date->format( "M d" ) . '">' .
						$date->format( "M d" ) . '</a></span>';
					} else {
						$html .='<span class="twitter_datetime"><a href="https://twitter.com/' . $tweet->user->screen_name .
						'/status/' . $tweet->id . '" target="_blank" title="' . $date->format( "d F Y" ) . '">' .
						$date->format( "d F Y" ) . '</a></span>';
					}
					$html .='</div>';
					$html .='</div>';
					$html .='</div>';
						
				}
			}
			
		} else {
			$html .='<div class="twitter_error_msg">';
			$html .='Please fill all the required options like Usernames, Consumer Key, Consumer Secret, Access Token and Access Token Secret.';
			$html .='</div>';
		}
	$html.='</div>';
$html.='</div>';
return $html;
}
?>