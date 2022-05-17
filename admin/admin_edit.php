<?php
ob_start();
include 'header.php';

if (!isset($_SESSION['admin'])) {
    header("location:../index.php");
}
if (!isset($_GET['id']) || !isset($_GET['type'])) {
    header("location:../index.php");
}

$doc_type = $_GET['type'];
$id = $_GET['id'];

if (isset($_POST['btn_loan'])) {
    $loan_name = $_POST['loan_name'];
    $max_amount = $_POST['max_amount'];
    $int_rate = $_POST['int_rate'];
    $max_tenure = $_POST['max_tenure'];

    $update_loan_info = new Database;
    $update_loan_info->prepare("update loan_data set loan_name = :loan_name, max_loan_amount = :max_loan_amount, int_rate = :int_rate, max_loan_tenure = :max_loan_tenure where id = :id ");
    $update_loan_info->bind(":loan_name", $loan_name);
    $update_loan_info->bind(":max_loan_amount", $max_amount);
    $update_loan_info->bind(":int_rate", $int_rate);
    $update_loan_info->bind(":max_loan_tenure", $max_tenure);
    $update_loan_info->bind(":id", $id);
    $update_loan_info->execute();
    Message::setmsg("Updated successfully", "success");
    header("location:admin_home.php?menu=loan_info");
}


if ($doc_type === 'loan') {
    $get_loan_data = new Database;
    $get_loan_data->prepare("select * from loan_data where id = :id");
    $get_loan_data->bind(":id", $id);
    $loan_data = $get_loan_data->resultset();
    foreach ($loan_data as $loan) {
        ?>
        <div class="col-md-6 col-md-offset-3">
            <form action='' method='post'>
                <div class="form-group">
                    <label for="loan_name">Loan Name</label>
                    <input type="text" name="loan_name" class="form-control" id="loan_name" value="<?php echo $loan['loan_name'] ?>">
                </div>
                <div class="form-group">
                    <label for="max_amount">Max Loan Amount</label>
                    <input type="text" name="max_amount" class="form-control" id="max_amount" value="<?php echo $loan['max_loan_amount'] ?>">
                </div>
                <div class="form-group">
                    <label for="int_rate">Int Rate</label>
                    <input type="text" name="int_rate" class="form-control" id="int_rate" value="<?php echo $loan['int_rate'] ?>">
                </div>
                <div class="form-group">
                    <label for="max_tenure">Max Tenure</label>
                    <input type="text" name="max_tenure" class="form-control" id="max_tenure" value="<?php echo $loan['max_loan_tenure'] ?>">
                </div>
                <div class="form-group">
                    <input type="submit" name="btn_loan" class="form-control btn btn-info" value="Submit">
                </div>
            </form>
        </div>
        <?php
    }
} elseif ($doc_type === 'scroll') {
    $select_scroll = new Database;
    $select_scroll->prepare("select * from scrol_text");
    $scroll = $select_scroll->resultset();
    foreach ($scroll as $scroll) {
        ?>
        <div class="col-md-6 col-md-offset-3">
            <form action='' method='post' enctype='multipart/form-data'>
                <div class="form-group">
                    <textarea name="scrole_desc" rows="3" class="form-control"><?php echo $scroll['scrole_text'] ?></textarea>
                </div>
                <div class="form-group">
                    <input type='submit' name='add_scrol' value='Edit' class="form-control btn btn-info">
                </div>
            </form>
        </div>
        <?php
    }
}



include 'footer.php';
