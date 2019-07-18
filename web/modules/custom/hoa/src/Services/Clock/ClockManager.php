<?php

namespace Drupal\hoa\Services\Clock;

use Drupal\Core\Url;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Psr7\Request as GuzzleRequest;
use Drupal\Component\Serialization\Json;

/**
 * Clock Manager service.
 * 
 * @package Drupal\hoa\Services
 */
class ClockManager {

	/**
	 * Get clock details.
	 * 
	 * @param string $timezone
	 *   Timezone(UTC, EST).
	 */
	public function getClockDetails($timezone) {
		try {
      // $api_url = 'http://worldclockapi.com/api/json/' . strtolower($timezone) . '/now';
      // $url = Url::fromUri($api_url)->toString();
      // $client  = new GuzzleClient();
      // $request = new GuzzleRequest('GET', $url, []);
      
			// $response_result = $client->send($request, ['timeout' => 30]);
      // $response = Json::decode($response_result->getBody()->getContents());
      
      if ($timezone == 'est') {
        $response['$id'] =	"1";
        $response['currentDateTime'] = '2019-07-12T13:00-04:00';
        $response['utcOffset'] = '-04:00:00';
        $response['isDayLightSavingsTime'] = true;
        $response['dayOfTheWeek'] =	'Friday';
        $response['timeZoneName'] =	'Eastern Standard Time';
        $response['currentFileTime'] = 132074049993770780;
        $response['ordinalDate'] =	'2019-193';
        $response['serviceResponse'] = null;
      }
      else {
        $response['$id'] =	"1";
        $response['currentDateTime'] = '2019-07-12T16:57Z';
        $response['utcOffset'] = '00:00:00';
        $response['isDayLightSavingsTime'] = false;
        $response['dayOfTheWeek'] =	'Friday';
        $response['timeZoneName'] =	'UTC';
        $response['currentFileTime'] = 132074049993770780;
        $response['ordinalDate'] =	'2019-193';
        $response['serviceResponse'] = null;
      }

      $date = new \DateTime($response['currentDateTime']);

      $response['date'] = $date->format('D, d-M-Y');
      $response['time'] = $date->format('H:i');
      $response['status'] = 200;
      return $response;
    }
    catch (\Exception $e) {
      return [
				'status' => 500,
				'message' => $e->getMessage(),
			];
    }
	}
	
}