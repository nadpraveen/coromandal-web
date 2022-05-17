<?php
ob_start();
session_start();
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
include 'assets/includes/Database.php';
include 'assets/includes/Message.php';
include 'assets/includes/function.php';
include 'assets/includes/Hash.php';
include 'assets/includes/cookie.php';
include 'assets/includes/sanitize.php';
//print_r($_SESSION);
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title>Coromandel Fertilisers Employees 
            Co-operative Society Ltd.,</title>

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
        if (isset($_SESSION['user'])) {
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
                        <a class="navbar-brand" href="#">Coramandal Co-op Society</a>
                    </div>

                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

                        <ul class="nav navbar-nav navbar-right">
                            <li><a href="user_home.php">User Info</a></li>

                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Loans <span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <li><a href="loan.php">Long term Loan</a></li>
                                    <li><a href="educational_loan.php">Educational Loan</a></li>
                                    <li><a href="article_loan.php">Article Loan</a></li>                            
                                    <li><a href="mv_loan.php">Mortgage Loan</a></li>
                                    <li><a href="spl_loan.php">Short Term Loan</a></li>
                                    <li><a href="veh_loan.php">Vehicle Loan</a></li>
                                    <li><a href="sur_data.php">Surity Info</a></li>
                                    <li><a href="emi_table.php">Emi Calculator</a></li>
                                </ul>
                            </li>

                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Deposits <span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <li><a href="thrift_deposit.php">Thrift Deposit</a></li>
                                    <li><a href="rd.php">RD</a></li>
                                    <li><a href="fixed_deposit.php">Fixed Deposit</a></li>                                   
                                    <li><a href="term_deposit.php">Term Deposit</a></li>
                                    <li><a href="addl_deposit.php">Addl Deposit</a></li>
                                    <li><a href="share.php">Share Capital</a></li>

                                </ul>
                            </li>
                            <li><a href="circulers.php">Circulers</a></li>
                            <li><a href="int_data.php">Interest Rates</a></li>
                            <li class="disabled"><a href="gallary.php">Gallary</a></li>
                            <li><a href="change_pass.php">Change Password</a></li>
                            <li><a href="logout.php">Logout</a></li>
                        </ul>
                        <?php
                    }
                    ?>
                </div><!-- /.navbar-collapse -->
            </div><!-- /.container-fluid -->
        </nav>


        <?php
        if (isset($_SESSION['user'])) {
            ?>
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <?php
                    $get_scrole = new Database;
                    $get_scrole->query("SELECT * FROM `scrol_text` ORDER BY id DESC LIMIT 1");
                    $scrole_count = $get_scrole->count();
                    if ($scrole_count > 0) {
                        $scroles = $get_scrole->resultset();
                        foreach ($scroles as $scrole) {
                            if ($scrole['link'] == '#') {
                                ?>
                                <marquee direction = "left" onmouseover="this.stop();" onmouseout="this.start();">
                                    <h5><a style="color: red; font-size: large; font-weight: bold;" href="<?php echo $scrole['link'] ?>"><?php echo $scrole['scrole_text'] ?></a></h5>
                                </marquee>
                                <?php
                            } elseif ($scrole['link'] != '#' || $scrole['link'] != '') {
                                ?>
                                <marquee direction = "left" onmouseover="this.stop();" onmouseout="this.start();">
                                    <h5><a style="color: red; font-size: large; font-weight: bold;" href="admin/<?php echo $scrole['link'] ?>" target="_blank"><?php echo $scrole['scrole_text'] ?></a></h5>
                                </marquee>
                                <?php
                            }
                        }
                    }
                    ?>
                </div>
            </div>
            <?php
        }
        ?>
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
        }if (isset($_SESSION['user'])) {
            ?>
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-info">
                            <div class="panel-heading">Welcome <?php echo $_SESSION['user'] ?>, <?php echo $_SESSION['name'] ?></div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
        ?>
      