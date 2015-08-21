=== DX GitHub Zen ===
Contributors: nofearinc
Tags: plugin, zen, github, messages, http
Requires at least: 3.1
Tested up to: 4.3
Stable tag: 1.1
License: GPLv2 or later

Add some Zen by GitHub to your WordPress website

== Description ==

Add some Zen by GitHub to your WordPress website. The guys from GitHub provide a
great API at https://api.github.com/zen with various geeky messages. The plugin
is fetching the messages for use in a widget or shortcode.

= Timeout =

The API has a limit of 60 requests/min for anonymous users. A standard timeout of 20min
is recommended for a normal load. Data is stored in a transient for internal access
over the timeout period before updating it from the API.

= Widget =

Use the DX GitHub Zen Widget and set a title and timeout for your messages.

= Shortcode =

Use the [dx_github_zen] shortcode in your posts/pages to display the messages there.
 
== Installation ==

Upload the DX GitHub Zen plugin to your blog and activate it. 

Use a widget or a shortcode as described above.

== Screenshots == 

1. Usage as a widget and a shortcode