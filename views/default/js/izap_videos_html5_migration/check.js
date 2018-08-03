define(function(require) {
	var $ = require('jquery');
	var elgg = require('elgg');
	var Ajax = require('elgg/Ajax');
	var spinner = require('elgg/spinner');

	// manage Spinner manually
	var ajax = new Ajax(false);

	$(document).on('submit', '.elgg-form-izap-videos-html5-migration-admin-check', function(e) {
		var $form = $(this);

		spinner.start();
		ajax.action($form.prop('action'), {
			data: ajax.objectify($form)
		}).done(function(json, status, jqXHR) {
			if (json && (typeof json.result === 'string')) {
				spinner.stop();
				$("#izap-videos-html5-migration-admin-check").html(json.result);
			} else {
				spinner.stop();
				$("#izap-videos-html5-migration-admin-check").html(elgg.echo('izap_videos_html5_migration:error'));
			}
		});

		e.preventDefault();
	});
});
