<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function isLoggedIn() {
    if (!isset($_SESSION['login']) || empty($_SESSION['customer_id'])):
        return false;
    endif;

    return true;
}

/*
function getBalance($prd_offering_id) {
    global $conn;
    $customer_id = $_SESSION['customer_id'];
    $records = $conn->prepare('SELECT * FROM v_savings_balance WHERE customer_id = :cust_id and prd_offering_id = :p_id');
    $records->bindParam(':cust_id', $customer_id);
    $records->bindParam(':p_id', $prd_offering_id);
    $records->execute();
    $results = $records->fetch(PDO::FETCH_ASSOC);

    return $results['balance'];
}
*/

function getBalance($savings_type) {
    global $conn;
    $customer_id = $_SESSION['customer_id'];
    
    //$records = $conn->prepare('SELECT  FROM savings_report WHERE customer_id = :cust_id and prd_offering_id = :p_id');
    $records = $conn->prepare('select '.$savings_type.'  FROM savings_report WHERE customer_id = :cust_id' );
    $records->bindParam(':cust_id', $customer_id);
    //$records->bindParam(':p_id', $prd_offering_id);
    $records->execute();
    $results = $records->fetch(PDO::FETCH_ASSOC);

    return $results[$savings_type];
}

