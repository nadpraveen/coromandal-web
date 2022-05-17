<?php
include 'header.php';
if (!isset($_SESSION['user'])) {
    header("location:index.php");
}
?>
<div class="container">
    <div class="row">
        <div class="col-md-6 col-sm-12 col-xs-12">
            <style>
                #info_tbl td:nth-child(1){
                    color: green;
                    font-weight: bold;
                }
            </style>
            <fieldset>
                <legend>Loan Info</legend>
                <table class="table table-bordered" id="info_tbl">
                    <?php
                    $get_loan_info = new Database;
                    $get_loan_info->query("select * from th_spl_loan_master where GL_NO = " . $_SESSION['gl_no'] . " and LOAN_STATUS = 'R'");
                    //print_r($get_loan_info);
                    //die();
                    $loan_count = $get_loan_info->count();
                    if ($loan_count > 0) {
                        $loan_info = $get_loan_info->resultset();
                        foreach ($loan_info as $info) {
                            ?>
                            <tr>
                                <td>Loan Number</td><td><?php echo $info['LOAN_NO'] ?></td>
                            </tr>
                            <tr>
                                <td>Loan Amount</td><td><?php echo $info['LOAN_AMOUNT'] ?></td>
                            </tr>
                            <tr>
                                <td>Installments</td><td><?php echo $info['INSTALLMENTS'] ?></td>
                            </tr>
                            <tr>
                                <td>Rate of Interest</td><td><?php echo $info['RATE_OF_INTREST'] ?></td>
                            </tr>
                            <tr>
                                <td>Recovery Rate</td><td><?php echo $info['REC_RATE_CUR'] ?></td>
                            </tr>
                            <tr>
                                <td>Present Balance</td><td><?php echo $info['CBP'] + $info['CBI'] ?></td>
                            </tr>
                            <tr>
                                <td>Surity 1</td>
                                <td>
                                    <?php
                                    //echo $info['SURITY1']
                                    $get_sur1_data = new Database;
                                    $get_sur1_data->prepare("select * from th_member_master where GL_NO = " . $info['SURITY1']);
                                    $sur1_data = $get_sur1_data->resultset();
                                    foreach ($sur1_data as $sur1) {                                        
                                        echo $sur1['GL_NO'] . "," . $sur1['EMP_NAME'].'<br>';
                                        $img_file = $sur1['EMP_NO'].".jpg";
                                        $img_file2 = $sur1['EMP_NO'].".JPG";
                                        if(file_exists('usr_img/'.$img_file)){
                                         echo '<img src="usr_img/'.$img_file.'" class="img-responsive" width="100">';   
                                        }else if(file_exists('usr_img/'.$img_file2)){
                                         echo '<img src="usr_img/'.$img_file2.'" class="img-responsive" width="100">';   
                                        }                                      
                                    }
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Surity 2</td>
                                <td>
                                    <?php
                                    //echo $info['SURITY2']
                                    
                                    $get_sur2_data = new Database;
                                    $get_sur2_data->prepare("select * from th_member_master where GL_NO = ".$info['SURITY2']);
                                    $sur2_data = $get_sur2_data->resultset();
                                    foreach ($sur2_data as $sur2){                                        
                                        echo $sur2['GL_NO'].",".$sur2['EMP_NAME'].'<br>';
                                        $img_file = $sur2['EMP_NO'].".jpg";
                                        $img_file2 = $sur2['EMP_NO'].".JPG";
                                        if(file_exists('usr_img/'.$img_file)){
                                         echo '<img src="usr_img/'.$img_file.'" class="img-responsive" width="100">';   
                                        }else if(file_exists('usr_img/'.$img_file2)){
                                         echo '<img src="usr_img/'.$img_file2.'" class="img-responsive" width="100">';   
                                        }
                                    }
                                    ?>
                                </td>
                            </tr>

                            <?php
                        }
                    } else {
                        ?>
                        <tr>
                            <td>You dont have any loan balance</td>
                        </tr>
                        <?php
                    }
                    ?>
                </table>
            </fieldset>
        </div>
        <?php
        if ($loan_count > 0) {
            ?>
            <div class="col-md-6 col-sm-12 col-xs-12">
                <fieldset>
                    <legend>Monthly Recovery</legend>
                    <div style="max-height: 300px; overflow-y: auto">
                        <table class="table table-bordered">
                            <?php
                            $get_rec_info = new Database;
                            $get_rec_info->query("select * from th_spl_loan_trans where LOAN_NO = " . $info['LOAN_NO'] . " and TRAN_TYPE = 'R' order by TRANS_DATE DESC");
                            //print_r($get_rec_info);
                            //die();
                            $rec_count = $get_rec_info->count();
                            if ($rec_count > 0) {
                                $rec_info = $get_rec_info->resultset();
                                foreach ($rec_info as $rec_info) {
                                    ?>
                                    <tr>
                                        <td><?php echo date('d-m-Y', strtotime($rec_info['TRANS_DATE'])) ?></td><td><?php echo $rec_info['AMOUNTP'] + $rec_info['AMOUNTI'] ?></td>
                                    </tr>
                                    <?php
                                }
                            } else {
                                ?>
                                <tr>
                                    <td>You Dont have any loan balance</td>
                                </tr>
                                <?php
                            }
                            ?>
                        </table>
                    </div>
                </fieldset>
            </div>
            <?php
        }
        ?>
    </div>
</div>

<?php include 'footer.php'; ?>
