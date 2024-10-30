=== Multi Account Tweet Feeds by Webline ===
Contributors: weblineindia
Tags:multiple account,twitter feeds, multi account tweets, tweets, multi account twitter feeds
Requires at least: 3.5
Tested up to: 6.1
Stable tag: 1.0.7
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

A Simple plugin to show latest Tweets from a multiple Twitter accounts in the same sidebar widget,post,page or text widget content.

== Description ==

Multi Account Tweet Feeds by Webline is a simple and easy to use plugin to show latest tweets from a multiple Twitter accounts in the same sidebar widget,post,page or text widget content including parsing of @usernames, #hashtags, media and URLs into links.

The plugin is based on Twitter API version 1.1. 

In order to use it, you have to create a personal Twitter Application on the https://apps.twitter.com/ website. Within your Application, Twitter provides you four values: the Consumer Key, the Consumer Secret, the Access Token and the Access Token Secret.

Enter all these Authorization strings in the widget options box from **Appearance -> Widgets**, along with your other display settings, for display widget in sidebar.

**OR** 

Enter all these Authorization strings in settings page from **Settings -> Multi Account Tweet Feeds**, along with your other display settings, for use shortcode **[wli-multi-account-tweet-feeds]** in post,page or text widget. 

Your Multi Account Tweet Feeds by Webline plugin is now ready and active!

= Key Features =

- Display tweets in sidebar using widget
- Shortcode [wli-multi-account-tweet-feeds] support, for display tweets on post,page or text widget content
- Show tweets from multiple accounts
- Control for set tweets cache time(in minutes), which improve tweets loading time.
- Control for showing Avtar
- Control for showing Replies
- Control for showing Time (e.g. 4 days ago, 27 mins ago)
- Control for showing Short Time (e.g. Sep 24, Nov 29)
- Control for set widget height.
- Control for set widget title color.
- Control for set widget header background color.

== Installation ==
1. Unzip 'multi-account-tweet-feeds-by-webline.zip' to the '/wp-content/plugins/' directory or add it by 'Add new' in the Plugins menu.
2. Activate the plugin through the 'Plugins' menu.
3. Done.

== Frequently Asked Questions ==

= Issue with showing more tweets than configured? =

When you set 5 as a tweet counts in widget setting then it will show 5 tweets from each accounts given and sort those tweets based on its time.

== Screenshots ==

1. Backend widget option settings
2. Frontend widget view
3. Backend plugin settings page for use [wli-multi-account-tweet-feeds]
4. Frontend page view using shortcode [wli-multi-account-tweet-feeds]

== Changelog ==

= 1.0.7 =

Release Date: February 02, 2023

* Fix: Checked compatibility with WordPress version 6.1

= 1.0.6 =

Release Date: January 03, 2020

* Fix: Minor other bug fixes.
* Checked compatibility with WordPress version 5.3.2

= 1.0.5 =

Release Date: January 03, 2018

* Fix: Resolved create_function deprecated issue in PHP 7.2.0.
* Fix: Checked compatibility with WordPress version 4.9.1.

= 1.0.4 =

Release Date: May 03, 2016

* Fix: Solved twitter feeds not updating within given cache time issue when plugin updates.

= 1.0.3 =

Release Date: April 26, 2016

* Enhancement: Added shortcode support.
* Fix: Improved performance using wordpress Transients API.

= 1.0.2 =

Release Date: January 13, 2016

* Enhancement: Added control for set widget height.
* Enhancement: Added control for set widget title color.
* Enhancement: Added control for set widget header background color.

= 1.0.1 =

Release Date: November 28, 2014

* Initial release
