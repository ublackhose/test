<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
	die();

return [
	'css' => 'dist/style.css',
	'js' => 'dist/script.js',
	'rel' => [
		'main.core',
		'ui.vue',
		'redsign.kompred.fonts.dejavu-sans',
	],
	'skip_core' => false,
];
