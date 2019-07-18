<?php

namespace Drupal\hoa\Services\Notifier;

/**
 * Notifier service.
 * 
 * @package Drupal\hoa\Services\Notifier
 */
class Notifier implements NotifierInterface {

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
	public function notify($recipient, $subject, $message, $from) {
		// Log messages for demo in a log file.
    $logPath = __DIR__ . '/../../../logs/emails.log';
    $logLines = array();
    $logLines[] = sprintf(
      '[%s][From: %s][To: %s][Subject: %s]',
      date('Y-m-d H:i:s'),
      $from,
      $recipient,
      $subject
    );
    $logLines[] = '---------------';
    $logLines[] = $message;
    $logLines[] = '---------------';
    $fh = fopen($logPath, 'a');
    fwrite($fh, implode("\n", $logLines) . "\n");
	}

}