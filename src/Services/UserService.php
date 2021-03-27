<?php

namespace Drupal\exsismodule\Services;
use Drupal\Core\Database\Driver\pgsql\Connection;

/**
 * Class UserService.
 */
class UserService {

  /**
   * Drupal\Core\Database\Driver\pgsql\Connection definition.
   *
   * @var \Drupal\Core\Database\Driver\pgsql\Connection
   */
  protected Connection $database;

  /**
   * Constructs a new UserService object.
   *
   * @param \Drupal\Core\Database\Driver\pgsql\Connection $database
   */
  public function __construct(Connection $database) {
    $this->database = $database;
  }


  public function saveUser(string $name, int $identification, string $birthday, string $position, int $status) {

    try {

      $query = $this->database->insert('example_users')
        ->fields(['name', 'identification', 'birthday', 'position', 'status'])
        ->values([
          'name' => $name,
          'identification' => $identification,
          'birthday' => $birthday,
          'position' => $position,
          'status' => $status,
        ]);
      $result = $query->execute();
    }
    catch (\Exception $e) {
      throw new \Exception("Data no save", $e);
    }
    return $result;
  }


  public function getAllUsers() {
    try {
      $query = $this->database->select('example_users', 'f')
        ->fields('f', ['id', 'name', 'identification', 'birthday', 'position', 'status']);

      $result = $query->execute()->fetchAll();

    } catch (\Exception $e) {
      throw new \Exception("Don't get data", $e);
    }
    return $result;
  }

}
