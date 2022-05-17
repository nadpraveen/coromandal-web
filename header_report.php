<?php
ob_start();
session_start();
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
include 'assets/includes/Database.php';
include 'assets/includes/Message.php';
include 'assets/includes/function.php';
//include 'header_report.php';
if (!isset($_SESSION['user'])) {
    echo('please login');
    header("location:index.php");
} else {
    $user = $_SESSION['gl_no'];

    $q = "select * from th_member_master where GL_NO='$user'";
    $get_member_data = new Database;
    $get_member_data->query($q);
    $member_data = $get_member_data->resultset();
    foreach ($member_data as $row) {
        $ename = $row['EMP_NAME'];
    }
}
?>
<link href="assets/bs/css/bootstrap.min.css" rel="stylesheet">
<link href="assets/style.css" rel="stylesheet">
<style>
    body{
        white-space: nowrap;
        font-size: 1em;
    }
    .table-condensed>tbody>tr>td, .table-condensed>tbody>tr>th, .table-condensed>tfoot>tr>td, .table-condensed>tfoot>tr>th, .table-condensed>thead>tr>td, .table-condensed>thead>tr>th
    {
        padding: 0;
    }
    .table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th{
        padding: 0;
        border-top: none;
    }
    .sno{
        padding: 0px;
    }
    .wrap{
        margin-top: 60px;
    }
    @media print{
        .report{
            font-size: x-small;
        }
        .wrap{
            margin-top: 0;
        }
    }
</style>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="wrap">
                <table style="border: none">
                    <tr >
                        <td width='30%'><img class="img-responsive" src="assets/img/CFECS-LOGO.bmp" width="100" /></td>
                        <td  align="center" width='70%'>
                            <h4>Coromandel Fertilisers Employees Co-operative Society Ltd.,</h4>
                            <p align="center">
                                (REGD.NO.B-1444)<br>
                                <b align="center">Visakhapatnam - 530011</b>
                            </p>
                        </td>
                    </tr>
                </table>