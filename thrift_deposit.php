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
                            Present Balance
                        </th>
                        <th>
                            Monthly Recovery
                        </th>
                    </tr>
                    <?php
                    $get_deposit_info = new Database;
                    $get_deposit_info->query("select * from th_thrift_deposit_master where GL_NO = " . $_SESSION['gl_no']);
                    //print_r($get_loan_info);
                    //die();
                    $dep_count = $get_deposit_info->count();
                    if ($dep_count > 0) {
                        $dep_info = $get_deposit_info->resultset();
                        foreach ($dep_info as $info) {
                            ?>
                            <tr>
                                <td>
                                    <?php echo $info['CLOSE_BAL'] ?>
                                </td>
                                <td>
                                    <?php echo $info['RECOVERY_RATE'] ?>
                                </td>
                            </tr>
                            <?php
                        }
                    } else {
                        ?>
                        <tr>
                            <td>You Dont have any Thrift Deposit Balance</td>
                        </tr>
                        <?php
                    }
                    ?>
                </table>
            </fieldset>
        </div>
        <?php
        if ($dep_count > 0) {
            ?>
        <div class="col-md-6 col-sm-12 col-xs-12">
            <fieldset>
                <legend>Monthly Recovery</legend>
                <div style="max-height: 300px; overflow-y: auto">
                    <table class="table table-bordered">
                        <?php
                        $get_rec_info = new Database;
                        $get_rec_info->query("select * from th_thrift_deposit_trans where GL_NO = " . $_SESSION['gl_no'] . " and TRAN_TYPE = 'R' order by TRANS_DATE DESC");
                        //print_r($get_rec_info);
                        //die();
                        $rec_count = $get_rec_info->count();
                        if ($rec_count > 0) {
                            $rec_info = $get_rec_info->resultset();
                            foreach ($rec_info as $rec_info) {
                                ?>
                                <tr>
                                    <td><?php echo date('d-m-Y', strtotime($rec_info['TRANS_DATE'])) ?></td><td><?php echo $rec_info['AMOUNTP'] + $rec_info['AMOUNTI'] ?></td>
                                </tr>
                                <?php
                            }
                        } else {
                            ?>
                            <tr>
                                <td>no data found</td>
                            </tr>
                            <?php
                        }
                        ?>
                    </table>
                </div>
            </fieldset>
        </div>
        <?php
        }
        ?>
    </div>
</div>

<?php include 'footer.php'; ?>