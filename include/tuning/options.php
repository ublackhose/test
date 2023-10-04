<?php

use Bitrix\Main\Localization\Loc;

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
    die();


Loc::loadMessages(__FILE__);

return array(
    'TABS' => array(
        'TAB_MAIN' => array(
            'NAME' => Loc::getMessage('RS.TAB.TAB_MAIN'),
        )
    ),
    'PARAMETERS' => array(
        'COLOR_CONTROL' => array(
            'TAB' => 'TAB_MAIN',
            'TYPE' => 'TITLE',
            'NAME' => Loc::getMessage('RS.TITLE.COLOR_CONTROL'),
            'GRID_SIZE' => 12,
        ),
        'COLOR_1_1' => array(
            'TAB' => 'TAB_MAIN',
            'TYPE' => 'COLORPICKER',
            'NAME' => Loc::getMessage('RS.COLOR_1'),
            'CONTROL_ID' => 'color1',
            'CONTROL_NAME' => 'color1',
            'GRID_SIZE' => 12,
            'CSS_CLASS' => '',
            'ATTR' => '',
            'MULTIPLE' => 'Y',
            'VALUES' => array(
                'COLOR_1_1' => array(
                    'NAME' => Loc::getMessage('RS.COLOR_1_1'),
                    'CONTROL_ID' => 'color1',
                    'CONTROL_NAME' => 'color1',
                    'HTML_VALUE' => '5578eb',
                    'DEFAULT' => '5578eb',
                    'MACROS' => 'COLOR_1_1',
                ),
                'COLOR_1_2' => array(
                    'NAME' => Loc::getMessage('RS.COLOR_1_2'),
                    'CONTROL_ID' => 'color2',
                    'CONTROL_NAME' => 'color2',
                    'HTML_VALUE' => '242939',
                    'DEFAULT' => '242939',
                    'MACROS' => 'COLOR_1_2',
                ),
            ),

            'SETS' => array(
                'NAME' => Loc::getMessage('RS.GOPRO.SETS'),
                'VALUES' => array(
                    'SET_1' => array(
                        'NAME' => '',
                        'CONTROL_ID' => 'color_1',
                        'CONTROL_NAME' => '',
                        'BACKGROUND' => '#5578eb',
                        'VALUES' => array(
                            'COLOR_1_1' => '5578eb',
                            'COLOR_1_2' => '242939',
                        ),
                    ),
                    'SET_2' => array(
                        'NAME' => '',
                        'CONTROL_ID' => 'color_2',
                        'CONTROL_NAME' => '',
                        'BACKGROUND' => '#f44336',
                        'VALUES' => array(
                            'COLOR_1_1' => 'f44336',
                            'COLOR_1_2' => '222222',
                        ),
                    ),
                    'SET_3' => array(
                        'NAME' => '',
                        'CONTROL_ID' => 'color_3',
                        'CONTROL_NAME' => '',
                        'BACKGROUND' => '#e91e63',
                        'VALUES' => array(
                            'COLOR_1_1' => 'e91e63',
                            'COLOR_1_2' => '222222',
                        ),
                    ),
                    'SET_4' => array(
                        'NAME' => '',
                        'CONTROL_ID' => 'color_4',
                        'CONTROL_NAME' => '',
                        'BACKGROUND' => '#673ab7',
                        'VALUES' => array(
                            'COLOR_1_1' => '673ab7',
                            'COLOR_1_2' => '222222',
                        ),
                    ),
                    'SET_5' => array(
                        'NAME' => '',
                        'CONTROL_ID' => 'color_5',
                        'CONTROL_NAME' => '',
                        'BACKGROUND' => '#2196f3',
                        'VALUES' => array(
                            'COLOR_1_1' => '2196f3',
                            'COLOR_1_2' => '222222',
                        ),
                    ),
                    'SET_6' => array(
                        'NAME' => '',
                        'CONTROL_ID' => 'color_6',
                        'CONTROL_NAME' => '',
                        'BACKGROUND' => '#00bcd4',
                        'VALUES' => array(
                            'COLOR_1_1' => '00bcd4',
                            'COLOR_1_2' => '222222',
                        ),
                    ),
                    'SET_7' => array(
                        'NAME' => '',
                        'CONTROL_ID' => 'color_7',
                        'CONTROL_NAME' => '',
                        'BACKGROUND' => '#009688',
                        'VALUES' => array(
                            'COLOR_1_1' => '009688',
                            'COLOR_1_2' => '222222',
                        ),
                    ),
                    'SET_8' => array(
                        'NAME' => '',
                        'CONTROL_ID' => 'color_8',
                        'CONTROL_NAME' => '',
                        'BACKGROUND' => '#4caf50',
                        'VALUES' => array(
                            'COLOR_1_1' => '4caf50',
                            'COLOR_1_2' => '222222',
                        ),
                    ),
                    'SET_9' => array(
                        'NAME' => '',
                        'CONTROL_ID' => 'color_9',
                        'CONTROL_NAME' => '',
                        'BACKGROUND' => '#9e9d24',
                        'VALUES' => array(
                            'COLOR_1_1' => '9e9d24',
                            'COLOR_1_2' => '222222',
                        ),
                    ),
                    'SET_10' => array(
                        'NAME' => '',
                        'CONTROL_ID' => 'color_10',
                        'CONTROL_NAME' => '',
                        'BACKGROUND' => '#f57c00',
                        'VALUES' => array(
                            'COLOR_1_1' => 'f57c00',
                            'COLOR_1_2' => '222222',
                        ),
                    ),
                    'SET_11' => array(
                        'NAME' => '',
                        'CONTROL_ID' => 'color_11',
                        'CONTROL_NAME' => '',
                        'BACKGROUND' => '#795548',
                        'VALUES' => array(
                            'COLOR_1_1' => '795548',
                            'COLOR_1_2' => '222222',
                        ),
                    ),
                    'SET_12' => array(
                        'NAME' => '',
                        'CONTROL_ID' => 'color_12',
                        'CONTROL_NAME' => '',
                        'BACKGROUND' => '#3d3d3d',
                        'VALUES' => array(
                            'COLOR_1_1' => '3d3d3d',
                            'COLOR_1_2' => '222222',
                        ),
                    ),
                ),
            )
        ),


    ),
);
