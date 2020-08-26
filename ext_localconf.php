<?php

if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}

call_user_func(
    function()
    {

    	\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            'AshokaTree.Accuweather',
            'Pi1',
            [
                'Weathershow' => 'current, hourly, daily'
            ],
            // non-cacheable actions
            [
                
            ]
        );
        
        // wizards
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
            'mod {
                wizards.newContentElement.wizardItems.plugins {
                    elements {
                        accuweather {
                            iconIdentifier = accuweather-plugin-pi1
                            title = LLL:EXT:accuweather/Resources/Private/Language/locallang.xlf:tx_accuweather_pi1.name
                            description = LLL:EXT:accuweather/Resources/Private/Language/locallang.xlf:tx_accuweather_pi1.description
                            tt_content_defValues {
                                CType = list
                                list_type = accuweather_pi1
                            }
                        }
                    }
                    show = *
                }
           }'
        );
        $iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Imaging\IconRegistry::class);
        
        $iconRegistry->registerIcon(
            'accuweather-plugin-pi1',
            \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
            ['source' => 'EXT:accuweather/Resources/Public/Icons/user_plugin_pi1.svg']
        );
        
		$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['scheduler']['tasks']['AshokaTree\\Accuweather\\Task\\AccuweatherCurrentTask'] = [
		    'extension' => 'AccuWeather',
		    'title' => 'LLL:EXT:accuweather/Resources/Private/Language/locallang.xlf:current_title',
		    'description' => 'LLL:EXT:accuweather/Resources/Private/Language/locallang.xlf:current_description',
		    'additionalFields' => 'AshokaTree\\Accuweather\\Task\\AccuweatherAdditionalFieldProvider',
		];        
        $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['scheduler']['tasks']['AshokaTree\\Accuweather\\Task\\AccuweatherHourlyTask'] = [
            'extension' => 'AccuWeather',
            'title' => 'LLL:EXT:accuweather/Resources/Private/Language/locallang.xlf:hourly_title',
            'description' => 'LLL:EXT:accuweather/Resources/Private/Language/locallang.xlf:hourly_description',
            'additionalFields' => 'AshokaTree\\Accuweather\\Task\\AccuweatherAdditionalFieldProvider',
        ];
        $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['scheduler']['tasks']['AshokaTree\\Accuweather\\Task\\AccuweatherDailyTask'] = [
            'extension' => 'AccuWeather',
            'title' => 'LLL:EXT:accuweather/Resources/Private/Language/locallang.xlf:daily_title',
            'description' => 'LLL:EXT:accuweather/Resources/Private/Language/locallang.xlf:daily_description',
            'additionalFields' => 'AshokaTree\\Accuweather\\Task\\AccuweatherAdditionalFieldProvider',
        ];

	}
);
