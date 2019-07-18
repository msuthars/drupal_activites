<?php

namespace Drupal\hoa\Controller;

use Drupal\node\NodeInterface;
use Drupal\Core\Access\AccessResult;
use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class HoaDemoController
 * 
 * @package Drupal\hoa\Controller
 */
class HoaDemoController extends ControllerBase {

  public function getNodeJson(NodeInterface $node, $api_key) {
    $serializer = \Drupal::service('serializer');
    $data = $serializer->normalize($node);
    return new JsonResponse(['node' => $data]);
  }

	/**
   * Custom access check for node.
   *
	 * @param string $api_key
   *   Api Key.
	 * 
   * @return \Drupal\Core\Access\AccessResult
   *   The access result.
   */
	public function access($api_key) {
    if ($api_key == $this->config('system.site')->get('apikey')) {
      // If the current api key match, give them access.
      return AccessResult::allowed();
    }
    return AccessResult::forbidden();
  }

}