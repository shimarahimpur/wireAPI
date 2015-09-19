<?php

ini_set('display_startup_errors',1);
ini_set('display_errors',1);
error_reporting(-1);

elgg_register_event_handler('init', 'system', 'wireAPI_init');
function wireAPI_init() 
{

	global $CONFIG;
	$actionspath = $CONFIG->pluginspath . "wireAPI/actions/wireAPI";
	elgg_register_action("wireAPI/usersettings/save", "$actionspath/usersettings/save.php");


elgg_register_library('wire:show', elgg_get_plugins_path() . 'wireAPI/lib/wire.php');
elgg_load_library('wire:show');

}

