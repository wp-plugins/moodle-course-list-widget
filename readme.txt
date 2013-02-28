=== Moodle Course List Widget ===
Contributors: kennibc
Tags: widget, moodle, education, k-12, schools, courses, teachers, students, learning
Requires at least: 3.0.1
Tested up to: 3.5.1
Stable tag: 1.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

This plugin will allow you to display a list of Moodle courses for a specific user of Moodle. 

== Description ==

This plugin will allow you to display a list of Moodle courses for a specific user of Moodle. This is ideal for teachers who use WordPress for public communication and Moodle for private classroom activities. This widget will allow the teacher to display a list of their courses so that parents and students can quickly navigate between WordPress and Moodle.

This plugin is designed for use in larger institutions and must be configured by a web administrator. There are 3 places in the code where you must make changes to get this plugin working properly. Each place is clearly commented with //CHANGE and an explanation of what needs to be changed.  Please see Installation for additional information on how to configure and install.

To see the plugin in action please view http://iblog.dearbornschools.org/webmaster 


== Installation ==

This section describes how to install the plugin and get it working.

Install:
1. Upload `moodle-courselist-widget.php` to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Place the new Moodle Courselist widget into your theme's sidebar.

IMPORTANT:  You will need to edit the code of this plugin in 3 places in order for this to work properly.  This will most likely involve a web administrator as you will need database connection settings for Moodle.  This plugin is designed for use by educational institutions.  Changes are clearly commented in the code with //CHANGE.  

Here are the code changes you must edit:

Line 35 (Your Moodle Site URL)- 
action="http://yourmoodlesiteurl.com/login/index.php

Line 44 (Moodle Database Connection)- 
mysql_connect("localhost","MySQLusername","MYSQLpassword");  

Line 76 (Your Moodle Site URL)- 
"http://yourmoodlesiteurl.com/course/view.php?id='.$course->courseid.'"



== Frequently Asked Questions ==

= What version of Moodle and Wordpress is required? =

This plugin has been tested and approved for Moodle version 2.4 and Wordpress 3.5.   I am pretty sure it will work with any version of Wordpress 3+.

= I get a MySQL connection error. =

You have not properly edited the plugin code.  You must provide a connection to your Moodle database.  This should be a READ ONLY user account.

= I edited the code and still get an error. =

Most likely your database connection settings are incorrect.  Please recheck and verify you can connect using the user and password for MySQL.

== Screenshots ==

1. Places where you must change the code are highlighted
2. Here is the widget settings the end user will see.  The can add a title to the widget and add the Moodle User Account that they want to display courses for.
3. Frontend display of courses.


== Changelog ==

= 1.0 =
* Initial release.
* Display Moodle course List with direct links to courses.
* Checkbox Toggle display of Moodle login form below list of courses.


== Upgrade Notice ==

= 1.0 =
Initial release.
