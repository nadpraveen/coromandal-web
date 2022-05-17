<?php

session_start();
spl_autoload_register(function($class) {
    require_once 'assets/includes/' . $class . '.php';
}
);
$user_id = $_SESSION['id'];
$delete_hash = new Database;
$delete_hash->query("delete from user_session where user_id = '$user_id'");
session_destroy();
cookie::delete('hash');
header("location:index.php");
?>