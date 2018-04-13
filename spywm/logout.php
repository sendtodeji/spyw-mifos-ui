<?php

//$_SESSION['customer_id'] = '';
session_start();
if (session_destroy()) {
    header("Location: /spywm/index.php");
}