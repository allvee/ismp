<?php
/* echo json_encode($_FILES)." ".json_encode($_REQUEST); */

if(move_uploaded_file($_FILES['file']['tmp_name'], "../../images/user".$_FILES['file']['name'])){
			
			echo "File uploaded successfully...  ";
			
			  
}else{
			echo "Error: File uploading...";
}



 ?>