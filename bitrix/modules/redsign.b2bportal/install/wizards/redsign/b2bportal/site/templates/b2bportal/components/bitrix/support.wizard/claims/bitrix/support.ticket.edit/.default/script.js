function onReady()
{
	var dropzones = $('.dropzone'), dropzone;

	Dropzone.autoDiscover = false;

	dropzones.each(function (index, el) {

		var $el = $(el);
		var $form = $el.closest('form');

		dropzone = new Dropzone(el, {
			previewTemplate: `<div class="dropzone-item" style="display:none">
				<div class="dropzone-file">
					<div class="dropzone-filename" title=""><span data-dz-name=""></span> <strong>(<span data-dz-size=""></span>)</strong></div>
					<div class="dropzone-error" data-dz-errormessage=""></div>
				</div>
				<div class="dropzone-toolbar">
					<span class="dropzone-delete" data-dz-remove=""><i class="flaticon2-cross"></i></span>
				</div>
			</div>`,
			url: $form.attr('action'),
			uploadMultiple:true,
			autoProcessQueue: false,
			previewsContainer: el.querySelector(".dropzone-items"),
			clickable: el.querySelector('.dropzone-select'),
		});

		$form.find('input[type="submit"]').on('click', function (e) {
			var button = $(this);

			if (dropzone.files.length)
			{
				KTApp.block($form.closest('.kt-portlet'));
				e.preventDefault();
				e.stopPropagation();
	
				dropzone.on("sendingmultiple", function (data, xhr, formData) {
					for (var i = 0; i < dropzone.files.length; i++)
					{
						formData.append('FILE_' + i, dropzone.files[i]);
					}
					
					$form.find('input:not([type="submit"]), select, textarea').each(function () {
						formData.append($(this).attr('name'), $(this).val());
					});
					
					formData.append('files_counter', dropzone.files.length);
					formData.set(button.attr('name'), button.val());
				});

				dropzone.on("successmultiple", function(files, response, e) {
					var result = BX.parseJSON(response);
					
					if (!result.isSuccess)
					{
						$form.find('[data-error-message]')
							.removeClass('d-none')
							.html(result.error);

						KTApp.unblock($form.closest('.kt-portlet'));
					}
					else
					{
						BX.reload(e.target.responseURL);
					}
					
				});

				dropzone.processQueue();
			}
		});

		dropzone.on("addedfile", function() {
			$el.find('.dropzone-item').css('display', '');
		});

	});
}

$(document).ready(onReady);