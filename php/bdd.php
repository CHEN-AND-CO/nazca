<?php
/**
 * @Author: Le Torc'h Kévin
 * @Company: Chen & Co
 * @Email: kev29lt@gmail.com
 */
  require_once('constantes.php');

  function dbConnect(){
    try
    {
      $db = new PDO('mysql:host='.DB_SERVER.';dbname='.DB_NAME.';charset=utf8',
        DB_USER, DB_PASSWORD);
    }
    catch (PDOException $exception)
    {
      error_log('Connection error: '.$exception->getMessage());
      return false;
    }
    return $db;
  }

  ?>