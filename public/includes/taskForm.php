<div class="form-container">
  <form action="tasks.php" method="POST" enctype="multipart/form-data">
    <h2>What do you need to do?</h2>
    <div class="input-group">
      <label>Task title:</label>
      <input type="text" name="title" value="<?php echo isset($_POST['title']) ? htmlspecialchars($_POST['title']) : ''; ?>" />
      <div class="form-error">
        <?php echo $errors['title'] ?? ''; ?>
      </div>
    </div>
    <div class="input-group">
      <label>Task description:</label>
      <input type="text" name="description" value="<?php echo isset($_POST['description']) ? htmlspecialchars($_POST['description']) : ''; ?>" />
      <div class="form-error">
        <?php echo $errors['description'] ?? ''; ?>
      </div>
    </div>
    <div class="input-group">
      <div class="upload-box">
        <div class="border">
          <i class="fas fa-upload upload-icon"></i>
          <i class="fas fa-plus upload-plus-icon hidden"></i>
          <label for="upload">Choose an image or drag it here</label>
          <input id="upload" class="upload-input" type="file" name="file" />
        </div>
      </div>
    </div>
    <div class="range-slider">
      <label>Time to complete: <span class="time-to-complete">1 day</span></label>
      <input class="slider" type="range" name="time_to_complete" value="1" min="1" max="14" />
    </div>

    <div class="task-button-container">
      <button type="submit" name="submit"><i class="fas fa-plus"></i> Add Task</button>
    </div>
  </form>
</div>