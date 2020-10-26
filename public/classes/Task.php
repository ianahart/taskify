<?php
include(__DIR__ . '/../../config/db.php');

class Task
{
  private $db;
  private $title;
  private $description;
  private $image;
  private $taskID;
  private $completed;
  private $userId;
  private $days;
  private $created_at;



  public function __construct($DB_con)
  {
    $this->db = $DB_con;
  }

  public function setDays($days)
  {
    $this->days = $days;
  }

  public function setCreatedAt()
  {

    $this->created_at = date('Y-m-d h-i-s ', time());
  }

  public function setTaskImage()
  {

    $file = $_FILES['file']['name'];
    $localFilePath = 'public/images/' . $file;
    $fileFullPath = $_SERVER['DOCUMENT_ROOT'] . '/todo-app-oop-prod/public/images/' . $file;
    $this->image = $localFilePath;
    if (move_uploaded_file($_FILES['file']['tmp_name'], $fileFullPath)) {

      // switch out localFilePath with fileFullPath on production

    }
  }

  private function setSeconds()
  {
    $seconds = $this->days * 86400;
    $this->seconds = $this->secondsToTime($seconds);
  }

  public function setUserId($id)
  {
    $this->userId = $id;
  }

  public function setTaskTitle($title)
  {
    $this->title = ucwords($title);
  }

  public function setTaskCompleted($status)
  {
    $this->completed = $status;
  }

  public function setTaskDescription($description)
  {
    $this->description = ucfirst($description);
  }

  public function setTaskID($ID)
  {
    $this->taskID = $ID;
  }

  public function addTask()
  {
    $this->setSeconds();


    try {
      $sql = "INSERT INTO tasks(title, description, image, user_id, time_to_complete, created_at)
    VALUES(:title, :description, :image, :user_id, :time_to_complete, :created_at)";

      $stmt = $this->db->prepare($sql);

      $stmt->bindParam(':title', $this->title);
      $stmt->bindParam(':description', $this->description);
      $stmt->bindParam(':image', $this->image);
      $stmt->bindParam(':user_id', $this->userId);
      $stmt->bindParam(':time_to_complete', $this->seconds);
      $stmt->bindParam(':created_at', $this->created_at);

      $stmt->execute();
    } catch (PDOException $e) {
      echo $e->getMessage();
    }
  }

  private function getAllTasks()
  {
    try {
      $sql = "SELECT * FROM tasks WHERE user_id = '$this->userId'";

      $stmt = $this->db->prepare($sql);

      $stmt->execute();

      $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

      return $result;
    } catch (PDOException $e) {
      echo $e->getMessage();
    }
  }

