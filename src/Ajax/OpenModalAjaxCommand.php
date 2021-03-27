<?php

namespace Drupal\exsismodule\Ajax;

use Drupal\Core\Ajax\CommandInterface;

/**
 * Class OpenModalAjaxCommand.
 */
class OpenModalAjaxCommand implements CommandInterface {

protected string $name;
protected int $identification;
protected string $birthday;
protected string $position;
protected int $status;

public function __construct($name, $identification, $birthday, $position, $status) {
  $this->name = $name;
  $this->identification = $identification;
  $this->birthday = $birthday;
  $this->position = $position;
  $this->status = $status;
}


  /**
   * Render custom ajax command.
   *
   * @return ajax
   *   Command function.
   */
  public function render() {
    return [
      'command' => 'exsis',
      'name' => $this->name,
      'identification' => $this->identification,
      'birthday' => $this->birthday,
      'position' => $this->position,
      'status' => $this->status,
    ];
  }

}
