<?php

/*////////////////////////////////////////////////////////////////////////////////////////////////////////////

@author Novi Sonko 2012

////////////////////////////////////////////////////////////////////////////////////////////////////////*/

$version= "v1";

//-----------------------------------------------------------

require_once("lib/main/settings/default_settings.php");
require_once("lib/".$version."/settings/version_settings.php");
require_once("lib/main/controllers/main_controller.php");

//---------------------------------------------------------

define("FATAL_MSG", "<br/>This service is not available, please try again later.<hr/> ");

if (!class_exists("default_settings") || !class_exists("version_settings") || !class_exists("main_controller")) {
    exit(FATAL_MSG."Error ind1_nbc");
}

//----------------------------------------------------------

main_controller::start($version);

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
