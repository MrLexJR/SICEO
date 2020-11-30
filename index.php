<?php
  session_start();
  if (!isset($_SESSION['username'])) {
    header("location: login.php");
  } else{ 
    require_once('layouts/layout.php');	
  }
?>


