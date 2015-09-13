<?php
$field_name = $_POST['name'];
$field_email = $_POST['email'];
$field_message = $_POST['message'];

if(empty($_POST['name'])||empty($_POST['email'])||empty($_POST['message']))
{
header("Location:contact.php?message=Please fill all the fields");	

}
else
{

$mail_to = 'adnanbih19962@gmail.com';
$subject = 'Message from a site visitor '.$field_name;

$body_message = 'From: '.$field_name."\n";
$body_message .= 'E-mail: '.$field_email."\n";
$body_message .= 'Message: '.$field_message;

$headers = 'From: '.$field_email."\r\n";
$headers .= 'Reply-To: '.$field_email."\r\n";

$mail_status = mail($mail_to, $subject, $body_message, $headers);

			

if ($mail_status)
{ 

header("Location:contact.php?message1=Thank you for you contact,We will contact you soon");	

}
else 
{
header("Location:contact.php?message=Message not sent");	


}

}

?>



