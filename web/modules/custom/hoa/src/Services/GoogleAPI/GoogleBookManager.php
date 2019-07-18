<?php

namespace Drupal\hoa\Services\GoogleAPI;

use Drupal\Core\Url;
use GuzzleHttp\Client as GuzzleClient;
use AntoineAugusti\Books\Fetcher;
use Drupal\Component\Serialization\Json;

/**
 * Form Data Manager service.
 * 
 * @package Drupal\hoa\Services
 */
class GoogleBookManager implements GoogleBookManagerInterface {
	
	/**
	 * Get google book details.
	 * 
	 * @param string $isbn
	 *   ISBN code.
	 * @return \AntoineAugusti\Books\Book|array
	 *   Return book object or array if any exception.
	 */
	public function getBookDetails($isbn) {
		try {
      $client = new GuzzleClient(['base_uri' => 'https://www.googleapis.com/books/v1/']);
      $fetcher = new Fetcher($client);
			$book = $fetcher->forISBN($isbn);
			return $book;
    }
    catch (\Exception $e) {
      return [
				'status' => 500,
				'message' => $e->getMessage(),
			];
    }
	}
	
}