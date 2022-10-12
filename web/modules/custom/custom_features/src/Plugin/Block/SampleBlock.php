<?php

namespace Drupal\custom_features\Plugin\Block;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Session\AccountInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;


/**
 * Provides a sample block.
 *
 * @Block(
 *   id = "custom_features_sample",
 *   admin_label = @Translation("Sample"),
 *   category = @Translation("Custom")
 * )
 */
class SampleBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * @var \Drupal\custom_features\My
   */
  protected $productKolichestvo;

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition){
    $instance = new static($configuration, $plugin_id, $plugin_definition );
    $instance->productKolichestvo = $container->get('custom_features.my_service');
    return $instance;
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $count = $this->productKolichestvo->getCount();
    $build['content'] = [
      '#markup' => $this->t('Count @count', ['@count' => 1]),
      '#cache' => [
        'tags' => ['node_list'],
      ],
    ];

    return $build;
  }

}
