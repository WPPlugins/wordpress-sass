=== Wordpress SASS ===
Contributors: blogrescue
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=GFVCGSUFKX2CU
Tags: SASS
Requires at least: 3.0
Tested up to: 3.0
Stable tag: 3.2.0

This plugin provides automated SASS stylesheet generation.

== Description ==

SASS is a programmable approach to stylesheets which really adds some cool features. It can make a stylesheet easier to read, easier to update and also adds some powerful features like functions, variables and imports. (See http://sass-lang.com/docs/yardoc/file.SASS_REFERENCE.html for more details.)

This plugin enables any Wordpress Theme to use SASS stylesheets.  In a typical implementation, style.css is generated from style.scss although the plugin supports different filenames and even multiple stylesheets.

== Installation ==

1. Install the plugin
2. Add the following to functions.php in your theme:

  // Enables SASS to CSS automatic generation
  function generate_css() {
    if(function_exists('wpsass_define_stylesheet'))
      wpsass_define_stylesheet("style.scss", "style.css");
  }  
  add_action( 'after_setup_theme', 'generate_css' );

3. Copy style.css to style.scss, and start coding SASS features into it.
4. Whenever style.scss is updated (has a newer date than style.css), the plugin detects that and will regenerate style.css automatically.
5. For obvious reasons, style.css must be writable (775 permissions)

== Frequently Asked Questions ==

= It is not working - what is the problem? =

I have no idea.  But, if you add a third parameter to the wpsass_define_stylesheet() call in functions.php:

  wpsass_define_stylesheet("style.scss", "style.css", true);

Then any errors encountered will be printed as html comments on your site.  That should provide some insight, but they will appear at the top of the page before the opening <html> tag, so only use this feature to determine why style.css fails to update and then turn it back off again.

= Style Definitions are being dropped - why? =

To avoid requiring Compass or another haml/sass conversion program to be installed on your server, this plugin uses PHamlP.  Unfortunately, there are some issues in this php port (See: http://code.google.com/p/phamlp/issues/list) and it has not been updated in a while.
  
Overall, it seems to work pretty well but just be aware that there might be some issues like the one I found:

 "margin:0;" gets omitted.
 "margin:0px;" works fine.
 "margin:0 0;" also works fine.
 "margin:none;" also works fine.