<?php

/**
 * Adds matweetfeeds widget.
 */
class Multi_Account_Tweet_Feeds extends WP_Widget {

	/**
	 *
	 * Unique identifier for your widget.
	 *
	 *
	 * The variable name is used as the text domain when internationalizing strings
	 * of text. Its value should match the Text Domain file header in the main
	 * widget file.
	 *
	 * @since    1.0.1
	 *
	 * @var      string
	 */
	protected $widget_slug = 'wli_matweetfeeds';

	/**
	 *   Multi_Account_Tweet_Feeds constructor
	 *
	 *  @since    			1.0.1
	 *
	 *  @return             void
	 *  @var                No arguments passed
	 *  @author             Weblineindia
	 *
	 */
	public function __construct() {
		// widget settings
		$widget_ops = array( 
			'classname' => $this->get_widget_slug() . '-class', 
			'description' => __( 
				' A Simple plugin to show latest Tweets from a multiple Twitter accounts in the same sidebar widget.', 
				$this->get_widget_slug() ) );
		// create the widget
		parent::__construct( 
			'matweetfeeds', 
			__( 'Multi Account Tweet Feeds', $this->get_widget_slug() ), 
			$widget_ops );
		
		add_action( 'load-widgets.php', array($this,'add_color_picker_js_css' ));
	}

	/**
	 * add_color_picker_js_css() is use to enqueue color picker js and css files.
	 *
	 * @since    1.0.2
	 *
	 * @return   void
	 * @var      $hook
	 * @author   Weblineindia
	 *
	 */
	public function add_color_picker_js_css( $hook ) {
	
		if( is_admin() ) {
			wp_enqueue_style( 'wp-color-picker' );
			wp_enqueue_script( 'wp-color-picker' );
		}
	}
	
	/**
	 * get_widget_slug() is use to get the widget slug.
	 *
	 * @since    1.0.1
	 *
	 * @return   Plugin slug variable.
	 * @var      No arguments passed
	 * @author   Weblineindia
	 *
	 */
	public function get_widget_slug() {
		return $this->widget_slug;
	}

