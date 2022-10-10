<?php

namespace Drupal\custom_features\Plugin\Block;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Session\AccountInterface;

/**
 * Provides an another block.
 *
 * @Block(
 *   id = "custom_features_another",
 *   admin_label = @Translation("Another user"),
 *   category = @Translation("User"),
 *   context_definitions = {
 *     "another_user" = @ContextDefinition("entity:user", label = @Translation("user"), required = TRUE )
 *   }
 * )
 */
class AnotherBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */

  public function defaultConfiguration() {
    return [
      'foo' => $this->t('Hello world!'),
    ];
  }

  /**
   * {@inheritdoc}
   */
  protected function blockAccess(AccountInterface $account) {
    // @DCG Evaluate the access condition here.
    $condition = TRUE;
    return AccessResult::allowedIf($condition);
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    /** @var \Drupal\user\UserInterface $user */
    $user = $this->getContextValue('another_user');


    $build['content'] = [
      '#markup' => $user->getAccountName(),
    ];

    return $build;
  }

}
