<?php
	// Edit upload location here
	//$destination_path = getcwd().DIRECTORY_SEPARATOR;

	$result = 0;
   
	$ftype = $_GET['ftype'];
	
	//$target_path = $destination_path . basename( $_FILES['txtFile']['name']);
	
	if($ftype=="pic"){
		$target_path = "photo/" . basename( $_FILES['txtFile']['name']);

		if(@move_uploaded_file($_FILES['txtFile']['tmp_name'], $target_path)) {
			$result = 1;
		}
	}

	if($ftype=="doc"){
		$target_path = "photo/" . basename( $_FILES['txtFile2']['name']);

		if(@move_uploaded_file($_FILES['txtFile2']['tmp_name'], $target_path)) {
			$result = 1;
		}
	}

   sleep(1);
?>

<script language="javascript" type="text/javascript">
	var url = window.location;
	if(contains(url,"pic")) window.top.window.stopUpload(<?php echo $result; ?>);
	if(contains(url,"doc")) window.top.window.stopUpload2(<?php echo $result; ?>);
	
	function contains(str,arg) {
		str = str+"";
		var token = "";
		var found= false;
		for(var k=0; k<str.length-(arg.length-1); k++){
			token = str.substring(k,k+arg.length);
			if(token == arg){
				found = true;
				break;
			}
		}
		return found;
	}

</script>
