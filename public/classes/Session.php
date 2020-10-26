<?php

class Session

{
  private static $_instance = null;

  public static function get($name)
  {
    return $_SESSION[$name];
  }

  public static function set($name, $value)
  {
    return $_SESSION[$name] = $value;
  }

  public static function exists($name)
  {
    return isset($_SESSION[$name]) ? true : false;
  }

  public static function delete($name)
  {
    if (self::exists($name)) {
      unset($_SESSION[$name]);
    }
  }

  public static function getInstance()
  {
    if (!isset(self::$_instance)) {
      self::$_instance = new Session();
    }
    return self::$_instance;
  }
}
