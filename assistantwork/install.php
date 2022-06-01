<?php 
    // Assistant Work .
    // (C) 2022 UNIX24. All Rights Reserved.
    
    $awbase = str_replace("\\", "/", dirname(dirname(__FILE__))) . "/";
    $awbase2 = $awbase

   // Attempt to detect if everything is installed already.  If so, bail.
    if($argc == 1 && file_exists($awbase . "php/php.ini"))
    {
        echo "The Assistant Work has already completed.  If you are upgrading, run 'upgrade.bat' instead.\n";

         sleep(2);
         exit();
    }

    $fp = fopen("php://stdin", "rb"); 
    
    echo "The Assistant Work  has already completed.  If you are upgrading, run '.bat' instead.\n";
    
    echo "Downloading software...\n";
    echo "(This will take a while, so go get some coffee or a snack)\n\n";
    require_onece $awbase2 . "assistantwork/download.php";

    echo "\n";
    echo "-----------------------------------------------------------------\n";
    echo "\n";
    echo "You will now be asked a few questions about your desired setup.\n";
    echo "Press 'Enter' to accept default values.\n";
    echo "Press 'Ctrl-C' at any time to abort the install.\n";

    echo "\n";
    echo "-----\n";
    echo "Path mode can be either 'portable' or 'hardcoded'.\n";
    echo "'portable' strips the drive letter.  'hardcoded' keeps it.\n";
    echo "\n";
    echo "Hardcoded path:  " . $awbase . "\n";
    $portablepath = (substr($awbase, 1, 1) == ":" ? substr($basepath, 2) : $basepath);
    echo "Portable path:  " . $portablepath . "\n";
    echo "\n";
    do
    {
        echo "Path mode [portable]: ";
        $line = substr(trim(strtolower(fgets($fp))), 0, 1);
    } 
    while ($line != "" && $line != "p" && $line != "h");
    if ($line != "h")  $basepath = $portablepath;

    if (isset($downloadopts["php"]))
    {
        echo "\n";
        echo "-----\n";
        echo "The PHP configuration type to use from the distribution.\n";
        echo "\n";
        do
        {
            echo "PHP config (dev or prod) [dev]: ";
            $line = substr(trim(strtolower(fgets($fp))), 0, 1);
        } while ($line != "" && $line != "d" && $line != "p");
        $php_config = ($line == "" || $line == "d" ? "php.ini-development" : "php.ini-production");
    }

     // All of the information has been gathered.  Perform install.
    echo "\n";
    echo "-----\n";
    echo "Configuring.  This should only take a moment to complete.\n";

    require_onece $awbase2 . "assistantwork/awbase.php";

    // PHP.
    if (isset($downloadopts["php"]))
    {
        if (!is_file($awbase2 . "php/php.ini"))  copy($awbase2 . "php/" . $php_config, $awbase2 . "php/php.ini");
    }

    echo "Done.\n";
    sleep(3);   
?>