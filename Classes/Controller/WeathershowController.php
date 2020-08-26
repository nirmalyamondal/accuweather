<?php
namespace AshokaTree\Accuweather\Controller;

/**
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

/**
 * Controller of Weathershow records
 *
 */
class WeathershowController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

    /**
     * @var \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface
     */
    protected $configurationManager;

    /**
     * Initializes the current action
     *
     * @return void
     */
    public function initializeAction()
    {
		 parent::initializeAction();
    }

    /**
     * Display the Current weather data
     *
     * @param 
     * @param
     * @return void
     */
    public function currentAction() 
	{
		$filepath	= \TYPO3\CMS\Core\Utility\GeneralUtility::getFileAbsFileName($this->settings['filepath']);
		if (!@is_file($filepath)) {	echo 'The file is not available in this path "'.$filepath.'"';	}
		$file_content_raw	= @file_get_contents($filepath);
		$file_content 		= (array) json_decode($file_content_raw);	
		//echo '<pre>'; print_r($file_content);

		$current['lodt'] 				= (string) $file_content[0]->LocalObservationDateTime;
		$current['epoch']				= (string) $file_content[0]->EpochTime;
		$current['weather']				= (string) $file_content[0]->WeatherText;
		$current['icon'] 				= (string) $file_content[0]->WeatherIcon;
		$current['precipitation'] 		= (string) $file_content[0]->HasPrecipitation;
		$current['ptype'] 				= (string) $file_content[0]->PrecipitationType;
		$current['isdaytime']			= (string) $file_content[0]->IsDayTime;

		$current['temperaturec'] 		= (string) $file_content[0]->Temperature->Metric->Value;
		$current['temperaturef'] 		= (string) $file_content[0]->Temperature->Imperial->Value;

		$current['rftemperaturec']		= (string) $file_content[0]->RealFeelTemperature->Metric->Value;
		$current['rftemperaturef']		= (string) $file_content[0]->RealFeelTemperature->Imperial->Value;

		$current['rftemperaturesc']		= (string) $file_content[0]->RealFeelTemperatureShade->Metric->Value;
		$current['rftemperaturesf']		= (string) $file_content[0]->RealFeelTemperatureShade->Imperial->Value;

		$current['rhumidity']			= (string) $file_content[0]->RelativeHumidity;
		$current['irhumidity'] 			= (string) $file_content[0]->IndoorRelativeHumidity;	

		$current['dewpointm']			= (string) $file_content[0]->DewPoint->Metric->Value;
		$current['dewpointi']			= (string) $file_content[0]->DewPoint->Imperial->Value;

		$current['winddd']				= (string) $file_content[0]->Wind->Direction->Degrees;
		$current['windde']				= (string) $file_content[0]->Wind->Direction->English;
		$current['windsmv']				= (string) $file_content[0]->Wind->Speed->Metric->Value;
		$current['windsmu']				= (string) $file_content[0]->Wind->Speed->Metric->Unit;
		$current['windsiv']				= (string) $file_content[0]->Wind->Speed->Imperial->Value;
		$current['windsiu']				= (string) $file_content[0]->Wind->Speed->Imperial->Unit;

		$current['windgustsmv']			= (string) $file_content[0]->WindGust->Speed->Metric->Value;
		$current['windgustsmu']			= (string) $file_content[0]->WindGust->Speed->Metric->Unit;
		$current['windgustsiv']			= (string) $file_content[0]->WindGust->Speed->Imperial->Value;
		$current['windgustsiu']			= (string) $file_content[0]->WindGust->Speed->Imperial->Unit;

		$current['uvindex']				= (string) $file_content[0]->UVIndex;
		$current['uvindextext']			= (string) $file_content[0]->UVIndexText;

		$current['visibilitymv']		= (string) $file_content[0]->Visibility->Metric->Value;
		$current['visibilitymu']		= (string) $file_content[0]->Visibility->Metric->Unit;
		$current['visibilityiv']		= (string) $file_content[0]->Visibility->Imperial->Value;
		$current['visibilityiu']		= (string) $file_content[0]->Visibility->Imperial->Unit;

		$current['otvisibility']		= (string) $file_content[0]->ObstructionsToVisibility;
		$current['cloudcover']			= (string) $file_content[0]->CloudCover;

		$current['ceilingmv']			= (string) $file_content[0]->Ceiling->Metric->Value;
		$current['ceilingmu']			= (string) $file_content[0]->Ceiling->Metric->Unit;
		$current['ceilingiv']			= (string) $file_content[0]->Ceiling->Imperial->Value;
		$current['ceilingiu']			= (string) $file_content[0]->Ceiling->Imperial->Unit;

		$current['pressuremv']			= (string) $file_content[0]->Pressure->Metric->Value;
		$current['pressuremu']			= (string) $file_content[0]->Pressure->Metric->Unit;
		$current['pressureiv']			= (string) $file_content[0]->Pressure->Imperial->Value;
		$current['pressureiu']			= (string) $file_content[0]->Pressure->Imperial->Unit;

		$current['pressuretl']			= (string) $file_content[0]->PressureTendency->LocalizedText;
		$current['pressuretc']			= (string) $file_content[0]->PressureTendency->Code;

		$current['p24htdmv']			= (string) $file_content[0]->Past24HourTemperatureDeparture->Metric->Value;
		$current['p24htdmu']			= (string) $file_content[0]->Past24HourTemperatureDeparture->Metric->Unit;
		$current['p24htdiv']			= (string) $file_content[0]->Past24HourTemperatureDeparture->Imperial->Value;
		$current['p24htdiu']			= (string) $file_content[0]->Past24HourTemperatureDeparture->Imperial->Unit;

		$current['apparenttmv']			= (string) $file_content[0]->ApparentTemperature->Metric->Value;
		$current['apparenttmu']			= (string) $file_content[0]->ApparentTemperature->Metric->Unit;
		$current['apparenttiv']			= (string) $file_content[0]->ApparentTemperature->Imperial->Value;
		$current['apparenttiu']			= (string) $file_content[0]->ApparentTemperature->Imperial->Unit;

		$current['windchilltmv']		= (string) $file_content[0]->WindChillTemperature->Metric->Value;
		$current['windchilltmu']		= (string) $file_content[0]->WindChillTemperature->Metric->Unit;
		$current['windchilltiv']		= (string) $file_content[0]->WindChillTemperature->Imperial->Value;
		$current['windchilltiu']		= (string) $file_content[0]->WindChillTemperature->Imperial->Unit;

		$current['wetbulbtmv']			= (string) $file_content[0]->WetBulbTemperature->Metric->Value;
		$current['wetbulbtmu']			= (string) $file_content[0]->WetBulbTemperature->Metric->Unit;
		$current['wetbulbtiv']			= (string) $file_content[0]->WetBulbTemperature->Imperial->Value;
		$current['wetbulbtiu']			= (string) $file_content[0]->WetBulbTemperature->Imperial->Unit;

		$current['precip1hrmv']			= (string) $file_content[0]->Precip1hr->Metric->Value;
		$current['precip1hrmu']			= (string) $file_content[0]->Precip1hr->Metric->Unit;
		$current['precip1hriv']			= (string) $file_content[0]->Precip1hr->Imperial->Value;
		$current['precip1hriu']			= (string) $file_content[0]->Precip1hr->Imperial->Unit;

		$current['psummarypmv']			= (string) $file_content[0]->PrecipitationSummary->Precipitation->Metric->Value;
		$current['psummarypmu']			= (string) $file_content[0]->PrecipitationSummary->Precipitation->Metric->Unit;
		$current['psummarypiv']			= (string) $file_content[0]->PrecipitationSummary->Precipitation->Imperial->Value;
		$current['psummarypiu']			= (string) $file_content[0]->PrecipitationSummary->Precipitation->Imperial->Unit;

		$current['psummaryphmv']		= (string) $file_content[0]->PrecipitationSummary->PastHour->Metric->Value;
		$current['psummaryphmu']		= (string) $file_content[0]->PrecipitationSummary->PastHour->Metric->Unit;
		$current['psummaryphiv']		= (string) $file_content[0]->PrecipitationSummary->PastHour->Imperial->Value;
		$current['psummaryphiu']		= (string) $file_content[0]->PrecipitationSummary->PastHour->Imperial->Unit;

		$current['psummaryp3hmv']		= (string) $file_content[0]->PrecipitationSummary->Past3Hours->Metric->Value;
		$current['psummaryp3hmu']		= (string) $file_content[0]->PrecipitationSummary->Past3Hours->Metric->Unit;
		$current['psummaryp3hiv']		= (string) $file_content[0]->PrecipitationSummary->Past3Hours->Imperial->Value;
		$current['psummaryp3hiu']		= (string) $file_content[0]->PrecipitationSummary->Past3Hours->Imperial->Unit;

		$current['psummaryp6hmv']		= (string) $file_content[0]->PrecipitationSummary->Past6Hours->Metric->Value;
		$current['psummaryp6hmu']		= (string) $file_content[0]->PrecipitationSummary->Past6Hours->Metric->Unit;
		$current['psummaryp6hiv']		= (string) $file_content[0]->PrecipitationSummary->Past6Hours->Imperial->Value;
		$current['psummaryp6hiu']		= (string) $file_content[0]->PrecipitationSummary->Past6Hours->Imperial->Unit;

		$current['psummaryp9hmv']		= (string) $file_content[0]->PrecipitationSummary->Past9Hours->Metric->Value;
		$current['psummaryp9hmu']		= (string) $file_content[0]->PrecipitationSummary->Past9Hours->Metric->Unit;
		$current['psummaryp9hiv']		= (string) $file_content[0]->PrecipitationSummary->Past9Hours->Imperial->Value;
		$current['psummaryp9hiu']		= (string) $file_content[0]->PrecipitationSummary->Past9Hours->Imperial->Unit;

		$current['psummaryp12hmv']		= (string) $file_content[0]->PrecipitationSummary->Past12Hours->Metric->Value;
		$current['psummaryp12hmu']		= (string) $file_content[0]->PrecipitationSummary->Past12Hours->Metric->Unit;
		$current['psummaryp12hiv']		= (string) $file_content[0]->PrecipitationSummary->Past12Hours->Imperial->Value;
		$current['psummaryp12hiu']		= (string) $file_content[0]->PrecipitationSummary->Past12Hours->Imperial->Unit;

		$current['psummaryp18hmv']		= (string) $file_content[0]->PrecipitationSummary->Past18Hours->Metric->Value;
		$current['psummaryp18hmu']		= (string) $file_content[0]->PrecipitationSummary->Past18Hours->Metric->Unit;
		$current['psummaryp18hiv']		= (string) $file_content[0]->PrecipitationSummary->Past18Hours->Imperial->Value;
		$current['psummaryp18hiu']		= (string) $file_content[0]->PrecipitationSummary->Past18Hours->Imperial->Unit;

		$current['psummaryp24hmv']		= (string) $file_content[0]->PrecipitationSummary->Past24Hours->Metric->Value;
		$current['psummaryp24hmu']		= (string) $file_content[0]->PrecipitationSummary->Past24Hours->Metric->Unit;
		$current['psummaryp24hiv']		= (string) $file_content[0]->PrecipitationSummary->Past24Hours->Imperial->Value;
		$current['psummaryp24hiu']		= (string) $file_content[0]->PrecipitationSummary->Past24Hours->Imperial->Unit;

		$current['tsummaryp6hmimv']		= (string) $file_content[0]->TemperatureSummary->Past6HourRange->Minimum->Metric->Value;
		$current['tsummaryp6hmimu']		= (string) $file_content[0]->TemperatureSummary->Past6HourRange->Minimum->Metric->Unit;
		$current['tsummaryp6hmiiv']		= (string) $file_content[0]->TemperatureSummary->Past6HourRange->Minimum->Imperial->Value;
		$current['tsummaryp6hmiiu']		= (string) $file_content[0]->TemperatureSummary->Past6HourRange->Minimum->Imperial->Unit;
		$current['tsummaryp6hmxmv']		= (string) $file_content[0]->TemperatureSummary->Past6HourRange->Maximum->Metric->Value;
		$current['tsummaryp6hmxmu']		= (string) $file_content[0]->TemperatureSummary->Past6HourRange->Maximum->Metric->Unit;
		$current['tsummaryp6hmxiv']		= (string) $file_content[0]->TemperatureSummary->Past6HourRange->Maximum->Imperial->Value;
		$current['tsummaryp6hmxiu']		= (string) $file_content[0]->TemperatureSummary->Past6HourRange->Maximum->Imperial->Unit;

		$current['tsummaryp12hmimv']	= (string) $file_content[0]->TemperatureSummary->Past12HourRange->Minimum->Metric->Value;
		$current['tsummaryp12hmimu']	= (string) $file_content[0]->TemperatureSummary->Past12HourRange->Minimum->Metric->Unit;
		$current['tsummaryp12hmiiv']	= (string) $file_content[0]->TemperatureSummary->Past12HourRange->Minimum->Imperial->Value;
		$current['tsummaryp12hmiiu']	= (string) $file_content[0]->TemperatureSummary->Past12HourRange->Minimum->Imperial->Unit;
		$current['tsummaryp12hmxmv']	= (string) $file_content[0]->TemperatureSummary->Past12HourRange->Maximum->Metric->Value;
		$current['tsummaryp12hmxmu']	= (string) $file_content[0]->TemperatureSummary->Past12HourRange->Maximum->Metric->Unit;
		$current['tsummaryp12hmxiv']	= (string) $file_content[0]->TemperatureSummary->Past12HourRange->Maximum->Imperial->Value;
		$current['tsummaryp12hmxiu']	= (string) $file_content[0]->TemperatureSummary->Past12HourRange->Maximum->Imperial->Unit;

		$current['tsummaryp24hmimv']	= (string) $file_content[0]->TemperatureSummary->Past24HourRange->Minimum->Metric->Value;
		$current['tsummaryp24hmimu']	= (string) $file_content[0]->TemperatureSummary->Past24HourRange->Minimum->Metric->Unit;
		$current['tsummaryp24hmiiv']	= (string) $file_content[0]->TemperatureSummary->Past24HourRange->Minimum->Imperial->Value;
		$current['tsummaryp24hmiiu']	= (string) $file_content[0]->TemperatureSummary->Past24HourRange->Minimum->Imperial->Unit;
		$current['tsummaryp24hmxmv']	= (string) $file_content[0]->TemperatureSummary->Past24HourRange->Maximum->Metric->Value;
		$current['tsummaryp24hmxmu']	= (string) $file_content[0]->TemperatureSummary->Past24HourRange->Maximum->Metric->Unit;
		$current['tsummaryp24hmxiv']	= (string) $file_content[0]->TemperatureSummary->Past24HourRange->Maximum->Imperial->Value;
		$current['tsummaryp24hmxiu']	= (string) $file_content[0]->TemperatureSummary->Past24HourRange->Maximum->Imperial->Unit;

		$current['mobilelink']			= (string) $file_content[0]->MobileLink;
		$current['link']				= (string) $file_content[0]->Link;
		//print_r($current); die();

		$this->view->assign('current', $current);			
    }

    /**
     * Display the Hourly forecast data
     *
     * @param 
     * @param
     * @return void
     */
    public function hourlyAction() 
	{
		$filepath	= \TYPO3\CMS\Core\Utility\GeneralUtility::getFileAbsFileName($this->settings['filepath']);
		if (!@is_file($filepath)) {	echo 'The file is not available in this path "'.$filepath.'"';	}
		$file_content_raw	= @file_get_contents($filepath);
		$file_content 		= (array) json_decode($file_content_raw);	//echo '<pre>'; print_r($file_content); die();

		$hourlyDataAll = [];
		foreach($file_content as $key => $value) {
			$hourlyDataAll[$key]['dt'] 				= (string) $value->DateTime;		
			$hourlyDataAll[$key]['edt'] 			= (string) $value->EpochDateTime;		
			$hourlyDataAll[$key]['icon'] 			= (string) $value->WeatherIcon;		
			$hourlyDataAll[$key]['weather'] 		= (string) $value->IconPhrase;	
			$hourlyDataAll[$key]['precipitation'] 	= (string) $value->HasPrecipitation;	
			$hourlyDataAll[$key]['isdaylight'] 		= (string) $value->IsDaylight;	

			$hourlyDataAll[$key]['temperaturev']	= (string) $value->Temperature->Value;	
			$hourlyDataAll[$key]['temperatureu'] 	= (string) $value->Temperature->Unit;	
			$hourlyDataAll[$key]['rftemperaturev'] 	= (string) $value->RealFeelTemperature->Value;
			$hourlyDataAll[$key]['rftemperatureu'] 	= (string) $value->RealFeelTemperature->Unit;		
			$hourlyDataAll[$key]['wbtemperaturev']	= (string) $value->WetBulbTemperature->Value;
			$hourlyDataAll[$key]['wbtemperatureu'] 	= (string) $value->WetBulbTemperature->Unit;

			$hourlyDataAll[$key]['dewpointv'] 		= (string) $value->DewPoint->Value;
			$hourlyDataAll[$key]['dewpointu'] 		= (string) $value->DewPoint->Unit;	

			$hourlyDataAll[$key]['windsv'] 			= (string) $value->Wind->Speed->Value;
			$hourlyDataAll[$key]['windsu'] 			= (string) $value->Wind->Speed->Unit;
			$hourlyDataAll[$key]['winddd'] 			= (string) $value->Wind->Direction->Degrees;
			$hourlyDataAll[$key]['winddue'] 		= (string) $value->Wind->Direction->English;
			$hourlyDataAll[$key]['windgsv'] 		= (string) $value->WindGust->Speed->Value;
			$hourlyDataAll[$key]['windgsd'] 		= (string) $value->WindGust->Speed->Unit;

			$hourlyDataAll[$key]['rhumidity'] 		= (string) $value->RelativeHumidity;
			$hourlyDataAll[$key]['irhumidity'] 		= (string) $value->IndoorRelativeHumidity;
			$hourlyDataAll[$key]['visibilityv'] 	= (string) $value->Visibility->Value;
			$hourlyDataAll[$key]['visibilityu'] 	= (string) $value->Visibility->Unit;
			$hourlyDataAll[$key]['ceilingv'] 		= (string) $value->Ceiling->Value;
			$hourlyDataAll[$key]['ceilingu'] 		= (string) $value->Ceiling->Unit;

			$hourlyDataAll[$key]['uvindex'] 		= (string) $value->UVIndex;
			$hourlyDataAll[$key]['uvitext'] 		= (string) $value->UVIndexText;
			$hourlyDataAll[$key]['pprobability'] 	= (string) $value->PrecipitationProbability;
			$hourlyDataAll[$key]['rprobability'] 	= (string) $value->RainProbability;
			$hourlyDataAll[$key]['sprobability'] 	= (string) $value->SnowProbability;
			$hourlyDataAll[$key]['iprobability'] 	= (string) $value->IceProbability;

			$hourlyDataAll[$key]['tliquidv'] 		= (string) $value->TotalLiquid->Value;
			$hourlyDataAll[$key]['tliquidu'] 		= (string) $value->TotalLiquid->Unit;
			$hourlyDataAll[$key]['rainv'] 			= (string) $value->Rain->Value;
			$hourlyDataAll[$key]['rainu'] 			= (string) $value->Rain->Unit;
			$hourlyDataAll[$key]['snowv'] 			= (string) $value->Snow->Value;
			$hourlyDataAll[$key]['snowu'] 			= (string) $value->Snow->Unit;
			$hourlyDataAll[$key]['icev'] 			= (string) $value->Ice->Value;
			$hourlyDataAll[$key]['iceu'] 			= (string) $value->Ice->Unit;

			$hourlyDataAll[$key]['ccover'] 			= (string) $value->CloudCover;
			$hourlyDataAll[$key]['mlink'] 			= (string) $value->MobileLink;
			$hourlyDataAll[$key]['link'] 			= (string) $value->Link;
		}
		//echo '<pre>'; print_r($hourlyDataAll);  die();

		$this->view->assign('hourlyDataAll', $hourlyDataAll);
	}

	/**
     * Display the Current and forecast weather data
     *
     * @param 
     * @param
     * @return void
     */
    public function dailyAction() 
	{
		$filepath	= \TYPO3\CMS\Core\Utility\GeneralUtility::getFileAbsFileName($this->settings['filepath']);
		if (!@is_file($filepath)) {	echo 'The file is not available in this path "'.$filepath.'"';	}
		$file_content_raw	= @file_get_contents($filepath);
		$file_content 		= (array) json_decode($file_content_raw);	//echo '<pre>'; print_r($file_content); die();

		$headlineDataAll = [];
		$headlineDataAll['dt']			= (string) $file_content['Headline']->EffectiveDate;
		$headlineDataAll['edt']			= (string) $file_content['Headline']->EffectiveEpochDate;
		$headlineDataAll['severity']	= (string) $file_content['Headline']->Severity;
		$headlineDataAll['text']		= (string) $file_content['Headline']->Text;
		$headlineDataAll['category']	= (string) $file_content['Headline']->Category;
		$headlineDataAll['edate']		= (string) $file_content['Headline']->EndDate;
		$headlineDataAll['eedate']		= (string) $file_content['Headline']->EndEpochDate;
		$headlineDataAll['mlink']		= (string) $file_content['Headline']->MobileLink;
		$headlineDataAll['link']		= (string) $file_content['Headline']->Link;

		$dailyDataAll	= [];
		$key = 0;
		foreach($file_content['DailyForecasts'] as $value) {
			$dailyDataAll[$key]['dt'] 			= (string) $value->Date;		
			$dailyDataAll[$key]['edt'] 			= (string) $value->EpochDate;

			$dailyDataAll[$key]['srise'] 			= (string) $value->Sun->Rise;		
			$dailyDataAll[$key]['serise'] 			= (string) $value->Sun->EpochRise;		
			$dailyDataAll[$key]['sset'] 			= (string) $value->Sun->Set;		
			$dailyDataAll[$key]['seset'] 			= (string) $value->Sun->EpochSet;	

			$dailyDataAll[$key]['mrise'] 			= (string) $value->Moon->Rise;		
			$dailyDataAll[$key]['merise'] 			= (string) $value->Moon->EpochRise;		
			$dailyDataAll[$key]['mset'] 			= (string) $value->Moon->Set;		
			$dailyDataAll[$key]['meset'] 			= (string) $value->Moon->EpochSet;	
			$dailyDataAll[$key]['mphase'] 			= (string) $value->Moon->Phase;		
			$dailyDataAll[$key]['mage'] 			= (string) $value->Moon->Age;		

			$dailyDataAll[$key]['tempeminv'] 		= (string) $value->Temperature->Minimum->Value;		
			$dailyDataAll[$key]['tempeminu'] 		= (string) $value->Temperature->Minimum->Unit;		
			$dailyDataAll[$key]['tempmaxv'] 		= (string) $value->Temperature->Maximum->Value;		
			$dailyDataAll[$key]['tempmaxu'] 		= (string) $value->Temperature->Maximum->Unit;

			$dailyDataAll[$key]['rftempminv']		= (string) $value->RealFeelTemperature->Minimum->Value;		
			$dailyDataAll[$key]['rftempminu']		= (string) $value->RealFeelTemperature->Minimum->Unit;		
			$dailyDataAll[$key]['rftempmaxv']		= (string) $value->RealFeelTemperature->Maximum->Value;		
			$dailyDataAll[$key]['rftempmaxu']		= (string) $value->RealFeelTemperature->Maximum->Unit;

			$dailyDataAll[$key]['rftempsminv']		= (string) $value->RealFeelTemperatureShade->Minimum->Value;		
			$dailyDataAll[$key]['rftempsminu']		= (string) $value->RealFeelTemperatureShade->Minimum->Unit;		
			$dailyDataAll[$key]['rftempsmaxv']		= (string) $value->RealFeelTemperatureShade->Maximum->Value;		
			$dailyDataAll[$key]['rftempsmaxu']		= (string) $value->RealFeelTemperatureShade->Maximum->Unit;

			$dailyDataAll[$key]['hoursofsun'] 		= (string) $value->HoursOfSun;

			$dailyDataAll[$key]['ddsheatingv']		= (string) $value->DegreeDaySummary->Heating->Value;		
			$dailyDataAll[$key]['ddsheatingu']		= (string) $value->DegreeDaySummary->Heating->Unit;		
			$dailyDataAll[$key]['ddscoolingv']		= (string) $value->DegreeDaySummary->Cooling->Value;		
			$dailyDataAll[$key]['ddscoolingu']		= (string) $value->DegreeDaySummary->Cooling->Unit;		
			//print_r($value['AirAndPollen']); die();
			$akey = 0;
			foreach($value->AirAndPollen as $avalue) {
				$dailyDataAll[$key]['airpollen'][$akey]['name'] 	= (string) $avalue->Name;		
				$dailyDataAll[$key]['airpollen'][$akey]['value'] 	= (string) $avalue->Value;		
				$dailyDataAll[$key]['airpollen'][$akey]['category'] = (string) $avalue->Category;	
				$dailyDataAll[$key]['airpollen'][$akey]['type'] 	= (string) $avalue->Type;
				$akey++;		
			}

			$dailyDataAll[$key]['mlink']			= (string) $value->MobileLink;
			$dailyDataAll[$key]['link']				= (string) $value->Link;

			//Day
			$dailyDataAll[$key]['dicon'] 			= (string) $value->Day->Icon;		
			$dailyDataAll[$key]['diconp'] 			= (string) $value->Day->IconPhrase;	
			$dailyDataAll[$key]['dprecipitation'] 	= (string) $value->Day->HasPrecipitation;	
			$dailyDataAll[$key]['dptype'] 			= (string) $value->Day->PrecipitationType;	
			$dailyDataAll[$key]['dpintensity'] 		= (string) $value->Day->PrecipitationIntensity;	
			$dailyDataAll[$key]['dsphrase'] 		= (string) $value->Day->ShortPhrase;	
			$dailyDataAll[$key]['dlphrase'] 		= (string) $value->Day->LongPhrase;	
			$dailyDataAll[$key]['dpprobability'] 	= (string) $value->Day->PrecipitationProbability;	
			$dailyDataAll[$key]['dtprobability'] 	= (string) $value->Day->ThunderstormProbability;	
			$dailyDataAll[$key]['drprobability'] 	= (string) $value->Day->RainProbability;	
			$dailyDataAll[$key]['dsprobability'] 	= (string) $value->Day->SnowProbability;	
			$dailyDataAll[$key]['diprobability'] 	= (string) $value->Day->IceProbability;	

			$dailyDataAll[$key]['dhop'] 			= (string) $value->Day->HoursOfPrecipitation;	
			$dailyDataAll[$key]['dhor'] 			= (string) $value->Day->HoursOfRain;	
			$dailyDataAll[$key]['dhos'] 			= (string) $value->Day->HoursOfSnow;	
			$dailyDataAll[$key]['dhoi'] 			= (string) $value->Day->HoursOfIce;	
			$dailyDataAll[$key]['dcc'] 				= (string) $value->Day->CloudCover;

			$dailyDataAll[$key]['dwseedv'] 			= (string) $value->Day->Wind->Speed->Value;
			$dailyDataAll[$key]['dwseedu'] 			= (string) $value->Day->Wind->Speed->Unit;
			$dailyDataAll[$key]['dwseedd'] 			= (string) $value->Day->Wind->Direction->Degrees;
			$dailyDataAll[$key]['dwseede'] 			= (string) $value->Day->Wind->Direction->English;

			$dailyDataAll[$key]['dwgseedv'] 		= (string) $value->Day->WindGust->Speed->Value;
			$dailyDataAll[$key]['dwgseedu'] 		= (string) $value->Day->WindGust->Speed->Unit;
			$dailyDataAll[$key]['dwgseedd'] 		= (string) $value->Day->WindGust->Direction->Degrees;
			$dailyDataAll[$key]['dwgseede'] 		= (string) $value->Day->WindGust->Direction->English;

			$dailyDataAll[$key]['dtliquidv'] 		= (string) $value->Day->TotalLiquid->Value;
			$dailyDataAll[$key]['dtliquidu'] 		= (string) $value->Day->TotalLiquid->Unit;

			$dailyDataAll[$key]['drainv'] 			= (string) $value->Day->Rain->Value;
			$dailyDataAll[$key]['drainu'] 			= (string) $value->Day->Rain->Unit;

			$dailyDataAll[$key]['dsnowv'] 			= (string) $value->Day->Snow->Value;
			$dailyDataAll[$key]['dsnowu'] 			= (string) $value->Day->Snow->Unit;

			$dailyDataAll[$key]['dicev'] 			= (string) $value->Day->Ice->Value;
			$dailyDataAll[$key]['diceu'] 			= (string) $value->Day->Ice->Unit;

			//Night
			$dailyDataAll[$key]['nicon'] 			= (string) $value->Night->Icon;		
			$dailyDataAll[$key]['niconp'] 			= (string) $value->Night->IconPhrase;	
			$dailyDataAll[$key]['nprecipitation'] 	= (string) $value->Night->HasPrecipitation;	
			$dailyDataAll[$key]['nptype'] 			= (string) $value->Night->PrecipitationType;	
			$dailyDataAll[$key]['niconp'] 			= (string) $value->Night->PrecipitationIntensity;	
			$dailyDataAll[$key]['niconp'] 			= (string) $value->Night->ShortPhrase;	
			$dailyDataAll[$key]['niconp'] 			= (string) $value->Night->LongPhrase;	
			$dailyDataAll[$key]['niconp'] 			= (string) $value->Night->PrecipitationProbability;	
			$dailyDataAll[$key]['niconp'] 			= (string) $value->Night->ThunderstormProbability;	
			$dailyDataAll[$key]['niconp'] 			= (string) $value->Night->RainProbability;	
			$dailyDataAll[$key]['niconp'] 			= (string) $value->Night->SnowProbability;	
			$dailyDataAll[$key]['niconp'] 			= (string) $value->Night->IceProbability;	

			$dailyDataAll[$key]['nhop'] 			= (string) $value->Night->HoursOfPrecipitation;	
			$dailyDataAll[$key]['nhor'] 			= (string) $value->Night->HoursOfRain;	
			$dailyDataAll[$key]['nhos'] 			= (string) $value->Night->HoursOfSnow;	
			$dailyDataAll[$key]['nhoi'] 			= (string) $value->Night->HoursOfIce;	
			$dailyDataAll[$key]['ncc'] 				= (string) $value->Night->CloudCover;

			$dailyDataAll[$key]['nwseedv'] 			= (string) $value->Night->Wind->Speed->Value;
			$dailyDataAll[$key]['nwseedu'] 			= (string) $value->Night->Wind->Speed->Unit;
			$dailyDataAll[$key]['nwseedd'] 			= (string) $value->Night->Wind->Direction->Degrees;
			$dailyDataAll[$key]['nwseede'] 			= (string) $value->Night->Wind->Direction->English;

			$dailyDataAll[$key]['nwgseedv'] 		= (string) $value->Night->WindGust->Speed->Value;
			$dailyDataAll[$key]['nwgseedu'] 		= (string) $value->Night->WindGust->Speed->Unit;
			$dailyDataAll[$key]['nwgseedd'] 		= (string) $value->Night->WindGust->Direction->Degrees;
			$dailyDataAll[$key]['nwgseede'] 		= (string) $value->Night->WindGust->Direction->English;

			$dailyDataAll[$key]['ntliquidv'] 		= (string) $value->Night->TotalLiquid->Value;
			$dailyDataAll[$key]['ntliquidu'] 		= (string) $value->Night->TotalLiquid->Unit;

			$dailyDataAll[$key]['nrainv'] 			= (string) $value->Night->Rain->Value;
			$dailyDataAll[$key]['nrainu'] 			= (string) $value->Night->Rain->Unit;

			$dailyDataAll[$key]['nsnowv'] 			= (string) $value->Night->Snow->Value;
			$dailyDataAll[$key]['nsnowu'] 			= (string) $value->Night->Snow->Unit;

			$dailyDataAll[$key]['nicev'] 			= (string) $value->Night->Ice->Value;
			$dailyDataAll[$key]['niceu'] 			= (string) $value->Night->Ice->Unit;
			$key++;
		}
		//echo '<pre>'; print_r($headlineDataAll); print_r($dailyDataAll); die();

		$this->view->assign('headlineDataAll', $headlineDataAll);
		$this->view->assign('dailyDataAll', $dailyDataAll);
	}
   
}