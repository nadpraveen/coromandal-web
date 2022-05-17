<?php include 'header.php'; ?>
<?php
if (isset($_POST['usr_login'])) {

     $emp = $_POST['emp_no'];
     $usr_pass = $_POST['pass'];

    //$pass = hash('sha256', $emp . $usr_pass);

    if ($emp == 'admin' && $usr_pass == 'admin') {
        $_SESSION['admin'] = $emp;
        header("location:admin_home.php");
    } else {
        header("location:index.php");
    }
}
?>
<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3 col-lg-6 col-lg-offset-3 col-sm-12 col-xs-12">
            <img src="assets/img/CFECS-LOGO.bmp" class="img-responsive logo">
            <h3 class="title">COROMANDEL EMPLOYEES CO-OP THRIFT AND CREDIT SOCIETY LTD.</h3>
        </div>
        <div class="col-md-6 col-md-offset-3 col-lg-6 col-lg-offset-3 col-sm-12 col-xs-12">
            <fieldset>
                <legend>Admin Login</legend>
                <form method="post" action="">
                    <div class="form-group">
                        <label for="emp_no">User Name</label>
                        <input type="text" name="emp_no" id="emp_no" placeholder="User Name" maxlength="8" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="pass">Password</label>
                        <input type="password" name="pass" id="pass" placeholder="Password" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <input type="submit" name="usr_login" value="Log In" class="form-control btn btn-success" required>
                    </div>

                </form>
            </fieldset>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>