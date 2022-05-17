<?php

ob_start();
session_start();
include 'assets/includes/Database.php';
include 'assets/includes/Message.php';

if (!isset($_SESSION['admin'])) {
    header("location:../index.php");
}
if (!isset($_GET['id']) || !isset($_GET['type'])) {
    header("location:../index.php");
}

$doc_type = $_GET['type'];
$id = $_GET['id'];

if ($doc_type === 'circuler') {
    $del_circuler = new Database;
    $del_circuler->prepare("delete from circulers where id = :id");
    $del_circuler->bind(":id", $id);
    $del_circuler->execute();
    Message::setmsg("deleted successfully", "error");
    header("location:admin_home.php?menu=circuler");
} elseif ($doc_type === 'loan') {
    $del_circuler = new Database;
    $del_circuler->prepare("delete from loan_data where id = :id");
    $del_circuler->bind(":id", $id);
    $del_circuler->execute();
    Message::setmsg("deleted successfully", "error");
    header("location:admin_home.php?menu=loan_info");
}


       