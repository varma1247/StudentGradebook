<?php
session_start();
include "conn.php";
$now = time();
if (isset($_SESSION['discard_after']) && $now > $_SESSION['discard_after']) {
    session_unset();
    session_destroy();
    echo "sto";
}

// either new or old, it should live at most for another hour
$_SESSION['discard_after'] = $now + 30;