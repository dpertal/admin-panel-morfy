<?php
    // required version
    if (version_compare(PHP_VERSION, "5.3.0", "<")) {exit("Panel requires PHP 5.3.0 or greater.");}


    // define only aadmin folder 
    // Separator
    define('DS', DIRECTORY_SEPARATOR);
    // Root directory
    define('ROOT', rtrim(dirname(__FILE__), '\\/'));
    // Assets folder
    define('ASSETS', ROOT.DS.'assets');
    // Controllers folder
    define('CONTROLLERS', ROOT.DS.'controllers');
    // database folder
    define('DATABASE', ROOT.DS.'database');
    // language folder
    define('LANGUAGE', ROOT.DS.'language');
    // language folder
    define('PARTIALS', ROOT.DS.'partials');
    // language folder
    define('VIEWS', ROOT.DS.'views');
    // language folder
    define('TEMPLATE', ROOT.DS.'template');
    // language folder
    define('HELPERS', ROOT.DS.'helpers');
    // backups
    define('BACKUP', ROOT.DS.'backup');
    // define access
    define('PANEL_ACCESS', true);



    // class panel
    include_once(CONTROLLERS.DS.'class.panel.php');
    // default timezone
    date_default_timezone_set(Panel::Settings('configuration','Timezone'));
    // define for out of admin  ../ folder
    define('ROOTBASE', rtrim(str_replace(array(Panel::Settings('configuration','Folder cms name')), array(''), dirname(__FILE__)), '\\/'));
    // public photos
    define('PHOTOS', ROOTBASE.DS.'public');

     // mORFY
    include_once(ROOTBASE.DS.'libraries'.DS.'Morfy'.DS.'Morfy.php');
    // class panel
    include_once(HELPERS.DS.'functions.php');   

    // session start
    session_start();

    // include layout
    include_once TEMPLATE.DS.'layout.php';


?>

