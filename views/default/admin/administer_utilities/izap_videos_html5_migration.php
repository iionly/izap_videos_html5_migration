<?php

$access_status = access_get_show_hidden_status();
access_show_hidden_entities(true);
$count_total = elgg_get_entities_from_metadata([
	'type' => 'object',
	'subtype' => IzapVideos::SUBTYPE,
	'metadata_name' => 'videotype',
	'metadata_value' => 'uploaded',
	'count' => true,
]);
access_show_hidden_entities($access_status);


$info_content = elgg_autop(elgg_echo('izap_videos_html5_migration:info_help'));
$info_content .= elgg_autop(elgg_echo('izap_videos_html5_migration:count_total', [$count_total]));
echo elgg_view_module('inline', elgg_echo('izap_videos_html5_migration:info_title'), $info_content);


$database_content = elgg_autop(elgg_echo('izap_videos_html5_migration:database_help'));
$form_vars_database = [
	'action' => 'action/izap_videos_html5_migration/admin/database',
	'class' => 'elgg-form-settings',
];
$body_vars_database = [];
$database_content .= elgg_view_form('izap_videos_html5_migration/admin/database', $form_vars_database, $body_vars_database);
echo elgg_view_module('inline', elgg_echo('izap_videos_html5_migration:database_title'), $database_content);

$check_content = elgg_autop(elgg_echo('izap_videos_html5_migration:check_help'));
$form_vars_check = [
	'action' => 'action/izap_videos_html5_migration/admin/check',
	'class' => 'elgg-form-settings',
];
$body_vars_check = [
	'count_total' => $count_total,
];
$check_content .= elgg_view_form('izap_videos_html5_migration/admin/check', $form_vars_check, $body_vars_check);
echo elgg_view_module('inline', elgg_echo('izap_videos_html5_migration:check_title'), $check_content);


$migration_content = elgg_autop(elgg_echo('izap_videos_html5_migration:migrate_help'));
$form_vars_migrate = [
	'action' => 'action/izap_videos_html5_migration/admin/migrate',
	'class' => 'elgg-form-settings',
];
$body_vars_migrate = [
	'count_total' => $count_total,
];
$migration_content .= elgg_view_form('izap_videos_html5_migration/admin/migrate', $form_vars_migrate, $body_vars_migrate);
echo elgg_view_module('inline', elgg_echo('izap_videos_html5_migration:migrate_title'), $migration_content);

$delete_content = elgg_autop(elgg_echo('izap_videos_html5_migration:delete_help'));
$form_vars_delete = [
	'action' => 'action/izap_videos_html5_migration/admin/delete',
	'class' => 'elgg-form-settings',
];
$body_vars_delete = [
	'count_total' => $count_total,
];
$delete_content .= elgg_view_form('izap_videos_html5_migration/admin/delete', $form_vars_delete, $body_vars_delete);
echo elgg_view_module('inline', elgg_echo('izap_videos_html5_migration:delete_title'), $delete_content);
