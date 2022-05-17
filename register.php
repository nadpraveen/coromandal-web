<?php include 'header.php'; ?>
<?php
if (isset($_POST['usr_reg'])) {
    $emp = $_POST['emp_no'];
    $chk_emp = new Database;
    $chk_emp->query("select * from th_member_master where EMP_NO = $emp and GL_NO <= 5000");
    $emp_count = $chk_emp->count();
    if ($emp_count > 0) {
        $emp_info = $chk_emp->resultset();
        foreach ($emp_info as $info) {
            if ($info['MEMBER_STATUS'] === 'C') {
                $closed_date = date('d-m-Y', strtotime($info['CLOSING_DATE']));
                Message::setmsg("your Membership has been closed on " . $closed_date, "error");
                header("location:register.php");
            } else if ($info['PH_NO_O'] == '' || $info['PH_NO_O'] == NULL || $info['PH_NO_O'] == ' ') {
                Message::setmsg("your Mobile Number is not Registerd with us please Register your mobile number ", "error");
                header("location:register.php");
            } else {
                $otp = randStrGen(4);
                $insert_otp = new Database();
                $insert_otp->query("INSERT INTO `otp_tbl` (`emp_no`, `otp`, `purpose`,`status`) VALUES ($emp, $otp, 'registration', 'un_used');");
                $_SESSION['otp'] = TRUE;
                $_SESSION['reg_emp'] = $emp;
            }
        }
    } else {
        Message::setmsg("you are not a member", "error");
        header("location:register.php");
    }
}

if (isset($_POST['usr_pass'])) {
    $usr_pass = $_POST['pass'];
    $re_pass = $_POST['re_pass'];
    $otp = $_POST['otp'];

    $chk_otp = new Database;
    $chk_otp->query("select * from otp_tbl where emp_no =" . $_SESSION['reg_emp'] . " and otp = $otp and purpose = 'registration' and status = 'un_used'");
    $otp_count = $chk_otp->count();
    if ($otp_count > 0) {
        if ($usr_pass === $re_pass) {
            $pass = hash('sha256', $_SESSION['reg_emp'] . $usr_pass);
            $insert_pass = new Database;
            $insert_pass->query("insert into th_password (`EMP_NO`, `PASS`) values(" . $_SESSION['reg_emp'] . ",'$pass')");
            unset($_SESSION['otp']);
            unset($_SESSION['reg_emp']);
            Message::setmsg("Account created successfully you can login now", "successmsg");
            header("location:index.php");
        } else {
            Message::setmsg("Password and Conformed password must be same", "error");
            header("location:register.php");
        }
    } else {
        Message::setmsg("invalid OTP", "error");
        header("location:register.php");
    }
}
?>
<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3 col-lg-6 col-lg-offset-3 col-sm-12 col-xs-12">
            <?php
            if (!isset($_SESSION['otp'])) {
                ?>
                <form method="post" action="">
                    <div class="form-group">
                        <label for="emp_no">Emp Number</label>
                        <input type="number" name="emp_no" id="emp_no" placeholder="Emp Number" maxlength="8" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <input type="submit" name="usr_reg" value="Register" class="form-control btn btn-info" required>
                    </div>
                </form>
                <?php
            } else if (isset($_SESSION['otp'])) {
                ?>
                <form method="post" action="">
                    <div class="form-group">
                        <label for="pass">Password</label>
                        <input type="password" name="pass" id="pass" placeholder="Password" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="re_pass">Re Type Password</label>
                        <input type="password" name="re_pass" id="re_pass" placeholder="Password" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="otp">Mobile Otp</label>
                        <input type="number" name="otp" id="otp" placeholder="OTP" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <input type="submit" name="usr_pass" value="Submit" class="form-control btn btn-info" required>
                    </div>
                </form>
                <?php
            }
            ?>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>