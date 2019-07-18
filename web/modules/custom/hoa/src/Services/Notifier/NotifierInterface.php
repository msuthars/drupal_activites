<?php

namespace Drupal\hoa\Services\Notifier;

/**
 * Notifier Interface.
 */
interface NotifierInterface {
	
	/**
   * Sends an email message.
   *
   * @param string $recipient
	 *   Email to.
   * @param string $subject
	 *   Email Subject.
   * @param string $message
	 *   Email message.
   * @param string $from
	 *   Email from.
   */
	public function notify($recipient, $subject, $message, $from);

}