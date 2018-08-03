<?php

// prevent timeout when script is running
set_time_limit(0);

access_show_hidden_entities(true);

$database_batch = elgg_get_entities_from_metadata([
	'type' => 'object',
	'subtype' => IzapVideos::SUBTYPE,
	'metadata_name' => 'videotype',
	'metadata_value' => 'uploaded',
	'batch' => true,
	'limit' => false,
]);

foreach($database_batch as $video) {
	$video->videosrc = elgg_get_site_url() . 'izap_videos_files/file/' . $video->guid . '/' . elgg_get_friendly_title($video->title) . '.mp4';

	$old_videofile = $video->videofile;
	$video->videofile = substr($old_videofile, 0, -3) . "mp4";
	
	if ($video->filename == $old_videofile) {
		$video->filename = $video->videofile;
	}
}

access_show_hidden_entities($access_status);

$output = json_encode([
	'result' => "<b>". elgg_echo('izap_videos_html5_migration:database_success') . "</b>",
]);

return elgg_ok_response($output, elgg_echo('izap_videos_html5_migration:database_success'));
