<?php

namespace Drupal\hoa\EventSubscriber;

use Drupal\Core\Url;
use Drupal\Core\Config\ConfigEvents;
use Drupal\Core\Config\ConfigImporterEvent;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\hoa\Services\Notifier\NotifierInterface;
use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\Core\StringTranslation\TranslationInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Module Enable Notifier Subscriber Subscriber.
 * 
 * @package \Drupal\hoa\EventSubscriber
 */
class ModuleEnableNotifierSubscriber implements EventSubscriberInterface {

  use StringTranslationTrait;

  /**
   * The notifier.
   *
   * @var \Drupal\hoa\Services\Notifier\NotifierInterface
   */
  protected $notifier;

  /**
   * The configuration factory.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
	protected $emails;

  /**
   * The Module Enable Notifier Event Subscriber Constructor.
   *
   * @param \Drupal\hoa\Services\Notifier\NotifierInterface $notifier
   *   The notifier interface.
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   The configuration factory.
   * @param \Drupal\Core\StringTranslation\TranslationInterface $string_translation
	 *   Translation Interface.
   */
  public function __construct(NotifierInterface $notifier, ConfigFactoryInterface $config_factory, TranslationInterface $string_translation) {
    $this->notifier = $notifier;
    $this->emails = $config_factory->get('hoa.email_configuration')->get('emails');
    $this->stringTranslation = $string_translation;
  }

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents() {
    $events[ConfigEvents::IMPORT][] = ['onModuleEnable'];
    return $events;
  }

  /**
   * Trigger this code on config import.
   * 
   * @param \Drupal\Core\Config\ConfigImporterEvent $event
   *   The config import event.
   */
  public function onModuleEnable(ConfigImporterEvent $event) {
    $importer = $event->getConfigImporter();
    $processed_extensions = $importer->getProcessedExtensions();
    // Notify users when new module enabled.
    if (isset($processed_extensions['module']['install']) && count($processed_extensions['module']['install']) > 0) {
      $new_module_enable = implode(', ', $processed_extensions['module']['install']);
      foreach($this->emails as $email) {
        $this->notifier->notify(
          $email,
          $this->t('New module/modules enabled.'),
          $this->t('Hello @email ! New module/modules: @modules enabled.', [
            '@email' => $email,
            '@module' => trim($new_module_enable),
          ]),
          'no-reply@qed42.com'
        );
      }
    }
  }

}