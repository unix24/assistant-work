<?php 

    // Assistant Work .
    // (C) 2022 UNIX24. All Rights Reserved.
   
      $awbase = str_replace("\\", "/", dirname(dirname(__FILE__))) . "/";
      

    // Attempt to detect if everything is installed already.  If so, bail.
         if ($argc == 1 && file_exists($awbase . "php/php.ini")) 
         {
           echo "The Firefox has already completed.  If you are running, run 'firefox.bat' instead.\n";

        sleep(2);
        exit();

         echo "Welcome to the Assistant Workr.\n\n";

         define("FIREFOX_ONLY", true);
         echo "Running Firefox (no download)...\n";
         require_once $awbase . "assistantwork/firefox.php"; 

         //Firefox
           echo "Firefox path [" . $firefox . "firefox]:"; \n";
         
         echo "Done. \n";
        
         sleep(3);
         exit();
?>