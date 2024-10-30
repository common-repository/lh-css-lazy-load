=== LH CSS Lazy Load ===
Contributors: shawfactor
Donate link: https://lhero.org/portfolio/lh-css-lazy-load/
Tags: css, javascript, lazy load, defer, async
Requires at least: 4.0
Tested up to: 5.2
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
 
Lazy load non critical css
 
== Description ==

Javascript has a HTML based method for deferring and asynchronously loading files, namely script Defer and script Async. Unfortunately these HTML solutions do not work for CSS files. 

But do not worry, this plugin allows you to lazy load yous css files. Thus speeding up your initial view experience for visitors and search engines.

== Installation ==

1. Upload the entire `lh-css-lazy-load` folder to the `/wp-content/plugins/` directory.
1. Activate the plugin through the 'Plugins' menu in WordPress.
1. Configure the plugin by adding the CSS handles via Settings->CSS Lazy Load


== Frequently Asked Questions ==

= Will this plugin work without javascript? =

Yes! As CSS elemets are wrapped in a noscript tag, they will be parsed if javascript is deactivated.


 == Changelog ==

**1.00 November 20, 2017**  
Initial release

**1.01 November 27, 2017**  
Minor bug fix

**1.02 June 04, 2018**  
Added tranlation support