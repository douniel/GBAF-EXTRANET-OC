<?php
session_start();

if (!isset($_SESSION['auth']['username'])) {
  header('Location: index.php');
  exit;
}

unset($_SESSION['auth']);
header('Location: index.php');