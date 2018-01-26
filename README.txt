=== Local Like And Share ===
Contributors: DevonOstendorf
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=ZQHYQSJDUW2JQ
Tags: like, share, local, self-hosted, standalone, track like, track share
Requires at least: 4.3
Tested up to: 4.9
Requires PHP: 5.6
Stable tag: 1.1.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Track liked and shared posts directly on your site.

== Description ==

Local Like And Share is a simple way to allow your readers to like and share your posts, directly on your site.

Merely confirm your settings, activate the portions of the widget to match, and monitor the results - all via the common WordPress online admin menu area (no tinkering with files required :) ).

= Included features: =

* Configurable button settings:
	* Select position on post where buttons get displayed
	* Choose individual "call to action" button hover message background and text colors
	* Choose individual count background, outline, and text colors
	* Display abbreviations for large count values?
		
* Configurable Like settings:
	* Display like button on post index pages?
	* Display like button on individual post?
	* Choose individual button and button hover colors
	* Set "call to action" button hover message
	* Set "successful like" button hover message
	* Set "already liked" button hover message

* Configurable Share settings:
	* Display share button on post index pages?
	* Display share button on individual post?
	* Choose individual button and button hover colors
	* Set "call to action" button hover message
	* Share post default email subject and body

* Configurable widget messages:
	* No likes found	
	* No shares found
	
* Versatile shortcode functionality:
	* Generate like button directly in content
	* Generate share button directly in content
	* Usable in posts and on pages
	
* Configurable widget labels/input field placeholders:
	* Show like section?
	* Like title
	* Show share section?
	* Share title
	* Time period
	* Number of posts to show
	* Show like/share counts?
	* Adjustable numbered result margin (to account for theme indentation differences)
	
* Admin and editor tools:
	* View statistics (for both likes and shares)
	* Reset all counts (for both likes and shares)
		
* Multisite capable

= Benefits: =

* No file server configuration required:
	* All color selection and positioning of buttons done via the plugin's settings page
	* All configuration of hover message contents done via the plugin's settings page
	
* For Multisite networks, once the plugin is installed in the network's plugin directory, individual site activation and configuration of the plugin can be handled by individual site admins without any access to the file server.

== Installation ==

= Download and Install =    
1. Go to "Plugins > Add New" in your Dashboard and search for: Local Like And Share
2. Click the "Install Now" button for the Local Like And Share plugin
3. See the appropriate section below ("Single Site - Activate and Configure" or "Multisite - Activate and Configure") **BEFORE** activating

**OR**  

1. Download `local-like-and-share.[version_number].zip` from the WordPress.org plugin directory
2. Extract `local-like-and-share.[version_number].zip` into a directory on your computer  
3. Upload the `local-like-and-share` directory to your plugins directory (typically `../wp-content/plugins`)  
4. See the appropriate section below ("Single Site - Activate and Configure" or "Multisite - Activate and Configure") **BEFORE** activating

= Single Site - Activate and Configure =  
1. Activate the plugin in the Plugins admin menu (Plugins >> Installed Plugins)  
2. Configure options (Settings >> Local Like And Share)  
3. Add and configure widget (Appearance >> Widgets)  

= Multisite - Activate and Configure =  
1. Be sure you ONLY activate it for one or more individual sites - DO NOT "network activate" it (there is not yet a way for plugin authors to disable this option which is why it is even available for this plugin)  
2. Activate the plugin in the Plugins admin menu (Plugins >> Installed Plugins)  
3. Configure options (Settings >> Local Like And Share)  
4. Add and configure widget (Appearance >> Widgets)  

== Frequently Asked Questions ==

= Why is such a recent version of WordPress listed as the minimum version required? =

I strongly believe admins need to keep their sites updated with the current WordPress core.  This is particularly important for security reasons but also because it provides admins and their users with new-and-improved functionality.  If you cannot (or will not) upgrade, this plugin will probably work fine if you're running WordPress 3.5 or higher.  But seriously, you really should upgrade!

