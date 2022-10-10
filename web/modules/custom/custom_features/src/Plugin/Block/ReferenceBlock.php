<?php

namespace Drupal\custom_features\Plugin\Block;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Session\AccountProxyInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;


/**
 * Provides a reference block.
 *
 * @Block(
 *   id = "custom_features_reference",
 *   admin_label = @Translation("Reference"),
 *   category = @Translation("Custom")
 * )
 */
class ReferenceBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * The current user.
   *
   * @var \Drupal\Core\Session\AccountProxyInterface
   */
  protected $currentUser;


  /**
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;


  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    $instance = new static($configuration, $plugin_id, $plugin_definition);
    $instance->currentUser = $container->get('current_user');
    $instance->entityTypeManager = $container->get('entity_type.manager');


    return $instance;
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
      if(!$this->currentUser->isAuthenticated()) {
        $build['content'] = [
          '#markup' => $this->currentUser->getAccountName(),
        ];
        return $build;
      }
    $account = $this->currentUser;
    $id = $account->id();
    $storage = $this->entityTypeManager->getStorage('user');
    $user = $storage->load($id);

    $viewBuilder = $this->entityTypeManager->getViewBuilder('user');
    $build['content'] = $viewBuilder->view($user,'card');


    return $build;
  }

  /**
   * {@inheritdoc}
   */
  public function getCacheContexts() {
    return ['user.roles'];


  }

}
