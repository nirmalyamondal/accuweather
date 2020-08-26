<?php
namespace AshokaTree\Accuweather\Task;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Scheduler\AbstractAdditionalFieldProvider;
use TYPO3\CMS\Core\Messaging\FlashMessage;
use TYPO3\CMS\Core\Messaging\FlashMessageService;
use TYPO3\CMS\Core\Core\Environment;
use TYPO3\CMS\Scheduler\Task\Enumeration\Action;

/**
 * Class AccuweatherAdditionalFieldProvider
 */
class AccuweatherAdditionalFieldProvider implements \TYPO3\CMS\Scheduler\AdditionalFieldProviderInterface
{
    /**
     * @var \TYPO3\CMS\Lang\LanguageService
     */
    protected $languageService;

    /**
     * Construct class.
     */
    public function __construct()
    {
        $this->languageService = $GLOBALS['LANG'];
    }

    /**
     * Gets additional fields to render in the form to add/edit a task.
     *
     * @param array $taskInfo Values of the fields from the add/edit task form
     * @param \TYPO3\Accuweather\Task\AccuweatherTask $task The task object
     * @param \TYPO3\CMS\Scheduler\Controller\SchedulerModuleController $schedulerModule
	 * CURRENT: http://dataservice.accuweather.com/currentconditions/v1/cityid?apikey=ApiKey
     * 12 Hours: http://dataservice.accuweather.com/forecasts/v1/hourly/12hour/cityid?apikey=ApiKey
     * 5days: http://dataservice.accuweather.com/forecasts/v1/daily/5day/cityid?apikey=ApiKey
     * PlaceId JSON: http://dataservice.accuweather.com/locations/v1/cities/geoposition/search.json?apikey=ApiKey&q=Latitude,Longitude
     * @return array
     */
    public function getAdditionalFields(
        array &$taskInfo,
        $task,
        \TYPO3\CMS\Scheduler\Controller\SchedulerModuleController $schedulerModule
    ) {
        $currentSchedulerModuleAction = $schedulerModule->getCurrentAction();
        // process fields
        if (empty($taskInfo['weather_appid'])) {
            if ($currentSchedulerModuleAction->equals(Action::ADD)) {
                $taskInfo['weather_appid'] = 'AA33DBynuJPWFAieW7YYOTbGeTqBGsXg';
            } elseif ($currentSchedulerModuleAction->equals(Action::EDIT)) {
                $taskInfo['weather_appid'] = $task->weather_appid;
            } else {
                $taskInfo['weather_appid'] = 'AA33DBynuJPWFAieW7YYOTbGeTqBGsXg';
            }
        }

		if (empty($taskInfo['weather_folder'])) {
            if ($currentSchedulerModuleAction->equals(Action::ADD)) {
                $taskInfo['weather_folder'] = '/fileadmin/accuweather/';
            } elseif ($currentSchedulerModuleAction->equals(Action::EDIT)) {
                $taskInfo['weather_folder'] = $task->weather_folder;
            } else {
                $taskInfo['weather_folder'] = '/fileadmin/accuweather/';
            }
        }

		if (empty($taskInfo['weather_file'])) {
            if ($currentSchedulerModuleAction->equals(Action::ADD)) {
                $taskInfo['weather_file'] = 'current.json';
            } elseif ($currentSchedulerModuleAction->equals(Action::EDIT)) {
                $taskInfo['weather_file'] = $task->weather_file;
            } else {
                $taskInfo['weather_file'] = 'current.json';
            }
        }

        if (empty($taskInfo['weather_placeid'])) {
            if ($currentSchedulerModuleAction->equals(Action::ADD)) {
                $taskInfo['weather_placeid'] = '2877452';
            } elseif ($currentSchedulerModuleAction->equals(Action::EDIT)) {
                $taskInfo['weather_placeid'] = $task->weather_placeid;
            } else {
                $taskInfo['weather_placeid'] = '2877452';
            }
        }

        // render appid field
        $fieldId = 'task_weather_appid';
        $fieldCode = '<input type="text" name="tx_scheduler[weather_appid]" id="'.$fieldId.'" value="'.
            htmlspecialchars($taskInfo['weather_appid']).'" size="100" />';

        $additionalFields[$fieldId] = [
            'code' => $fieldCode,
            'label' => BackendUtility::wrapInHelp('weather', $fieldId, $this->translate('appid')),
            'cshKey' => '_MOD_tools_txschedulerM1',
            'cshLabel' => $fieldId,
        ];

		// render folder field
        $fieldId = 'task_weather_folder';
        $fieldCode = '<input type="text" name="tx_scheduler[weather_folder]" id="'.$fieldId.'" value="'.
            htmlspecialchars($taskInfo['weather_folder']).'" size="100" />';

        $additionalFields[$fieldId] = [
            'code' => $fieldCode,
            'label' => BackendUtility::wrapInHelp('weather', $fieldId, $this->translate('folder')),
            'cshKey' => '_MOD_tools_txschedulerM1',
            'cshLabel' => $fieldId,
        ];

		// render file field
        $fieldId = 'task_weather_file';
        $fieldCode = '<input type="text" name="tx_scheduler[weather_file]" id="'.$fieldId.'" value="'.
            htmlspecialchars($taskInfo['weather_file']).'" size="100" />';

        $additionalFields[$fieldId] = [
            'code' => $fieldCode,
            'label' => BackendUtility::wrapInHelp('weather', $fieldId, $this->translate('file')),
            'cshKey' => '_MOD_tools_txschedulerM1',
            'cshLabel' => $fieldId,
        ];

        // render placeid field
        $fieldId = 'task_weather_placeid';
        $fieldCode = '<input type="text" name="tx_scheduler[weather_placeid]" id="'.$fieldId.'" value="'.
            htmlspecialchars($taskInfo['weather_placeid']).'" size="100" />';

        $additionalFields[$fieldId] = [
            'code' => $fieldCode,
            'label' => BackendUtility::wrapInHelp('weather', $fieldId, $this->translate('placeid')),
            'cshKey' => '_MOD_tools_txschedulerM1',
            'cshLabel' => $fieldId,
        ];

        return $additionalFields;
    }

