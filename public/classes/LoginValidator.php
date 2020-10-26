<?php
include(__DIR__ . '/../../config/db.php');

class LoginValidator
{
  private $errors;
  private $fields = ['email', 'password'];
  private $loginData;

  public function __construct($data)
  {
    $this->loginData = $data;
  }

  public function validateForm()
  {
    foreach ($this->fields as $field) {
      if (!array_key_exists($field, $this->loginData)) {
        return;
      }
    }
    $this->validateLoginEmail();
    $this->validateLoginPassword();

    return $this->errors;
  }

  public function validateLoginEmail()
  {
    $email = trim($this->loginData['email']);

    if (empty($email)) {

      $this->addError('email', 'Please provide an email');
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

      $this->addError('email', 'Not a valid email address');
    }
  }

  public function validateLoginPassword()
  {
    $password = trim($this->loginData['password']);

    if (empty($password)) {
      $this->addError('password', 'Please provide a password');
    }
  }

  public function addError($key, $value)
  {
    return $this->errors[$key] = $value;
  }
}
