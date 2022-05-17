<?php
require 'assets/PHPMailer/src/Exception.php';
require 'assets/PHPMailer/src/PHPMailer.php';
require 'assets/PHPMailer/src/SMTP.php';

function getStringOfAmount($num) {
    $count = 0;
    global $ones, $tens, $triplets;
    $ones = array(
        '',
        ' One',
        ' Two',
        ' Three',
        ' Four',
        ' Five',
        ' Six',
        ' Seven',
        ' Eight',
        ' Nine',
        ' Ten',
        ' Eleven',
        ' Twelve',
        ' Thirteen',
        ' Fourteen',
        ' Fifteen',
        ' Sixteen',
        ' Seventeen',
        ' Eighteen',
        ' Nineteen'
    );
    $tens = array(
        '',
        '',
        ' Twenty',
        ' Thirty',
        ' Forty',
        ' Fifty',
        ' Sixty',
        ' Seventy',
        ' Eighty',
        ' Ninety'
    );

    $triplets = array(
        '',
        ' Thousand',
        ' Million',
        ' Billion',
        ' Trillion',
        ' Quadrillion',
        ' Quintillion',
        ' Sextillion',
        ' Septillion',
        ' Octillion',
        ' Nonillion'
    );
    return convertNum($num);
}

/**
 * Function to dislay tens and ones
 */
function commonloop($val, $str1 = '', $str2 = '') {
    global $ones, $tens;
    $string = '';
    if ($val == 0)
        $string .= $ones[$val];
    else if ($val < 20)
        $string .= $str1 . $ones[$val] . $str2;
    else
        $string .= $str1 . $tens[(int) ($val / 10)] . $ones[$val % 10] . $str2;
    return $string;
}

/**
 * returns the number as an anglicized string
 */
function convertNum($num) {
    $num = (int) $num;    // make sure it's an integer

    if ($num < 0)
        return 'negative' . convertTri(-$num, 0);

    if ($num == 0)
        return 'Zero';
    return convertTri($num, 0);
}

/**
 * recursive fn, converts numbers to words
 */
function convertTri($num, $tri) {
    global $ones, $tens, $triplets, $count;
    $test = $num;
    $count++;
// chunk the number, ...rxyy
// init the output string
    $str = '';
// to display hundred & digits
    if ($count == 1) {
        $r = (int) ($num / 1000);
        $x = ($num / 100) % 10;
        $y = $num % 100;
// do hundreds
        if ($x > 0) {
            $str = $ones[$x] . ' Hundred';
// do ones and tens
            $str .= commonloop($y, ' and ', '');
        } else if ($r > 0) {
// do ones and tens
            $str .= commonloop($y, ' and ', '');
        } else {
// do ones and tens
            $str .= commonloop($y);
        }
    }
// To display lakh and thousands
    else if ($count == 2) {
        $r = (int) ($num / 10000);
        $deci = $num / 100000;
        $x = ($num / 100) % 100;
        $y = $num % 100;
        $str .= commonloop($x, '', ' Lakh ');
        $str .= commonloop($y);
        //echo $y . '<br>';
        if ($str != '')
            if ($y != 0) {
                $str .= $triplets[$tri];
            }
    }
// to display till hundred crore
    else if ($count == 3) {
        $r = (int) ($num / 1000);
        $x = ($num / 100) % 10;
        $y = $num % 100;
// do hundreds
        if ($x > 0) {
            $str = $ones[$x] . ' Hundred';
// do ones and tens
            $str .= commonloop($y, ' and ', ' Crore ');
        } else if ($r > 0) {
// do ones and tens
            $str .= commonloop($y, ' and ', ' Crore ');
        } else {
// do ones and tens
            $str .= commonloop($y);
        }
    } else {
        $r = (int) ($num / 1000);
    }
// add triplet modifier only if there
// is some output to be modified...
// continue recursing?
    if ($r > 0) {
        return convertTri($r, $tri + 1) . $str;
    } else {
        return $str;
    }
}

function send_mail($to_email, $name, $message, $subject) {

    $mail = new PHPMailer\PHPMailer\PHPMailer(true);
//        $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
    try {
        //Server settings
        //$mail->SMTPDebug = 1;                                 // Enable verbose debug output
        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = 'smtp.vizagsteel.com';                       // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = 'thriftsociety@vizagsteel.com';       // SMTP username
        $mail->Password = 'Thrift@1918';                        // SMTP password
        $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 465;                                    // TCP port to connect to
        //Recipients
        $mail->setFrom('thriftsociety@vizagsteel.com', 'VSP Thrift Society');
        $mail->addAddress($to_email, $name);     // Add a recipient
        //Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = $subject;
        $mail->Body = $message;
        $mail->AltBody = $message;

        $mail->send();
        //echo 'Message has been sent';
    } catch (Exception $e) {
        echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
    }
}

