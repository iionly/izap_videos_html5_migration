<?php

elgg_require_js('izap_videos_html5_migration/database');

echo '<div id="izap-videos-html5-migration-admin-database"></div>';

$footer = elgg_view_field([
	'#type' => 'submit',
	'value' => elgg_echo('izap_videos_html5_migration:database_submit'),
]);

elgg_set_form_footer($footer);
