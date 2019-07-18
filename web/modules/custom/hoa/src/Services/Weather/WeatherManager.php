<?php

namespace Drupal\hoa\Services\Weather;

use Drupal\Core\Url;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Psr7\Request as GuzzleRequest;
use Drupal\Component\Serialization\Json;
use Drupal\Core\Config\ConfigFactoryInterface;

/**
 * Form Data Manager service.
 * 
 * @package Drupal\hoa\Services
 */
class WeatherManager implements WeatherManagerInterface {

	/**
   * The configuration factory.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
	protected $configFactory;
	
	/**
   * The constructor for the site creation mail manager.
   *
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   The configuration factory.
   */
  public function __construct(ConfigFactoryInterface $config_factory) {
    $this->appid = $config_factory->get('hoa.settings')->get('appid');
	}
	
	/**
	 * Get weather details.
	 * 
	 * @param string $city_name
	 *   City Name for fetch weather data.
	 */
	public function getWeatherDetails($city_name) {
		$option['city_name'] = $city_name;
		$option['appid'] = $this->appid;

		try {
      $url = $this->getRequestUrl($option)->toString();
      $client  = new GuzzleClient();
      $request = new GuzzleRequest('GET', $url, []);
			$response_result = $client->send($request, ['timeout' => 30]);
			$response = Json::decode($response_result->getBody()->getContents());
      $response['status'] = 200;
      $response['main']['temp_min'] = isset($response['main']['temp_min']) ? round($response['main']['temp_min']) : 'N/A';
      $response['main']['temp_max'] = isset($response['main']['temp_max']) ? round($response['main']['temp_max']) : 'N/A';
      $response['main']['pressure'] = isset($response['main']['pressure']) ? round($response['main']['pressure']) : 'N/A';
      $response['wind']['speed'] = isset($response['wind']['speed']) ? round($response['wind']['speed']) : 'N/A';
      
      return $response;
    }
    catch (\Exception $e) {
      return [
				'status' => 500,
				'message' => $e->getMessage(),
			];
    }
	}

	/**
   * Get request url.
   */
  public function getRequestUrl($option) {
    $api_url = 'http://api.openweathermap.org/data/2.5/weather';
    $query = [
      'q' => $option['city_name'],
      'appid' => $option['appid'],
      'units' => 'metric',
    ];
    return Url::fromUri($api_url, [
      'query' => $query,
    ]);
	}
	
}