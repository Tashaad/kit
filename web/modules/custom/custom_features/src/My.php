<?php

namespace Drupal\custom_features;

use Drupal\Core\Entity\ContentEntityStorageInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\node\NodeInterface;

/**
 * My service class.
 */
Class My {

  use StringTranslationTrait;

  /**
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * @param EntityTypeManagerInterface $entityTypeManager
   */
  public function __construct(EntityTypeManagerInterface $entityTypeManager) {
    $this->entityTypeManager = $entityTypeManager;
  }

  /**
   * @return int
   */
  public function getCount(): int {
    $count = 0;

    try {
      /** @var \Drupal\Core\Config\Entity\ConfigEntityStorageInterface $storage */
      $storage = $this->entityTypeManager->getStorage('node');
      $query = $storage->getQuery()
        ->condition('status', TRUE)
        ->condition('type', 'tovary')
        ->exists('field_kolichestvo');
      $idsOfEntities = $query->execute(); // array of ids

      /** @var NodeInterface[] $entities */
      $entities = $storage->loadMultiple($idsOfEntities);
    }
    catch (\Exception $e) {
      return $count;
    }


    foreach ($entities as $node){
      $count += $node->get('field_kolichestvo')->value;
    }

    return $count;
  }

}
