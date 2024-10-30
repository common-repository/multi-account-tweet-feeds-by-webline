<?php   
class MATFSettings
{
	/**
	 * Holds the values to be used in the fields callbacks
	 */
	private $options;
	
	public function __construct()
	{
		add_action('admin_menu', array($this,'matf_admin_add_page'));
		add_action('admin_init', array($this,'matf_admin_init'));
		add_action('admin_enqueue_scripts', array($this,'add_admin_script'));
	}
	
	public function add_admin_script($hook)
	{
		if($hook == "settings_page_multi-account-tweet-feeds-menu")
		{
			wp_enqueue_script('matf_settings_js',MATF_URL.'/admin/assets/js/wli_matf_settings.js',array('jquery'));
			wp_enqueue_style( 'wp-color-picker' );
			wp_enqueue_script('wp-color-picker');
		}
	}
	
	public function matf_admin_add_page()
	{
		add_options_page( 'Multi Account Tweet Feeds Page','Multi Account Tweet Feeds','manage_options', 'multi-account-tweet-feeds-menu', array($this,'matf_options_page' ));
	}

	public function matf_options_page()
	{
		// Set class property
		$this->options = get_option( 'wli_matf_options' );
		?>
		<div class="wrap matf_wrap">
			<h2>Multi Account Tweet Feeds Settings</h2>
			<h3>Please fill below fields, then copy this <input type="text" style="width:228px;" value="[wli-multi-account-tweet-feeds]" readonly="readonly" onfocus="this.select();"> shortcode and paste it into your post, page, or text widget content.</h3>
			
			<form action="options.php" method="post">
				<?php 
					settings_fields('wli_matf_option_group');
					do_settings_sections('wli_matf_setting_admin');
					submit_button(); 
				?> 
			</form>
		</div>
	<?php
	}
	
	public function matf_admin_init()
	{
		register_setting('wli_matf_option_group','wli_matf_options');
		add_settings_section('wli_matf_section_id', '','', 'wli_matf_setting_admin');
		add_settings_field('title', 'Title', array($this,'matf_title_callback'), 'wli_matf_setting_admin', 'wli_matf_section_id');
		add_settings_field('usernames', 'Usernames', array($this,'matf_usernames_callback'), 'wli_matf_setting_admin', 'wli_matf_section_id');
		add_settings_field('consumer_key', 'Consumer Key', array($this,'matf_ckey_callback'), 'wli_matf_setting_admin', 'wli_matf_section_id');
		add_settings_field('consumer_secret', 'Consumer Secret', array($this,'matf_csecret_callback'), 'wli_matf_setting_admin', 'wli_matf_section_id');
		add_settings_field('access_token', 'Access Token', array($this,'matf_atoken_callback'), 'wli_matf_setting_admin', 'wli_matf_section_id');
		add_settings_field('access_token_secret', 'Access Token Secret', array($this,'matf_atokensecret_callback'), 'wli_matf_setting_admin', 'wli_matf_section_id');
		add_settings_field('no_of_feeds_to_show', 'No. Of Feeds To Show', array($this,'matf_nofeeds_callback'), 'wli_matf_setting_admin', 'wli_matf_section_id');
		add_settings_field('cache_time', 'Tweets Cache Time (In Minutes)', array($this,'matf_cachetime_callback'), 'wli_matf_setting_admin', 'wli_matf_section_id');
		add_settings_field('show_avatar', 'Show Avatar', array($this,'matf_savatar_callback'), 'wli_matf_setting_admin', 'wli_matf_section_id');
		add_settings_field('show_replies', 'Show Replies', array($this,'matf_sreplies_callback'), 'wli_matf_setting_admin', 'wli_matf_section_id');
		add_settings_field('show_ago', 'Show Ago After The Time', array($this,'matf_sagotime_callback'), 'wli_matf_setting_admin', 'wli_matf_section_id');
		add_settings_field('show_short_time', 'Set Twitter Like Short Time', array($this,'matf_stweetshorttime_callback'), 'wli_matf_setting_admin', 'wli_matf_section_id');
		add_settings_field('widget_height', 'Widget Height', array($this,'matf_wheight_callback'), 'wli_matf_setting_admin', 'wli_matf_section_id');
		add_settings_field('widget_title_color', 'Widget Title Color', array($this,'matf_wtcolor_callback'), 'wli_matf_setting_admin', 'wli_matf_section_id');
		add_settings_field('widget_header_color', 'Widget Header Color', array($this,'matf_whcolor_callback'), 'wli_matf_setting_admin', 'wli_matf_section_id');
	}
	
