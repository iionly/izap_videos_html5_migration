<?php

$count_total = (int) get_input('count_total', false);
$delete_count = (int) get_input('delete_count');

if (!$count_total) {
	return elgg_error_response(elgg_echo('izap_videos_html5_migration:count_error'));
}
if (!$delete_count) {
	$delete_count = $count_total;
}
if ($delete_count > $count_total) {
	$delete_count = $count_total;
}

// prevent timeout when script is running
set_time_limit(0);

access_show_hidden_entities(true);

$delete_batch = elgg_get_entities_from_metadata([
	'type' => 'object',
	'subtype' => IzapVideos::SUBTYPE,
	'metadata_name' => 'videotype',
	'metadata_value' => 'uploaded',
	'batch' => true,
	'limit' => false,
]);

$found_flv_count = 0;
foreach($delete_batch as $video) {
	if ($found_flv_count < $delete_count) {
		$filename = $video->videofile;
		$fileHandler = new ElggFile();
		$fileHandler->owner_guid = $video->owner_guid;
		$fileHandler->setFilename($filename);
		$file = $fileHandler->getFilenameOnFilestore();
		$file_no_ending = substr($file, 0, -3);
		$file_flv = $file_no_ending . "flv";

		if (file_exists($file_flv)) {
			unlink($file_flv);
			$found_flv_count++;
		}
	}
}

access_show_hidden_entities($access_status);

$output = json_encode([
	'result' => "<b>". elgg_echo('izap_videos_html5_migration:delete_success', [$found_flv_count]) . "</b>",
]);

return elgg_ok_response($output, elgg_echo('izap_videos_html5_migration:delete_success', [$found_flv_count]));
