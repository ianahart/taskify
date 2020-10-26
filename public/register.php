<?php
include(__DIR__ . '/classes/RegisterValidator.php');
include(__DIR__ . '/classes/User.php');
include(__DIR__ . '/classes/Session.php');

session_start();

if (Session::exists('userId')) {
  header("Location: index.php");
}

if (isset($_POST['signup'])) {
  $userValidator = new UserValidator($_POST);

  if ($user->checkExistingEmail($_POST['email'])) {
    $userValidator->addError('email', 'Email address already exists');
  }
  $errors = $userValidator->validateForm();



  if (!$errors) {

    $firstName = $_POST['firstname'];
    $lastName = $_POST['lastname'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $user->setFirstName($firstName);
    $user->setLastName($lastName);
    $user->setEmail($email);
    $user->setPassword($password);

    if ($user->registerUser()) {
      header("Location: login.php");
    }
  }
}




?>



<!DOCTYPE html>
<html lang="en">

<?php include('./includes/head.php'); ?>

<body>
  <?php include('./includes/nav.php'); ?>
  <div class="main-content">
    <div class="register-form-container">
      <form action="register.php" method="POST">
        <header>
          <h2>Sign up for Taskify</h2>
          <p>Get ready to put your life in order</p>
        </header>
        <div class="row-group">
          <div class="input-group">
            <label>First Name:</label>
            <input type="text" name="firstname" value="<?php echo isset($_POST['firstname']) ? htmlspecialchars($_POST['firstname']) : '' ?>" />
            <div class="register-form-error">
              <?php echo $errors['firstname'] ?? ''; ?>
            </div>
          </div>
          <div class="input-group">
            <label>Last Name:</label>
            <input type="text" name="lastname" value="<?php echo isset($_POST['lastname']) ? htmlspecialchars($_POST['lastname']) : '' ?>" />
            <div class="register-form-error">
              <?php echo $errors['lastname'] ?? ''; ?>
            </div>
          </div>
        </div>
        <div class="input-group">
          <label>Email:</label>
          <input type="text" name="email" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>" />
          <div class="register-form-error">
            <?php echo $errors['email'] ?? ''; ?>
          </div>
        </div>
        <div class="input-group">
          <label>Password: <span>*<em>Include at least 1 uppercase letter, 1 lowercase letter, and 1 number</em></span></label>
          <input type="password" name="password" value="<?php echo isset($_POST['password']) ? htmlspecialchars($_POST['password']) : '' ?>" />
          <div class="register-form-error">
            <?php echo $errors['password'] ?? ''; ?>
          </div>
        </div>
        <div class="register-button-container">
          <button type="submit" name="signup">submit</button>
        </div>
      </form>
    </div>
  </div>
  <?php include('./includes/footer.php'); ?>
</body>

</html>