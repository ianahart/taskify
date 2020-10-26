<?php



class TaskValidator
{
  private $title;
  private $description;
  public $errors = [];

  public function __construct($title, $description)
  {
    $this->title = $title;
    $this->description = $description;
  }

  public function validateForm()
  {
    $this->validateTitle();
    $this->validateDescription();

    return $this->errors;
  }

  private function validateTitle()
  {
    $title = trim($this->title);
    if (empty($title)) {

      $this->addError('title', 'Please fill out the title field');
    } else if (strlen($title) < 6) {

      $this->addError('title', 'Title must be a minimum of 6 characters');
    } else if (strlen($title) > 35) {

      $this->addError('title', 'Title must not exceed 35 characters');
    } else if (preg_match('/[\'\/~`\!@#\$%\^&\*\(\)_\-\+=\{\}\[\]\|;:"\<\>,\.\?\\\]/', $title)) {

      $this->addError('title', 'Please exclude special characters in the title');
    }
  }
  private function validateDescription()
  {
    $description = trim($this->description);

    if (empty($description)) {

      $this->addError('description', 'Please fill out the description field');
    } else if (strlen($description) < 6) {

      $this->addError('description', 'Description must be a minimum of 6 characters');
    } else if (strlen($description > 50)) {

      $this->addError('description', 'Description must not exceed 50 characters');
    }
  }

  public function addError($key, $value)
  {
    $this->errors[$key] = $value;
  }
}
