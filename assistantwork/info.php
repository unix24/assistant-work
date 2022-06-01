<?php 

    // Assistant Work .
    // (C) 2022 UNIX24. All Rights Reserved.
   
      $awbase = str_replace("\\", "/", dirname(dirname(__FILE__))) . "/";
      
      
    // Attempt to detect if everything is installed already.  If so, bail.
         if ($argc == 1 && file_exists($about . "php/php.ini")) 
        {
        echo "The Assistant Work has already completed.  If you are running, run 'about.bat' instead.\n";

        sleep(2);
        exit();
    }
        
         echo "Welcome to the Assistant Workr.\n\n";
          
          define("INFO_ONLY", true);
          echo "Prout Information (no download)...\n";
          require_once $awbase. "assistantwork/about.php";

      //Prout Information
      echo " Prout name Assistant Work\n";
      echo "Company: UNIX24 \n";
      echo "Version: 0.0.1-RC \n";
      echo "Coppyinght:(C) 2022 All Rights Reserved. \n";
      echo "Support: support@unix24.pl \n";
      echo "Website: hhttps://unix24.pl \n";
      
         sleep(3);
         exit();
?>