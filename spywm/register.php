<?php
include('header.php');

//session_start();
if( isset($_SESSION['customer_id']) ){
	header("Location: /dashboard.php");

}
$message = '';
$customer_id='';
$hash='';

$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
$passwd = filter_input(INPUT_POST, 'passwd');
$gcustom_num = filter_input(INPUT_POST, 'account_num');
//echo "$email $gcustom_num";
if(!empty($email) && !empty($passwd)):
	//echo "$email $gcustom_num";
	// Get customer_id
	$custsql = "select customer_id from customer where global_cust_num = :gcustom_num";
	$custstmt = $conn->prepare($custsql);
	$custstmt->bindParam(':gcustom_num',$gcustom_num);
	
	if( $custstmt->execute() ):
            $results = $custstmt->fetch(PDO::FETCH_ASSOC);
            $customer_id = $results['customer_id'];
            //echo $customer_id;
	else:
		$message = 'Sorry there must have been an issue creating your account';
	endif;
	
	// Enter the new user in the database
	
	$sql = "INSERT INTO login (email, passwd, customer_id, hash) VALUES (:email, :password, :customer_id, :vhash)";
        //echo $sql;
        $hash = md5( rand(0,1000) );
        
	$stmt = $conn->prepare($sql);
	$stmt->bindParam(':email', $email);
        $stmt->bindParam(':customer_id', $customer_id);
        $stmt->bindParam(':vhash', $hash);
        $phash = password_hash($passwd, PASSWORD_BCRYPT);
	$stmt->bindParam(':password', $phash);
	if( $stmt->execute() ):
		$data = $stmt->fetchAll();
                //echo $data;
	else:
		$message = 'Sorry there must have been an issue creating your account';
	endif;
        
        $subject = "Confirmation Email for SpyWestCoop Self-Service Portal";
        $confirmurl = sprintf("http://%s:8082/spywm/confirm.php?code=%s", $_SERVER['SERVER_NAME'], $hash);
        //echo $confirmurl;
        $headers = 'From: NoReply@SpyWestCoop.org'."\r\m".'Content-Type: text/html';
        
$message = <<<EOD
 Please,  click on the url or copy and paste the url into your browser to activate your account.     <br/><br/>
        <a href="$confirmurl"> $confirmurl </a>
EOD;
    
//echo $message . "<br/>";
             
        mail($email, $subject, $message, $headers);
        echo "A confirmation email has been sent to your provided email. Please, click on the email to activate";
else:
    include('regform.php');
endif;
?>

<?php
include('footer.php');
