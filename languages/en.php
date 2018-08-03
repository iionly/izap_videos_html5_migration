<?php

return [
	'admin:administer_utilities:izap_videos_html5_migration' => "iZAP Videos HTML5 Migration",
	'izap_videos_html5_migration:info_title' => "Information on Migration process",
	'izap_videos_html5_migration:error' => "An error occured. Please try again.",
	'izap_videos_html5_migration:add_video_disabled' => "The iZAP Videos plugin is currently getting updated. During the upgrade adding new videos has been disabled. Please try again later.",
	'izap_videos_html5_migration:count_error' => "Total number of on-server videos unknown. Stopping here. Please try again",
	'izap_videos_html5_migration:info_help' => "A lot of text... But please read carefully!

	The iZAP Videos HTML5 Migration plugin is a helper plugin only necessary if you upgrade to iZAP Videos version 2.3.4 from an older version and have already on-server videos on your site. Previously, the videos were saved in FLV format (requiring the Flash plugin to view the videos). With version 2.3.4 of iZAP Videos the on-server videos get saved in MP4 format to allow for HTML5 video playback without the need to have the Flash plugin installed on the client computers. The existing on-server videos need to be converted from FLV to MP4 to be able to still view them. As this is a one-time migration task (and not even necessary at all if you haven't used iZAP Videos before) this task has been implemented outside of iZAP Videos in the iZAP Videos HTML5 Migration plugin to keep the iZAP Videos plugin clean of stuff not needed anymore once the migration has been done.

	<b>IMPORTANT:</b> version 2.3.4 of iZAP Videos also dropped the upgrade scripts that were included in it since version 1.8.0 already. These are also no longer needed at all (as you would have run them long before upgrading to version 2.3.4 - if you ever needed them at all to be run if you haven't started with an original iZAP Videos version before I had started my fork). Nevertheless, if you worry about the necessity of having these scripts run before, install version 2.3.3 of my iZAP Videos plugin fork first and only then upgrade to version 2.3.4.

	<b>How does the migration work now?</b>
	<b>1.</b> First thing you need is to have version 2.3.4 of iZAP Videos installed.
	<b>2.</b> Then you most likely need to modify the \"Video converting command\" on the Settings tab of the iZAP Videos plugin settings page. With HTML5 video playback the audio codec needed is \"aac\". If you have made any custom modifications to the converting command, you might need to make other adjustments (you would need to find out for yourself). As an example the new optimized command is listed below the \"Video converting command\" input field. Further info in the README.md of iZAP Videos.
	<b>3.</b> <b>MOST IMPORTANT:</b> Backup your database and your data directory before you start the migration! In case the conversion fails or gets stuck at some point it's your only fallback!

	Once the converting command used by iZAP Videos has been adjusted, the migration of the exisiting on-server videos can begin here. If you want to make sure the command works, you can test with converting only a single for a start. As long as you don't delete the FLV video file you can repeat the migration process as often as you like.

	<b>The migration process is divided into serveral steps:</b>
	<b>1.</b> <b>Database upgrade:</b> This step upgrades the metadata enties associated with the on-server video entities. You only need to run this upgrade once. As it doesn't require any additional space, the database entries of all videos are upgraded at once. PLEASE START WITH THIS STEP BEFORE CONVERTING ANY VIDEOS!
	<b>2.</b> <b>Check:</b> The creation of the MP4 files of your on-server videos requires disc-space in your data directory. The required space is about the same as currently used by the FLV files of your videos (it might be slightly more as the converted MP4 files could be slightly larger than the FLV files). To be able to repeat the conversion process in case of errors (or if you are not happy with the quality of the converted files and need to adjust the converting command used by iZAP Videos) the FLV files are not automatically deleted immediatelly after the creation of the MP4 files. So, converting all videos at once would mean you would need a total free disc-space in the same range as currently used by all your videos. As this might not be the case, you can convert only a certain number of videos at once (e.g. 10 videos) and - if the conversion was successful - delete the FLV files of these videos before starting the conversion of the next videos. This way you need less free disc space during the process. To be able to estimate the necessary disc space, you can do a \"Check\" run to learn the total disc-space used by all the FLV and MP4 files and additionally get the disc-space used by the first X number of videos.
	<b>3.</b>. <b>Migrate:</b>This step creates the MP4 files of your on-server videos. It's done by putting the FLV files into the iZAP Videos on-server videos conversion queue. You can select how many of your videos you want to put into the queue if you can't add them all in one go. Watch the conversion queue of iZAP Videos to be sure that the conversion of all videos you put in the queue has finished before adding more videos, deleting any videos or checking disc-space usage.
	<b>4.</b> <b>Delete:</b> This step deletes the FLV video files no longer necessary once you have finished the conversion/creation of the MP4 files of your on-server videos. As with the Check and Migrate step you can select to delete only a certain number of FLV files of your on-server videos if you need to proceed with the conversion in steps due to limitations of free disc-space. Make sure you got the videos converted successfully before deleting them!",

	'izap_videos_html5_migration:database_title' => '1. Database upgrade',
	'izap_videos_html5_migration:database_help' => "In this step the database entries associated with the on-server videos files are updated to point to the MP4 files in the future. This upgrade step is done for all on-server video entities at once in one go. The conversion of the video files has to be done independently. Without both steps completed the videos won't play. Please do the database upgrade before you start with the conversion of the videos to MP4 format below.",
	'izap_videos_html5_migration:database_submit' => "Database upgrade",
	'izap_videos_html5_migration:database_success' =>"Database upgrade finished. Please re-load page before performing any other action!",

	'izap_videos_html5_migration:check_title' => "2. Check",
	'izap_videos_html5_migration:check_help' => "Here you check the disc space usage of your on-server videos. You will get the total disc space used by the FLV files, the total disc space used by the MP4 files and you can get additionally the disc space used by FLV and MP4 files respectively of a number of videos of your choice. The subset of videos (depending on the number you enter) will give you the disc-space of the latest videos (by upload time) that still have FLV files associated. For example, if you proceed with the conversion in subsets of 10 videos by checking for disc-space used by the latest 10 videos, then converting them and then deleting the FLV files of these you would get the disc-space used by the next 10 videos on a subsequent check for disc-space usage. But if you wouldn't have deleted the FLV files of the first 10 videos you already converted in the first round, you would still get the disc-space used by these first 10 videos and not of the next 10. If you enter 0 for the number of videos, it means \"no limit\", so the subset would be equal to all videos.",
	'izap_videos_html5_migration:count_total' => "<b>Total number of on-server videos: %s</b>",
	'izap_videos_html5_migration:check_number' => 'In addition of total FLV files disc-space check disc-space used by how many of the on-server videos (counted in order of newest videos ascending):',
	'izap_videos_html5_migration:check_submit' => "Check",
	'izap_videos_html5_migration:check_finished' => "Disc-space check finished. Please re-load page before performing any other action!",
	'izap_videos_html5_migration:check_output' => "<b>Check results:</b><br>
Query was checking filesize for a subset of the newest %s FLV videos.<br>
Actual number of videos files in FLV format found that are included in subset is %s.<br>
Within subset the accumulated filesize of video files in FLV format is %s MB.<br>
Within subset the accumulated filesize of video files in MP4 format is %s MB.<br>
Total number of video files in FLV format found is %s.<br>
Total filesize of all video files in FLV format remaining is %s MB.<br>
Total filesize of all video files in already in MP4 format is %s MB.<br>",
	'izap_videos_html5_migration:check_error' => "An error occured. Please try again.",

	'izap_videos_html5_migration:migrate_title' => '3. Migrate',
	'izap_videos_html5_migration:migrate_help' => "Here you create the MP4 video files necessary for HTML5 video playback. The existing FLV files associated to the video entities are converted to MP4 with ffmpeg via the iZAP Videos conversion queue. BEFORE starting with converting videos you MUST have run the Database upgrade in step 1!
	
If you can't migrate all your videos at once due to free disc-space limitations you can migrate only a certain number of videos in this step and then delete the SAME number of videos in step 4 (make sure you don't mix up the numbers!).

If you haven't deleted the FLV files in step 4 yet, you can repeat the migration/conversion to MP4 format as often as you want in case the MP4 file created is not as you have expected (you should check quality/sound to make sure your ffmpeg command entered on the iZAP Videos plugin settings page is appropriate for your needs).

As the iZAP Videos conversion queue is used, make sure you have adjusted the command as needed for your requirements (e.g. for audio getting converted corretly it's very likely necessary that you use the parameter \"-acodec aac\" and no longer \"-acodec libmp3lame\" as used by iZAP Videos before version 2.3.4... any other customizations in the conversion command you might have made on your own you would have to adjust on your own).

Once you started the migration of some (or all) of your video entries check the iZAP Videos queue and wait until the conversion has finished before you continue.",
	'izap_videos_html5_migration:migrate_number' => 'Enter the number of FLV video files (counting from the newest video entries with only the entries considered where FLV files remain) you want to put into the conversion queue to create the MP4 video files of it (0 means all):',
	'izap_videos_html5_migration:migrate_submit' => "Migrate",
	'izap_videos_html5_migration:migrate_success' =>"%s FLV video files added to queue. Check the iZAP Videos queue and wait until all videos have been converted",

	'izap_videos_html5_migration:delete_title' => '4. Delete',
	'izap_videos_html5_migration:delete_help' => "Here you delete the FLV video files associated with the videos. BEFORE you delete a FLV file you need to have the migration / conversion to MP4 video format finished for the video entry you want to delete the associated FLV file. Deletion can't be reversed! You have made a backup, right!?
	
If you can't migrate all your videos at once, only delete the same number of videos you already have migrated in step 3, i.e. enter the same number below as you had entered in step 3 for the last migration run.",
	'izap_videos_html5_migration:delete_number' => 'Enter the number of FLV video files (counting from the newest video entries with only the entries considered where FLV files remain) you want to delete the associated FLV file you already have created the MP4 files of (0 means all):',
	'izap_videos_html5_migration:delete_submit' => "Delete",
	'izap_videos_html5_migration:delete_success' =>"Deletion of %s FLV video files finished.",
];
