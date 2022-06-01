<?php 

    // Assistant Work .
    // (C) 2022 UNIX24. All Rights Reserved.
   
      $awbase = str_replace("\\", "/", dirname(dirname(__FILE__))) . "/";
      
      
    // Attempt to detect if everything is installed already.  If so, bail.
         if ($argc == 1 && file_exists($awbase . "php/php.ini")) 
        {
            echo "The SubiektGT has already completed.  If you are running run 'subiektgt.bat' instead.\n";

        sleep(2);
        exit();
    }
         echo "Running SubiektGT.\n\n";
          
    //SubiektGT 
      define("SUBIEKTtGT_ONLY", true);   
      echo " Running SubiektGT \n";
      require_once $awbase . "assistantwork/subiektgt.php";
     
         echo "Done.\n";
        
         sleep(3);
         exit();
?>