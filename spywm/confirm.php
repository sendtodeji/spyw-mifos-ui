<?php
include('header.php');
?>

<body class="hold-transition login-page">
    <?php
    // put your code here
    $code = filter_input(INPUT_GET, "code");

    //echo $code;
    $status = 1;

    $custsql = "update login set active=:activate";
    $custstmt = $conn->prepare($custsql);

    $custstmt->bindParam(':activate', $status);

    if ($custstmt->execute()):
        echo "Your account has been activated. You can <a href='/spywm' >login</a> now.";
        session_destroy();
    else:
        $message = 'Sorry there must have been an issue creating your account';
    endif;
    ?>
</body>
<?php
include('footer.php');

