<?php
require('vendor/autoload.php');

include(__DIR__ . '/classes/TaskValidator.php');
include(__DIR__ . '/classes/Task.php');
include(__DIR__ . '/classes/Session.php');

session_start();




if (!Session::exists('userId')) {

  header("Location: home.php");
} else {

  $task->setUserId(Session::get('userId'));
}



if (isset($_COOKIE['timers']) && !isset($_COOKIE['elapsedTime'])) {

  $task->updateTimers(json_decode($_COOKIE['timers'], true));
} else if (isset($_COOKIE['timers']) && isset($_COOKIE['elapsedTime'])) {

  $task->updateTimers(json_decode($_COOKIE['timers'], true), $_COOKIE['elapsedTime']);
}

if (isset($_POST['submit'])) {
  $validator = new TaskValidator($_POST['title'], $_POST['description']);

  $errors = $validator->validateForm();

  if (!$errors) {
    $taskTitle = $_POST['title'];
    $taskDescription = $_POST['description'];
    $days = $_POST['time_to_complete'];

    $task->setTaskTitle($taskTitle);
    $task->setTaskDescription($taskDescription);
    $task->setTaskImage();
    $task->setDays($days);
    $task->setCreatedAt();

    $s3 = new Aws\S3\S3Client([
      'version'  => '2006-03-01',
      'region'   => 'us-east-1',
    ]);

    $bucket = getenv('S3_BUCKET') ?: die('No "S3_BUCKET" config var in found in env!');

    if (isset($_FILES['userfile']) && is_uploaded_file($_FILES['userfile']['tmp_name'])) {
      try {
        $result = $s3->putObject([
          'Bucket' => 'hart-taskify',
          'Key' => $_FILES['userfile']['name'],
          'ContentType' => 'image/jpeg'
        ]);
        // $upload = $s3->upload($bucket, $_FILES['userfile']['name'], fopen($_FILES['userfile']['tmp_name'], 'rb'), 'public-read');
      } catch (Exception $e) {

        echo "Error Uploading" . $e;
      }
    }


    if ($task->addTask()) {

      $task->getFormattedTasks();
    }
    header("Location: processTaskForm.php");
  }
}

if (isset($_POST['remove'])) {
  $taskID = $_POST['taskID'];

  $task->setTaskID($taskID);

  if ($task->removeTask()) {
    $task->getFormattedTasks();
    header("Location: tasks.php");
  }
}

if (isset($_POST['status'])) {
  $taskIDtoComplete = $_POST['completed'];

  $task->setTaskID($taskIDtoComplete);
  $task->setTaskCompleted('true');

  if ($task->updateTaskCompleted()) {
    header("Location: tasks.php");
  }
}

if (isset($_POST['edit'])) {
  $editValidator = new TaskValidator($_POST['edit_title'], $_POST['edit_description']);
  $editErrors = $editValidator->validateForm();

  if (!$editErrors) {
    $taskID = $_POST['taskid'];
    $taskTitle = $_POST['edit_title'];
    $taskDescription = $_POST['edit_description'];

    $task->setTaskID($taskID);
    $task->setTaskTitle($taskTitle);
    $task->setTaskDescription($taskDescription);

    if ($task->UpdateTask()) {

      header("Location: tasks.php");
    }
  }
}

if (isset($_POST['sort'])) {
  $tasks = $task->getSortedTasks($_POST['sortby']);
} else {
  $tasks = $task->getFormattedTasks();
}



?>


<!DOCTYPE html>
<html lang="en">

<?php include('public/includes/head.php'); ?>

<body>
  <?php include('public/includes/nav.php'); ?>
  <div class="main-content">
    <div class="tasks-wrapper">
      <div id="row" class="row">
        <?php include('public/includes/taskForm.php'); ?>

        <?php include('public/includes/taskList.php'); ?>
      </div>
    </div>
  </div>
  <?php include('public/includes/footer.php'); ?>
  <script src="public/js/tasks.js"></script>
  <script src="public/js/imageUpload.js"></script>
</body>

</html>