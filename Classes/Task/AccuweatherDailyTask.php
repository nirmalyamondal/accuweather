<?php
namespace AshokaTree\Accuweather\Task;

ini_set('max_execution_time', 300);

use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Resource\ResourceFactory;
use TYPO3\CMS\Core\Core\Environment;

/**
 * Class AccuweatherDailyTask
 */
class AccuweatherDailyTask extends \TYPO3\CMS\Scheduler\Task\AbstractTask
{

    /**
     * @var bool
     */
    protected $debugging = false;

	/**
     * @var bool
     */
    protected $logging = true;	

    /**
     * @var string
     */
    public $weather_appid;

 	/**
     * @var string
     */
    public $weather_folder;

 	/**
     * @var string
     */
    public $weather_file;	

    /**
     * @var string
     */
    public $weather_placeid;

    /**
     * {@inheritdoc}
     *
     * @return bool
     */
    public function execute()
    {        
		if (!function_exists('curl_init')){
			die('Sorry cURL is not installed!');
		}
		$this->cleanValues();
		$this->downloadWeatherFile();		
	return TRUE;
    }

    /**
     * {@inheritdoc}
     *
     * @return string
     */
    protected function cleanValues()
    {
        $this->weather_appid = strip_tags($this->weather_appid);
		$this->weather_folder = strip_tags($this->weather_folder);
        $this->weather_file = strip_tags($this->weather_file);
        $this->weather_placeid = strip_tags($this->weather_placeid);

        $this->log('$this->appid: '.$this->weather_appid);
        $this->log('$this->folder: '.$this->weather_folder);
		$this->log('$this->file: '.$this->weather_file);
        $this->log('$this->placeid: '.$this->weather_placeid);
    }

    /**
     * Download JSON file to a given directory path.
     *
     * @return bool
     */
    public function downloadWeatherFile()
    {
		$appid	   = $this->weather_appid;		
		$folder	   = $this->weather_folder;
		$file	   = $this->weather_file;
		$placeid   = $this->weather_placeid;

        $conf_settings  = $this->parseSettings();
        $daily_url      = $conf_settings['daily_url'] ? $conf_settings['daily_url'] : 'http://dataservice.accuweather.com/forecasts/v1/daily/5day/';
        $url            = $daily_url.$placeid.'?apikey='.$appid.'&details=true&metric=true';

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		//comment out curl_setopt when NO ssl/ https
        //curl_setopt($ch, CURLOPT_SSLVERSION,3);
		$data = curl_exec($ch);
		$error = curl_error($ch); 
		curl_close($ch);

		$path = Environment::getPublicPath().$folder.$file;
		$fp = fopen($path, "w+");
		fputs($fp, $data);
		fclose($fp);
		//die();
    }

    /**
     * Parse settings and return it as array
     *
     * @return array unserialized extconf settings
     */
    public static function parseSettings()
    {
        $settings = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['EXTENSIONS']['accuweather']);
        if (!is_array($settings)) {
            $settings = [];
        }
        return $settings;
    }

    /**
     * @param $msg
     * @param int $status
     */
    protected function log($msg, $status = 1)
    {
        // higher status for debugging
        if ($this->debugging) {
            \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($msg);
            $status = 3;
        }
        // write dev log if enabled
        if ($this->logging) {
            //GeneralUtility::devLog($msg, 'accuweather', $status);
        }
    }

}
