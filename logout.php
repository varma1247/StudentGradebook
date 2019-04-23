<?php
session_start();
include "conn.php";
if (isset($_POST['logout'])){
    session_destroy();
    echo "logout";
    }
?>