<?php 
  // Assistant Work .
 // (C) 2022 UNIX24. All Rights Reserved.
    
      if(!isset($forceoffice))  $forceoffice = false;

    require_once $office . "assistantwork/office/libre_office.php";
    require_once $office . "assistantwork/office/open_office.php";
    require_once $office . "assistantwork/office/excel.php";
    require_once $office . "assistantwork/office/powerpoin.php";
    require_once $office . "assistantwork/office/word.php";
    require_once $office . "assistantwork/office/outlook.php";
    
    function ResetStagingOffice($path)
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
                        ResetStagingOffice($path . "/" . $file);
                        rmdir($path . "/" . $file);
                    }

                }

                   closedir($dir);

    }


?>