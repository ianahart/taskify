<?php

class UserValidator
{
  private $userData;
  private $errors;
  private $fields = ['firstname', 'lastname', 'email', 'password'];

  public function __construct($submittedData)
  {
    $this->userData = $submittedData;
  }

  public function validateForm()
  {
    foreach ($this->fields as $field) {
      if (!array_key_exists($field, $this->userData)) {
        return;
      }

      $this->validateFirstName();
      $this->validatePassword();
      $this->validateLastName();
      $this->validateEmail();

      return $this->errors;
    }
  }

  public function validateFirstName()
  {
    $firstName = trim($this->userData['firstname']);

    if (empty($firstName)) {
      $this->addError('firstname', 'Please provide a first name');
    } else if (strlen($firstName) < 2) {

      $this->addError('firstname', 'First name must be a minimum of 2 characters');
    } else if (strlen($firstName) > 30) {

      $this->addError('firstname', 'First name cannot exceed 30 characters');
    } else if (!ctype_alpha($firstName)) {

      $this->addError('firstname', 'First name cannot include numbers or special characters');
    }
  }

  public function validateLastName()
  {
    $lastName = trim($this->userData['lastname']);

    if (empty($lastName)) {

      $this->addError('lastname', 'Please provide a last name');
    } else if (strlen($lastName) < 2) {

      $this->addError('lastname', 'Last name must be a minimum of 2 characters');
    } else if (strlen($lastName > 30)) {

      $this->addError('lastname', 'Last name must not exceed 30 characters');
    } else if (!ctype_alpha($lastName)) {

      $this->addError('lastname', 'Last name cannot include numbers or special characters');
    }
  }

  public function validateEmail()
  {
    $email = trim($this->userData['email']);

    if (empty($email)) {

      $this->addError('email', 'please provide your email address');
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

      $this->addError('email', 'Not a valid email address');
    }
  }

  public function validatePassword()
  {
    $password = trim($this->userData['password']);

    $lowercaseLetter = false;
    $uppercaseLetter = false;
    $number = false;

    if (empty($password)) {

      $this->addError('password', 'Please provide a password');
    } else if (strlen($password) < 6) {

      $this->addError('password', 'Password must be a minium of 6 characters');
    }

    foreach (str_split($password) as $char) {

      if ($char === strtolower($char) && !is_numeric($char)) {

        $lowercaseLetter = true;
      } else if ($char === strtoupper($char) && !is_numeric($char)) {

        $uppercaseLetter = true;
      } else if (is_numeric($char)) {

        $number = true;
      }
    }

    if (!$lowercaseLetter || !$uppercaseLetter || !$number) {

      $this->addError('password', 'Include at least 1 uppercase letter, 1 lowercase letter, and 1 number');
    }
  }

  public function addError($key, $value)
  {
    $this->errors[$key] = $value;
  }
}
