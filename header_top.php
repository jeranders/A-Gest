<?php include 'bdd.php';
session_start();

if (isset($_SESSION['id_membre']) == '' ) {
	header('Location:login.php');
	die();
}

 ?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    