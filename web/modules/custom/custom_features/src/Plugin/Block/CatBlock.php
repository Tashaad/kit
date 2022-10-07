<?php

namespace Drupal\custom_features\Plugin\Block;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Session\AccountInterface;

/**
 * Provides a cat block.
 *
 * @Block(
 *   id = "custom_features_cat",
 *   admin_label = @Translation("Cat"),
 *   category = @Translation("Custom")
 * )
 */
class CatBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $build['content'] = [
      '#markup' => date ('Y-M-D H:i:s'),
    ];
    return $build;
  }

  /**
   * {@inheritdoc}
   */
  public function getCacheMaxAge() {
    return 5;
  }


}
