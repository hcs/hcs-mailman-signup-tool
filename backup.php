<?

	//backup.php
	$params = json_decode($_POST["params"], true);
	
	$j = count($params);
	
	for($i = 0; $i < $j; $i++){
		$params[$i] = mysql_real_escape_string($params[$i]);
	}
	
	$filehandle =  fopen('backup.csv', 'a') or die("Log could not be generated. Reconnect to wifi and try again.");
				
	$newline = "\n";
	$sep = ",";
		
	$signupinfo = $params['fullname'].$sep.$params['email'].$newline;		
	
	fwrite($filehandle,$signupinfo);

	// chmod($filename,0744);

	return true;
	
?>