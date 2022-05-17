<?php
include 'header.php';
if (!isset($_SESSION['user'])) {
header("location:index.php");
} else {
$get_user_info = new Database;
$get_user_info->query("select * from th_member_master where EMP_NO = " . $_SESSION['user']);
$user_count = $get_user_info->count();
if ($user_count > 0) {
$user_info = $get_user_info->resultset();
foreach ($user_info as $info) {

}
}
}
?>
<div class="container">
    <div class="row">
        <!-- Loans -->
        <div class="col-md-12 col-sm-12 col-xs-12">
            <h4>Deposit Interest Rates</h4>
            <?php
            $get_circulers_list = new Database;
            $get_circulers_list->query("select * from int_data where type = 'deposit'");
            $circuler_count = $get_circulers_list->count();
            if ($circuler_count == 0) {
            ?>
            <div class=" alert alert-info">
                Data yet to be updated
            </div>
            <?php
            } else {
                ?>
                <table class="table">
                    <?php
                    $circulers = $get_circulers_list->resultset();
                    foreach ($circulers as $circuler) {
                        ?>
                        <tr>
                            <td><?php echo $circuler['service'] ?></td>
                           <td><?php echo $circuler['int_rate'] ?></td>
                            
                        </tr>
                        <?php
                    }
                    ?>
                </table>
                <?php
            }
            ?>
        </div>
        
        <!-- Deposits -->
        
        <div class="col-md-12 col-sm-12 col-xs-12">
            <h4>Loan Interest Rates</h4>
            <?php
            $get_circulers_list = new Database;
            $get_circulers_list->query("select * from int_data where type = 'loan'");
            $circuler_count = $get_circulers_list->count();
            if ($circuler_count == 0) {
            ?>
            <div class=" alert alert-info">
                Data yet to be updated
            </div>
            <?php
            } else {
                ?>
                <table class="table">
                    <?php
                    $circulers = $get_circulers_list->resultset();
                    foreach ($circulers as $circuler) {
                        ?>
                        <tr>
                            <td><?php echo $circuler['service'] ?></td>
                           <td><?php echo $circuler['int_rate'] ?></td>
                            
                        </tr>
                        <?php
                    }
                    ?>
                </table>
                <?php
            }
            ?>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>