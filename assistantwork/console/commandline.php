<?php 
     // Assistant Work .
     // (C) 2022 UNIX24. All Rights Reserved.
     
     // Include the Console_CommandLine package.
     require_once 'assistantwork/console/commandline.php';

     // create the parser
     $parser = new Console_CommandLine(array(
    'description' => 'zip given files using the php zip module.',
    'version'     => '1.0.0'
));

    // add an option to make the program verbose
    $parser->addOption(
    'verbose',
    array(
        'short_name'  => '-v',
        'long_name'   => '--verbose',
        'action'      => 'StoreTrue',
        'description' => 'turn on verbose output'
    );

    // add the files argument, the user can specify one or several files
    $parser->addArgument(
    'files',
    array(
        'multiple' => true,
        'description' => 'list of files to zip separated by spaces'
    );

    // run the parser
try {
    $result = $parser->parse();
    // run your program here...
    print_r($result->options);
    print_r($result->args);
} catch (Exception $exc) {
    $parser->displayError($exc->getMessage());
}


?>