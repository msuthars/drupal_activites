<?php

namespace Drupal\hoa\Controller;

use Drupal\node\NodeInterface;
use Drupal\Core\Access\AccessResult;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Controller\ControllerBase;

/**
 * Class HoaController
 * 
 * @package Drupal\hoa\Controller
 */
class HoaController extends ControllerBase {

	/**
	 * Static content callback.
	 * 
	 * @return array
	 *   Markup.
	 */
	public function staticCallback() {
		return ['#markup' => 'Hello! I am your node listing page.'];
	}

	/**
	 * Dynamic content callback.
	 * 
	 * @param int $arg
	 *   Demo argument.
	 * 
	 * @return array
	 *   Markup.
	 */
	public function dynamicCallback($arg) {
		return ['#markup' => 'Hello! I am your ' . $arg . ' listing page.'];
	}

	/**
	 * Node Details.
	 * 
	 * @param \Drupal\node\NodeInterface $node
	 *   Node.
	 * 
	 * @return array
	 *   Markup.
	 */
	public function getNodeDetails(NodeInterface $node) {
		$build['wrapper'] = [
			'#type' => 'container',
		];

		$build['wrapper']['node1']['title'] = [
			'#type' => 'html_tag',
			'#tag' => 'h1',
			'#value' => $node->label(),
		];
		$build['wrapper']['node1']['body'] = [
			'#type' => 'html_tag',
			'#tag' => 'p',
			'#value' => $node->body->value,
		];
		
		return $build;
	}

	/**
	 * Nodes Details.
	 * 
	 * @param \Drupal\node\NodeInterface $node1
	 *   Node.
	 * @param \Drupal\node\NodeInterface $node2
	 *   Node.
	 * 
	 * @return array
	 *   Markup.
	 */
	public function getNodesDetails(NodeInterface $node1, NodeInterface $node2 = NULL) {
		$build['wrapper'] = [
			'#type' => 'container',
		];

		$build['wrapper']['node1']['title'] = [
			'#type' => 'html_tag',
			'#tag' => 'h1',
			'#value' => $node1->label(),
		];
		$build['wrapper']['node1']['body'] = [
			'#type' => 'html_tag',
			'#tag' => 'p',
			'#value' => $node1->body->value,
		];
		
		if (!is_null($node2)) {
			$build['wrapper']['node2']['title'] = [
				'#type' => 'html_tag',
				'#tag' => 'h1',
				'#value' => $node2->label(),
			];
			$build['wrapper']['node2']['body'] = [
				'#type' => 'html_tag',
				'#tag' => 'p',
				'#value' => $node2->body->value,
			];
		}
		return $build;
	}

	/**
   * Custom access check for node.
   *
	 * @param \Drupal\node\NodeInterface $node1
	 *   Node.
	 * @param \Drupal\node\NodeInterface $node2
	 *   Node.
   * @param \Drupal\Core\Session\AccountInterface $account
   *   Run access checks for this account.
	 * 
   * @return \Drupal\Core\Access\AccessResult
   *   The access result.
   */
	public function access(NodeInterface $node1, NodeInterface $node2, AccountInterface $account) {
    // Check current user with node author.
    if ($account->id() == $node1->uid->getString() && $account->id() == $node2->uid->getString()) {
      // If the current user match with nodes author, give them access.
      return AccessResult::allowed();
    }
    return AccessResult::forbidden();
  }

}