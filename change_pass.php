<?php include 'header.php'; ?>

<?php
if(isset($_POST['update_pass'])){
    $new_pass = $_POST['new_pass'];
    $re_new_pass = $_POST['re_new_pass'];
    if($new_pass === $re_new_pass){
        $update_pass = new Database;
        $update_pass->query("update th_pass set pass = '$new_pass'  where emp_no = ".$_SESSION['user']);
        Message::setmsg('Password Updated Successfully', 'success');
        
    }else{
        Message::setmsg('Two Passwords must match', 'error');
    }
}
?>

<div class="container">
    <div class="row">
        <?php
        Message::display();
        ?>
    </div>
    <div class="row">
        <div class="col-md-6 col-md-offset-3 col-xs-12 col-sm-12 col-lg-6 col-lg-offset-3">
            
            <fieldset>
                <legend>Change Password</legend>
                <form method="post" action="">
                    <div class="form-group">
                        <label for="new_pass">New Password</label>
                        <input type="password" name="new_pass" id="new_pass" placeholder="New Password" class="form-control" required="" minlength="6">
                    </div>
                    <div class="form-group">
                        <label for="re_new_pass">Retype New Password</label>
                        <input type="password" name="re_new_pass" id="re_new_pass" placeholder="New Password" class="form-control" required="" minlength="6">
                    </div>
                    <div class="form-group">
                        <input type="submit" name="update_pass" value="Update Password" class="form-control btn btn-info" required="">
                    </div>
                </form>
            </fieldset>

        </div>
    </div>
</div>


<?php include 'footer.php'; ?>