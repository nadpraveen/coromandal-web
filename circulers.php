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
        <div class="col-md-12 col-sm-12 col-xs-12">
            <?php
            $get_circulers_list = new Database;
            $get_circulers_list->query("select * from circulers order by date DESC");
            $circuler_count = $get_circulers_list->count();
            if ($circuler_count == 0) {
                ?>
                <div class=" alert alert-info">
                    No Circulars Yet
                </div>
                <?php
            } else {
                ?>
                <table class="table">
                    <tr>
                        <th>Description</th>
                        <th>Link</th>

                    </tr>
                    <?php
                    $circulers = $get_circulers_list->resultset();
                    foreach ($circulers as $circuler) {
                        ?>
                        <tr>
                            <td><?php echo $circuler['description'] ?></td>
                            <td><a href="<?php echo 'admin/' . $circuler['link'] ?>" target="_blank">View</a></td>

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