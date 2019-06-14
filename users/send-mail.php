
<?php
require_once '../backend/mail/autoload.php';
require_once '../backend/mail/swiftmailer/swiftmailer/lib/swift_required.php';

//GETTING INFORMATION FROM DATABASE
include '../backend/connection.php';

if (!$conn) {
	die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT customers.email FROM customers INNER JOIN pawnings ON customers.name='".$_GET['name']."' AND customers.lastname='".$_GET['lastName']."' LIMIT 1";

$result = $conn->query($sql);

$row = $result->fetch_assoc();

$sql2 = "SELECT webEmail,webPassword,mailBody,endmailBody,mailTittle,mailAuthor,userId,domainName FROM config,users WHERE users.email = '".$_SESSION["email"]."'";
$result2 = $conn->query($sql2);

$row2 = $result2->fetch_assoc();

// Create the Transport
//echo "creando el transporte<br>";
$user = $row["webEmail"];
$password = $row["webPassword"];

$transport = (new Swift_SmtpTransport('smtp.gmail.com', 465,'ssl'))
->setUsername($user)
->setPassword($password);


// Create the Mailer using your created Transport
//echo "creando el mailer usando el transporte<br>";
$mailer = (new Swift_Mailer($transport));

// To use the ArrayLogger
$logger = new Swift_Plugins_Loggers_EchoLogger();
$mailer->registerPlugin(new Swift_Plugins_LoggerPlugin($logger));

// Create a message
//echo "creando el mensaje<br>";

$message = (new Swift_Message('Title'))
->setFrom(['labarca_123456@gmail.com' => 'Luis'])
->setTo([$row["email"] => $_GET["name"]])           
->setBody('Test');

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

header('Location: warning-letter.php?billno=1');
?>