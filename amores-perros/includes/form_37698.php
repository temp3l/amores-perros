<?php
	if (empty($_POST['name_37698']) && strlen($_POST['name_37698']) == 0 || empty($_POST['email_37698']) && strlen($_POST['email_37698']) == 0 || empty($_POST['message_37698']) && strlen($_POST['message_37698']) == 0)
	{
		return false;
	}
	
	$name_37698 = $_POST['name_37698'];
	$email_37698 = $_POST['email_37698'];
	$message_37698 = $_POST['message_37698'];
	
	// Create Message	
	$to = 'receiver@yoursite.com';
	$email_subject = "Message from a Blocs website.";
	$email_body = "You have received a new message. \n\nName_37698: $name_37698 \nEmail_37698: $email_37698 \nMessage_37698: $message_37698 \n";
	$headers = "MIME-Version: 1.0\r\nContent-type: text/plain; charset=UTF-8\r\n";	
	$headers .= "From: contact@yoursite.com\r\n";
	$headers .= "Reply-To: $email_37698";

	// Post Message
	if (function_exists('mail'))
	{
		$result = mail($to,$email_subject,$email_body,$headers);
	}
	else // Mail() Disabled
	{
		$error = array("message" => "The php mail() function is not available on this server.");
	    header('Content-Type: application/json');
	    http_response_code(500);
	    echo json_encode($error);
	}	
?>