<?php

namespace Drupal\exsismodule\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'ExsisBlock' block.
 *
 * @Block(
 *  id = "exsis_block",
 *  admin_label = @Translation("Exsis block"),
 * )
 */
class ExsisBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $build = [];
    $exsisUserForm = \Drupal::formBuilder()->getForm('\Drupal\exsismodule\Form\ExsisUserForm');
    $exsisUsersModalForm = \Drupal::formBuilder()->getForm('\Drupal\exsismodule\Form\ExsisUserModalForm');

    $build = [
      '#theme' => 'exsis_block',
      '#form_exsis_user' => $exsisUserForm,
      '#form_exsis_user_modal' => $exsisUsersModalForm,
      '#attached' => [
        'library' => [
          'exsismodule/exsismodule',
        ],
      ],
    ];

    return $build;
  }

}
