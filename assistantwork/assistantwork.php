<?php 
     // Assistant Work .
     // (C) 2022 UNIX24. All Rights Reserved.
    
    $awbase = str_replace("\\", "/", dirname(dirname(__FILE__))) . "/";
    $awbase2 = $awbase;
    require_once $awbase . "assistantwork/awbase.php";
    
    // Attempt to detect if everything is installed already.  If so, bail.
	      if ($argc == 1 && file_exists($awbase . "php/php.ini"))
        {
		        
            echo "The Assistant Work has already completed.  If you are running, run '' instead.\n";

		sleep(2);
		exit();
	}
  
       echo "Welcome to the Assistant Workr.\n\n";
     
     // Assistant Work
         echo"Please wait ... \n";
         echo "Running Assistant Work ....\n";
         $assistantwork = str_replace("\\", "/", dirname(dirname(__FILE__))) . "/";
         $assistantwork2 = $assistantwork;
         
    //About
      if (isset($about ["about"]))
      {  
          echo "\n";
          echo "About \n";
          $about = str_replace("\\", "/", dirname(dirname(__FILE__))) . "/";
          $about2 = $about
          require_once  $about2 . "assistantwork/about2.php";
      
      } 

      echo " The About has already completed.  If you are running run 'abut.bat' .\n";
              
        echo "Done.\n";
        sleep(2);
        exit();

        //INSERTGT
     if (isset($insertgt ["insertgt"]))
    {   
          $name = "INSERTGT";
          echo ($name) ."\n";
          $insertgt = str_replace("\\", "/", dirname(dirname(__FILE__))) . "/";
          $insertgt2 = $insertgt;
          require_once  $insertgt2 . "assistantwork/support/insertgt.php";
    }

    echo "The INSERT GT has already completed.  If you are running run 'insertgt.bat' .\n";
     
     echo "Done.\n";
        sleep(2);
        exit();

     //INSERTNEXO
       if (isset($insertnexo ["insertnexo"])) 
       {
          $name = "INSERTNEXO";
          echo ($name) ."\n";
          $insertnexo = str_replace("\\", "/", dirname(dirname(__FILE__))) . "/";
          $insertnexo2 = $insertnexo ;
          require_once  $insertnexo2 . "assistantwork/support/insertnexo.php";
       }
       
         echo "The INSERT NEXO has already completed.  If you are running run 'insertnexo.bat' .\n";
         
     //Thunderbird
       if (isset($thunderbird ["thunderbird"])) 
       { 
           $name = 'Thunderbird'
           echo ($name) ."\n";
           $thunderbird  = str_replace("\\", "/", dirname(dirname(__FILE__))) . "/";
           $thunderbird2 =  $thunderbird
           require_once $thunderbird2 . "assistantwork/thunderbird.php";
        
        }

            echo "The Thunderbird has already completed.  If you are running, run 'thunderbird.bat' .\n";

   //Office
     if (isset($office ["office"]))
      { 
        $name = "Office"
        echo ($name) . " \n";
        $office = str_replace("\\", "/", dirname(dirname(__FILE__))) . "/";
        $office2 = $office;

      }
     echo "The Office has already completed.  If you are running, run 'office.bat' .\n";

   //Firefox
     if (isset($firefox ["firefox"])) 
     { 
      $name = "Firefox"
      echo ($name) . " \n";
      $firefox = str_replace("\\", "/", dirname(dirname(__FILE__))) . "/";
      $firefox2 = $firefox;
      require_once $firefox2 . "assistantwork/firefox.php";

     }       
     
     echo "The Firefox has already completed.  If you are running, run 'firefox.bat' .\n";
       
       echo "Done.\n";
       sleep(2);
       exit();

       define("AW_ONLY", true);
	     echo "Running Assistant Work software (no download)...\n";
	     require_once $assistantwork2 . "assistantwork/assistantwork.php";

      echo "Done.\n";
      sleep(3);
      exit();
?>