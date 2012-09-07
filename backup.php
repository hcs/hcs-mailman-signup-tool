<?

	//backup.php
	
	$params = $_POST["params"];
	
	
		$filehandle =  fopen($filename, 'w') or die("Log could not be generated. Reconnect to wifi and try again.");
		
		
		
		
		$date = date("Ymd");
		$time = date("Gi");
		
		$newline = "\n";
		$linebreak = "=================================";
		$sep = ",";
		
		$datecreated = "Date Created: " . $date . $newline;
		$timecreated = "Time Created: " . $time . $newline;
		
		if($type == 'nightly')
			$filelog = "Nightly Inventory Log" . $newline . $newline;
		else if($type == 'weekly')
			$filelog = "Weekly Inventory Log" . $newline . $newline;
		
		$userinfo = "Submitted by: " . $_SESSION['firstname'] . " " . $_SESSION['lastname'] . $newline;
		$userinfo = $userinfo . "Username: " . $_SESSION['user'] . $sep . "ID: " . $_SESSION['id'] . $newline;
		
		$filelog = $filelog . $datecreated . $timecreated . $userinfo . $linebreak . $newline . $newline;
		
		fwrite($filehandle,$filelog);
		
		$namesStr = '';
		$valuesStr = '';
		
		// parse through item array and store names and values
		// also update the values in the database...
		foreach($items_array as $item){
			$namesStr = $namesStr . $item['name'] . $sep;
			$valuesStr = $valuesStr . $item['value'] . $sep;
			
			if($type == 'nightly')
				$sql = "UPDATE nightlyinventory SET last_amt = {$item['value']} WHERE item_name = '{$item['name']}'";
			if($type == 'weekly')
				$sql = "UPDATE weeklyinventory SET last_amt = {$item['value']} WHERE item_name = '{$item['name']}'";
			if(($type != 'deliveries') && !mysql_query($sql) && ($item['name'] != 'comments_text'))
				echoexit('error', "Failed to update item amounts correctly!");
		}
		
		fwrite($filehandle, $namesStr.$newline);
		fwrite($filehandle, $valuesStr);
		
		fclose($filehandle);
		chmod($filename,0744);

		return true;
	
	
	




?>