<?php
/**
 * @package WPSASS
 */
/*
Plugin Name: Wordpress SASS
Plugin URI: http://blogrescue.com/2011/12/sass-for-wordpress/
Description: This plugin provides automated SASS stylesheet generation
Version: 3.2.0
Author: Blogrescue.com
Author URI: http://blogrescue.com
License: New BSD License (http://www.opensource.org/licenses/bsd-license.php)
*/

/*
Note: 
This plugin uses the PHamlP (http://code.google.com/p/phamlp/) SassParser.  The plugin version is set to match the PHamlP version, with an added decimal and number to denote any plugin updates that do not correspond to a PHamlP version update.
*/

define('WPSASS_VERSION', '3.2.0');
define('WPSASS_PLUGIN_DIR', dirname( __FILE__ ).DIRECTORY_SEPARATOR);

function wpsass_define_stylesheet($sass, $css, $debug = false) {
	$css_location = get_stylesheet_directory().DIRECTORY_SEPARATOR;
	$source = $css_location.$sass;
	$target = $css_location.$css;

	$source_exists = file_exists($source);
	$target_exists = file_exists($target);

	if($source_exists && $target_exists) {
		$source_date = filemtime($source);
		$target_date = filemtime($target);

		if($source_date > $target_date) 
			wpsass_update_stylesheet($source, $target, $debug);
	}
}

function wpsass_update_stylesheet($source, $target, $debug) {
	try {
		include_once(WPSASS_PLUGIN_DIR."phamlp/sass/SassParser.php");
    
		$sass_parser = new SassParser(array('cache'=>false));
		$css = $sass_parser->toCss($source);
    
		if(is_writable($target)) {
			$fh = fopen($target, 'w');
			if($fh) {
				fwrite($fh, "/* DO NOT EDIT - ".
					" AUTOMATICALLY GENERATED FROM: ".
					basename($source)." */\n"
				);
				fwrite($fh, $css);
				fclose($fh);
			} else {
				if($debug) wpsass_report_error(
					"Error Writing CSS File $target",
					error_get_last()->message);
			}
		} else if($debug) {
 			wpsass_report_error(
				"Cannot Update CSS File $target",
				"File does not have write permissions");
		}
	} catch (Exception $e) {
		if($debug) 
			wpsass_report_error(
				"Error Parsing SASS File $sass",
				$e->getMessage() 
			);
	}
}

function wpsass_report_error($error, $message) {
	print "<!--\n WPSASS - $error\n";
	print "  $message\n-->\n";
}

?>
