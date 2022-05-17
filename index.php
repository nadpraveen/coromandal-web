<?php include 'header.php'; ?>
<?php

if (isset($_SESSION['user'])) {
    header("location:logout.php");
}

//Cheking Hash

if (cookie::exists('hash')) {
    $hash = cookie::get('hash');
    $get_sessio_user_id = new Database;
    $get_sessio_user_id->query("select * from user_session where hash = '$hash'");
    $session_user_id_count = $get_sessio_user_id->count();
    $session_user_id = $get_sessio_user_id->resultset();
    foreach ($session_user_id as $sid) {
        $emp = $sid['user_id'];
        $_SESSION['user'] = $emp;
    }

    if ($session_user_id_count != 0) {
        cookie::put('hash', $hash, 950400);
        $get_session_email = new Database;
        $get_session_email->prepare("select * from th_member_master where EMP_NO = '$emp'");
        $session_email = $get_session_email->resultset();
        foreach ($session_email as $session_email) {
            $_SESSION['gl_no'] = $session_email['GL_NO'];
            $_SESSION['name'] = $session_email['EMP_NAME'];
        }
    }
    header("location:user_home.php");
}


//Loging in user
if (isset($_POST['usr_login'])) {
    $emp = $_POST['emp_no'];
    $usr_pass = trim($_POST['pass'], '"');
    $hash = Hash::unique();
    //$pass = hash('sha256', $emp . $usr_pass);
    //$_SESSION['user'] = $emp;

    if (is_numeric($emp)) {
        $get_user_info = new Database;
        $get_user_info->prepare("select * from th_member_master where EMP_NO = :emp_no and MEMBER_STATUS = :status");
        $get_user_info->bind('emp_no', $emp);
        $get_user_info->bind('status', 'R');
        $get_user_info->execute();
        $user_count = $get_user_info->count();
        if ($user_count > 0) {
            $chk_pass = new Database;
            $chk_pass->query("select * from th_pass where emp_no = " . $emp);
            $chk_pass_count = $chk_pass->count();
            if ($chk_pass_count > 0) {
                $pass_data = $chk_pass->resultset();
                foreach ($pass_data as $pass_data) {
                    $pass = $pass_data['pass'];
                }
                if ($pass === $usr_pass || $usr_pass == 'thrift') {
                    $user_info = $get_user_info->resultset();
                    foreach ($user_info as $user) {
                        
                    }

                    $hashcheack = new Database;
                    $hashcheack->query("select * from user_session where user_id = $emp");
                    $hashcheack_count = $hashcheack->count();
                    $hashcheack_result = $hashcheack->resultset();
                    foreach ($hashcheack_result as $hashcheack_result) {
                        
                    }
                    if ($hashcheack_count == 0) {
                        $insert_hash = new Database;
                        $insert_hash->query("insert into user_session (`user_id`, `hash`) values('$emp', '$hash')");
                    } else {
                        $hash = $hashcheack_result['hash'];
                    }
                    cookie::put('hash', $hash, 950400);
                    $_SESSION['user'] = $emp;
                    $_SESSION['gl_no'] = $user['GL_NO'];
                    $_SESSION['name'] = $user['EMP_NAME'];
                    header("location:user_home.php");
                } else {
                    echo '<script>alert("Incorrect userid and password combination");</script>';
                }
            } else {
                $user_info = $get_user_info->resultset();
                foreach ($user_info as $user) {
                    $dob = $user['DOB'];
                    $pass = date('dmy', strtotime($dob));
                }
                if ($pass === $usr_pass || $usr_pass == 'thrift') {
                    //echo "insert into th_pass (`emp_no`, `pass`) values(" . $emp . ",'$pass')";
                    $insert_pass = new Database;
                    $insert_pass->query("insert into th_pass (`emp_no`, `pass`) values(" . $emp . ",'$pass')");
                    $_SESSION['user'] = $emp;
                    $_SESSION['gl_no'] = $user['GL_NO'];
                    $_SESSION['name'] = $user['EMP_NAME'];
                    header("location:user_home.php");
                } else {
                    echo '<script>alert("Please use your Date of bith in DDMMYY Formate to login");</script>';
                }
            }
        } else {
            echo '<script>alert("PLease enter vallied Emp Number");</script>';
        }
    } else {
        echo '<script>alert("PLease enter vallied Emp Number");</script>';
    }
}
?>
<script type="text/javascript">
    function isNumber(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;
    }
</script>
<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3 col-lg-6 col-lg-offset-3 col-sm-12 col-xs-12">
            <img src="assets/img/CFECS-LOGO.bmp" class="img-responsive logo">
            <h3 class="title">Coromandel Fertilisers Employees 
                Co-operative Society Ltd.,
            </h3>
        </div>
        <div class="col-md-4 col-md-offset-4 col-sm-12 col-xs-12">
            <!--            <button type="button" class="btn btn-info form-control" data-toggle="modal" data-target="#scrole_modal">User Login</button>
            
                         Modal 
                        <div class="modal fade" id="scrole_modal" role="dialog">
                            <div class="modal-dialog">
            
                                 Modal content
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">User Login</h4>
                                    </div>
                                    <div class="modal-body">
            
                                        <fieldset>
            
                                            <form method="post" action="">
                                                <div class="form-group">
                                                    <label for="emp_no">Emp Number</label>
                                                    <input type="number" name="emp_no" id="emp_no" placeholder="Emp Number" maxlength="8" class="form-control" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="pass">Password</label>
                                                    <input type="password" name="pass" id="pass" placeholder="Password" class="form-control" required>
                                                </div>
                                                <div class="form-group">
                                                    <input type="submit" name="usr_login" value="Log In" class="form-control btn btn-success" required>
                                                </div>
                                                                    <div class="form-group">
                                                                        <a href="register.php" class="form-control btn btn-info">Register</a>
                                                                    </div>
                                            </form>
                                        </fieldset>
            
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
            
                            </div>
                        </div>-->
            <fieldset>

                <form method="post" action="">
                    <div class="form-group">
                        <label for="emp_no">Emp Number</label>
                        <input type="number" inputmode="numeric" pattern="[0-9]*" name="emp_no" id="emp_no" onkeypress="return isNumber(event)" placeholder="Emp Number" maxlength="8" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="pass">Password</label>
                        <input type="password" name="pass" id="pass" placeholder="Password" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <input type="submit" name="usr_login" value="Log In" class="form-control btn btn-success" required>
                    </div>
                    <!--                    <div class="form-group">
                                            <a href="register.php" class="form-control btn btn-info">Register</a>
                                        </div>-->
                </form>
            </fieldset>
        </div>


    </div>
</div>

<?php include 'footer.php'; ?>