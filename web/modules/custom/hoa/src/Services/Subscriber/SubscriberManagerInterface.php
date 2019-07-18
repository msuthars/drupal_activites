<?php

namespace Drupal\hoa\Services\Subscriber;

/**
 * SubscriberManager Interface.
 */
interface SubscriberManagerInterface {
	
	/**
	 * Get Subscribers.
	 * 
	 * @return array
	 *   Subscriber List.
	 */
	public function getSubscribers();

}