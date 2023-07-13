<?php

use Bitrix\Main\Engine\Response\Converter;
use Bitrix\Main\Localization\Loc;

/**
 * @var CMain $APPLICATION
 * @var CBitrixComponentTemplate $this
 * @var RedsignKompredOfferEdit $component
 * @var array $arParams
 * @var array $arResult
 */

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
	die();


\Bitrix\Main\Loader::includeModule('currency');

\Bitrix\Main\UI\Extension::load('currency');
\Bitrix\Main\UI\Extension::load('ui.fontawesome4');
\Bitrix\Main\UI\Extension::load('redsign.kompred.editor');

if (!empty($arResult['ERRORS']))
{
	if (isset($arResult['ERRORS'][$component::ERROR_NO_ACCESS]))
	{
		$APPLICATION->AuthForm($arResult['ERRORS'][$component::ERROR_NO_ACCESS], false, false, 'N', false);
	}
	else
	{
		echo '<div class="alert alert-danger">' .
			implode('<br>', $arResult['ERRORS']) .
		'</div>';
	}
}
else
{
	global $APPLICATION;
	$APPLICATION->SetTitle($arResult['OFFER']['NAME']);
	$APPLICATION->AddChainItem(
		$arResult['OFFER']['NAME'],
		$arResult['OFFER']['EDIT_URL']
	);

	$this->addExternalJS($templateFolder . '/dist/component.js');

	$randString = $this->randString();

	$blockIds = [
		'editor' => 'koe_editor_' . $randString,
		'nameInput' => 'koe_name_input_' . $randString,
		'linkInput' => 'koe_link_input_' . $randString,
		'copyToClipboardButton' => 'koe_copy_to_clipboard_button_' . $randString,
		'deleteButton' => 'koe_delete_button_' . $randString,
		'makeShortLinkButton' => 'koe_make_shortlink_button_' . $randString,
		'shortLinkToggle' => 'koe_shortlink_toggle_' . $randString
	];

	/** @var \Bitrix\Main\HttpRequest */
	$request = \Bitrix\Main\Application::getInstance()->getContext()->getRequest();
	$host = ($request->isHttps() ? 'https://' : 'http://') . $request->getHttpHost();
	$download = $host . $arResult['OFFER']['DOWNLOAD_URL'];
	$shortlink = $arResult['OFFER']['DOWNLOAD_URL_SHORT'] ? $host . $arResult['OFFER']['DOWNLOAD_URL_SHORT'] : '';

	$baseCurrency =	\Bitrix\Sale\Internals\SiteCurrencyTable::getSiteCurrency($arResult['OFFER']['SITE_ID']);
	$baseCurrencyFormat = \CCurrencyLang::GetFormatDescription($baseCurrency);

	$editorParams = [];
	$editorParams['offer'] = (Converter::toJson())->process($arResult['OFFER']);
	$editorParams['structure'] = $arResult['STRUCTURE'];
	$editorParams['config'] = [
		'defaultLogo' => $arParams['DEFAULT_LOGO']
	];
	?>

	<div class="row">
		<div class="col-12 col-xl-9 order-2 order-xl-1">
			<div class="kt-portlet">
				<div class="kt-portlet__body">
					<div class="py-5" id="<?=$blockIds['editor'];?>"></div>
				</div>
			</div>
		</div>
		<div class="col-12 col-xl-3 order-1 order-xl-2">
			<div class="kt-portlet kt-portlet--fit">
				<div class="kt-portlet__body">
					<ul class="kt-nav">

						<li class="kt-nav__section">
							<div class="mb-3">
								<label for="offer_name_<?=$randString?>"><?=Loc::getMessage('RS_KP_KOE_T_NAME') ?></label>
								<input type="text" class="form-control" id="<?=$blockIds['nameInput'];?>" value="<?=htmlspecialcharsbx($arResult['OFFER']['NAME'])?>" placeholder="RS_KP_KOE_T_NAME_PLACEHOLDER">
							</div>

							<div class="mb-3">
								<label for="offer_copy_<?=$randString?>"><?=Loc::getMessage('RS_KP_KOE_T_LINK') ?></label>
								<div class="input-group">
									<input type="text" class="form-control" id="<?=$blockIds['linkInput'];?>" readonly value="<?=!empty($shortlink) ? $shortlink : $download ?>">
									<div class="input-group-append">
										<?php /**if (!$arResult['OFFER']['DOWNLOAD_URL_SHORT']): ?>
										<button id="<?=$blockIds['makeShortLinkButton'];?>" class="btn btn-default btn-icon" type="button">
											<i class="la la-link"></i>
										</button>
										<?php endif; **/?>
										<button id="<?=$blockIds['shortLinkToggle'];?>" class="btn btn-default btn-icon" type="button">
											<i class="la la-link"></i>
										</button>
										<button id="<?=$blockIds['copyToClipboardButton'];?>" class="btn btn-default btn-icon" type="button">
											<i class="la la-copy"></i>
										</button>
									</div>
								</div>
							</div>
						</li>

						<li class="kt-nav__separator"></li>

						<li class="kt-nav__item">
							<a href="<?=$arResult['OFFER']['DOWNLOAD_URL']?>" class="kt-nav__link" target="_blank">
								<i class="kt-nav__link-icon flaticon-download-1"></i>
								<span class="kt-nav__link-text"><?=Loc::getMessage('RS_KP_KOE_T_DOWNLOAD') ?></span>
							</a>
						</li>

						<li class="kt-nav__item">
							<a href="<?=$arResult['OFFER']['DELETE_URL']?>" id="<?=$blockIds['deleteButton']?>" class="kt-nav__link">
								<i class="kt-nav__link-icon flaticon2-rubbish-bin-delete-button"></i>
								<span class="kt-nav__link-text"><?=Loc::getMessage('RS_KP_KOE_T_DELETE') ?></span>
							</a>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>

	<script>
		(function() {
			BX.message(<?=CUtil::PhpToJSObject(Loc::loadLanguageFile(__FILE__))?>);

			BX.Currency.setCurrencyFormat(
				'<?=$baseCurrency?>',
				<?=\CUtil::PhpToJSObject($baseCurrencyFormat)?>
			);

			new B2BPortal.Components.KPEdit({
				signedParameters: '<?=$this->getComponent()->getSignedParameters()?>',
				editor: new RSKomPred.Editor(
					document.getElementById('<?=$blockIds['editor']?>'),
					<?=\CUtil::PhpToJSObject($editorParams, false, false, true)?>
				),
				nameInput: document.getElementById('<?=$blockIds['nameInput']?>'),
				linkInput: document.getElementById('<?=$blockIds['linkInput']?>'),
				copyToClipboardButton: document.getElementById('<?=$blockIds['copyToClipboardButton']?>'),
				deleteButton: document.getElementById('<?=$blockIds['deleteButton']?>'),
				makeShortLinkButton: document.getElementById('<?=$blockIds['makeShortLinkButton']?>'),
				shortLinkToggle: document.getElementById('<?=$blockIds['shortLinkToggle']?>'),

				download: '<?=\CUtil::JSEscape($download)?>',
				shortlink: '<?=\CUtil::JSEscape($shortlink)?>'
			});
		}());
	</script>
	<?php
}