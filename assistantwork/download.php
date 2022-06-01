<?php
	 // Assistant Work .
     // (C) 2022 UNIX24. All Rights Reserved.

	if (!isset($forcedownload))  $forcedownload = false;

	$installpath = str_replace("\\", "/", dirname(dirname(__FILE__))) . "/";
	$stagingpath = $installpath . "staging/";

	require_once $installpath . "assistantwork/awbase.php";
	require_once $installpath . "assistantwork/about.php";
	require_once $installpath . "assistantwork/info.php";
	require_once $installpath . "assistantwork/support/web_browser.php";
	require_once $installpath . "assistantwork/support/simple_html_dom.php";
	require_once $installpath . "assistantwork/support/insertgt.php";
	require_once $installpath . "assistantwork/support/office.php";



	function ResetStagingArea($path)
	{
		if (substr($path, -1) == "/")  $path = substr($path, 0, -1);

		$dir = opendir($path);
		if ($dir)
		{
			while (($file = readdir($dir)) !== false)
			{
				if ($file != "." && $file != "..")
				{
					if (is_link($path . "/" . $file) || is_file($path . "/" . $file))  unlink($path . "/" . $file);
					else
					{
						ResetStagingArea($path . "/" . $file);
						rmdir($path . "/" . $file);
					}
				}
			}

			closedir($dir);
		}
	}

	$html = new simple_html_dom();
	$html2 = new simple_html_dom();

	function DownloadFailed($msg)
	{
		echo "\n";
		echo "Fatal error:  Download failed.\n";
		echo $msg . "\n";

		sleep(5);
		exit();
	}

	function DownloadAndExtract_Callback($response, $data, $opts)
	{
		if ($response["code"] == 200)
		{
			$size = ftell($opts);
			fwrite($opts, $data);

			if ($size % 1000000 > ($size + strlen($data)) % 1000000)  echo ".";
		}

		return true;
	}

	function DownloadAndExtract($installkey, $url)
	{
		global $stagingpath, $web;

		echo "Downloading:  " . $url . "\n";
		echo "Please wait...";

		$fp = fopen($stagingpath . $installkey . ".zip", "wb");
		$web2 = clone $web;
		$options = array(
			"read_body_callback" => "DownloadAndExtract_Callback",
			"read_body_callback_opts" => $fp
		);
		$result = $web2->Process($url, $options);
		fclose($fp);

		if (!$result["success"])  DownloadFailed("Error retrieving URL.  " . $result["error"]);
		else if ($result["response"]["code"] != 200)  DownloadFailed("Error retrieving URL.  Server returned:  " . $result["response"]["code"] . " " . $result["response"]["meaning"]);

		echo "\n";
		echo "ZIP file downloaded successfully.\n";
		echo "Extracting...";

		$emptyfiles = array();
		$num = 0;
		@mkdir($stagingpath . $installkey);
		$zip = zip_open($stagingpath . $installkey . ".zip");
		if (!is_resource($zip))  DownloadFailed("The ZIP file '" . $stagingpath . $installkey . ".zip" . "' was unable to be opened for reading.");
		while (($zipentry = zip_read($zip)) !== false)
		{
			$name = str_replace("\\", "/", zip_entry_name($zipentry));
			$name = str_replace("../", "/", $name);
			$name = str_replace("./", "/", $name);
			$name = preg_replace("/\/+/", "/", $name);

			$pos = strrpos($name, "/");
			if ($pos !== false)
			{
				$dirname = substr($name, 0, $pos);
				@mkdir($stagingpath . $installkey . "/" . $dirname, 0777, true);
				if (trim(substr($name, $pos + 1)) == "")  continue;
			}

			$size = zip_entry_filesize($zipentry);
			if ($size == 0)
			{
				$emptyfiles[] = $name;
				continue;
			}

			if (!zip_entry_open($zip, $zipentry, "rb"))  DownloadFailed("Error opening the ZIP file entry '" . zip_entry_name($name) . "' for reading.");
			$fp = fopen($stagingpath . $installkey . "/" . $name, "wb");
			while ($size > 1000000)
			{
				fwrite($fp, zip_entry_read($zipentry, 1000000));
				$size -= 1000000;
			}
			if ($size > 0)  fwrite($fp, zip_entry_read($zipentry, $size));
			fclose($fp);
			zip_entry_close($zipentry);

			$num++;
			if ($num % 10 == 0)  echo ".";
		}
		zip_close($zip);

		foreach ($emptyfiles as $name)  @file_put_contents($stagingpath . $installkey . "/" . $name, "");

		echo "\n";
	}

	function FindExtractedFile($path, $filename)
	{
		if (substr($path, -1) == "/")  $path = substr($path, 0, -1);

		if (file_exists($path . "/" . $filename))  return $path . "/" . $filename;

		$dir = opendir($path);
		if ($dir)
		{
			while (($file = readdir($dir)) !== false)
			{
				if ($file != "." && $file != "..")
				{
					if (is_dir($path . "/" . $file))
					{
						$result = FindExtractedFile($path . "/" . $file, $filename);
						if ($result !== false)  return $result;
					}
				}
			}

			closedir($dir);
		}

		return false;
	}

	function SaveInstalledData()
	{
		global $installed, $installpath;

		file_put_contents($installpath . "installed.dat", json_encode($installed));
	}

	// Track the versions of stuff that is installed.
	if (!file_exists($installpath . "installed.dat"))  $installed = array();
	else
	{
		$installed = @json_decode(@file_get_contents($installpath . "installed.dat"), true);
		if ($installed === false)  $installed = array();
	}

	if (!is_dir($stagingpath))  mkdir($stagingpath);

	// Determine if the user is only interested in a specific download.
	$downloadopts = array();
	for ($x = 1; $x < $argc; $x++)  $downloadopts[strtolower($argv[$x])] = true;
	if ($argc == 1)  $downloadopts["assistantwork"] = true;
    if ($argc == 1)  $downloadopts["php"] = true;

	

	 // Assistant Work
	 if (isset($downloadopts["assistantwork"]))
	 {
	 		$url = "";
	 		echo "\n";
            echo "Detecting latest version of  Assistant Work:\n";
            echo "  " . $url . "\n";
            echo"Please wait ... \n";
            $web = new WebBrowser();
		    $result = $web->Process($url);
        
            if (!$result["success"])  DownloadFailed("Error retrieving URL.  " . $result["error"]);
		    else if ($result["response"]["code"] != 200)  DownloadFailed("Error retrieving URL.  Server returned:  " . $result["response"]["code"] . " " . $result["response"]["meaning"]);

		    $baseurl = $result["url"];

		    $found = false;
		    $html->load($result["body"]);
		    $rows = $html->find("a[href]");
		    foreach ($rows as $row)
		    {
			if (preg_match('/^\/downloads\/releases\/assistantwork-(0\.1\.\d+)-Win32-vc15-x64.zip$/', $row->href, $matches))
			{
				echo "Found:  " . $row->href . "\n";
				echo "Latest version:  " . $matches[1] . "\n";
				echo "Currently installed:  " . (isset($installed["assistantwork"]) ? $installed["assistantwork"] : 
					  "Not installed") . "\n";
				
			    $found = true;

                if ((!defined("CHECK_ONLY") || !CHECK_ONLY) && (!isset($installed["assistantwork"]) || $matches[1]  != $installed ["assistantwork"] || isset($downloadopts["force"])))
				{
					DownloadAndExtract("assistantwork", HTTP::ConvertRelativeToAbsoluteURL($baseurl, $row->href));

					$extractpath = dirname(FindExtractedFile($stagingpath, "php.exe")) . "/";
					copy($installpath . "vc_redist/vcruntime140.dll", $extractpath . "vcruntime140.dll");

					echo "Copying staging files to final location...\n";
					$result2 = CopyDirectory($extractpath, $installpath . "php");
					if (!$result2["success"])  echo "ERROR:  Unable to copy files from staging to the final location.  Partial upgrade applied.\n" . $result2["error"] . "\n";
					else
					{
						echo "Cleaning up...\n";
						ResetStagingArea($stagingpath);

						$installed["assistantwork"] = $matches[1];
						SaveInstalledData();

						echo "Assistant Work binaries updated to " . $matches[1] . ".\n\n";
					}
				}

				break;
			}
		}
		  if (!$found)
		{
			echo "ERROR:  Unable to find latest PHP verison.  Probably a bug.\n";
			echo "Currently installed:  " . (isset($installed["php"]) ? $installed["php"] : "Not installed") . "\n";
		}
	}

	        ResetStagingArea($stagingpath);
	        rmdir($stagingpath);

	        echo "Updating finished.\n\n";	


	// PHP.
	if (isset($downloadopts["php"]))
	{
		$url = "https://windows.php.net/download/";
		echo "\n";
		echo "Detecting latest version of PHP:\n";
		echo "  " . $url . "\n";
		echo "Please wait...\n";
		$web = new WebBrowser();
		$result = $web->Process($url);

		if (!$result["success"])  DownloadFailed("Error retrieving URL.  " . $result["error"]);
		else if ($result["response"]["code"] != 200)  DownloadFailed("Error retrieving URL.  Server returned:  " . $result["response"]["code"] . " " . $result["response"]["meaning"]);

		$baseurl = $result["url"];

		$found = false;
		$html->load($result["body"]);
		$rows = $html->find("a[href]");
		foreach ($rows as $row)
		{
			if (preg_match('/^\/downloads\/releases\/php-(7\.4\.\d+)-Win32-vc15-x64.zip$/', $row->href, $matches))
			{
				echo "Found:  " . $row->href . "\n";
				echo "Latest version:  " . $matches[1] . "\n";
				echo "Currently installed:  " . (isset($installed["php"]) ? $installed["php"] : "Not installed") . "\n";
				$found = true;

				if ((!defined("CHECK_ONLY") || !CHECK_ONLY) && (!isset($installed["php"]) || $matches[1] != $installed["php"] || isset($downloadopts["force"])))
				{
					DownloadAndExtract("php", HTTP::ConvertRelativeToAbsoluteURL($baseurl, $row->href));

					$extractpath = dirname(FindExtractedFile($stagingpath, "php.exe")) . "/";
					copy($installpath . "vc_redist/vcruntime140.dll", $extractpath . "vcruntime140.dll");

					echo "Copying staging files to final location...\n";
					$result2 = CopyDirectory($extractpath, $installpath . "php");
					if (!$result2["success"])  echo "ERROR:  Unable to copy files from staging to the final location.  Partial upgrade applied.\n" . $result2["error"] . "\n";
					else
					{
						echo "Cleaning up...\n";
						ResetStagingArea($stagingpath);

						$installed["php"] = $matches[1];
						SaveInstalledData();

						echo "PHP binaries updated to " . $matches[1] . ".\n\n";
					}
				}

				break;
			}
		}
		if (!$found)
		{
			echo "ERROR:  Unable to find latest PHP verison.  Probably a bug.\n";
			echo "Currently installed:  " . (isset($installed["php"]) ? $installed["php"] : "Not installed") . "\n";
		}
	}

	ResetStagingArea($stagingpath);
	rmdir($stagingpath);

	echo "Updating finished.\n\n";
?>