	/**
	 *  form() is used to generates the administration form for the widget.
	 *
	 *  @since    			1.0.1
	 *
	 *  @return             void
	 *  @var                $instance
	 *  @author             Weblineindia
	 *
	 */
	public function form( $instance ) {
		// Set up some default widget settings.
		$defaults = array( 
			'title' => 'Twitter Feeds', 
			'users' => '', 
			'consumer_key' => '', 
			'consumer_secret' => '', 
			'access_token' => '', 
			'access_token_secret' => '', 
			'no_of_feeds_to_show' => '5', 
			'cache_time' => '5',
			'show_replies' => 'off', 
			'show_ago' => 'on', 
			'show_short_time' => 'off', 
			'show_avatar' => 'on',
			'widget_title_color'=>'#000000',
			'widget_header_color'=>'#2fc2ef',
			'widget_height'=>'300px'
		 );
		
		$instance = wp_parse_args( (array) $instance, $defaults );
		?>

		<script type='text/javascript'>
		(function($){

			var parent = $('body');
			
			if ($('body').hasClass('widgets-php')){
				parent = $('.widget-liquid-right');
			}
			
			jQuery(document).ready(function($) {
				parent.find('.matweetfeeds-color-picker').wpColorPicker();
			});

			jQuery(document).on('widget-added', function(e, widget){
				widget.find('.matweetfeeds-color-picker').wpColorPicker();
			});

			jQuery(document).on('widget-updated', function(e, widget){
				widget.find('.matweetfeeds-color-picker').wpColorPicker();
			});

		})(jQuery);
        </script>
        
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Widget Title', $this->get_widget_slug()); ?></label>
			<br/><span class="description">( Leave empty if you want to take from global settings. )</span>
			<input class="widefat"
				id="<?php echo $this->get_field_id( 'title' ); ?>"
				name="<?php echo $this->get_field_name( 'title' ); ?>" 
				type="text"
				value="<?php echo esc_attr( $instance['title'] ); ?>" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'users' ); ?>"><?php _e('Usernames', $this->get_widget_slug()); ?>&nbsp;&nbsp;(Without the "@" symbol)</label>
			<br/><span class="description">( Leave empty if you want to take from global settings. )</span>
			<input class="widefat"
				id="<?php echo $this->get_field_id( 'users' ); ?>"
				name="<?php echo $this->get_field_name( 'users' ); ?>" 
				type="text"
				value="<?php echo esc_attr( $instance['users'] ); ?>"
				placeholder="user1,user2,user3,..." />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'consumer_key' ); ?>"><?php _e('Consumer Key', $this->get_widget_slug()); ?></label>
			<br/><span class="description">( Leave empty if you want to take from global settings. )</span>
			<input class="widefat"
				id="<?php echo $this->get_field_id( 'consumer_key' ); ?>"
				name="<?php echo $this->get_field_name( 'consumer_key' ); ?>"
				type="text"
				value="<?php echo esc_attr( $instance['consumer_key'] ); ?>" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'consumer_secret' ); ?>"><?php _e('Consumer Secret', $this->get_widget_slug()); ?></label>
			<br/><span class="description">( Leave empty if you want to take from global settings. )</span>
			<input class="widefat"
				id="<?php echo $this->get_field_id( 'consumer_secret' ); ?>"
				name="<?php echo $this->get_field_name( 'consumer_secret' ); ?>"
				type="text"
				value="<?php echo esc_attr( $instance['consumer_secret'] ); ?>" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'access_token' ); ?>"><?php _e('Access Token', $this->get_widget_slug()); ?></label>
			<br/><span class="description">( Leave empty if you want to take from global settings. )</span>
			<input class="widefat"
				id="<?php echo $this->get_field_id( 'access_token' ); ?>"
				name="<?php echo $this->get_field_name( 'access_token' ); ?>"
				type="text"
				value="<?php echo esc_attr( $instance['access_token'] ); ?>" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'access_token_secret' ); ?>"><?php _e('Access Token Secret', $this->get_widget_slug()); ?></label>
			<br/><span class="description">( Leave empty if you want to take from global settings. )</span>
			<input class="widefat"
				id="<?php echo $this->get_field_id( 'access_token_secret' ); ?>"
				name="<?php echo $this->get_field_name( 'access_token_secret' ); ?>"
				type="text"
				value="<?php echo esc_attr( $instance['access_token_secret'] ); ?>" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'no_of_feeds_to_show' ); ?>"><?php _e('No. Of Tweets To Show', $this->get_widget_slug()); ?></label>
			<br/><span class="description">( Leave empty if you want to take from global settings. )</span>
			<input class="widefat"
				id="<?php echo $this->get_field_id( 'no_of_feeds_to_show' ); ?>"
				name="<?php echo $this->get_field_name( 'no_of_feeds_to_show' ); ?>"
				type="number"
				value="<?php echo esc_attr( $instance['no_of_feeds_to_show'] ); ?>" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'cache_time' ); ?>"><?php _e('Tweets Cache Time (In Minutes)', $this->get_widget_slug()); ?></label>
			<br/><span class="description">( Leave empty if you want to take from global settings. )</span>
			<input class="widefat"
				id="<?php echo $this->get_field_id( 'cache_time' ); ?>"
				name="<?php echo $this->get_field_name( 'cache_time' ); ?>"
				type="number"
				min="0"
				value="<?php echo esc_attr( $instance['cache_time'] ); ?>" />
		</p>
		
		<p>
			<input class="checkbox"
				id="<?php echo $this->get_field_id( 'show_avatar' ); ?>"
				name="<?php echo $this->get_field_name( 'show_avatar' ); ?>"
				type="checkbox" <?php checked($instance['show_avatar'], 'on'); ?> /> 
			<label for="<?php echo $this->get_field_id( 'show_avatar' ); ?>"><?php _e('Show Avatar', $this->get_widget_slug()); ?></label>
		</p>
		
		<p>
			<input class="checkbox"
				id="<?php echo $this->get_field_id( 'show_replies' ); ?>"
				name="<?php echo $this->get_field_name( 'show_replies' ); ?>"
				type="checkbox" <?php checked($instance['show_replies'], 'on'); ?> />
			<label for="<?php echo $this->get_field_id( 'show_replies' ); ?>"><?php _e('Show Replies', $this->get_widget_slug()); ?></label>
		</p>
		
		<p>
			<input class="checkbox"
				id="<?php echo $this->get_field_id( 'show_ago' ); ?>"
				name="<?php echo $this->get_field_name( 'show_ago' ); ?>"
				type="checkbox" <?php checked($instance['show_ago'], 'on'); ?> /> 
			<label for="<?php echo $this->get_field_id( 'show_ago' ); ?>"><?php _e('Show Ago After The Time', $this->get_widget_slug()); ?></label>
		</p>
		
		<p>
			<input class="checkbox"
				id="<?php echo $this->get_field_id( 'show_short_time' ); ?>"
				name="<?php echo $this->get_field_name( 'show_short_time' ); ?>"
				type="checkbox" <?php checked($instance['show_short_time'], 'on'); ?> />
			<label for="<?php echo $this->get_field_id( 'show_short_time' ); ?>"><?php _e('Set Twitter Like Short Time', $this->get_widget_slug()); ?></label>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'widget_height' ); ?>"><?php _e('Widget Height', $this->get_widget_slug()); ?>&nbsp;&nbsp;(in "px")</label>
			<br/><span class="description">( Leave empty if you want to take from global settings. )</span>
			<input class="widefat"
				id="<?php echo $this->get_field_id( 'widget_height' ); ?>"
				name="<?php echo $this->get_field_name( 'widget_height' ); ?>" 
				type="text"
				value="<?php echo esc_attr( $instance['widget_height'] ); ?>" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'widget_title_color' ); ?>"><?php _e('Widget Title Color', $this->get_widget_slug()); ?></label>
			<br/><span class="description">( Leave empty if you want to take from global settings. )</span>
		</p>
		<p>
			<input class="widefat matweetfeeds-color-picker"
				id="<?php echo $this->get_field_id( 'widget_title_color' ); ?>"
				name="<?php echo $this->get_field_name( 'widget_title_color' ); ?>" 
				type="text"
				value="<?php echo esc_attr( $instance['widget_title_color'] ); ?>" />
			
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'widget_header_color' ); ?>"><?php _e('Widget Header Color', $this->get_widget_slug()); ?></label>
			<br/><span class="description">( Leave empty if you want to take from global settings. )</span>
		</p>
		<p>
			<input class="widefat matweetfeeds-color-picker"
				id="<?php echo $this->get_field_id( 'widget_header_color' ); ?>"
				name="<?php echo $this->get_field_name( 'widget_header_color' ); ?>" 
				type="text"
				value="<?php echo esc_attr( $instance['widget_header_color'] ); ?>" />
		</p>
	<?php
	}

	/**
	 *  update() is used to replace the new value when the Saved button is clicked.
	 *
	 *  @since    			1.0.1
	 *
	 *  @return             $instance
	 *  @var                $new_instance,$old_instance
	 *  @author             Weblineindia
	 *
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = sanitize_text_field( $new_instance['title'] );
		$instance['users'] = sanitize_text_field( $new_instance['users'] );
		$instance['consumer_key'] = sanitize_text_field( $new_instance['consumer_key'] );
		$instance['consumer_secret'] = sanitize_text_field( $new_instance['consumer_secret'] );
		$instance['access_token'] = sanitize_text_field( $new_instance['access_token'] );
		$instance['access_token_secret'] = sanitize_text_field( $new_instance['access_token_secret'] );
		$instance['no_of_feeds_to_show'] = sanitize_text_field( $new_instance['no_of_feeds_to_show'] );
		$instance['cache_time'] = sanitize_text_field( $new_instance['cache_time'] );
		$instance['show_avatar'] = isset( $new_instance['show_avatar'] ) ? $new_instance['show_avatar'] : 'off';
		$instance['show_replies'] = isset( $new_instance['show_replies'] ) ? $new_instance['show_replies'] : 'off';
		$instance['show_ago'] = isset( $new_instance['show_ago'] ) ? $new_instance['show_ago'] : 'off';
		$instance['show_short_time'] = isset( $new_instance['show_short_time'] ) ? $new_instance['show_short_time'] : 'off';
		$instance['widget_title_color'] = sanitize_text_field( $new_instance['widget_title_color'] );
		$instance['widget_header_color'] = sanitize_text_field( $new_instance['widget_header_color'] );
		$instance['widget_height'] = sanitize_text_field( $new_instance['widget_height'] );
		return $instance;
	}

	/**
	 * widget() is used to show the frontend part .
	 *
	 *  @since    			1.0.1
	 *
	 *  @return             void
	 *  @var                $args,$instance
	 *  @author             Weblineindia
	 *
	 */
	public function widget( $args, $instance ) {
		extract( $args );

		//Get Details and Declaration
		$options = get_option( 'wli_matf_options' );
		$tweets = array();
		$tweet_array = array();

		$title = !empty( $instance['title'] ) ? $instance['title'] : ( !empty( $options['title'] ) ? $options['title'] : '' );
		$usernames = !empty( $instance['users'] ) ? $instance['users'] : ( !empty( $options['usernames'] ) ? $options['usernames'] : '' );
		$count = !empty( $instance['no_of_feeds_to_show'] ) ? $instance['no_of_feeds_to_show'] : ( !empty( $options['no_of_feeds_to_show'] ) ? $options['no_of_feeds_to_show'] : '' );
		$transname = "matfw_widget";
		$consumerkey = !empty( $instance['consumer_key'] ) ? $instance['consumer_key'] : ( !empty( $options['consumer_key'] ) ? $options['consumer_key'] : '' );
		$consumersecret = !empty( $instance['consumer_secret'] ) ? $instance['consumer_secret'] : ( !empty( $options['consumer_secret'] ) ? $options['consumer_secret'] : '' );
		$accesstoken = !empty( $instance['access_token'] ) ? $instance['access_token'] : ( !empty( $options['access_token'] ) ? $options['access_token'] : '' );
		$accesstokensecret = !empty( $instance['access_token_secret'] ) ? $instance['access_token_secret'] : ( !empty( $options['access_token_secret'] ) ? $options['access_token_secret'] : '' );
		$shorttime 	= $instance['show_short_time'];
		$avatar 	= $instance['show_avatar'];
		$replies 	= $instance['show_replies'];
		$showago 	= $instance['show_ago'];

		if ( $replies == "on" ) {
			$excludereplies = 'false';
		} else {
			$excludereplies = 'true';
		}

		if (!empty($instance['widget_title_color'])) {
			$titlecolor = $instance['widget_title_color'];
		} else { 
			$titlecolor = !empty( $options['widget_title_color'] ) ? $options['widget_title_color'] : '#000000';
		}
		
		if (!empty($instance['widget_header_color'])) {
			$headercolor = $instance['widget_header_color'];
		} else {
			$headercolor = !empty( $options['widget_header_color'] ) ? $options['widget_header_color'] : '#2fc2ef';
		}
		
		if (!empty($instance['widget_height'])) {
			$widgetheight = $instance['widget_height'];
		} else {
			$widgetheight = !empty( $options['widget_height'] ) ? $options['widget_height'] : '300px';
		}
		
		if (!empty($instance['cache_time'])) {
			$cachetime = $instance['cache_time'];
		} else {
			$cachetime = !empty( $options['cache_time'] ) ? $options['cache_time'] : '5';
		}
		
		echo $args['before_widget'];
		
		$path = MATF_PUBLIC . '/inc/GenerateTweets.php';
		require_once $path;
	
		$tweets_args = array( "title" => $title,
							  "usernames" => $usernames,
							  "count" => $count,
							  "cachetime" => $cachetime,
							  "transname" => $transname,
							  "consumerkey" => $consumerkey,
							  "consumersecret" => $consumersecret,
							  "accesstoken" => $accesstoken,
							  "accesstokensecret" => $accesstokensecret,
							  "shorttime" => $shorttime,
							  "avatar" => $avatar,
							  "excludereplies" => $excludereplies,
							  "showago" => $showago,
							  "titlecolor" => $titlecolor,
							  "headercolor" => $headercolor,
							  "widgetheight" => $widgetheight
					 );
		
		$tweet_html = "";
		$tweet_html = generate_tweets($tweets_args);
		
		echo $tweet_html;
		
		echo $args['after_widget'];
	}
} // class Multi_Account_Tweet_Feeds
  
// register widget
function register_multi_account_tweet_feeds_widget() {
    register_widget( 'Multi_Account_Tweet_Feeds' );
}
add_action( 'widgets_init', 'register_multi_account_tweet_feeds_widget' );
?>