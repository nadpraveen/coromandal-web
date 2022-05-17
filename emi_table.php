<?php
include 'header.php';
if (!isset($_SESSION['user'])) {
    header("location:index.php");
}

function disp() {
    if (isset($_POST['btnadd'])) {
        $loan_id = $_POST['loan'];
        $get_loan_info = new Database;
        $get_loan_info->query("SELECT * FROM `loan_data` where id = $loan_id ");
        $loan_info = $get_loan_info->resultset();
        foreach ($loan_info as $info) {
            
        }
        $amount = trim($_POST['amount']);
        $rate = trim($info['int_rate']);
        $term = trim($_POST['tenure']);
        if ($amount > $info['max_loan_amount']) {
            
        } else if ($term > $info['max_loan_tenure'] || $term < 1) {
            
        } else {


            $rate_month = ($rate / 100) / 12;
            $int = ($amount * $rate_month);
            global $emi;
            $emi = $amount * (($rate_month * (pow(1 + $rate_month, $term))) / (pow(1 + $rate_month, $term) - 1));

//        echo '' . ceil($emi / 10) * 10 .'<br>';
//        echo $int.'<br>';
            number_format($emi) . '<br> <br> <br>';
            ?>
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="col-md-12">
                    Loan Name: <?php echo $info['loan_name'] ?><br>
                    Interest Rate: <?php echo $info['int_rate'] ?><br>
                    Tenure Selected: <?php echo $term ?><br>
                </div>
                <table class="table table-bordered">
                    <thead>
                    <th>Months</th>
                    <th>EMI</th>
                    <th>Interest </th>
                    <th>Principle</th>
                    <th>Loan Amount</th>

                    </thead>
                    <tr>
                        <td>
                            0
                        </td>
                        <td>

                        </td>
                        <td>

                        </td>
                        <td>

                        </td>
                        <td>
                            <?php echo number_format($amount); ?>
                        </td>
                    </tr>


                    <?php
                    for ($i = 1; $i <= $term; $i++) {
                        $int = ($amount * $rate_month);
                        $principle = $emi - $int;
                        $amount = $amount - $principle;

//                echo $i .'  | '.number_format($emi).'  | '.number_format($amount). ' |  '. number_format($int). '  | ' .number_format($principle).   '<br>';
                        ?>
                        <tr>
                            <td>
                                <?php echo $i; ?>
                            </td>
                            <td>
                                <?php echo number_format($emi); ?>
                            </td>

                            <td>
                                <?php echo number_format($int); ?>
                            </td>
                            <td>
                                <?php echo number_format($principle); ?>
                            </td>
                            <td>
                                <?php echo number_format($amount); ?>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                </table>
            </div>
            <?php
        }
    }
}
?>
<div class="container">
    <div class="row">
        <div class="col-md-6 col-xs-12 col-sm-12 col-md-offset-3">
            <form action="" method="post" >
                <table class="table table-striped">
                    <tr>
                        <td colspan="2">
                            <select name="loan" required class="form-control">
                                <option value="">Select Loan Type</option>
                                <?php
                                $get_loan_list = new Database;
                                $get_loan_list->query("SELECT * FROM `loan_data`");
                                $loan_list = $get_loan_list->resultset();
                                foreach ($loan_list as $loan) {
                                    ?>
                                    <option value="<?php echo $loan['id'] ?>"><?php echo strtoupper($loan['loan_name']) ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Principle</td><td><input type="text" name="amount" required="" class="form-control"></td>
                    </tr>
                    <tr>
                    <tr>
                        <td>No of Installments</td><td><input  type="text" name="tenure" required="" class="form-control"></td>
                    </tr>

                    <tr>
                        <td colspan="2" align="center" >
                            <input type="submit" value="submit" name="btnadd" class="form-control"></td>
                    </tr>
                </table>   
            </form>

            <hr>
            <div>
                <?php disp(); ?>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
