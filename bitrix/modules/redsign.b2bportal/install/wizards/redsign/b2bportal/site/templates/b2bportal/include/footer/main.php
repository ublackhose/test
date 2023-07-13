<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
	die();

?>

<?php
$offPortlet = $APPLICATION->GetProperty('off_portlet');

if (empty($offPortlet)):
	?>
</div><!-- end:: /.kt-portlet__body -->
</div><!-- end:: /.kt-portlet -->
<?php endif; ?>
							 </div>
						</div>
						<!-- end:: Content -->
					</div>

					<!-- begin:: Footer -->
					<div class="kt-footer kt-grid__item kt-grid kt-grid--desktop kt-grid--ver-desktop">
						<div class="kt-container kt-container--fluid kt-grid__item kt-grid__item--fluid">

							<div class="kt-footer__copyright">
								<?php include 'copyright.php'; ?>
							</div>

							<div class="kt-footer__menu">
								<?$APPLICATION->IncludeComponent(
									"bitrix:main.include",
									"",
									array(
										"AREA_FILE_SHOW" => "file",
										"PATH" => SITE_DIR . "include/menu.footer.php",
										"EDIT_TEMPLATE" => ""
									),
									false
								);?>
							</div>
						</div>
					</div>
					<!-- end:: Footer -->

				</div>
			</div>
		</div>
		<!-- end:: Page -->

		<!-- begin:: Scrolltop -->
		<div id="kt_scrolltop" class="kt-scrolltop"> <i class="la la-arrow-up"></i> </div>
		<!-- end:: Scrolltop -->
