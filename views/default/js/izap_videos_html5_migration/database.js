define(function(require) {
	var $ = require('jquery');
	var elgg = require('elgg');
	var Ajax = require('elgg/Ajax');
	var spinner = require('elgg/spinner');

	// manage Spinner manually
	var ajax = new Ajax(false);

	$(document).on('submit', '.elgg-form-izap-videos-html5-migration-admin-database', function(e) {
		var $form = $(this);

		spinner.start();
		ajax.action($form.prop('action'), {
			data: ajax.objectify($form)
		}).done(function(json, status, jqXHR) {
			if (json && (typeof json.result === 'string')) {
				spinner.stop();
				$("#izap-videos-html5-migration-admin-database").html(json.result);
			} else {
				spinner.stop();
				$("#izap-videos-html5-migration-admin-database").html("An error occured. Please try again.");
			}
		});

		e.preventDefault();
	});
});
