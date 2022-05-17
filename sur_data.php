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
$user = $_SESSION['gl_no'];
?>
<div class="container">
    <div class="row">
        <!-- Main Loan -->
        <div class="col-md-12">
            <h5> Long Term Loan :</h5>
            <table class="table table-bordered">
                <tr>
                    <th>E.no </th>
                    <th>Name </th>
                    <th>Loan Amount </th>
                    <th>Present Balance </th>
                    <th>Date </th>
                    <th>Photo</th>
                </tr>
                <?php
                $query = "SELECT * FROM `th_loan_master` WHERE (SURITY1 = $user OR SURITY2 = $user) AND LOAN_STATUS = 'R' ORDER BY `LOAN_NO` ASC";
                //echo $query;
                $get_edl_data = new Database;
                $get_edl_data->query($query);
                $count = $get_edl_data->count();
                if ($count > 0) {
                    $result = $get_edl_data->resultset();
                    foreach ($result as $row) {
                        ?>
                        <tr>
                            <td> <?php echo $row['GL_NO'] ?></td>
                            <?php
                            $get_name = new Database;
                            $get_name->prepare("select * from th_member_master where GL_NO = " . $row['GL_NO']);
                            $name = $get_name->resultset();
                            foreach ($name as $name) {
                                
                            }
                            ?>
                            <td> <?php echo $name['EMP_NAME'] ?></td>
                            <td> <?php echo $row['LOAN_AMOUNT'] ?></td>

                            <td> <?php echo $row['CBP'] + $row['CBI'] ?></td>
                            <?php
                            $loan_data = date('d-m-Y', strtotime($row['DATE_OF_SANCTION']));
                            ?>
                            <td> <?php echo $loan_data ?></td>
                            <td><img class="img-responsive" src="usr_img/<?php echo $name['EMP_NO'] ?>.JPG" width="50"></td>
                        </tr>


                        <?php
                    }
                } else {
                    ?>
                    <tr>
                        <td colspan="4">You have not given any Surity</td>
                    </tr>
                    <?php
                }
                ?>
            </table>
        </div>

        <br>
        <hr>

        <!-- Education Loan -->
        <div class="col-md-12">
            <h5> Education Loan :</h5>
            <table class="table table-bordered">
                <tr>
                    <th>E.no </th>
                    <th>Name </th>
                    <th>Loan Amount </th>
                    <th>Present Balance </th>
                    <th>Date </th>
                    <th>Photo</th>
                </tr>
                <?php
                $query = "SELECT * FROM `th_ed_loan_master` WHERE (SURITY1 = $user OR SURITY2 = $user) AND LOAN_STATUS = 'R' ORDER BY `LOAN_NO` ASC";
                //echo $query;
                $get_edl_data = new Database;
                $get_edl_data->query($query);
                $count = $get_edl_data->count();
                if ($count > 0) {
                    $result = $get_edl_data->resultset();
                    foreach ($result as $row) {
                        ?>
                        <tr>
                            <td> <?php echo $row['GL_NO'] ?></td>
                            <?php
                            $get_name = new Database;
                            $get_name->prepare("select * from th_member_master where GL_NO = " . $row['GL_NO']);
                            $name = $get_name->resultset();
                            foreach ($name as $name) {
                                
                            }
                            ?>
                            <td> <?php echo $name['EMP_NAME'] ?></td>
                            <td> <?php echo $row['LOAN_AMOUNT'] ?></td>

                            <td> <?php echo $row['CBP'] + $row['CBI'] ?></td>
                            <?php
                            $loan_data = date('d-m-Y', strtotime($row['DATE_OF_SANCTION']));
                            ?>
                            <td> <?php echo $loan_data ?></td>
                            <td><img class="img-responsive" src="user_img/<?php echo $name['EMP_NO'] ?>.jpg" width="50"></td>
                        </tr>
                        <?php
                    }
                } else {
                    ?>
                    <tr>
                        <td colspan="4">You have not given any Surity</td>
                    </tr>
                    <?php
                }
                ?>
            </table>
        </div>

        <br>
        <hr>
        <!-- Article Loan -->
        <div class="col-md-12">
            <h5> Article Loan :</h5>
            <table class="table table-bordered">
                <tr>
                    <th>E.no </th>
                    <th>Name </th>
                    <th>Loan Amount </th>
                    <th>Present Balance </th>
                    <th>Date </th>
                    <th>Photo</th>
                </tr>
                <?php
                $query = "SELECT * FROM `th_arti_loan_master` WHERE (SURITY1 = $user OR SURITY2 = $user) AND LOAN_STATUS = 'R' ORDER BY `LOAN_NO` ASC";
                //echo $query;
                $get_edl_data = new Database;
                $get_edl_data->query($query);
                $count = $get_edl_data->count();
                if ($count > 0) {
                    $result = $get_edl_data->resultset();
                    foreach ($result as $row) {
                        ?>
                        <tr>
                            <td> <?php echo $row['GL_NO'] ?></td>
                            <?php
                            $get_name = new Database;
                            $get_name->prepare("select * from th_member_master where GL_NO = " . $row['GL_NO']);
                            $name = $get_name->resultset();
                            foreach ($name as $name) {
                                
                            }
                            ?>
                            <td> <?php echo $name['EMP_NAME'] ?></td>
                            <td> <?php echo $row['LOAN_AMOUNT'] ?></td>

                            <td> <?php echo $row['CBP'] + $row['CBI'] ?></td>
        <?php
        $loan_data = date('d-m-Y', strtotime($row['DATE_OF_SANCTION']));
        ?>
                            <td> <?php echo $loan_data ?></td>
                            <td><img class="img-responsive" src="user_img/<?php echo $name['EMP_NO'] ?>.jpg" width="50"></td>
                        </tr>


                        <?php
                    }
                } else {
                    ?>
                    <tr>
                        <td colspan="4">You have not given any Surity</td>
                    </tr>
    <?php
}
?>
            </table>
        </div>

        <br>
        <hr>
        <div class="col-md-12">
            <h5> Martigage Loan :</h5>
            <table class="table table-bordered">
                <tr>
                    <th>E.no </th>
                    <th>Name </th>
                    <th>Loan Amount </th>
                    <th>Present Balance </th>
                    <th>Date </th>
                    <th>Photo</th>
                </tr>
                <?php
                $query = "SELECT * FROM `th_mv_loan_master` WHERE (SURITY1 = $user OR SURITY2 = $user) AND LOAN_STATUS = 'R' ORDER BY `LOAN_NO` ASC";
                //echo $query;
                $get_edl_data = new Database;
                $get_edl_data->query($query);
                $count = $get_edl_data->count();
                if ($count > 0) {
                    $result = $get_edl_data->resultset();
                    foreach ($result as $row) {
                        ?>
                        <tr>
                            <td> <?php echo $row['GL_NO'] ?></td>
                            <?php
                            $get_name = new Database;
                            $get_name->prepare("select * from th_member_master where GL_NO = " . $row['GL_NO']);
                            $name = $get_name->resultset();
                            foreach ($name as $name) {
                                
                            }
                            ?>
                            <td> <?php echo $name['EMP_NAME'] ?></td>
                            <td> <?php echo $row['LOAN_AMOUNT'] ?></td>

                            <td> <?php echo $row['CBP'] + $row['CBI'] ?></td>
        <?php
        $loan_data = date('d-m-Y', strtotime($row['DATE_OF_SANCTION']));
        ?>
                            <td> <?php echo $loan_data ?></td>
                            <td><img class="img-responsive" src="user_img/<?php echo $name['EMP_NO'] ?>.jpg" width="50"></td>
                        </tr>


        <?php
    }
} else {
    ?>
                    <tr>
                        <td colspan="4">You have not given any Surity</td>
                    </tr>
    <?php
}
?>
            </table>
        </div>

        <br>
        <hr>
        <div class="col-md-12">
            <h5> Spcial Loan :</h5>
            <table class="table table-bordered">
                <tr>
                    <th>E.no </th>
                    <th>Name </th>
                    <th>Loan Amount </th>
                    <th>Present Balance </th>
                    <th>Date </th>
                    <th>Photo</th>
                </tr>
                <?php
                $query = "SELECT * FROM `th_spl_loan_master` WHERE (SURITY1 = $user OR SURITY2 = $user) AND LOAN_STATUS = 'R' ORDER BY `LOAN_NO` ASC";
                //echo $query;
                $get_edl_data = new Database;
                $get_edl_data->query($query);
                $count = $get_edl_data->count();
                if ($count > 0) {
                    $result = $get_edl_data->resultset();
                    foreach ($result as $row) {
                        ?>
                        <tr>
                            <td> <?php echo $row['GL_NO'] ?></td>
                            <?php
                            $get_name = new Database;
                            $get_name->prepare("select * from th_member_master where GL_NO = " . $row['GL_NO']);
                            $name = $get_name->resultset();
                            foreach ($name as $name) {
                                
                            }
                            ?>
                            <td> <?php echo $name['EMP_NAME'] ?></td>
                            <td> <?php echo $row['LOAN_AMOUNT'] ?></td>

                            <td> <?php echo $row['CBP'] + $row['CBI'] ?></td>
        <?php
        $loan_data = date('d-m-Y', strtotime($row['DATE_OF_SANCTION']));
        ?>
                            <td> <?php echo $loan_data ?></td>
                            <td><img class="img-responsive" src="user_img/<?php echo $name['EMP_NO'] ?>.jpg" width="50"></td>
                        </tr>


        <?php
    }
} else {
    ?>
                    <tr>
                        <td colspan="4">You have not given any Surity</td>
                    </tr>
    <?php
}
?>
            </table>
        </div>

        <br>
        <hr>
        <div class="col-md-12">
            <h5> Vehicle Loan :</h5>
            <table class="table table-bordered">
                <tr>
                    <th>E.no </th>
                    <th>Name </th>
                    <th>Loan Amount </th>
                    <th>Present Balance </th>
                    <th>Date </th>
                    <th>Photo</th>
                </tr>
                <?php
                $query = "SELECT * FROM `th_vehi_loan_master` WHERE (SURITY1 = $user OR SURITY2 = $user) AND LOAN_STATUS = 'R' ORDER BY `LOAN_NO` ASC";
                //echo $query;
                $get_edl_data = new Database;
                $get_edl_data->query($query);
                $count = $get_edl_data->count();
                if ($count > 0) {
                    $result = $get_edl_data->resultset();
                    foreach ($result as $row) {
                        ?>
                        <tr>
                            <td> <?php echo $row['GL_NO'] ?></td>
                            <?php
                            $get_name = new Database;
                            $get_name->prepare("select * from th_member_master where GL_NO = " . $row['GL_NO']);
                            $name = $get_name->resultset();
                            foreach ($name as $name) {
                                
                            }
                            ?>
                            <td> <?php echo $name['EMP_NAME'] ?></td>
                            <td> <?php echo $row['LOAN_AMOUNT'] ?></td>

                            <td> <?php echo $row['CBP'] + $row['CBI'] ?></td>
        <?php
        $loan_data = date('d-m-Y', strtotime($row['DATE_OF_SANCTION']));
        ?>
                            <td> <?php echo $loan_data ?></td>
                            <td><img class="img-responsive" src="user_img/<?php echo $name['EMP_NO'] ?>.jpg" width="50"></td>
                        </tr>


                        <?php
                    }
                } else {
                    ?>
                    <tr>
                        <td colspan="4">You have not given any Surity</td>
                    </tr>
    <?php
}
?>
            </table>
        </div>

        <br>
        <hr>
    </div>
</div>


<?php include 'footer.php'; ?>