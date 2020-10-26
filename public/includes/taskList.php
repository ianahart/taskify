<div class="list force-overflow">
  <?php if (count($tasks) === 0) : ?>
    <h2><?php echo Session::get('userName'); ?>, your list appears empty.</h2>
  <?php else : ?>
    <h2><?php echo Session::get('userName'); ?>, Your List...</h2>
    <div class="sort-tasks">
      <form action="tasks.php" method="POST">
        <select name="sortby">
          <!-- <option selected disabled hidden>Sort Tasks</option> -->
          <option value="DESC">Newest to Oldest</option>
          <option value="ASC">Oldest to Newest</option>
          <option value="title ASC">By Title A&#8594;Z</option>
          <option value="title DESC">By Title Z&#8594;A</option>
        </select>
        <button type="submit" name="sort"><i class="fas fa-filter"></i> Sort</button>
      </form>
    </div>
  <?php endif; ?>

  <?php foreach ($tasks as $taskItem) : ?>
    <?php if ($taskItem['completed'] === 'false') : ?>
      <div class="modal hidden">
        <div class="inner-modal-content">
          <form class="edit-form" action="tasks.php" method="POST" class="edit-form">
            <h2>Editing task "<?php echo htmlspecialchars($taskItem['title']); ?>"</h2>
            <div class="edit-form-wrapper">
              <div class="input-group">
                <label>Task title:</label>
                <input type="text" name="edit_title" value="<?php echo htmlspecialchars($taskItem['title']); ?>" />
                <p class="edit-form-error title-error"></p>
              </div>
              <div class="input-group">
                <label>Task description:</label>
                <input type="text" name="edit_description" value="<?php echo htmlspecialchars($taskItem['description']); ?>" />
                <p class="edit-form-error description-error"></p>
              </div>
              <input type="hidden" name="taskid" value="<?php echo $taskItem['id']; ?>" />
              <div class="edit-btn-container">
                <button type="submit" name="edit"><i class="fas fa-pen"></i> Edit</button>
                <button class="cancel-edit">Cancel</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    <?php endif; ?>
    <div class="list-item">
      <div class="task-column">
        <p class="date"><i class="far fa-calendar-alt calendar-icon"></i> <?php echo htmlspecialchars($taskItem['created_at']); ?></p>
        <?php if ($taskItem['completed'] === 'false') : ?>
          <div class="edit-icon-container">
            <p class="edit-tooltip hidden">Edit Task</p>
            <i class="far fa-edit edit-icon"></i>
          </div>
        <?php endif; ?>
        <?php if (isset($taskItem['image'])) : ?>
          <div class="task-image-container">
            <img class="task-image" src="<?php echo htmlspecialchars($task->getTaskImage($taskItem['image'])); ?>" alt="<?php echo htmlspecialchars($taskItem['title']); ?>" />
          </div>
        <?php endif; ?>
        <p><span class="marker">Title:</span><span class="title"><?php echo htmlspecialchars($taskItem['title']); ?></span></p>
        <p><span class="marker">Description:</span><span class="description"><?php echo htmlspecialchars($taskItem['description']); ?></span></p>
      </div>
      <div class="actions-column">
        <form class="remove-form" action="tasks.php" method="POST">
          <input type="hidden" name="taskID" value="<?php echo htmlspecialchars($taskItem['id']); ?>" />
          <button class="remove-button" type="submit" name="remove"><i class="fas fa-times"></i></button>
        </form>
        <?php if ($taskItem['completed'] == 'false') : ?>
          <div class="timer-container">
            <?php if (is_null($taskItem['time_to_complete'])) : ?>
              <p class="time-up">Time is up!</p>
            <?php else : ?>
              <p class="time" data-id="<?php echo $taskItem['id']; ?>" data-timer="<?php echo $taskItem['time_to_complete']; ?>"></p>
            <?php endif; ?>
          </div>
        <?php endif; ?>
        <form action="tasks.php" method="POST">
          <input type="hidden" name="completed" value="<?php echo htmlspecialchars($taskItem['id']); ?>" />
          <?php if ($taskItem['completed'] === 'true') : ?>
            <div class="completed"><i class="fas fa-check"></i> Completed</div>
          <?php else : ?>
            <button class="uncompleted-button" type="submit" name="status">Not Completed</button>
          <?php endif; ?>
        </form>
      </div>
    </div>
  <?php endforeach; ?>
</div>