    /**
     * {@inheritdoc}
     *
     * @return bool
     */
    public function validateAdditionalFields(
        array &$submittedData,
        \TYPO3\CMS\Scheduler\Controller\SchedulerModuleController $schedulerModule
    ) {
        $validInput = true;

        // clean data
        $submittedData['weather_appid'] = trim($submittedData['weather_appid']);
		$submittedData['weather_folder'] = trim($submittedData['weather_folder']);
		$submittedData['weather_file'] = trim($submittedData['weather_file']);
        $submittedData['weather_placeid'] = trim($submittedData['weather_placeid']);

        /** @var FlashMessageService $flashMessageService */
        $flashMessageService = GeneralUtility::makeInstance(FlashMessageService::class);

        if (!(strlen($submittedData['weather_appid']) > 0 )) {
           // Argument is required and argument value is empty0
            $flashMessageService->getMessageQueueByIdentifier()->addMessage(
                new FlashMessage(
                    sprintf($this->translate('appid_invalid'), $submittedData['weather_appid']),
                    $this->translate('appid_invalid'),
                    FlashMessage::ERROR
                )
            );

            $validInput = false;
        }
		
		$jsonfolder = $submittedData['weather_folder'];
        $path = Environment::getPublicPath().$jsonfolder;
		if (!(strlen($jsonfolder) > 0 && is_dir(Environment::getPublicPath().$jsonfolder) && GeneralUtility::isAllowedAbsPath(Environment::getPublicPath().$jsonfolder))) {
            $flashMessageService->getMessageQueueByIdentifier()->addMessage(
                new FlashMessage(
                    sprintf($this->translate('folder_invalid'), $jsonfolder),
                    $this->translate('folder_invalid'),
                    FlashMessage::ERROR
                )
            );
            $validInput = false;
        }

		if (!(strlen($submittedData['weather_file']) > 0 )) {
            $flashMessageService->getMessageQueueByIdentifier()->addMessage(
                new FlashMessage(
                    sprintf($this->translate('file_invalid'), $submittedData['weather_file']),
                    $this->translate('file_invalid'),
                    FlashMessage::ERROR
                )
            );
            $validInput = false;
        }

        if (!(strlen($submittedData['weather_placeid']) > 0 )) {
            $flashMessageService->getMessageQueueByIdentifier()->addMessage(
                new FlashMessage(
                    sprintf($this->translate('latitude_placeid'), $submittedData['weather_placeid']),
                    $this->translate('latitude_placeid'),
                    FlashMessage::ERROR
                )
            );
            $validInput = false;
        }

        return $validInput;
    }

    /**
     * {@inheritdoc}
     */
    public function saveAdditionalFields(array $submittedData, \TYPO3\CMS\Scheduler\Task\AbstractTask $task)
    {
        $task->weather_appid = $submittedData['weather_appid'];
		$task->weather_folder = $submittedData['weather_folder'];
		$task->weather_file = $submittedData['weather_file'];
        $task->weather_placeid = $submittedData['weather_placeid'];
    }
	
    /**
     * Translate by key.
     *
     * @param string $key
     * @param string $prefix
     *
     * @return string
     */
    protected function translate($key, $prefix = 'LLL:EXT:accuweather/Resources/Private/Language/locallang.xlf:')
    {
        return $this->languageService->sL($prefix.$key);
    }
}
