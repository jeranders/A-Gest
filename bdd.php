<?php
try{
	$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
	$pdo_options[PDO::MYSQL_ATTR_INIT_COMMAND] = 'SET NAMES utf8';
	$bdd = new PDO('mysql:host=localhost;dbname=commerce', 'root', '', $pdo_options);
	$bdd->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
	$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
}catch (Exception $e){
	die('Erreur : ' . $e->getMessage());
}
// try{
// 	$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
// 	$pdo_options[PDO::MYSQL_ATTR_INIT_COMMAND] = 'SET NAMES utf8';
// 	$bdd = new PDO('mysql:host=mysql.hostinger.fr;dbname=u269251321_easy', 'u269251321_easy', 'ch0caPIc$', $pdo_options);
// 	$bdd->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
// 	$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
// }catch (Exception $e){
// 	die('Erreur : ' . $e->getMessage());
// }
