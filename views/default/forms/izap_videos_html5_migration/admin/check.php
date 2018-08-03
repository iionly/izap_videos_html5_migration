<?php

elgg_require_js('izap_videos_html5_migration/check');

/* @var $count Integer */
$count_total = elgg_extract('count_total', $vars);

echo elgg_view_field([
	'#type' => 'hidden',
	'name' => 'count_total',
	'value' => $count_total,
]);

echo elgg_view_field([
	'#type' => 'number',
	'#label' => elgg_echo('izap_videos_html5_migration:check_number'),
	'name' => 'check_count',
	'min' => 0,
	'max' => $count_total,
	'step' => 1,
	'value' => 1,
]);

echo '<div id="izap-videos-html5-migration-admin-check"></div>';

$footer = elgg_view_field([
	'#type' => 'submit',
	'value' => elgg_echo('izap_videos_html5_migration:check_submit'),
]);

elgg_set_form_footer($footer);