function sms($message, $phone) {
    $message = urlencode($message);
    $url = "http://cloud.smsindiahub.in/vendorsms/pushsms.aspx?user=vspthriftsociety&password=Thrift@1918&msisdn=$phone&sid=THRIFT&msg=$message&fl=0&gwid=2";
    file_get_contents($url);
}

function randStrGen($legth) {
    $result = "";
    $chars = "0123456789";
    $charArray = str_split($chars);
    for ($i = 0; $i <= $legth; $i++) {
        $randItem = array_rand($charArray);
        $result .="" . $charArray[$randItem];
    }
    return $result;
}

function pluralize($count, $text) {
    return $count . ( ( $count == 1 ) ? ( " $text" ) : ( " ${text}s" ) );
}

function ago_sec($datetime) {
    $interval = date_create('now')->diff($datetime);

    if ($hr = $interval->h >= 1)
        $h = $interval->h * 3600;
    else
        $h = 0;
    if ($mi = $interval->i >= 1)
        $m = $interval->i * 60;
    else
        $m = 0;
    if ($s = $interval->s >= 1)
        $s = $interval->s;

    $total_seconds = $h + $m + $s;
    //return $interval;
    return $total_seconds;
}

function ago($datetime) {
    $interval = date_create('now')->diff($datetime);
    $suffix = ( $interval->invert ? ' ago' : '' );
    if ($v = $interval->y >= 1)
        return pluralize($interval->y, 'year') . $suffix;
    if ($v = $interval->m >= 1)
        return pluralize($interval->m, 'month') . $suffix;
    if ($v = $interval->d >= 1)
        return pluralize($interval->d, 'day') . $suffix;
    if ($v = $interval->h >= 1)
        return pluralize($interval->h, 'hour') . $suffix;
    if ($v = $interval->i >= 1)
        return pluralize($interval->i, 'minute') . $suffix;
    return pluralize($interval->s, 'second') . $suffix;
}

function create_image() {
    $image = imagecreatetruecolor(200, 50);
    $background_color = imagecolorallocate($image, 0, 0, 0);
    imagefilledrectangle($image, 0, 0, 200, 50, $background_color);

    $line_color = imagecolorallocate($image, 64, 64, 64);
    $number_of_lines = rand(3, 7);

//    for ($i = 0; $i < $number_of_lines; $i++) {
//        imageline($image, 0, rand() % 50, 250, rand() % 50, $line_color);
//    }

    $pixel = imagecolorallocate($image, 0, 0, 255);
    for ($i = 0; $i < 500; $i++) {
        imagesetpixel($image, rand() % 200, rand() % 50, $pixel);
    }

    //$allowed_letters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    $allowed_letters = '0123456789';
    $length = strlen($allowed_letters);
    $letter = $allowed_letters[rand(0, $length - 1)];
    $word = '';
    $text_color = imagecolorallocate($image, 255, 255, 255);
    $cap_length = 4; // No. of character in image
    for ($i = 0; $i < $cap_length; $i++) {
        $letter = $allowed_letters[rand(0, $length - 1)];
        imagestring($image, 5, 5 + ($i * 30), 20, $letter, $text_color);
        $word.=$letter;
    }
    session_start();
    $_SESSION['captcha_string'] = $word;

    imagepng($image, "captcha_image.png");
}

function display() {
    ?>
    <div style="text-align:center;" >

        <div style="display:block;margin-bottom:20px;margin-top:20px;" >
            <img src="captcha_image.png"> &nbsp; <i class="fa fa-refresh" aria-hidden="true" onclick="return reload_captcha();"></i>
        </div>
        <input class="form-control" type="text" name="captcha"/>
        <input type="hidden" name="flag" value="1"/>
    </div>      
    <?php
}

function create_pdf() {

    require_once 'dompdf/autoload.inc.php';

// reference the Dompdf namespace
    //use Dompdf\Dompdf;
// instantiate and use the dompdf class
    $dompdf = new Dompdf();

    $url = "";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $contents = curl_exec($ch);
    if (curl_errno($ch)) {
        echo curl_error($ch);
        echo "\n<br />";
        $contents = '';
    } else {
        curl_close($ch);
    }

    if (!is_string($contents) || !strlen($contents)) {
        echo "Failed to get contents.";
        $contents = '';
    }

    $dompdf->loadHtml($contents);

// (Optional) Setup the paper size and orientation
    $dompdf->setPaper('A4', 'portrait');

// Render the HTML as PDF
    $dompdf->render();

// Output the generated PDF to Browser
//$dompdf->stream();

    $output = $dompdf->output();
}
