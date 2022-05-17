<?php
ob_start();
include 'header.php';
?>
<div class="container">
    <div class="row">
        <?php
        if (!isset($_SESSION['admin'])) {
            header("location:index.php");
        } else {
            if (!isset($_GET['menu'])) {
                ?>
                <div class="alert alert-info">
                    Please select a menu to start working
                </div>
                <?php
            } else {
                ?>
                <div class="col-md-12">
                    <?php
                    if ($_GET['menu'] == 'scroll') {
                        if (isset($_POST['add_scrol'])) {
                            $description = $_POST['scrole_desc'];
                            if (isset($_FILES['scrole'])) {
                                $name = $_FILES["scrole"]["name"];
                                $type = $_FILES["scrole"]['type'];
                                $size = $_FILES["scrole"]['size'];
                                $tempname = $_FILES["scrole"]['tmp_name'];
                                $error = $_FILES["scrole"]['error'];
                                move_uploaded_file($tempname, "scroles/" . $name);
                                if ($name != '') {
                                    $path = 'scroles/' . $name;
                                } else {
                                    $path = '#';
                                }
                            }
                            $insert_circuler = new Database;
                            $insert_circuler->query("insert into scrol_text (`scrole_text`, `link`,`updated_on`) values('$description', '$path', now())");
                            header("location:admin_home.php?menu=scroll");
                        }
                        ?>

                        <div class="row">
                            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#scrole_modal">Add Scroll  Text</button>

                            <!-- Modal -->
                            <div class="modal fade" id="scrole_modal" role="dialog">
                                <div class="modal-dialog">

                                    <!-- Modal content-->
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h4 class="modal-title">Add Scrole</h4>
                                        </div>
                                        <div class="modal-body">
                                            <form action='' method='post' enctype='multipart/form-data'>
                                                <div class="form-group">
                                                    <textarea name="scrole_desc" rows="3" class="form-control"></textarea>
                                                </div>
                                                <div class="form-group">
                                                    <input type='file' name='scrole' class="form-control">
                                                </div>
                                                <div class="form-group">
                                                    <input type='submit' name='add_scrol' value='Add' class="form-control btn btn-info">
                                                </div>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <br>
                        <table class="table table-hover">
                            <tr>
                                <th>Description</th>
                                <th colspan="2">Action</th>
                            </tr>

                            <?php
                            $select_scroll = new Database;
                            $select_scroll->prepare("select * from scrol_text");
                            $scroll = $select_scroll->resultset();
                            foreach ($scroll as $scroll) {
                                ?>
                                <tr>
                                    <td><?php echo $scroll['scrole_text'] ?></td>
                                    <td><a href="admin_edit.php?id=<?php echo $scroll['id'] ?>&type=scroll">Edit</a></td>
                                    <td><a href="">Delete</a></td>
                                </tr>
                                <?php
                            }
                            ?>
                        </table>
                        <?php
                    } else if ($_GET['menu'] == 'circuler') {

                        if (isset($_POST['add_circuler'])) {
                            $description = $_POST['cir_desc'];
                            $name = $_FILES["circuler"]["name"];
                            $type = $_FILES["circuler"]['type'];
                            $size = $_FILES["circuler"]['size'];
                            $tempname = $_FILES["circuler"]['tmp_name'];
                            $error = $_FILES["circuler"]['error'];
                            move_uploaded_file($tempname, "circulers/" . $name);

                            $path = 'circulers/' . $name;
                            $insert_circuler = new Database;
                            $insert_circuler->query("insert into circulers (`description`, `link`,`date`) values('$description', '$path', now())");
                            header("location:admin_home.php?menu=circuler");
                        }

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
                                    <th>Action</th>
                                </tr>
                                <?php
                                $circulers = $get_circulers_list->resultset();
                                foreach ($circulers as $circuler) {
                                    ?>
                                    <tr>
                                        <td><?php echo $circuler['description'] ?></td>
                                        <td><a href="<?php echo $circuler['link'] ?>" target="_blank">View</a></td>
                                        <td><a href="adm_del.php?id=<?php echo $circuler['id'] ?>&type=circuler">Delete</a></td>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </table>
                            <?php
                        }
                        ?>
                        <div class="row">
                            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#cir_modal">Add Circular</button>

                            <!-- Modal -->
                            <div class="modal fade" id="cir_modal" role="dialog">
                                <div class="modal-dialog">

                                    <!-- Modal content-->
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h4 class="modal-title">Add Circular</h4>
                                        </div>
                                        <div class="modal-body">
                                            <form action='' method='post' enctype='multipart/form-data'>
                                                <div class="form-group">
                                                    <textarea name="cir_desc" rows="3" class="form-control"></textarea>
                                                </div>
                                                <div class="form-group">
                                                    <input type='file' name='circuler' class="form-control">
                                                </div>
                                                <div class="form-group">
                                                    <input type='submit' name='add_circuler' value='Add' class="form-control btn btn-primary">
                                                </div>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <?php
                    } else if ($_GET['menu'] == 'reset_pass') {
                        if (isset($_POST['btn_reset_pass'])) {
                            $user = $_POST['emp_no'];
                            $check_emp_dob = new Database;
                            $check_emp_dob_query = "select * from `th_member_master` where EMP_NO = $user";
                            $check_emp_dob->query($check_emp_dob_query);
                            $emp_dob_count = $check_emp_dob->count();
                            if ($emp_dob_count > 0) {
                                $emp_dob_data = $check_emp_dob->resultset();
                                foreach ($emp_dob_data as $emp_data) {
                                    $dob = date('dmy', strtotime($emp_data['DOB']));
                                    $pass = hash('sha256', $user . $dob);
                                    //$email = $emp_data['EMAIL_ID'];
                                    $insert_pass = new Database;
                                    $insert_pass_query = "update `th_pass` set `pass` = '$dob' where emp_no = '$user'";
                                    //die();
                                    //$insert_pass_query = "INSERT INTO `pass_word` (`EMP_NO`, `pswd`) VALUES ('$user', '$dob')";
                                    $insert_pass->query($insert_pass_query);
                                    Message::setmsg("Password Reseted Successfully", "success");
                                    //header("location:admin_home.php?menu=reset_pass");
                                }
                            }
                        }
                        ?>

                        <div class="col-md-12">
                            <form method="post" action="">
                                <div class="form-group">
                                    <label for="emp_no">Emp No</label>
                                    <input type="text" class=" form-control" name="emp_no" id="emp_no">
                                </div>
                                <div class="form-group">
                                    <input type="submit" class=" form-control btn btn-info" name="btn_reset_pass" id="btn_reset_pass" value="Reset">
                                </div>
                            </form>
                        </div>
                        <?php
                    } else if ($_GET['menu'] == 'loan_info') {
                        
                        if (isset($_POST['btn_loan'])) {
                            $loan_name = $_POST['loan_name'];
                            $max_amount = $_POST['max_amount'];
                            $int_rate = $_POST['int_rate'];
                            $max_tenure = $_POST['max_tenure'];
                            
                            $insert_circuler = new Database;
                            $insert_circuler->query("insert into loan_data (`loan_name`, `max_loan_amount`,`int_rate`, `max_loan_tenure`) "
                                    . "values('$loan_name', '$max_amount', '$int_rate', '$max_tenure')");
                            header("location:admin_home.php?menu=loan_info");
                        }

                        $get_circulers_list = new Database;
                        $get_circulers_list->query("select * from loan_data");
                        $circuler_count = $get_circulers_list->count();
                        if ($circuler_count == 0) {
                            ?>
                            <div class=" alert alert-info">
                                No Loan Data Yet
                            </div>
                            <?php
                        } else {
                            ?>
                            <table class="table">
                                <tr>
                                    <th>Loan Name</th>
                                    <th>Max Amount</th>
                                    <th>Interest Rate</th>
                                    <th>Max Tenure</th>
                                    <th colspan="2">Action</th>
                                </tr>
                                <?php
                                $circulers = $get_circulers_list->resultset();
                                foreach ($circulers as $circuler) {
                                    ?>
                                    <tr>
                                        <td><?php echo $circuler['loan_name'] ?></td>
                                        <td><?php echo $circuler['max_loan_amount'] ?></td>
                                        <td><?php echo $circuler['int_rate'] ?></td>
                                        <td><?php echo $circuler['max_loan_tenure'] ?></td>
                                        <td><a href="admin_edit.php?id=<?php echo $circuler['id'] ?>&type=loan">Edit</a></td>
                                        <td><a href="adm_del.php?id=<?php echo $circuler['id'] ?>&type=loan">Delete</a></td>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </table>
                            <?php
                        }
                        ?>
                        <div class="row">
                            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#loan_modal">Add Loan Data</button>

                            <!-- Modal -->
                            <div class="modal fade" id="loan_modal" role="dialog">
                                <div class="modal-dialog">

                                    <!-- Modal content-->
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h4 class="modal-title">Add Loan Info</h4>
                                        </div>
                                        <div class="modal-body">
                                            <form action='' method='post'>
                                                <div class="form-group">
                                                    <label for="loan_name">Loan Name</label>
                                                    <input type="text" name="loan_name" class="form-control" id="loan_name">
                                                </div>
                                                <div class="form-group">
                                                    <label for="max_amount">Max Loan Amount</label>
                                                    <input type="text" name="max_amount" class="form-control" id="max_amount">
                                                </div>
                                                <div class="form-group">
                                                    <label for="int_rate">Int Rate</label>
                                                    <input type="text" name="int_rate" class="form-control" id="int_rate">
                                                </div>
                                                <div class="form-group">
                                                    <label for="max_tenure">Max Tenure</label>
                                                    <input type="text" name="max_tenure" class="form-control" id="max_tenure">
                                                </div>
                                                <div class="form-group">
                                                    <input type="submit" name="btn_loan" class="form-control btn btn-info" value="Submit">
                                                </div>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <?php
                    }else if ($_GET['menu'] == 'int_data') {
                        
                        if (isset($_POST['btn_int'])) {
                            $srv_name = $_POST['ser_name'];
                            $int_rate = $_POST['int_rate'];
                            $type = $_POST['type'];
                            $insert_circuler = new Database;
                            $insert_circuler->query("insert into int_data (`service`, `type`, `int_rate`)"
                                    . "values('$srv_name', '$type', '$int_rate')");
                            header("location:admin_home.php?menu=int_data");
                        }

                        $get_circulers_list = new Database;
                        $get_circulers_list->query("select * from int_data");
                        $circuler_count = $get_circulers_list->count();
                        if ($circuler_count == 0) {
                            ?>
                            <div class=" alert alert-info">
                                No Data Yet
                            </div>
                            <?php
                        } else {
                            ?>
                            <table class="table">
                                <tr>
                                    <th>Loan / Deposit</th>
                                    <th>Type</th>
                                    <th>Interest Rate</th>
                                    <th colspan="2">Action</th>
                                </tr>
                                <?php
                                $circulers = $get_circulers_list->resultset();
                                foreach ($circulers as $circuler) {
                                    ?>
                                    <tr>
                                        <td><?php echo $circuler['service'] ?></td>.
                                        <td><?php echo $circuler['type'] ?></td>
                                        <td><?php echo $circuler['int_rate'] ?></td>
                                        <td><a href="#" target="_blank">Edit</a></td>
                                        <td><a href="#">Delete</a></td>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </table>
                            <?php
                        }
                        ?>
                        <div class="row">
                            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#int_modal">Add Interest Data</button>

                            <!-- Modal -->
                            <div class="modal fade" id="int_modal" role="dialog">
                                <div class="modal-dialog">

                                    <!-- Modal content-->
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h4 class="modal-title">Add Int Info</h4>
                                        </div>
                                        <div class="modal-body">
                                            <form action='' method='post'>
                                                <div class="form-group">
                                                    <label for="loan_name">Service Name</label>
                                                    <input type="text" name="ser_name" class="form-control" id="loan_name">
                                                </div>
                                                <div class="form-group">
                                                    <label for="int_rate">Int Rate</label>
                                                    <input type="text" name="int_rate" class="form-control" id="int_rate">
                                                </div>
                                                <div class="form-group">
                                                    <select name="type" class="form-control">
                                                        <option value="">Select Type</option>
                                                        <option value="loan">Loan</option>
                                                        <option value="deposit">Deposit</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <input type="submit" name="btn_int" class="form-control btn btn-info" value="Submit">
                                                </div>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <?php
                    }
                }
                ?>
            </div>
            <?php
        }
        ?>
    </div>
</div>
<?php
include 'footer.php';
?>


