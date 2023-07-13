<?php

use Bitrix\Main\Localization\Loc;

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
	die();


$arResult['TYPES'] = [
	'xslx',
	'csv',
	'catalog',
];

if (count($arResult['TYPES']) > 0):
	?>
	<div class="dropdown dropdown-inline">
		<a class="btn btn-default dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-expanded="false">
			�������� ������ ��
		</a>
		<div class="dropdown-menu" x-placement="bottom-end">
			<ul class="kt-nav">
				<?php foreach ($arResult['TYPES'] as $sType) :?>
				<li class="kt-nav__item">
					<a href="#" class="kt-nav__link" data-toggle="modal" data-target="#modalImport_<?=$sType?>">
						<i class="kt-nav__link-icon la la-file-excel-o"></i>
						<span class="kt-nav__link-text"><?=Loc::getMessage('RS_B2BPORTAL_BASKET_IMPORTS_TYPE_' . ToUpper($sType))?></span>
					</a>
				</li>
				<?php endforeach; ?>
			</ul>
		</div>
	</div>
	<?php
	foreach ($arResult['TYPES'] as $sType)
	{
		?>
		<div class="modal fade" id="modalImport_<?=$sType?>">
		<?php
		switch($sType)
		{
			case 'catalog':
				?>
				<div class="modal-dialog modal-dialog-centered">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title">������ �� �����</h5>
						</div>
						<div class="modal-body">
							<textarea id="test_input" class="form-control" style="width:100%;height:200px;" placeholder="<?=Loc::getMessage('RS_B2BPORTAL_BASKET_IMPORT_CATALOG_PLACEHOLDER')?>"></textarea>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-outline-brand" data-dismiss="modal">������</button>
							<button type="button" class="btn btn-primary" id="test_btn">������</button>
						</div>
					</div>
				</div>

				<script>
					new CatalogImport(
						document.getElementById('test_input'),
						document.getElementById('test_btn'),
					);
				</script>
				<?php

				break;
			default:
				break;
		}
		?>
		</div>
		<?php
	}
endif;
