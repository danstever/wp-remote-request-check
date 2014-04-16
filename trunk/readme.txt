=== WP Remote Request Check ===
Contributors: danstever, noticesoftware
Tags: API, testing, network
Tested up to: 3.9
Requires at least: 3.0
Stable Tag: 0.1
License: GPLv2 or later

== Description ==
Checks if the WordPress HTTP API is able to be used by making calls using wp_remote_requst().

A textfield allows entering URLs. If left blank, the request will use http://google.com.

Returned response contains a success or fail message with details. (Response code, response message, and the used URL are displayed on the screen.)

If the request fails, the error or WP_Error object will also be shown via var_dump() at the bottom of the page, making debug just a little bit easier.

== Installation ==

1. Upload to your plugins folder, usually `wp-content/plugins/`
2. Activate the plugin on the plugin screen.
3. Go to Tools -> Rmt Request Check
4. Click on "Check"

== Screenshots ==

1. Admin page of the plugin showing a successful request
