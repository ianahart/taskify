<?php
include(__DIR__ . '/../../config/db.php');

class User
{
  private $db;
  private $firstName;
  private $lastName;
  private $email;
  private $password;
  private $userData;
  private $isLoggedIn;
  private $authError;


  public function __construct($DB_con)
  {
    $this->db = $DB_con;
  }

  public function setFirstName($firstName)
  {
    $this->firstName = trim(ucfirst($firstName));
  }

  public function setLastName($lastName)
  {
    $this->lastName = trim(ucfirst($lastName));
  }

  public function setEmail($email)
  {
    $this->email = trim($email);
  }

  public function setAuthStatus($status)
  {
    return $this->isLoggedIn = $status;
  }

  public function getAuthStatus()
  {
    return $this->isLoggedIn;
  }

  public function getUserData()
  {
    return $this->userData;
  }

  public function setAuthError($error)
  {
    $this->authError = $error;
  }

  public function getAuthError()
  {
    return $this->authError;
  }

  public function registerUser()
  {
    try {
      $sql = "INSERT INTO users (firstname, lastname, password, email)
    VALUES(:firstname, :lastname, :password, :email)";

      $stmt = $this->db->prepare($sql);

      $stmt->bindParam(':firstname', $this->firstName);
      $stmt->bindParam(':lastname', $this->lastName);
      $stmt->bindParam(':email', $this->email);
      $stmt->bindParam(':password', $this->password);

      $stmt->execute();

      return true;
    } catch (PDOException $e) {

      echo $e->getMessage();

      return false;
    }
  }

  public function checkExistingEmail($email)
  {
    $sql = "SELECT email FROM users WHERE email = '$email'";

    $stmt = $this->db->prepare($sql);

    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {

      return $result;
    }
    return false;
  }

  private function hashPassword($password)
  {
    return password_hash($password, PASSWORD_BCRYPT);
  }

  public function setPassword($password)
  {

    $this->password = $this->hashPassword($password);
  }

  private function comparePassword($inputPassword, $hashedPassword)
  {
    if (password_verify($inputPassword, $hashedPassword)) {

      return true;
    } else {

      $this->setAuthError('Email and password do not match');

      return false;
    }
  }

  public function login($email, $password)
  {
    $this->fetchUser($email);

    if ($this->comparePassword($password, $this->userData['password'])) {

      unset($this->userData['password']);

      $this->setAuthStatus(true);
    } else {

      $this->setAuthStatus(false);
    }
  }

  public function logout()
  {
    Session::delete('userId');

    Session::delete('userName');

    Session::delete('lastLogin');

    session_destroy();
  }

  public function getLastLogin()
  {
    $userId = Session::get('userId');

    $sql = "SELECT last_login FROM users WHERE id = '$userId'";

    $stmt = $this->db->prepare($sql);

    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_ASSOC);
  }


  public function setLastLogin()
  {
    $userId = Session::get('userId');
    $currentTime = time();

    $sql = "UPDATE users SET last_login = '$currentTime' WHERE id = '$userId'";

    $stmt = $this->db->prepare($sql);

    $stmt->execute();
  }

  public function fetchUser($email)
  {
    $sql = "SELECT email, firstname, id, password FROM users WHERE email = '$email'";

    $stmt = $this->db->prepare($sql);

    $stmt->execute();

    $this->userData = $stmt->fetch(PDO::FETCH_ASSOC);
  }
}