= How do I get this thing to work? =

Follow the steps on the Installation page and then review the Screenshots (which show the plugin "in action" from both the administrator's and a user's perspective).  If people have more specific questions, I will update this page accordingly.

= Why isn't Local Like And Share translated into my language? =

It is because no one who speaks your language has translated this plugin yet.  If you'd like to do so, you'll find the current local-like-and-share.pot file in the local-like-and-share/languages directory.  [Please contact me](https://devonostendorf.com) with any translation files you create; I will help you get set up as a Project Translation Editor (PTE) with the WordPress.org [Polyglots team](https://make.wordpress.org/polyglots/) to create a language pack for Local Like And Share - thanks much!

= Why build another like and share plugin? =

This was a somewhat spontaneous project; I wanted to add an easy-to-set-up way to allow likes and shares without requiring the user to sign into some other service.  And lots of people choose not to use Facebook or Twitter.  If you do, there are plenty of other plugins available.  There are also other existing plugins that provide similar functionality but require you to maintain an account on their server(s) to access statistics.  My aim was to provide a simple, self-contained, and locally-hosted tool where your stats stay with you (in the same way that the excellent [Matomo](https://matomo.org) does for analytics).  All while being independent from and unaffected by the whims of outside organizations that may change things without your knowledge or permission.

= How do I reset like or share counts? =

Go to the View Statistics page (Local Like And Share >> View Statistics), select the "All-time" tab, and press either the "Reset all like counts" or "Reset all share counts" button.  This will reset ALL of your likes or shares (depending on which button you press).  You will be presented with an "Undo" link immediately after having pressed a delete button.  If you pressed a delete button by accident, or change your mind about deleting your counts, you must click the undo link IMMEDIATELY; your action CANNOT be reversed later.

= How do I use the shortcodes? =

1. Go to Settings >> Local Like And Share and make sure the settings in the Common Settings, Like Settings, and Share Settings sections are populated to your liking   
<br /><br />  

    **Note**: "Button(s) position on post", "Show on post index pages", and "Show on individual post" are not relevant to the shortcodes.   
<br /><br />  

2. Add `[llas_like]` or `[llas_share]` to a post or page   
<br /><br />  

3. If you use either shortcode more than once in a post or on a page, you MUST specify a unique value for the `id` attribute

    Here is an example, passing the id attribute:    
    
    Somewhere in the middle of a post, we drop a like button.
    <pre>[llas_like id="1"]</pre>
    It is fine to reuse the same id for a share button.
    <pre>[llas_share id="1"]</pre>
    But we need to make the like button ids unique and here is a second one.
    <pre>[llas_like id="2"]</pre>
    And the second share button id must also be unique (among share buttons).
    <pre>[llas_share id="2"]</pre>
    That's all there is to it!

== Screenshots ==

1. Activating the plugin
2. Overriding the default settings with your own custom values
3. Adding the widget to a sidebar and overriding the defaults with your own custom values
4. Using the shortcode to render the like and share buttons within the body of a post
5. User likes a post
6. User shares a post
7. Widget displays likes and shares
8. View statistics

== Changelog ==

= 1.1.0 =
Release Date: January 25, 2018

* NEW: Added shortcode to generate like and share buttons
* CHANGED: Replaced gear dashicon w/ heart dashicon for Local Like And Share top level menu
* FIXED: Prevented buttons from displaying on search results pages

= 1.0.6 =
Release Date: November 3, 2016

* FIXED: Fixed postmeta table ORDER BY clause to sort like and share counts as integers

= 1.0.5 =
Release Date: September 22, 2016

* FIXED: Renamed CSS classes to avoid clashes with CSS from other packages
* CHANGED: Improved performance for public-facing counts by aggregating in post meta data
* FIXED: Updated custom table create statements to adhere to WordPress 4.6 dbDelta() KEY format
* NEW: Added option to display abbreviations for large count values

= 1.0.4 =
Release Date: May 2, 2016

* FIXED: Fixed issue with translation check generating errors during core update process

= 1.0.3 =
Release Date: March 26, 2016

* FIXED: Revised translation nag functionality
* NEW: Added minified JavaScript and CSS files

= 1.0.2 =
Release Date: February 28, 2016

* NEW: Added translation nag functionality based on [Clorith's example](http://www.clorith.net/blog/encourage-community-translations-wordpress-org-plugins/)
* FIXED: Fixed issue where underlines were rendering beneath both like and share icons in some themes

= 1.0.1 =
Release Date: December 15, 2015

* NEW: Added additional configurable color settings (Settings >> Local Like And Share): "Button hover message background color", "Button hover message text color", "Count background color", "Count outline color", and "Count text color"
* NEW: Added functionality to reset ALL like counts and/or reset ALL share counts (Local Like And Share >> View Statistics [All-time tab])
* CHANGED: Modified dynamic HTML throughout the code, sanitizing it with "esc()" functions

= 1.0.0 =
Release Date: September 18, 2015

* Initial release

== Upgrade Notice ==

= 1.1.0 =
Added shortcode to generate like and share buttons.  Replaced gear dashicon w/ heart dashicon for Local Like And Share top level menu.  Prevented buttons from displaying on search results pages.

= 1.0.6 =
Fixed postmeta table ORDER BY clause to sort like and share counts as integers.

= 1.0.5 =
Renamed CSS classes to avoid clashes with CSS from other packages.  Improved performance for public-facing counts by aggregating in post meta data.  Updated custom table create statements to adhere to WordPress 4.6 dbDelta() KEY format.  Added option to display abbreviations for large count values.

= 1.0.4 =
Fixed issue with translation check generating errors during core update process.

= 1.0.3 =
Revised translation nag functionality.  Added minified JavaScript and CSS files.

= 1.0.2 =
Fixed issue with underlines underneath icons.  Added (dismissible) translation nag screen to solicit translation help from all admins whose site uses a language for which Local Like And Share does not yet have an official translation.

= 1.0.1 =
Added functionality to reset ALL like counts and/or reset ALL share counts.  Added new configurable color settings.  Sanitized dynamic HTML via "esc()" functions.

== Thanks ==

Special thanks to:

* [Pippin Williamson](https://pippinsplugins.com) for his [love-it plugin tutorial](https://pippinsplugins.com/write-a-love-it-plugin-with-ajax); it was the original inspiration for this plugin a couple of years back. I'd used it as the basis for some custom plugin work but then, when I started my [blog](https://devonostendorf.com), I determined I wanted a very specific set of functionality incorporated into a single plugin, hence what you're looking at now.
* [Tom McFarlin](https://tommcfarlin.com) for creating the [WordPress Widget Boilerplate](https://github.com/tommcfarlin/WordPress-Widget-Boilerplate) and he and [Devin Vinson](https://github.com/DevinVinson) for the [WordPress Plugin Boilerplate](https://github.com/DevinVinson/WordPress-Plugin-Boilerplate)
* Jason Frame's magical [Tipsy](http://onehackoranother.com/projects/jquery/tipsy) jQuery plugin for creating tooltips 
* [Tom's](https://profiles.wordpress.org/edge22) great [Lightweight Social Icons](https://wordpress.org/plugins/lightweight-social-icons) plugin which helped me considerably when attempting to figure out how to use icons with [Fontello](http://fontello.com)
* [Peter Coles](http://mrcoles.com) for the superb [callout box CSS](http://mrcoles.com/blog/callout-box-css-border-triangles-cross-browser)
* [John Blackbourn](https://profiles.wordpress.org/johnbillion) and [Frank Prendergast](https://profiles.wordpress.org/frankprendergast) for their [LinkedIn Share Button](https://wordpress.org/plugins/linkedin-share-button) plugin which helped with positioning the buttons on the page
* All of the generous people who've asked "stupid" questions (so I didn't have to ask the same ones) about how certain things work in WordPress, and then took the time to share what they've learned!