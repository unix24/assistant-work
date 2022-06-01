<?php 

    // Assistant Work .
    // (C) 2022 UNIX24. All Rights Reserved.
   
      $awbase = str_replace("\\", "/", dirname(dirname(__FILE__))) . "/";
      
    // Attempt to detect if everything is installed already.  If so, bail.
         if ($argc == 1 && file_exists($awbase . "php/php.ini")) 
        {
        echo "The Assistant Work has already completed.  If you are raning, run 'info.bat' instead.\n";

        sleep(2);
        exit();
    }
        
         echo "Welcome to the Assistant Workr.\n\n";
          
          define("ABOUT_ONLY", true);
          echo "Information software (no download)...\n";
          require_once $awbase . "assistantwork/info.php";

      //About
      echo "About UNIX24\n";
      echo "Company: UNIX24 \n";
      echo "Coppyinght:(C) 2022 All Rights Reserved. \n";
      echo "Support: support@unix24.pl \n";
      echo "Website: hhttps://unix24.pl \n";
      
         sleep(3);
         exit();
?>