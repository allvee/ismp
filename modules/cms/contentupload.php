<?php

$uploadfile = trim($_POST['path_info']);
$name	=	trim($_POST['name']); 

	if(move_uploaded_file($_FILES['file_contents']['tmp_name'], $uploadfile.$name)) {
	    echo '1';
	} else {
	    echo '0';
	}

?>