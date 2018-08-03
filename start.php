<?php
/**
 * iZAP Videos HTML5 migration plugin by iionly
 * Contact: iionly@gmx.de
 * https://github.com/iionly
 *
 * @license GNU Public License version 2
 *
 */

elgg_register_event_handler('init', 'system', 'init_izap_videos_html5_migration');

/**
 * Main function that register everything
 */
function init_izap_videos_html5_migration() {

	// Add admin menu item
	elgg_register_admin_menu_item('administer', 'izap_videos_html5_migration', 'administer_utilities');

	$period = izapAdminSettings_izap_videos('izap_cron_time');
	if ($period != 'none') {
		elgg_unregister_plugin_hook_handler('cron', $period, 'izap_queue_cron');
		elgg_register_plugin_hook_handler('cron', $period, 'izap_migrate_queue_cron');
	} else {
		elgg_register_plugin_hook_handler('cron', 'minute', 'izap_migrate_queue_cron');
	}

	// Register some actions
	elgg_register_action('izap_videos_html5_migration/admin/check', dirname(__FILE__) . "/actions/izap_videos_html5_migration/admin/check.php", 'admin');
	elgg_register_action('izap_videos_html5_migration/admin/database', dirname(__FILE__) . "/actions/izap_videos_html5_migration/admin/database.php", 'admin');
	elgg_register_action('izap_videos_html5_migration/admin/migrate', dirname(__FILE__) . "/actions/izap_videos_html5_migration/admin/migrate.php", 'admin');
	elgg_register_action('izap_videos_html5_migration/admin/delete', dirname(__FILE__) . "/actions/izap_videos_html5_migration/admin/delete.php", 'admin');

	// Prevent video uploads while migration process is going on, i.e. while this plugin is enabled
	elgg_unregister_action('izap_videos/addEdit');
	elgg_register_action('izap_videos/addEdit', dirname(__FILE__) . "/actions/izap_videos_html5_migration/addEdit.php", 'logged_in');
}

function izap_migrate_queue_cron($hook, $entity_type, $returnvalue, $params) {
	izapTrigger_izap_migrate_videos();
}

function izapTrigger_izap_migrate_videos() {
	if (!izapIsQueueRunning_izap_videos()) {
		ini_set('max_execution_time', 0);
		ini_set('memory_limit', izapAdminSettings_izap_videos('izapMaxFileSize') + 100 . 'M');

		izapGetAccess_izap_videos(); // get the complete access to the system
		izapRunQueue_izap_migrate_videos();
		izapRemoveAccess_izap_videos(); // remove the access from the system
	}
}

function izapRunQueue_izap_migrate_videos() {
	$queue_object = new IzapQueue();
	$queue = $queue_object->fetch_videos();
	if (is_array($queue)) {
		foreach($queue as $pending) {
			$converted = izapConvertVideo_izap_migrate_videos($pending['main_file'], $pending['guid'], $pending['title'], $pending['url'], $pending['owner_id']);
// 			if (!$converted) {
// 				$queue_object->move_to_trash($pending['guid']);
// 			}
			$queue_object->delete($pending['guid']);
			izap_update_all_defined_access_id($pending['guid'], $pending['access_id']);
		}
		// re-check if there are new videos in the queue
		if ($queue_object->count() > 0) {
			izapRunQueue_izap_migrate_videos();
		}
	}
	return true;
}

function izapConvertVideo_izap_migrate_videos($file, $videoId, $videoTitle, $videoUrl, $ownerGuid, $accessId = 2) {
	$return = false;

	// Works only if we have the input file
	if (file_exists($file)) {
		// Need to set flag for the file going in the conversion
		$queue_object = new IzapQueue;
		$queue_object->change_conversion_flag($videoId);

		$video = new IzapConvertMigrate($file);
		$videofile = $video->izap_video_convert();

		// Check if everything is ok
		if (!is_array($videofile)) {
			return true;
		} else {
			$errorReason = $videofile['message'];
		}
	} else {
		$errorReason = elgg_echo('izap_videos:fileNotFound');
	}

	if (!empty($errorReason)) {
		$return = ['error' => true, 'reason' => $errorReason];
	}
	return $return;
}
