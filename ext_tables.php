<?php
defined('TYPO3_MODE') || die('Access denied.');

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	'accuweather',
	'Pi1',
	'AccuWeather'
);


//$pluginSignature = 'weathershow_pi1';
$pluginSignature = 'accuweather_pi1';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist'][$pluginSignature] = 'layout,recursive,select_key';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($pluginSignature, 'FILE:EXT:accuweather/Configuration/FlexForms/flexform_accuweather_show.xml');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile('accuweather', 'Configuration/TypoScript', 'AccuWeather');
