<?php
$secret=get_input('secret');
$token=get_input('token');
$plugin_id = get_input('plugin_id');
$user_guid = get_input('user_guid', elgg_get_logged_in_user_guid());
$plugin = elgg_get_plugin_from_id($plugin_id);
$user = get_entity($user_guid);


$name=get_input('app');
$entity_guid=get_input('pid');



$user_guid = elgg_get_logged_in_user_guid();

if (!($plugin instanceof ElggPlugin)) {
	register_error(elgg_echo('plugins:usersettings:save:fail', array($plugin_id)));
	forward(REFERER);
}

if (!($user instanceof ElggUser)) {
	register_error(elgg_echo('plugins:usersettings:save:fail', array($plugin_id)));
	forward(REFERER);
}

$plugin_name = $plugin->getManifest()->getName();

// make sure we're admin or the user
if (!$user->canEdit()) {
	register_error(elgg_echo('plugins:usersettings:save:fail', array($plugin_name)));
	forward(REFERER);
}





if($entity_guid)
{
$msg= like_post_API($entity_guid);
if($msg=='1')
{
	$t=true;
	$message= elgg_echo("likes:likes");

}
if($msg=='2')
{
		$t=false;

	$message=elgg_echo("likes:failure");
}
if($msg=='3')
{
		$t=true;

	$message=elgg_echo("likes:deleted");

}
if($msg=='4')
{
			$t=false;

	$message=elgg_echo("likes:notdeleted");
}
if($msg=='5')
{
			$t=false;

	$message=elgg_echo("likes:notfound"); 
}

if($msg=='6')
{
				$t=false;

		$message=elgg_echo("guid not for one wire!! "); 

}
if ($token!=""&& $secret!="")
{ 

	
if(elgg_get_entities(array('types' => 'object',
	'subtypes' => $name.'token','owner_guid'=> elgg_get_logged_in_user_guid())) && elgg_get_entities(array('types' => 'object',
	'subtypes' => $name.'secret','owner_guid'=> elgg_get_logged_in_user_guid()))) 
{
	$entities= elgg_get_entities(array('types' => 'object',
	'subtypes' => $name.'token','owner_guid'=> elgg_get_logged_in_user_guid()));
	if($entities)
	{
	foreach($entities as $entity)
	{
		$entity->delete();
		}
	
	}
	$entities2= elgg_get_entities(array('types' => 'object',
	'subtypes' => $name.'secret','owner_guid'=> elgg_get_logged_in_user_guid()));
	if($entities2)
	{
		foreach($entities2 as $entity2)
	{
			$entity2->delete();
	}
	}
	
	
	
	
	$entity=new ElggObject();

$entity -> subtype =$name.'token';


$entity -> title=$token;
$entity->save();

$entity2=new ElggObject();

$entity2 -> subtype =$name.'secret';
$entity2 -> title =$secret;


$entity2->save();

if($entity ->save()&& $entity2->save())
{
		if($t)
	{
	system_message(elgg_echo($message));
	}
	else
	{
		register_error(elgg_echo($message));

	}

system_message(elgg_echo($name.":keys updated"));
forward(REFERER);

}
}}

else
{
	if($t)
	{
	system_message(elgg_echo($message));
	}
	else
	{
		register_error(elgg_echo($message));

	}
}

}

else

{
	
	if ($token!=""&& $secret!="")
{ 
if(!elgg_get_entities(array('types' => 'object',
	'subtypes' => $name.'token','owner_guid'=> elgg_get_logged_in_user_guid())) && !elgg_get_entities(array('types' => 'object',
	'subtypes' => $name.'secret','owner_guid'=> elgg_get_logged_in_user_guid()))) 
	{
	$entity=new ElggObject();
$entity -> subtype =$name.'token';

$entity -> title=$token;
$entity->save();

$entity2=new ElggObject();
$entity2 -> subtype =$name.'secret';
$entity2 -> title =$secret;

$entity2->save();

if($entity ->save()&& $entity2->save())
{
system_message(elgg_echo($name.":new keys saved"));
forward(REFERER);

}
	}
else
{
	$entities= elgg_get_entities(array('types' => 'object',
	'subtypes' => $name.'token','owner_guid'=> elgg_get_logged_in_user_guid()));
	if($entities)
	{
	foreach($entities as $entity)
	{
		$entity->delete();
		}
	
	}
	$entities2= elgg_get_entities(array('types' => 'object',
	'subtypes' => $name.'secret','owner_guid'=> elgg_get_logged_in_user_guid()));
	if($entities2)
	{
		foreach($entities2 as $entity2)
	{
			$entity2->delete();
	}
	}
	
	
	
	
	$entity=new ElggObject();
$entity -> subtype =$name.'token';

$entity -> title=$token;
$entity->save();

$entity2=new ElggObject();
$entity2 -> subtype =$name.'secret';
$entity2 -> title =$secret;

$entity2->save();

if($entity ->save()&& $entity2->save())
{
system_message(elgg_echo($name.":keys updated"));
forward(REFERER);

}
}}
else
{
	if(!elgg_get_entities(array('types' => 'object',
	'subtypes' => $name.'secret' ,'owner_guid'=> elgg_get_logged_in_user_guid())) && !elgg_get_entities(array('types' => 'object',
	'subtypes' => $name.'token','owner_guid'=> elgg_get_logged_in_user_guid()))) 
	{
		register_error(elgg_echo($name.":keys is empty"));
forward(REFERER);

	}
	else
	{
	$entities= elgg_get_entities(array('types' => 'object',
	'subtypes' => $name.'token','owner_guid'=> elgg_get_logged_in_user_guid()));
	if($entities)
	{
	foreach($entities as $entity)
	{
		$entity->delete();
	}
	
	}
	$entities2= elgg_get_entities(array('types' => 'object',
	'subtypes' => $name.'secret', 'title'=>$name.'secret','owner_guid'=> elgg_get_logged_in_user_guid()));
	if($entities2)
	{
	foreach($entities2 as $entity2)
	{
		$entity2->delete();
	}
	}
	
	
	
	system_message(elgg_echo($name.":keys deleted"));
forward(REFERER);

	
}}

	
}
