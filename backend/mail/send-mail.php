<?php
session_start();
require_once 'autoload.php';
require_once 'swiftmailer/swiftmailer/lib/swift_required.php';

//GETTING INFORMATION FROM DATABASE
if(isset($_SESSION["email"])){
	$target = $_SESSION["email"];
	include 'connection.php';
	$sql = "SELECT webEmail,webPassword,mailBody,endmailBody,mailTittle,mailAuthor,userId,domainName FROM config,users WHERE users.email = '".$_SESSION["email"]."'";
	$result = $conn->query($sql);

	if ($result->num_rows > 0) {
		$row = $result->fetch_assoc();
		//echo 'Gonna send from '.$row["webEmail"].'<br>';

	} else {
	    header('Locaton:../index.php?forgot=1&fail=1');
	}
	$conn->close();
}else{
	header('Locaton:../forgot.php');
}

// Create the Transport
//echo "creando el transporte<br>";
$transport = (new Swift_SmtpTransport('smtp.gmail.com', 465,'ssl'))
->setUsername($row["webEmail"])
->setPassword($row["webPassword"]);


// Create the Mailer using your created Transport
//echo "creando el mailer usando el transporte<br>";
$mailer = (new Swift_Mailer($transport));

// To use the ArrayLogger
$logger = new Swift_Plugins_Loggers_EchoLogger();
$mailer->registerPlugin(new Swift_Plugins_LoggerPlugin($logger));

//Encrypt the email
$encrypt = base64_encode ($row["userId"]);

// Create a message
//echo "creando el mensaje<br>";
$message = (new Swift_Message($row['mailTittle']))
						->setFrom([$row["webEmail"] => $row["mailAuthor"]])
            ->setTo([$target => 'User'])           
            ->setBody($row['mailBody'].'Link to the password reset form: 
            	'.$row["domainName"].'/mcq/admin/backend/reset.php?encrypt='.$encrypt.'&action=reset
            	54'.$row['endmailBody']);

// Send the message
//echo "mensaje: ".$message."<br><br>";
//echo "enviando el mensaje<br>";

if ($mailer->send($message, $failures))
{
  //echo $result." mensajes enviados<br>";
}
else
{
  //echo "Fallido<br>";
  var_dump($failures);
}
header("Location:../index.php?forgot=1&success=1");

?>

