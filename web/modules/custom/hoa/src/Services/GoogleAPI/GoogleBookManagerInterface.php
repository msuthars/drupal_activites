<?php

namespace Drupal\hoa\Services\GoogleAPI;

/**
 * Google book manager interface.
 */
interface GoogleBookManagerInterface {

    /**
	 * Get google book details.
	 * 
	 * @param string $isbn
	 *   ISBN code.
	 * @return \AntoineAugusti\Books\Book|array
	 *   Return book object or array if any exception.
	 */
    public function getBookDetails($isbn);
    
}