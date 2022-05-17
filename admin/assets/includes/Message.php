<?php

class Message {

    public static function setmsg($text, $type) {
        $_SESSION['message'] = 'YES';
        if ($type == 'error') {
            $_SESSION['errormsg'] = $text;
        } else {
            $_SESSION['successmsg'] = $text;
        }
    }

    public static function display() {
        if (isset($_SESSION['errormsg'])) {
            ?>
            <div class="alert alert-danger">
                <?php echo $_SESSION['errormsg'] ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php
            unset($_SESSION['errormsg']);
        }
        if (isset($_SESSION['successmsg'])) {
            ?>
            <div class="alert alert-success">
                <?php echo $_SESSION['successmsg'] ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php
            unset($_SESSION['successmsg']);
        }
    }

}