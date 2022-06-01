<?php 

    // Assistant Work .
    // (C) 2022 UNIX24. All Rights Reserved.
   
    $about = str_replace("\\", "/", dirname(dirname(__FILE__))) . "/";
    $about2 = $about;
    require_once $about2 . "assistantwork/about.php";

    // Attempt to detect if everything is installed already.  If so, bail.
         if ($argc == 1 && file_exists($about . "php/php.ini")) 

         echo "Welcome to the Assistant Workr.\n\n";
          
          //About
      echo "About \n";
      echo "Company: UNIX24 \n";
      echo "Coppyinght:(C) 2022 All Rights Reserved. \n";
      echo "Support: support@unix24.pl \n";
      echo "Website: hhttps://unix24.pl \n";
      
         sleep(2);
         exit();
?>