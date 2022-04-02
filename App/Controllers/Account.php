<?php

namespace App\Controllers;

use \App\Models\User;
use \App\Models\Expense;

/**
 * Account controller
 *
 * PHP version 7.4
 */
class Account extends \Core\Controller
{

  /**
   * Validate if email is available (AJAX) for a new signup.
   *
   * @return void
   */
  public function validateEmailAction()
  {
    $is_valid = ! User::emailExists($_GET['email'], $_GET['ignore_id'] ?? null);

    header('Content-Type: application/json');
    echo json_encode($is_valid);
  }

  /**
   * Validate if method name is available (AJAX) for a new payment method.
   *
   * @return void
   */
  public function validateMethodName()
  {
    $is_valid = ! Expense::MethodExists($_GET['new_method_name']);

    header('Content-Type: application/json');
    echo json_encode($is_valid);
  }
}
