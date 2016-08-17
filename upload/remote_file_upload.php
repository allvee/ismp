<?php

/*
if(isset($_FILES['fileupload']))
{
       move_uploaded_file($_FILES['fileupload']['tmp_name'], 'tmp.jpg');
}
*/

$encoded_file = $_POST['file'];
$filename=$_POST['filename'];
$decoded_file = base64_decode($encoded_file);
/* Now you can copy the uploaded file to your server. */
file_put_contents($filename, $decoded_file);

?>