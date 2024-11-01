=== Simple History NGG Loggers ===
Contributors: (wpo-HR)
Tags: NextGEN Gallery, Simple History, custom loggers, gallery link, image title, image description
Requires at least: 4.5.1
Tested up to: 5.9.1
Requires PHP: 5.2.4
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

This plugin adds custom loggers to the 'Simple History' plugin which protocoll user activities for the 'NextGEN Gallery' plugin.

== Description ==

'Simple History' will log changes to the wordpress website, in particular changes to posts and pages. 'NextGEN Gallery' uses posts for some generic functionality, however its specific information is stored in own internal tables. Therefore 'Simple History' can log changes in a 'NextGEN Gallery' post-types, but it will not provide any gallery-specific information thereby.

This plugin hooks into NextGEN Gallery and will provide that kind of missing specific information to  'Simple History' custom loggers. Now the following information will be logged by 'Simple History':

for images

* which image is uploaded to which gallery
* which image from which gallery is deleted
* Which image is copied or moved from which source gallery to which target gallery

for galleries

* which gallery is created
* which gallery is deleted
* for which galleries are metadata changed

for albums

* which album is created
* which album is deleted
* which album is changed (i.e. which galleries are assigned to an album)

The log entry details will show some more information for each activity. In addition to logging this kind of information, this plugin will also enhance some functionality of 'NextGEN Gallery':

* When uploading images and optimizing the image size, 'NextGEN Gallery' will currently strip off metadata like titel and description of the image. Therefore the uploader has to reenter titel and description for all uploaded images. This plugin will check for the original upload file and will automatically provide titel and description, if present.
* When moving or copying images between galleries, 'NextGEN Gallery' will currently only move/copy the optimized image file but not the original/backup image file. This plugin will check for the original/backup file and move/copy this file if needed. UPDATE: starting with version 2.1.57 NextGEN Gallery will now also move/copy backup files.
* This plugin will add a shortcut link to the edit post link of a page. This links directly points to the corresponding backend 'manage gallery' page, if the current page relates to this gallery.

This plugin requires 'NextGEN Gallery' version 2.1.43 or above to provide the full functionality. It hooks to various actions in 'NextGEN Gallery', which in part are only provided starting from version 2.1.43.

This plugin provides a setting page, where all logging activities can be customized. By default, all of the above listed events are logged for each user. In addition the no longer needed 'Simple History' generic log entries for 'NextGEN Gallery' posts are filtered out. Finally the time period for clearing old log entries in 'Simple Historie' is set to zero. This will prevent 'Simple Historie' from deleting any log entries.

== Installation ==

* Upload `simple-history-ngg-logger` to the `/wp-content/plugins/` directory
* Activate the plugin through the 'Plugins' menu in WordPress
* Adjust settings, if necessary

== Frequently Asked Questions ==

= A question that someone might have =

An answer to that question.



== Screenshots ==

1. setting page
2. log entries for galleries
3. log detail for gallery update
4. log entry for image move
5. manage gallery page with corresponding page link
6. corresponding gallery link to backend on gallery front end page

== Changelog ==

= 1.2 =
* changed some code for testing version management, no functional differences

= 1.1 =
* fixed: protocoll title and description saved from backup for images in certain situations (if no uploader is given)
* improved: protocoll title and description in extended log entry

= 1.0.1 =
* redefined screenshot attributes to prevent download
* fixed missing edit_post_link

= 1.0 =
* Initial public version

== Upgrade Notice ==

= 1.0 =
No upgrade, just initial install
