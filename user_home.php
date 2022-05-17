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
        <div class="col-md-3 col-sm-12 col-xs-12">
            <a href="trans_report.php" target="_blank"><button class="btn btn-info disabled">Click Here for Member Transaction Details</button></a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <table class="table table-bordered">
                <tr>
                    <td  colspan="2">
                        <?php
                        $img_file1 = $_SESSION['user'] . ".JPG";
                        $img_file2 = $_SESSION['user'] . ".jpg";
                        if (file_exists('usr_img/'.$img_file1)) {
                            ?>
                        <img src="usr_img/<?php echo $img_file1 ?>" class="img-responsive" style="margin-left: auto; margin-right: auto" width="200">
                            <?php
                        } else if (file_exists('usr_img/'.$img_file2)) {
                            ?>
                            <img src="usr_img/<?php echo $img_file2 ?>" class="img-responsive" style="margin-left: auto; margin-right: auto" width="200">
                            <?php
                        } else {
                            ?>
                            No image , Please contact society office.
                            <?php
                        }
                        ?>  
                        
                    </td>
                </tr>
                <tr>
                    <td>Name</td><td><?php echo $info['EMP_NAME'] ?></td>

                </tr>
                <tr>
                    <td>GL No</td><td><?php echo $info['GL_NO'] ?></td>
                </tr>
                <tr>
                    <td>Date Of Joining</td><td><?php echo date('d-m-Y', strtotime($info['DATE_OF_JOIN'])) ?></td>
                </tr>
                <tr>
                    <td>Phone</td><td><?php echo $info['PH_NO_O'] ?></td>
                </tr>
                <tr>
                    <td>Department</td><td><?php echo $info['DEPT'] ?></td>
                </tr>
                <tr>
                    <td>Designation</td><td><?php echo $info['SECTION'] ?></td>
                </tr>
                <tr>
                    <td>Nominee</td><td><?php echo $info['NOMIN_NAME1'] ?>, <?php echo $info['NOMIN1_RELATION'] ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>