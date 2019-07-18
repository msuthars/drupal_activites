<?php

namespace Drupal\hoa\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Field\FieldItemListInterface;

/**
 * Plugin implementation of the 'youtube_video' formatter.
 *
 * @FieldFormatter(
 *   id = "youtube_video",
 *   label = @Translation("YouTube Formatter"),
 *   field_types = {
 *     "string",
 *   },
 *   quickedit = {
 *     "editor" = "plain_text"
 *   }
 * )
 */
class YouTubeLinkFormatter extends FormatterBase { 

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = array();
    foreach ($items as $delta => $item) {
      $elements[$delta] = array(
        '#theme' => 'youtube_link_formatter',
        '#url' => $item->value,
      );
    }
    return $elements;
  }

}
