=== Whatpulse Widget ===
Contributors: jaapmarus
Donate link: http://eris.nu/wordpress/whatpulse
Tags: whatpulse, widgets
Requires at least: 2.7
Tested up to: 3.1
Stable tag: 1.2.1

Shows WhatPulse.org statics on your sidebar inside your weblog. Just provide a valid user ID.
== Description ==

Shows WhatPulse.org statics on your sidebar inside your weblog. Just provide a valid user ID.

== Installation ==

1. Upload the file `whatpulse.php` to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Add the widget to your sidebar from Appearance->Widgets and configure the widget options
1. Enter your WhatPulse User ID

== Frequently Asked Questions ==

= What is Whatpulse =

The purpose of WhatPulse is simply to collect statistics about your computer behavior. Some people (Like me) use it to determine how long they've worked on something, like a programming project, a school essay, chatting by all means.

= How do I enable webapi =

1. Log into Whatpulse.org website
1. Go to http://whatpulse.org/my/profile
1. Check Generate XML statistics (WebAPI) and click on submit.

== Screenshots ==

1. Interface in widget bar
1. Admin interface

== Changelog ==

= 1.2.1 = 
* Fixed a bug in the widget because PHP 5.3 handles number_format more strict then PHP 5.2 or lower.  

= 1.2 =
* Fixed When Whatpulse is offline it will prevent that the system will crash.
* Added Support for Curl instead of file_get_contents. Using file_get_contents only when curl is not available

= 1.1.1 =
* Fixed auto install

= 1.1 =
* Fixed bugs due fact that the widget api has changed
* Added options to enable more or less options. 

= 1.0 =
* First release

== Upgrade Notice ==

= 1.2.1 =

Please update see change log for changes