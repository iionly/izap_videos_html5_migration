<?php

$count_total = (int) get_input('count_total', false);
$check_count = (int) get_input('check_count');

if (!$count_total) {
	return elgg_error_response(elgg_echo('izap_videos_html5_migration:count_error'));
}
if (!$check_count) {
	$check_count = $count_total;
}
if ($check_count > $count_total) {
	$check_count = $count_total;
}

// prevent timeout when script is running
set_time_limit(0);

access_show_hidden_entities(true);

$check_batch = elgg_get_entities_from_metadata([
	'type' => 'object',
	'subtype' => IzapVideos::SUBTYPE,
	'metadata_name' => 'videotype',
	'metadata_value' => 'uploaded',
	'batch' => true,
	'limit' => false,
]);

$subset_count = 0;
$total_flv_videos = 0;
$total_discspace_flv = 0;
$total_discspace_mp4 = 0;
$subset_discspace_flv = 0;
$subset_discspace_mp4 = 0;

foreach($check_batch as $video) {

	$video_flv_size = 0;
	$video_mp4_size = 0;
	
	$filename = $video->videofile;
	$fileHandler = new ElggFile();
	$fileHandler->owner_guid = $video->owner_guid;
	$fileHandler->setFilename($filename);
	$file = $fileHandler->getFilenameOnFilestore();
	$file_no_ending = substr($file, 0, -3);
	$file_flv = $file_no_ending . "flv";
	$file_mp4 = $file_no_ending . "mp4";

	if (file_exists($file_mp4)) {
		$video_mp4_size =  filesize($file_mp4);
		$video_mp4_size = $video_mp4_size / 1024 / 1024;
	}

	if (file_exists($file_flv)) {
		$video_flv_size =  filesize($file_flv);
		$video_flv_size = $video_flv_size / 1024 / 1024;

		if ($subset_count < $check_count) {
			$subset_discspace_flv += (int) $video_flv_size;
			$subset_discspace_mp4 += (int) $video_mp4_size;
			$subset_count++;
		}

		$total_flv_videos++;
	}

	$total_discspace_flv += (int) $video_flv_size;
	$total_discspace_mp4 += (int) $video_mp4_size;
}

access_show_hidden_entities($access_status);
$output_string = elgg_echo('izap_videos_html5_migration:check_output', [$check_count, $subset_count, $subset_discspace_flv, $subset_discspace_mp4, $total_flv_videos, $total_discspace_flv, $total_discspace_mp4]);

$output = json_encode([
	'result' => $output_string,
]);

return elgg_ok_response($output, elgg_echo('izap_videos_html5_migration:check_finished'));
