<?php
include(__DIR__ . '/classes/Session.php');
include(__DIR__ . '/classes/User.php');

session_start();



$user->setLastLogin();



$user->logout();

setcookie("timers", "", time() - 3600);
setcookie('elapsedTime', '', time() - 3600);

header("Location: login.php");
