<?php

$count_total = (int) get_input('count_total', false);
$migrate_count = (int) get_input('migrate_count');

if (!$count_total) {
	return elgg_error_response(elgg_echo('izap_videos_html5_migration:count_error'));
}
if (!$migrate_count) {
	$migrate_count = $count_total;
}
if ($migrate_count > $count_total) {
	$migrate_count = $count_total;
}

// prevent timeout when script is running
set_time_limit(0);

access_show_hidden_entities(true);

$migrate_batch = elgg_get_entities_from_metadata([
	'type' => 'object',
	'subtype' => IzapVideos::SUBTYPE,
	'metadata_name' => 'videotype',
	'metadata_value' => 'uploaded',
	'batch' => true,
	'limit' => false,
]);

$found_flv_count = 0;
foreach($migrate_batch as $video) {
	if ($found_flv_count < $migrate_count) {
		$filename = $video->videofile;
		$fileHandler = new ElggFile();
		$fileHandler->owner_guid = $video->owner_guid;
		$fileHandler->setFilename($filename);
		$file = $fileHandler->getFilenameOnFilestore();
		$file_no_ending = substr($file, 0, -3);
		$file_flv = $file_no_ending . "flv";
		$file_mp4 = $file_no_ending . "mp4";

		if (file_exists($file_flv)) {
			$queue = new IzapQueue();
			$queue->put($video, $file_flv, $video->access_id);
		
			$found_flv_count++;
		}
	}
}

access_show_hidden_entities($access_status);

$output = json_encode([
	'result' => "<b>". elgg_echo('izap_videos_html5_migration:migrate_success', [$found_flv_count]) . "</b>",
]);

return elgg_ok_response($output, elgg_echo('izap_videos_html5_migration:migrate_success', [$found_flv_count]));