  public function getSortedTasks($sort)
  {
    try {
      if (strpos($sort, 'title') !== false) {

        [$sortFlag, $order] = explode(' ', $sort);

        $sql = "SELECT * FROM tasks WHERE user_id = '$this->userId' ORDER BY $sortFlag $order";
      } else {

        $sql = "SELECT * FROM tasks WHERE user_id = '$this->userId' ORDER BY created_at $sort";
      }
      $stmt = $this->db->prepare($sql);

      $stmt->execute();

      $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);

      $formattedTasks = array_map(
        function ($task) {

          return $this->formatTask($task);
        },
        $tasks
      );

      return $formattedTasks;
    } catch (PDOException $e) {

      echo $e->getMessage();
    }
  }

  private function formatTask($row)
  {

    $month = date('m', strtotime($row['created_at']));

    $day = date('d', strtotime($row['created_at']));

    $createdAt = $month . "/" . $day;

    $formatted = array_combine(
      array_keys($row),

      array_map(function ($key, $field) use ($createdAt) {
        if ($key === 'created_at') {
          $field = $createdAt;

          return $field;
        } else {

          return $field;
        }
      }, array_keys($row), $row)
    );

    return $formatted;
  }

  public function getFormattedTasks()
  {
    $tasks = $this->getAllTasks();

    $formattedTasks = array_map(function ($task) {

      return $this->formatTask($task);
    }, $tasks);

    return $formattedTasks;
  }

  private function getTask($id)
  {
    $sql = "SELECT * FROM tasks where id = '$id'";

    $stmt = $this->db->prepare($sql);

    $stmt->execute();

    $task = $stmt->fetch(PDO::FETCH_ASSOC);

    return $task;
  }

  public function removeTask()
  {
    $taskImageToDelete = $this->getTask($this->taskID)['image'];

    if (isset($taskImageToDelete)) {
      unlink($taskImageToDelete);
    }


    $sql = "DELETE FROM tasks WHERE id = '$this->taskID'";

    $stmt = $this->db->prepare($sql);

    $stmt->execute();
  }

  public function updateTask()
  {
    $sql = "UPDATE tasks SET title = '$this->title', description = '$this->description' WHERE id = '$this->taskID'";

    $stmt = $this->db->prepare($sql);

    $stmt->execute();
  }


  public function updateTaskCompleted()
  {
    $sql = "UPDATE tasks SET completed = '$this->completed', time_to_complete = NULL WHERE id = '$this->taskID'";

    $stmt = $this->db->prepare($sql);

    $stmt->execute();
  }



  public function updateTimers($timers, $elapsedTime = null)
  {
    foreach ($timers as $timer) {

      $time = $timer['timer'];
      $taskID = $timer['timerId'];

      if ($timer['timer'] === 'Time is up!') {

        $taskIDNull = $timer['timerId'];
        $sql = "UPDATE tasks SET time_to_complete = NULL WHERE id = '$taskIDNull'";

        $stmt = $this->db->prepare($sql);

        $stmt->execute();
      } else {
        if (is_null($elapsedTime)) {

          $sql = "UPDATE tasks SET time_to_complete = '$time' WHERE id='$taskID'";
        } else {
          $totalSeconds = $this->timerToSeconds($time, $elapsedTime);

          $formattedTime = $this->secondsToTime($totalSeconds);

          $sql = "UPDATE tasks SET time_to_complete = '$formattedTime' WHERE id='$taskID'";
        }
        $stmt = $this->db->prepare($sql);

        $stmt->execute();
      }
    }
  }

  private function getTimers($userId)
  {
    $sql = "SELECT time_to_complete, id FROM tasks WHERE user_id = '$userId' AND completed = 'false' AND time_to_complete IS NOT NULL";

    $stmt = $this->db->prepare($sql);

    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  private function timerToSeconds($timer, $elapsedTime, $id = null)
  {

    $countDown = explode(' ', preg_replace('/[^0-9]/i', ' ', $timer));

    $countDown = array_values(array_filter($countDown, function ($el) {
      return $el !== '';
    }));

    $countDown = array_combine(['days', 'hours', 'mins', 's'], $countDown);

    $timerInSeconds = ($countDown['days'] * 86400) +
      ($countDown['hours'] * 60 * 60) +
      ($countDown['mins'] * 60) +
      ($countDown['s']);

    $updatedTime =  $timerInSeconds - (time() - $elapsedTime);

    if ($updatedTime <= 0) {

      $sql = "UPDATE tasks SET time_to_complete = NULL WHERE id = '$id'";

      $stmt = $this->db->prepare($sql);

      $stmt->execute();
    } else {
      return $updatedTime;
    }
  }

  private function secondsToTime($totalSeconds)
  {
    $day = floor($totalSeconds / 86400);
    $hours = floor(($totalSeconds - ($day * 86400)) / 3600);
    $minutes = floor(($totalSeconds / 60) % 60);
    $seconds = $totalSeconds % 60;

    return $day . "d " . $hours . "hrs " . $minutes . "mins " . $seconds . "s";
  }

  public function setTimers($userId, $elapsedTime)
  {

    $timers =  $this->getTimers($userId);

    foreach ($timers as $timer) {
      $totalSeconds = $this->timerToSeconds($timer['time_to_complete'], $elapsedTime, $timer['id']);

      $formattedTime = $this->secondsToTime($totalSeconds);

      $taskId = $timer['id'];

      $sql = "UPDATE tasks SET time_to_complete = '$formattedTime' WHERE user_id = '$userId' AND id='$taskId'";

      $stmt = $this->db->prepare($sql);

      $stmt->execute();
    }
  }
}
