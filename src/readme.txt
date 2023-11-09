=== Stop WP Emails Going to Spam ===
Contributors: alanfuller, fullworks
Donate Link: https://www.buymeacoffee.com/wpdevalan
Tags: email, spam, envelope sender, phpmail, phpmailer
Tested up to: 6.4
Stable tag: 2.0.6
License: GPLv3 or later
License URI: http://www.gnu.org/licenses/gpl-3.0.html

Emails generated from within WordPress often end up in your spam or junk folder, This plugin helps you sort that out. The default setting can often be enough to solve your problem.

== Description ==

Emails generated from within WordPress often end up in your spam or junk folder, This plugin helps you sort that out. The default settings of this plugin can often be enough to solve your problem.

When using the default PHP mailer in WordPress, especially on shared servers, emails will often be set to spam or junk by receiving email systems. This can be very frustrating and important notifications can be missed by you or your clients.

Why does this happen? One problem is the "envelope sender" not being set, and many hosts will recommend that you install a plugin to set the "envelope sender", this is the main purpose of this plugin.

Along with setting the "envelope sender" this plugin also displays your Sender Permitted From (SPF) and checks your server IP is in the SPF record, if there is one.

Optionally this plugin allows you to change the name and email address of the default WordPress notification email easily.

If you use an SMTP email plugin or use an API based transactional email plugin, this plugin will add no value; it is built to support the default PHP mailer only.

= PHP 8.0 compatible =
Tested on PHP 8

= Features Include =
* Checks email SPF health
* Checks if your IP is blacklisted
* Set envelope sender when missing
* Allows you to change the default WordPress sending email
* Allows you to change the default WordPress sending email name
* Allows you to set the sending email domain


== Installation ==

This section describes how to install the plugin and get it working.

Either using the dashboard 'Add Plugin' feature to find, install and activate the plugin,  or
1. Download and unzip the plugin
2. Upload the entire contents of stop-wp-emails-going-to-spam to the /wp-contents/plugins directory.
3. Activate the plugin through the Plugins menu

Once activated you will be taken to the settings page.  The default settings are a good place to start, so save these and start testing your email delivery.

== Frequently Asked Questions ==

= Can You Help Me Investigate Why Email Goes To Spam=

This plugin is provided for free and any support is totally voluntary.

== Changelog ==
= 2.0.6 =
* library update

= 2.0.5 =
* Correct server IP detection

= 2.0.4 =
* add buy me a coffee donation option

= 2.0.3 =
* update donation library

= 2.0.2 =
* stop settings link showing twice

= 2.0.1 =
* Improve donation process

= 2.0.0 == 2.0.0 =
* Add IP blacklist check
* Remove Freemius
* Add donation link

= 1.1.6 =
* Correct display output in settings when SPF redirect to another domain

= 1.1.5 =
* Removed deactivation survey

= 1.1.4 =
* Library Update

= 1.1.3 =
* Move support off menu to settings

= 1.1.2 =
* Minor Fix

= 1.1.1 =
* Minor Fix

= 1.1 =
* Ensure default settings work on multisite

= 1.0 =
* First Release
