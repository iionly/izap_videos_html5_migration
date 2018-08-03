iZAP Videos HTML5 Migration plugin for Elgg 2.3 and newer Elgg 2.X
============================================================

Latest Version: 2.3.4  
Released: 2018-08-02  
Contact: iionly@gmx.de  
License: GNU General Public License version 2  
Copyright: (C) iionly 2018


Description
-----------

This is a helper plugin for migrating on-server videos uploaded with iZAP Videos with a version older than 2.3.4 (which saved on-server videos in FLV format and required the Flash plugin on client computers for playback) into MP4 format (HTML5 video playback support introduced with version 2.3.4 of iZAP Videos).

While the iZAP Videos HTML5 Migration plugin is enabled the uploading of videos with the iZAP Videos plugin is disabled. Therefore, you also need to disable/remove the iZAP Videos HTML5 Migration plugin after you have finished the migration of your on-server videos.

Before starting the migration process make a backup of your database and your data directory. In case anything goes wrong while migrating the videos this is your only chance to return to a valid state of database and data directory. I won't help you (most likely can't even help even if I would like to) if you were too lazy to make a backup. You've been warned!

The migration process is handled on the "Administer - Utilities - iZAP Videos HTML5 Migration" page in the admin area of your Elgg site. The migration process is described in detail there, so please read everything carefully. Before you start please check out the plugin settings page of the iZAP Videos plugin and make sure you have adjusted the ffmpeg conversion command in a suitable way. If you used the default (or the suggested optimized ) command, you will have to change the audio codec to be used at least (changing "-acodec libmp3lame" to "-acodec aac"). Any other changes you might have made might also require modification. But you would have to figure out what to change on your own. Best would be to test out version 2.3.4 of iZAP Videos on a test installation to find a conversion command parameter setting that is okay for you and will then also be used for migrating the existing on-server videos on your site.


Installation
------------

1. If any older version of the iZAP Videos HTML5 Migration plugin is installed, disable it on your site and remove the old izap_videos_html5_migration plugin folder from the mod directory,
2. Copy the izap_videos_html5_migration folder in your mod directory,
3. Enable the iZAP Videos HTML5 Migration plugin on your site,
4. Make sure you have a working ffmpeg conversion command entered on the iZAP Videos plugin settings page before you start the migration process,
5. Go to the "Administer - Utilities - iZAP Videos HTML5 Migration" page, read the instructions and then follow them to upgrade your database entries, convert the videos to MP4 format and delete the old FLV videos files no longer needed after the migration,
6. Once the migration is done disable the iZAP Videos HTML5 Migration plugin and remove the izap_videos_html5_migration plugin folder from the mod directory. The iZAP Videos HTML5 Migration plugin is no longer needed.
