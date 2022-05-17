<?php
ob_start();
session_start();
include 'header_report.php';
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
<style>
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
                <table class="table table-responsive" style="border: none">
                    <tr >
                        <td><img class="img-responsive" src="assets/img/CFECS-LOGO.bmp" width="80" height="100"/></td>
                        <td  align="center" colspan="3"><h4>Coromandel Fertilisers Employees Co-operative Society Ltd.,</h4>

                            <p align="center">(REGD.NO.B-1444)<br>
                                <b align="center">Visakhapatnam - 530011</b></p>
                        </td>
                    </tr>
                </table>
                <table class="table table-bordered table-responsive">
                    <tr>
                        <td>Name of the Member</td>
                        <td><strong><?php echo $row['EMP_NAME'] ?></strong></td>
                        <td>Gl No</td>
                        <td><strong><?php echo $row['GL_NO'] ?></strong></td>
                        <td>Emp No</td>
                        <td><strong><?php echo $row['EMP_NO'] ?></strong></td>
                    </tr>
                    <tr>
                        <td>Zone</td>
                        <td><strong><?php echo $row['ZONE'] ?></strong></td>
                    </tr>
                </table>
                <h5 class=" h5">Thrift Deposit Details</h5>
                <table class="table table-bordered table-responsive">
                    <?php 
                    $get_td_data = new Database;
                    $get_td_data->prepare("SELECT * FROM `th_thrift_deposit_master` where GL_NO = $user");
                    $td_data = $get_td_data->resultset();
                    foreach ($td_data as $td){
                        ?>
                    <tr>
                        <td>Balance as on <?php echo date('d-m-Y') ?></td>
                        <td><strong><?php echo $td['CLOSE_BAL'] ?></strong></td>
                        <td>Current Recovery Rate</td>
                        <td><strong><?php echo $td['RECOVERY_RATE'] ?></strong></td>
                    </tr>
                    <?php
                    }
                    ?>
                </table>
                
                <h5 class=" h5">Share Capital Details</h5>
                <table class="table table-bordered table-responsive">
                    <?php 
                    $get_share_data = new Database;
                    $get_share_data->prepare("SELECT * FROM `th_share_master` where GL_NO = $user");
                    $share_data = $get_share_data->resultset();
                    foreach ($share_data as $share){
                        ?>
                    <tr>
                        <td>Balance as on <?php echo date('d-m-Y') ?></td>
                        <td><strong><?php echo $share['CLOSE_BAL'] ?></strong></td>
                        
                    </tr>
                    <?php
                    }
                    ?>
                </table>
                <!-- Long Term Loan Details -->
                <?php 
                $get_loan_data_query = "SELECT * FROM `th_loan_master` where GL_NO = $user and LOAN_STATUS = 'R'";
                $get_loan_data = new Database;
                $get_loan_data->query($get_loan_data_query);
                $loan_count = $get_loan_data->count();
                if($loan_count > 0){
                    $loan_data = $get_loan_data->resultset();
                    foreach ($loan_data as $loan){
                    ?>
                <table class="table table-bordered table-responsive">
                    <tr>
                        <td colspan="8" align="center">
                            <strong>Long Term Loan Details</strong>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <strong>Loan Sanctioned</strong>
                        </td>
                        <td>
                            <?php echo $loan['LOAN_AMOUNT'] ; ?>
                        </td>
                        <td>
                            <strong>Loan Date</strong>
                        </td>
                        <td>
                            <?php echo date('d-m-Y', strtotime($loan['DATE_OF_SANCTION'])) ; ?>
                        </td>
                        <td>
                            <strong>Interest</strong>
                        </td>
                        <td>
                            <?php echo $loan['RATE_OF_INTREST'] ; ?>
                        </td>
                        <td>
                            <strong>Installments</strong>
                        </td>
                        <td>
                            <?php echo $loan['INSTALLMENTS'] ; ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <strong>Loan Bal (Prl)</strong>
                        </td>
                        <td>
                            <?php echo $loan['CBP'] ; ?>
                        </td>
                        <td>
                            <strong>Loan Bal (Int)</strong>
                        </td>
                        <td>
                            <?php echo $loan['CBI'] ; ?>
                        </td>
                        <td colspan="2">
                            <strong>Loan Balance</strong>
                        </td>
                        <td colspan="2">
                            <?php echo $loan['CBP'] + $loan['CBI']. ' (as on '. date('d-m-Y').')' ; ?>
                        </td>
                    </tr>
                    </tr>
                </table>
                <?php
                    }
                }
                ?>

                <!-- Short Term Loan Details -->
                <?php 
                $get_loan_data_query = "SELECT * FROM `th_ed_loan_master` where GL_NO = $user and LOAN_STATUS = 'R'";
                $get_loan_data = new Database;
                $get_loan_data->query($get_loan_data_query);
                $loan_count = $get_loan_data->count();
                if($loan_count > 0){
                    $loan_data = $get_loan_data->resultset();
                    foreach ($loan_data as $loan){
                    ?>
                <table class="table table-bordered table-responsive">
                    <tr>
                        <td colspan="8" align="center">
                            <strong>Short Term Loan Details</strong>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <strong>Loan Sanctioned</strong>
                        </td>
                        <td>
                            <?php echo $loan['LOAN_AMOUNT'] ; ?>
                        </td>
                        <td>
                            <strong>Loan Date</strong>
                        </td>
                        <td>
                            <?php echo date('d-m-Y', strtotime($loan['DATE_OF_SANCTION'])) ; ?>
                        </td>
                        <td>
                            <strong>Interest</strong>
                        </td>
                        <td>
                            <?php echo $loan['RATE_OF_INTREST'] ; ?>
                        </td>
                        <td>
                            <strong>Installments</strong>
                        </td>
                        <td>
                            <?php echo $loan['INSTALLMENTS'] ; ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <strong>Loan Bal (Prl)</strong>
                        </td>
                        <td>
                            <?php echo $loan['CBP'] ; ?>
                        </td>
                        <td>
                            <strong>Loan Bal (Int)</strong>
                        </td>
                        <td>
                            <?php echo $loan['CBI'] ; ?>
                        </td>
                        <td colspan="2">
                            <strong>Loan Balance</strong>
                        </td>
                        <td colspan="2">
                            <?php echo $loan['CBP'] + $loan['CBI']. ' (as on '. date('d-m-Y').')' ; ?>
                        </td>
                    </tr>
                    </tr>
                </table>
                <?php
                    }
                }
                ?>
                
                <!-- Artical Loan Details -->
                <?php 
                $get_loan_data_query = "SELECT * FROM `th_arti_loan_master` where GL_NO = $user and LOAN_STATUS = 'R'";
                $get_loan_data = new Database;
                $get_loan_data->query($get_loan_data_query);
                $loan_count = $get_loan_data->count();
                if($loan_count > 0){
                    $loan_data = $get_loan_data->resultset();
                    foreach ($loan_data as $loan){
                    ?>
                <table class="table table-bordered table-responsive">
                    <tr>
                        <td colspan="8" align="center">
                            <strong>Article Loan Details</strong>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <strong>Loan Sanctioned</strong>
                        </td>
                        <td>
                            <?php echo $loan['LOAN_AMOUNT'] ; ?>
                        </td>
                        <td>
                            <strong>Loan Date</strong>
                        </td>
                        <td>
                            <?php echo date('d-m-Y', strtotime($loan['DATE_OF_SANCTION'])) ; ?>
                        </td>
                        <td>
                            <strong>Interest</strong>
                        </td>
                        <td>
                            <?php echo $loan['RATE_OF_INTREST'] ; ?>
                        </td>
                        <td>
                            <strong>Installments</strong>
                        </td>
                        <td>
                            <?php echo $loan['INSTALLMENTS'] ; ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <strong>Loan Bal (Prl)</strong>
                        </td>
                        <td>
                            <?php echo $loan['CBP'] ; ?>
                        </td>
                        <td>
                            <strong>Loan Bal (Int)</strong>
                        </td>
                        <td>
                            <?php echo $loan['CBI'] ; ?>
                        </td>
                        <td colspan="2">
                            <strong>Loan Balance</strong>
                        </td>
                        <td colspan="2">
                            <?php echo $loan['CBP'] + $loan['CBI']. ' (as on '. date('d-m-Y').')' ; ?>
                        </td>
                    </tr>
                    </tr>
                </table>
                <?php
                    }
                }
                ?>
                
                <!-- Mortgage Vehicle Loan -->
                 <?php 
                $get_loan_data_query = "SELECT * FROM `th_vehi_loan_master` where GL_NO = $user and LOAN_STATUS = 'R'";
                $get_loan_data = new Database;
                $get_loan_data->query($get_loan_data_query);
                $loan_count = $get_loan_data->count();
                if($loan_count > 0){
                    $loan_data = $get_loan_data->resultset();
                    foreach ($loan_data as $loan){
                    ?>
                <table class="table table-bordered table-responsive">
                    <tr>
                        <td colspan="8" align="center">
                            <strong>Mortgage Vehicle Loan Details</strong>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <strong>Loan Sanctioned</strong>
                        </td>
                        <td>
                            <?php echo $loan['LOAN_AMOUNT'] ; ?>
                        </td>
                        <td>
                            <strong>Loan Date</strong>
                        </td>
                        <td>
                            <?php echo date('d-m-Y', strtotime($loan['DATE_OF_SANCTION'])) ; ?>
                        </td>
                        <td>
                            <strong>Interest</strong>
                        </td>
                        <td>
                            <?php echo $loan['RATE_OF_INTREST'] ; ?>
                        </td>
                        <td>
                            <strong>Installments</strong>
                        </td>
                        <td>
                            <?php echo $loan['INSTALLMENTS'] ; ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <strong>Loan Bal (Prl)</strong>
                        </td>
                        <td>
                            <?php echo $loan['CBP'] ; ?>
                        </td>
                        <td>
                            <strong>Loan Bal (Int)</strong>
                        </td>
                        <td>
                            <?php echo $loan['CBI'] ; ?>
                        </td>
                        <td colspan="2">
                            <strong>Loan Balance</strong>
                        </td>
                        <td colspan="2">
                            <?php echo $loan['CBP'] + $loan['CBI']. ' (as on '. date('d-m-Y').')' ; ?>
                        </td>
                    </tr>
                    </tr>
                </table>
                <?php
                    }
                }
                ?>
                
                <!-- Education Loan Details -->
                <?php 
                $get_loan_data_query = "SELECT * FROM `th_ed_loan_master` where GL_NO = $user and LOAN_STATUS = 'R'";
                $get_loan_data = new Database;
                $get_loan_data->query($get_loan_data_query);
                $loan_count = $get_loan_data->count();
                if($loan_count > 0){
                    $loan_data = $get_loan_data->resultset();
                    foreach ($loan_data as $loan){
                    ?>
                <table class="table table-bordered table-responsive">
                    <tr>
                        <td colspan="8" align="center">
                            <strong>Education Loan Details</strong>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <strong>Loan Sanctioned</strong>
                        </td>
                        <td>
                            <?php echo $loan['LOAN_AMOUNT'] ; ?>
                        </td>
                        <td>
                            <strong>Loan Date</strong>
                        </td>
                        <td>
                            <?php echo date('d-m-Y', strtotime($loan['DATE_OF_SANCTION'])) ; ?>
                        </td>
                        <td>
                            <strong>Interest</strong>
                        </td>
                        <td>
                            <?php echo $loan['RATE_OF_INTREST'] ; ?>
                        </td>
                        <td>
                            <strong>Installments</strong>
                        </td>
                        <td>
                            <?php echo $loan['INSTALLMENTS'] ; ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <strong>Loan Bal (Prl)</strong>
                        </td>
                        <td>
                            <?php echo $loan['CBP'] ; ?>
                        </td>
                        <td>
                            <strong>Loan Bal (Int)</strong>
                        </td>
                        <td>
                            <?php echo $loan['CBI'] ; ?>
                        </td>
                        <td colspan="2">
                            <strong>Loan Balance</strong>
                        </td>
                        <td colspan="2">
                            <?php echo $loan['CBP'] + $loan['CBI']. ' (as on '. date('d-m-Y').')' ; ?>
                        </td>
                    </tr>
                    </tr>
                </table>
                <?php
                    }
                }
                ?>
                
                <h5>Recovery Details</h5>
                
            </div>
        </div>
    </div>
    <div class="row hidden-print">
        <script type="text/javascript">
            function hideme() {
                document.getElementById('printing').style.visibility = 'hidden';
            }

            function hideme_div() {
                document.getElementById('click').style.visibility = 'hidden';
            }

            function closewin() {
                window.close();
            }
        </script>
        <div class="col-md-12">
            <div class="col-md-6">
                <a class="btn btn-primary form-control" href="javascript:window.print();">Print</a>
            </div>
            <div class="col-md-6" align="right">
                <button class="btn btn-danger form-control" onclick="closewin()">Close</button>
            </div>                        
        </div>
        <br>
        <br>
    </div>
</div>