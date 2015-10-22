<?php

include 'db.php';

if(isset($_REQUEST['submit'])) {

$email  =  $_REQUEST['email'];
$subject = 'Requested forgot password';

$query="select email,password from registered_users where email = '$email'";
$sendpass = mysql_query($query);
$row = mysql_fetch_array($sendpass);

$user_email =$row['email'];
$user_password =md5($row['password']);

if(!preg_match("/^[A-Za-z0-9._%+-]+[@][A-Za-z0-9.-]+[.][A-Za-z]{2,4}$/",$email)) {
        header("Location:forgot.php?message=Invalid email format");
}

else if($email==$user_email) {

$from = "noreply@lennyface.260mb.net";

$headers = "From: $from
X-Sender: $from
Reply-To: $from
MIME-Version: 1.0
X-Priority: 5
X-MSMail-Priority: High
X-Mailer: Microsoft Outlook Express 6.00.2800.1437
X-MimeOLE: Produced By Microsoft MimeOLE V6.00.2800.1441
Content-type: text/html; charset=iso-8859-1
";

mail($email,$subject,$user_password,$headers);
header("Location:forgot.php?message1=A message has been sent to $email");

} else {

header("Location:forgot.php?message= $email does not belong to any account");

}

}
?>
