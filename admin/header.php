<?php
ob_start();
session_start(); 
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
include 'assets/includes/Database.php';
include 'assets/includes/Message.php';
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title>Coramandal Employees Co-op THrift and Credit Society -- Admin Panel </title>

        <!-- Bootstrap -->
        <link href="assets/bs/css/bootstrap.min.css" rel="stylesheet">
        <link href="assets/style.css" rel="stylesheet">

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
        <?php
        if (isset($_SESSION['admin'])) {
            ?>
            <nav class="navbar navbar-inverse ">
                <div class="container-fluid">
                    <!-- Brand and toggle get grouped for better mobile display -->
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="#">Coramandal Co-op Thrift Society</a>
                    </div>

                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

                        <ul class="nav navbar-nav navbar-right">
                            <li><a href="admin_home.php?menu=scroll">Scroll</a></li>
                            <li><a href="admin_home.php?menu=circuler">Circular</a></li>
                            <li><a href="admin_home.php?menu=loan_info">Loan Info</a></li>
                            <li><a href="admin_home.php?menu=int_data">Interest Data</a></li>
                            <li><a href="admin_home.php?menu=reset_pass">Reset Password</a></li>
                            <li><a href="logout.php">Logout</a></li>
                        </ul>
                        <?php
                    }
                    ?>
                </div><!-- /.navbar-collapse -->
            </div><!-- /.container-fluid -->
        </nav>
        <?php
        if (isset($_SESSION['message'])) {
            ?>
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <?php
                        Message::display();
                        unset($_SESSION['message']);
                        ?>
                    </div>
                </div>
            </div>
            <?php
        }
      