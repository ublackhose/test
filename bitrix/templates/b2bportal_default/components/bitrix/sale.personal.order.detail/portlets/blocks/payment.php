<?php

use Bitrix\Main\Localization\Loc;

/**
 * @var CBitrixPersonalOrderDetailComponent $component
 * @var array $arParams
 * @var array $arResult
 * @var string $templateFolder
 * @var \Closure $renderBlock
 */

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
	die();




$template = $component->getTemplate();

$template->addExternalJs($templateFolder . '/js/payment.js');
$template->addExternalJs(SITE_TEMPLATE_PATH . '/components/bitrix/sale.order.payment.change/' . $component->GetTemplateName() . '/js/component.js');

$isCollapsed = in_array('payment', $arResult['COLLAPSED_BLOCKS']);
$renderBlock(
	'payment',
	Loc::getMessage('SPOD_ORDER_PAYMENT'),
	$isCollapsed,
	function () use (&$arResult, &$arParams, $component) {
		$template = $component->getTemplate();
		$paymentsCount = count($arResult['PAYMENT']);
		$index = 0;

		foreach ($arResult['PAYMENT'] as $payment)
		{
			$elementId = 'sale_order_detail_payment_' . $template->randString(3) . '_' . $payment['ID'];

			$paymentData = [
				'id' => $payment['ID'],
				'payment' => $payment['ACCOUNT_NUMBER'],
				'order' => $arResult['ACCOUNT_NUMBER'],
				'allow_inner' => $arParams['ALLOW_INNER'],
				'only_inner_full' => $arParams['ONLY_INNER_FULL'],
				'refresh_prices' => $arParams['REFRESH_PRICES'],
				'path_to_payment' => $arParams['PATH_TO_PAYMENT']
			];
			?>
			<div class="<?=($index < $paymentsCount - 1 ? ' mb-5' : '')?>" id="<?=$elementId?>">
				<div class="row">
					<div class="col-12 col-md-8">
						<h6>
							<?php
							$paymentSubTitle = Loc::getMessage('SPOD_TPL_BILL') . ' ' . Loc::getMessage('SPOD_NUM_SIGN') . $payment['ACCOUNT_NUMBER'];
							if(isset($payment['DATE_BILL']))
							{
								$paymentSubTitle .= ' ' . Loc::getMessage('SPOD_FROM') . ' ' . $payment['DATE_BILL']->format($arParams['ACTIVE_DATE_FORMAT']);
							}

							$paymentSubTitle .= ', ';

							echo htmlspecialcharsbx($paymentSubTitle);
							echo $payment['PAY_SYSTEM_NAME'];
							?>
						</h6>
					</div>
					<div class="col-md-4 text-right">
						<?php
						if ($payment['PAID'] === 'Y')
						{
							echo '<span class="kt-badge kt-badge--inline kt-badge--pill kt-badge--success">' . Loc::getMessage('SPOD_PAYMENT_PAID') . '</span>';
						}
						elseif ($arResult['IS_ALLOW_PAY'] == 'N')
						{
							echo '<span class="kt-badge kt-badge--inline kt-badge--pill kt-badge--warning">' . Loc::getMessage('SPOD_TPL_RESTRICTED_PAID') . '</span>';
						}
						else
						{
							echo '<span class="kt-badge kt-badge--inline kt-badge--pill kt-badge--danger">' . Loc::getMessage('SPOD_PAYMENT_UNPAID') . '</span>';
						}
						?>
					</div>
				</div>
				<div class="row">
					<div class="col-12">
						<div class="d-block"><?=Loc::getMessage('SPOD_ORDER_PRICE_BILL')?>: <?=$payment['PRICE_FORMATED']?></div>
						<?php
						if (!empty($payment['CHECK_DATA']))
						{
							$listCheckLinks = '';
							foreach ($payment['CHECK_DATA'] as $checkInfo)
							{
								$title = Loc::getMessage('SPOD_CHECK_NUM', array('#CHECK_NUMBER#' => $checkInfo['ID'])) . ' - ' . htmlspecialcharsbx($checkInfo['TYPE_NAME']);
								if (strlen($checkInfo['LINK']) > 0)
								{
									$link = $checkInfo['LINK'];
									$listCheckLinks .= "<div><a href='$link' target='_blank'>$title</a></div>";
								}
							}
							if (strlen($listCheckLinks) > 0)
							{
								?>
								<div class="d-block"><?=Loc::getMessage('SPOD_CHECK_TITLE')?>: <?=$listCheckLinks?></div>
								<?php
							}
						}

						if ($arResult['IS_ALLOW_PAY'] === 'N' && $payment['PAID'] !== 'Y')
						{
							?>
							<div class="d-block"><?=Loc::getMessage('SOPD_TPL_RESTRICTED_PAID_MESSAGE')?></div>
							<?php
						}

						?>
						<div class="d-block mt-4">
							<?php

//                            echo "<pre style='background: #333333; color:#ffffff;border-radius: 5px; padding: 10px;'>";
//                            print_r($arResult);
//                            echo "</pre>";
							if (
								$payment['PAY_SYSTEM']['IS_CASH'] !== 'Y'
								&& $payment['PAY_SYSTEM']['ACTION_FILE'] !== 'cash'
							) {
								if (
									$payment['PAY_SYSTEM']['PSA_NEW_WINDOW'] === 'Y'
									&& $arResult['IS_ALLOW_PAY'] !== 'N'
								) {
									?>
									<a class="btn btn-primary btn-sm" target="_blank" href="<?=htmlspecialcharsbx($payment['PAY_SYSTEM']['PSA_ACTION_FILE'])?>"><?= Loc::getMessage('SPOD_ORDER_PAY') ?></a>
									<?php
								}
								else
								{
									if (
										$payment['PAID'] === 'Y'
										|| $arResult['CANCELED'] === 'Y'
										|| $arResult['IS_ALLOW_PAY'] === 'N'
									) {
										?>
<!--										<button class="btn btn-primary btn-sm disabled">--><?//= Loc::getMessage('SPOD_ORDER_PAY') ?><!--</button>-->
										<?php
									}
									else
									{
										?>
										<button class="btn btn-primary btn-sm active-button" data-toggle="collapse" data-target="#payment_block_<?=$payment['ID']?>"><?= Loc::getMessage('SPOD_ORDER_PAY') ?></button>
										<?php
									}
								}
							}
							?>
							<?php
//                            echo "<pre style='background: #333333; color:#ffffff;border-radius: 5px; padding: 10px;'>";
//                            print_r($payment);
//                            echo "</pre>";
							if (
								$payment['PAID'] !== 'Y'
//								&& $arResult['CANCELED'] !== 'Y'
//								&& $arParams['GUEST_MODE'] !== 'Y'
//								&& $arResult['LOCK_CHANGE_PAYSYSTEM'] !== 'Y'
							) {
								?>
								<a href="#" class="btn btn-outline-primary btn-sm" data-toggle="dropdown" id="<?=$payment['ACCOUNT_NUMBER']?>" data-entity="change-payment"><?=Loc::getMessage('SPOD_CHANGE_PAYMENT_TYPE')?></a>
								<div class="dropdown-menu" x-placement="bottom-start" data-entity="payment-list">
									<div class="d-flex justify-content-center" class="my-3">
										<div class="spinner-grow text-primary" role="status">
											<span class="sr-only">Loading...</span>
										</div>
									</div>
								</div>
								<?php
							}
							?>
						</div>
						<?php
						if (
							$payment['PAID'] !== 'Y'
							&& $payment['PAY_SYSTEM']['IS_CASH'] !== 'Y'
							&& $payment['PAY_SYSTEM']['ACTION_FILE'] !== 'cash'
							&& $payment['PAY_SYSTEM']['PSA_NEW_WINDOW'] !== 'Y'
							&& $arResult['CANCELED'] !== 'Y'
							&& $arResult['IS_ALLOW_PAY'] !== 'N'
						) {
							?>
							<div class="collapse mt-4" id="payment_block_<?=$payment['ID']?>">
								<?php if (empty($payment['ERROR']) && !empty($payment['BUFFERED_OUTPUT'])): ?>
									<div class="card card-body">
										<?=$payment['BUFFERED_OUTPUT']?>
									</div>
								<?php else: ?>
									<div class="alert alert-danger mb-0" role="alert">
										<?=$payment['ERROR']?>
									</div>
								<?php endif; ?>
							</div>
							<?
						}
						?>
					</div>
				</div>
			</div>
			<script>
			(function() {
				new B2BPortal.SaleOrderDetail.Payment(document.getElementById('<?=$elementId?>'), {
					ajaxPath: '<?=CUtil::JSEscape($component->GetPath() . '/ajax.php')?>',
					templateName: '<?=$component->GetTemplateName()?>',
					paymentData: <?=CUtil::PhpToJSObject($paymentData);?>
				});
			}());
			</script>
			<?php
			$index++;
		}
	}
);







