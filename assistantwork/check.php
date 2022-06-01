<?php
	 // Assistant Work .
     // (C) 2022 UNIX24. All Rights Reserved.

	$awbase = str_replace("\\", "/", dirname(dirname(__FILE__))) . "/";

	// Attempt to detect if everything is installed already.  If so, bail.
	if ($argc == 1 && !file_exists($awbase . "php/php.ini"))
	{
		echo "The Assistant Work has not completed.  If you are installing, run 'install.bat' instead.\n";

		sleep(2);
		exit();
	}

	echo "Welcome to the Assistant Work checking tool.\n\n";

	define("CHECK_ONLY", true);
	echo "Checking software (no download)...\n";
	require_once $awbase . "assistantwork/download.php";

	echo "Done.\n";
	sleep(3);
?>