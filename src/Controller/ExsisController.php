<?php

namespace Drupal\exsismodule\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\exsismodule\Services\UserService;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class ExsisController.
 */
class ExsisController extends ControllerBase {


  /**
   * @var
   */
  protected UserService $userService;


  public static function create(ContainerInterface $container) {
    $userService = $container->get('exsismodule.user');


    return new static($userService);
  }


  /**
   * ExsisController constructor.
   *
   * @param $userService
   */
  public function __construct(UserService $userService)
  {
    $this->userService = $userService;
  }

  /**
   * Registerusers.
   *
   * @return string
   *   Return Hello string.
   */
  public function registerUsers() {
    $block_manager = \Drupal::service('plugin.manager.block');

    $config = [];
    $plugin_block = $block_manager->createInstance('exsis_block', $config);
    $access_result = $plugin_block->access(\Drupal::currentUser());
    if (is_object($access_result) && $access_result->isForbidden() || is_bool($access_result) && !$access_result) {
      return [];
    }
    return $plugin_block->build();
  }


  /**
   * @return \Symfony\Component\HttpFoundation\JsonResponse
   */
  public function getJsonUsers(): JsonResponse {

    return new JsonResponse([
      'data' => $this->userService->getAllUsers(),
]);
  }

}
