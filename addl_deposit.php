<?php
include 'header.php';
if (!isset($_SESSION['user'])) {
    header("location:index.php");
}
?>
<div class="container">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <style>
                #info_tbl th{
                    color: green;
                    font-weight: bold;
                }
            </style>
            <fieldset>
                <legend>Deposit Info</legend>
                <table class="table table-bordered" id="info_tbl">
                    <tr>
                        <th>
                            FD No
                        </th>
                        <th>
                            Date
                        </th>
                        <th>
                            FD Amount
                        </th>
                        <th>
                            Period
                        </th>
                        <th>
                            Interest pay Interval
                        </th>
                        <th>
                            Interest Rate
                        </th>
<!--                        <th>
                            Maturity Amount
                        </th>
                        <th>
                            Nominee
                        </th>-->
                    </tr>
                    <?php
                    $get_deposit_info = new Database;
                    $get_deposit_info->query("select * from th_addl_deposit where GL_NO = " . $_SESSION['gl_no']." and FD_STATUS = 'R'");
                    //print_r($get_loan_info);
                    //die();
                    $dep_count = $get_deposit_info->count();
                    
                    if ($dep_count > 0) {
                        $dep_info = $get_deposit_info->resultset();
                        foreach ($dep_info as $info) {
                            ?>
                    <tr>
                        <td><?php echo $info['FD_AC_NO'] ?></td>
                        <td><?php echo date('d-M-Y', strtotime($info['FD_DATE'])) ?></td>
                        <td><?php echo $info['FD_AMOUNT'] ?></td>
                        <td><?php echo $info['FD_PERIOD'] ?></td>
                        <td><?php echo $info['INT_PAY_INTERVAL'] ?></td>
                        <td><?php echo $info['INT_RATE'] ?></td>
<!--                        <td><?php echo $info['MATURITY_AMOUNT'] ?></td>
                        <td><?php echo $info['NOMINEE'] ?></td>-->
                    </tr>
                            <?php
                        }
                    } else {
                        ?>
                        <tr>
                            <td colspan="8">You Dont have any Deposits</td>
                        </tr>
                        <?php
                    }
                    ?>
                </table>
            </fieldset>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
