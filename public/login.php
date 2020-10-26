<?php

include(__DIR__ . '/classes/User.php');
include_once(__DIR__ . '/classes/Task.php');
include(__DIR__ . '/classes/LoginValidator.php');
include(__DIR__ . '/classes/Session.php');

session_start();

if (Session::exists('userId')) {
  header("Location: home.php");
}


if (isset($_POST['login'])) {
  $LoginValidator = new LoginValidator($_POST);

  if (!$user->checkExistingEmail($_POST['email'])) {
    $LoginValidator->addError('email', 'Not a valid email address');
  }
  $errors = $LoginValidator->validateForm();

  if (!$errors) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $user->login($email, $password);

    if ($user->getAuthStatus()) {

      if (!Session::exists('userId')) {

        Session::set('userId', $user->getUserData()['id']);
        Session::set('userName', $user->getUserData()['firstname']);
      }
      Session::set('lastLogin', $user->getLastLogin()['last_login']);
      header("Location: index.php");
      $task->setTimers(Session::get('userId'), Session::get('lastLogin'));
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<?php include('public/includes/head.php'); ?>

<body>
  <?php include('public/includes/nav.php'); ?>
  <div class="main-content">
    <div class="login-form-container">
      <form action="login.php" method="POST">
        <header>
          <h2>Login to Taskify</h2>
          <p class="login-form-error"><?php echo $user->getAuthError() ?? '' ?></p>
        </header>

        <div class="input-group">
          <label>Email:</label>
          <input type="text" name="email" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>" />
          <div class="login-form-error">
            <?php echo $errors['email'] ?? ''; ?>
          </div>
        </div>
        <div class="input-group">
          <label>Password: </label>
          <input type="password" name="password" value="<?php echo isset($_POST['password']) ? htmlspecialchars($_POST['password']) : '' ?>" />
          <div class="login-form-error">
            <?php echo $errors['password'] ?? ''; ?>
          </div>
        </div>
        <div class="login-button-container">
          <button type="submit" name="login">login</button>
        </div>
      </form>
    </div>
  </div>
  <?php include('public/includes/footer.php'); ?>
</body>

</html>