	public function matf_title_callback() 
	{
		printf('<input type="text" id="title" name="wli_matf_options[title]" value="%s" size="50"/>',isset( $this->options['title'] ) ? esc_attr( $this->options['title']) : 'Twitter Feeds');
	}
	
	public function matf_usernames_callback()
	{
		printf('<input type="text" placeholder="user1,user2,user3,... (Without the @ symbol)" id="usernames" name="wli_matf_options[usernames]" value="%s" size="50"/>',isset( $this->options['usernames'] ) ? esc_attr( $this->options['usernames']) : '');
	}
	
	public function matf_ckey_callback()
	{
		printf('<input type="text" id="consumer_key" name="wli_matf_options[consumer_key]" value="%s" size="50"/>',isset( $this->options['consumer_key'] ) ? esc_attr( $this->options['consumer_key']) : '');
	}
	
	public function matf_csecret_callback()
	{
		printf('<input type="text" id="consumer_secret" name="wli_matf_options[consumer_secret]" value="%s" size="50"/>',isset( $this->options['consumer_secret'] ) ? esc_attr( $this->options['consumer_secret']) : '');
	}
	
	public function matf_atoken_callback()
	{
		printf('<input type="text" id="access_token" name="wli_matf_options[access_token]" value="%s" size="50"/>',isset( $this->options['access_token'] ) ? esc_attr( $this->options['access_token']) : '');
	}
	
	public function matf_atokensecret_callback()
	{
		printf('<input type="text" id="access_token_secret" name="wli_matf_options[access_token_secret]" value="%s" size="50"/>',isset( $this->options['access_token_secret'] ) ? esc_attr( $this->options['access_token_secret']) : '');
	}
	
	public function matf_nofeeds_callback()
	{
		printf('<input type="number" id="no_of_feeds_to_show" name="wli_matf_options[no_of_feeds_to_show]" value="%s" class="small-text"/>',isset( $this->options['no_of_feeds_to_show'] ) ? esc_attr( $this->options['no_of_feeds_to_show']) : '5');
	}
	
	public function matf_cachetime_callback()
	{
		printf('<input type="number" id="cache_time" name="wli_matf_options[cache_time]" min="0" value="%s" class="small-text"/>',isset( $this->options['cache_time'] ) ? esc_attr( $this->options['cache_time']) : '5');
	}
	
	public function matf_savatar_callback()
	{
		printf('<input type="checkbox" id="show_avatar" name="wli_matf_options[show_avatar]" %s />',checked( isset( $this->options['show_avatar'] ), true, false ));
	}
	
	public function matf_sreplies_callback()
	{
		printf('<input type="checkbox" id="show_replies" name="wli_matf_options[show_replies]" %s />',checked( isset( $this->options['show_replies'] ), true, false ));
	}
	
	public function matf_sagotime_callback()
	{
		printf('<input type="checkbox" id="show_ago" name="wli_matf_options[show_ago]" %s />',checked( isset( $this->options['show_ago'] ), true, false ));
	}
	
	public function matf_stweetshorttime_callback()
	{
		printf('<input type="checkbox" id="show_short_time" name="wli_matf_options[show_short_time]" %s />',checked( isset( $this->options['show_short_time'] ), true, false ));
	}
	
	public function matf_wheight_callback()
	{
		printf('<input type="text" placeholder="Height in px" id="widget_height" name="wli_matf_options[widget_height]" value="%s" size="10"/>',isset( $this->options['widget_height'] ) ? esc_attr( $this->options['widget_height']) : '300px');
	}
	
	public function matf_wtcolor_callback()
	{
		printf('<input class="matweetfeeds-color-picker" type="text" id="widget_title_color" name="wli_matf_options[widget_title_color]" value="%s" size="50"/>',isset( $this->options['widget_title_color'] ) ? esc_attr( $this->options['widget_title_color']) : '#000000');
	}
	
	public function matf_whcolor_callback()
	{
		printf('<input class="matweetfeeds-color-picker" type="text" id="widget_header_color" name="wli_matf_options[widget_header_color]" value="%s" size="50"/>',isset( $this->options['widget_header_color'] ) ? esc_attr( $this->options['widget_header_color']) : '#2fc2ef');
	}
}
if( is_admin() )
	new MATFSettings();
?>