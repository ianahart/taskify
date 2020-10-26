<?php

$request = $_SERVER['REQUEST_URI'];

switch ($request) {
  case '/':
    include __DIR__ . '/public/home.php';
    break;

  case '/home.php':
    include __DIR__ . '/public/home.php';
    break;
  case '/login.php':
    include __DIR__ . '/public/login.php';
    break;
  case '/logout.php':
    include __DIR__ . '/public/logout.php';
    break;
  case '/register.php':
    include __DIR__ . '/public/register.php';
    break;
  case '/processTaskForm.php':
    include __DIR__ . '/public/processTaskForm.php';
    break;
  case '/tasks.php':
    include __DIR__ . '/public/tasks.php';
    break;
}
