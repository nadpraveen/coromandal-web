<?php include 'header_report.php'; ?>

<table class="table table-bordered table-condensed report">
    <tr>
        <td colspan="6" align="center"><h4 style=" font-weight: bold"> Loan Statement</h4></td>
    </tr>
    <?php
    $q = "select * from th_member_master where GL_NO='$user'";
    $get_member_data = new Database;
    $get_member_data->query($q);
    $member_data = $get_member_data->resultset();
    foreach ($member_data as $row) {
        
    }
    ?>
    <tr>
        <td>Name of the Member</td><td><?php echo $ename ?></td>
        <td>GL No</td><td><?php echo $row['GL_NO'] ?></td>
        <td>Emp No</td><td><?php echo $row['EMP_NO'] ?></td>
    </tr>
    <tr>
        <td>Designation</td><td><?php echo $row['DESIG'] ?></td>
        <td>Department</td><td><?php echo $row['DEPT'] ?></td>
    </tr>
</table>
<?php
$loan_number = $_GET['loan_no'];
$fetch_loan_data = new Database;
$fetch_loan_data->prepare("SELECT * FROM `th_loan_master` where GL_NO = $user AND LOAN_NO = $loan_number ORDER BY `DATE_OF_SANCTION` DESC");
$loan_data = $fetch_loan_data->resultset();
foreach ($loan_data as $loan_data) {
    ?>
    <table class="table table-bordered table-condensed report">
        <tr>
            <td colspan="8" align="center"> <h5 style="padding: 0; margin: 0">Loan Sanction Details</h5></td>
        </tr>
        <tr>
            <td>Loan Amount</td><td> <?php echo round($loan_data['LOAN_AMOUNT'], 0) ?></td>
            <td>Sanctioned Date</td><td> <?php echo date('d-m-Y', strtotime($loan_data['DATE_OF_SANCTION'])) ?></td>
            <td>Interest Rate</td><td> <?php echo $loan_data['RATE_OF_INTREST'] ?></td>
            <td>No. Installments</td><td> <?php echo $loan_data['INSTALLMENTS'] ?></td>

        </tr>
        <tr>
            <td>Loan No</td><td><?php echo $loan_data['LOAN_NO'] ?></td>
            <td>Old Loan Adjusted</td><td><?php echo round($loan_data['ADJ_LOAN_P'] + $loan_data['ADJ_LOAN_I'] + $loan_data['ADJ_SHR'], 0) ?></td>
            <td>Net Amount</td><td><?php echo round($loan_data['LOAN_AMOUNT'] - ($loan_data['ADJ_LOAN_P'] + $loan_data['ADJ_LOAN_I'] + $loan_data['ADJ_SHR']), 0) ?> </td>
            <td>Recovery Rate</td><td><?php echo round($loan_data['REC_RATE_CUR'], 0) ?></td>
        </tr>
    </table>

    <?php
}
?>


<table class="table table-bordered table-condensed ">
    <tr>
        <td colspan="3" align="center" >
            <h5 style="font-size: small; padding: 0; margin: 0;">Balance as on <?php echo date('d-m-Y') ?> </h5>  
        </td>
    <tr>
        <?php
        if ($loan_data['LOAN_STATUS'] == 'R') {
            ?>
            <td>Principle Balance : <?php echo round($loan_data['CBP'], 0) ?></td>
            <td>Interest Balance : <?php echo round($loan_data['CBI'], 0) ?></td>
            <td>Total Balance : <?php echo round($loan_data['CBP'] + $loan_data['CBI'], 0) ?></td>
            <?php
        } else {
            ?>
            <td colspan="3"> <h5 align="center" style="font-weight: bold">Loan is closed on <?php echo date('d-m-Y', strtotime($loan_data['CLOSE_DATE'])) ?> </h5> </td>
            <?php
        }
        ?>
    </tr>

</tr>
</table>

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12" align="center"> 
        <h5>Loan Repayment Details</h5>
    </div>

    <div style="width: 33.3%; float: left">
        <div class="sno" style="width: 15%; border: 1px solid ;display: block;float: left"><strong>S.NO</strong></div>
        <div style="width: 25%; border: 1px solid ;display: block;float: left"><strong>Date</strong></div>
        <div style="width: 25%; border: 1px solid ;display: block;float: left"><strong>Princple</strong></div>
        <div style="width: 25%; border: 1px solid ;display: block;float: left"><strong>Interest</strong></div>
        <div style=" width: 10%"></div>
    </div>
    <div style="width: 33.3%; float: left">
        <div class="sno" style="width: 15%; border: 1px solid ;display: block;float: left"><strong>S.NO</strong></div>
        <div style="width: 25%; border: 1px solid ;display: block;float: left"><strong>Date</strong></div>
        <div style="width: 25%; border: 1px solid ;display: block;float: left"><strong>Princple</strong></div>
        <div style="width: 25%; border: 1px solid ;display: block;float: left"><strong>Interest</strong></div>
        <div style=" width: 10%"></div>
    </div>
    <div style="width: 33.3%; float: left">
        <div class="sno" style="width: 15%; border: 1px solid ;display: block;float: left"><strong>S.NO</strong></div>
        <div style="width: 25%; border: 1px solid ;display: block;float: left"><strong>Date</strong></div>
        <div style="width: 25%; border: 1px solid ;display: block;float: left"><strong>Princple</strong></div>
        <div style="width: 25%; border: 1px solid ;display: block;float: left"><strong>Interest</strong></div>
    </div>

    <?php
    $query = "SELECT * FROM `th_loan_trans` where LOAN_NO = $loan_number";
    //echo $query;
    $fetch_loan_trans = new Database;
    $fetch_loan_trans->query($query);
    $trans_count = $fetch_loan_trans->count();
    //echo $trans_count;
    $loan_trans = $fetch_loan_trans->resultset();
    $i = 0;
    foreach ($loan_trans as $loan_trans) {
        $i = $i + 1;
        ?>
        <div style="width: 33.3%; display: block; float: left" >
            <div style="width: 15%; border: 1px solid ;display: block; float: left; background-color: yellowgreen"><?php echo $i ?></div>
            <div style="width: 25%; border: 1px solid ;display: block; float: left"><?php echo date('d-m-y', strtotime($loan_trans['TRANS_DATE'])) ?></div>
            <div style="width: 25%; border: 1px solid ;display: block; float: left"><?php echo round($loan_trans['AMOUNTP'], 0) ?></div>
            <div style="width: 25%; border: 1px solid ;display: block; float: left"><?php echo round($loan_trans['AMOUNTI'], 0) ?></div>
            <div style=" width: 10%"></div>
        </div>

        <?php
    }
    ?>
</div>
</div>
</div>
</div>
</div>
<div class="container" style=" margin-top: 50px">
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
            <!--            <div class="col-md-6">
                            <a class="btn btn-primary form-control" href="javascript:window.print();">Print</a>
                        </div>-->
            <div class="col-md-2 col-md-offset-5">
                <button class="btn btn-danger form-control" onclick="closewin()">Close</button>
            </div>                        
        </div>
        <br>
        <br>
    </div>
</div>