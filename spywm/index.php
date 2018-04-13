<?php
require_once('header.php');

if (empty($_SESSION)):
    //session_start();
    session_regenerate_id(true);
endif;

//if (isset($_SESSION['customer_id']) && $_SESSION['customer_id'] !== ''):
//    header("Location: /spywm/dashboard.php");
//endif;
//require 'config.php';

$_SESSION['login'] = true;

$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
$passwd = filter_input(INPUT_POST, 'passwd');
$message = '';

if (!empty($email) && !empty($passwd)):
    //echo $_SESSION['customer_id'];
    $records = $conn->prepare('SELECT customer_id, email, passwd FROM login WHERE email = :email and active = 1');
    $records->bindParam(':email', $email);
    $records->execute();
    $results = $records->fetch(PDO::FETCH_ASSOC);

    if (count($results) > 0 && password_verify($passwd, $results['passwd'])) {
        $_SESSION['customer_id'] = $results['customer_id'];
        $customer_id = $results['customer_id'];
        $custSQL = "select display_name from customers where customer_id=:cust_id";
        $custrecord = $conn->prepare("select display_name, customer_activation_date from customer where customer_id=:cust_id");
        $custrecord->bindParam(':cust_id', $customer_id);
        $custrecord->execute();
        $results1 = $custrecord->fetch(PDO::FETCH_ASSOC);
        $_SESSION['display_name'] = $results1['display_name'];
        $_SESSION['member_since'] = $results1['customer_activation_date'];
        //echo $_SESSION['display_name'];
        //echo $_SESSION['member_since'];

        header("Location: /spywm/dashboard.php");
    } else {
        $message = 'Sorry, those credentials do not match';
    }
endif;
?>

</head>
<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <a href="index.php"><b>SpyWest</b>Coop</a>
        </div>
        <!-- /.login-logo -->
        <div class="login-box-body">
            <p class="login-box-msg">Sign in to start your session</p>

            <form action="index.php" method="post">
                <div class="form-group has-feedback">
                    <input type="email" class="form-control" placeholder="Email" name="email">
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <input type="password" class="form-control" placeholder="Password" name="passwd">
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
                <div class="row">
                    <div class="col-xs-8">
                        <div class="checkbox icheck">
                            <label>
                                <input type="checkbox"> Remember Me
                            </label>
                        </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-xs-4">
                        <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>

            <!--div class="social-auth-links text-center">
              <p>- OR -</p>
              <a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Sign in using
                Facebook</a>
              <a href="#" class="btn btn-block btn-social btn-google btn-flat"><i class="fa fa-google-plus"></i> Sign in using
                Google+</a>
            </div>
            /.social-auth-links -->

            <a href="#">I forgot my password</a><br>
            <a href="register.php" class="text-center">Register a new membership</a>

        </div>
        <!-- /.login-box-body -->
    </div>
    <!-- /.login-box -->
    <?php
    include('footer.php');
    
