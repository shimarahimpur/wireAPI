<?php 

function wire_get_posts($context, $limit = 10, $offset = 0, $username) {
	if(!$username) {
		$user = elgg_get_loggedin_user_entity();
	} else {
		$user = get_user_by_username($username);
		if (!$user) {
			throw new InvalidParameterException('registration:usernamenotvalid');
		}
	}
		
	if($context == "all"){
		$params = array(
			'types' => 'object',
			'subtypes' => 'thewire',
			'limit' => $limit,
			'full_view' => FALSE,
			'no_results' => elgg_echo('thewire:noposts'),
		);
		}
		if($context == "mine" || $context == "user"){
		$params = array(
			'types' => 'object',
			'subtypes' => 'thewire',
			'owner_guid' => $user->guid,
			'limit' => $limit,
			'full_view' => FALSE,
			'no_results' => elgg_echo('thewire:noposts'),
		);
		}
		$latest_wire = elgg_get_entities($params);
		
		if($context == "friends"){
			$options = array(
	'type' => 'object',
	'subtype' => 'thewire',
	'full_view' => false,
	'no_results' => elgg_echo('thewire:noposts'),

);



		$latest_wire = $user->getFriendsObjects($options,  $limit, $offset);
		


		}

if($latest_wire){
	foreach($latest_wire as $single ) {
		$wire['guid'] = $single->guid;
		
		$owner = get_entity($single->owner_guid);
		$wire['owner']['guid'] = $owner->guid;
		$wire['owner']['name'] = $owner->name;
		$wire['owner']['avatar_url'] = elgg_view_entity_icon($owner,'small');
			
		$wire['time_created'] = (int)$single->time_created;
		$wire['description'] = $single->description;
		$return[] = $wire;
	} 
} else {
			$msg = elgg_echo('thewire:noposts');
	$return[]=$msg ;
}
	
					   echo json_encode($return,true).'<br/>';


	} 
				
				
				function like_post_API($entity_guid)
				{
					
		
		$params = array(
			'types' => 'object',
			'subtypes' => 'thewire',
			'guid'=>$entity_guid,
			
		);
		
				$latest_wire = elgg_get_entities($params);
								

if (elgg_annotation_exists($entity_guid, 'likes')) {
//delete like
if ($entity_guid) {
	$like = elgg_get_annotation_from_id($entity_guid);
}

if (!$like) {
	$likes = elgg_get_annotations(array(
		'guid' => $entity_guid,
		'annotation_owner_guid' => elgg_get_logged_in_user_guid(),
		'annotation_name' => 'likes',
	));
	$like = $likes[0];
}
if($latest_wire)
	{
if ($like && $like->canEdit()) {
	
	$like->delete();
	
//echo elgg_echo("likes:deleted");
return '3';
//return 'delete';
	}
	


else
{
//echo elgg_echo("likes:notdeleted");
//return 'notdelete';
return '4';
}
	}else
	{
		return '6';
	}

}
else
{
// Let's see if we can get an entity with the specified GUID
$entity = get_entity($entity_guid);
if (!$entity) {
	//echo elgg_echo("likes:notfound"); 
	//return'not found';
	return '5';
}
if($latest_wire)
{
$user = elgg_get_logged_in_user_entity();
$annotation_id = create_annotation($entity->guid,
								'likes',
								"likes",
								"",
								$user->guid,
								$entity->access_id);

// tell user annotation didn't work if that is the case
if (!$annotation_id) {
	//echo elgg_echo("likes:failure");
	//return 'like failure';
	return '2';
}

// notify if poster wasn't owner

return '1';
//echo elgg_echo("likes:likes");
//return 'like';

				
				
}
else
{
	return '6';
}
				}
				}
		
		
		
		
		
		function show_likers( )
		{
			$params = array(
			'types' => 'object',
			'subtypes' => 'thewire',
			'limit' => $limit,
			'full_view' => FALSE,
			'no_results' => elgg_echo('thewire:noposts'),
		);
		
		
				$latest_wire = elgg_get_entities($params);

		if($latest_wire){
	foreach($latest_wire as $single ) {
		$wire['guid'] = $single->guid;
		$wire['owner']= user_like($single->guid);
		
		$return[] = $wire;
	} 
} 
		//return $return;
							   echo json_encode($return,true).'<br/>';

		
		}
		
		
		
function user_like($entity_guid)
{
	//if (elgg_annotation_exists($entity_guid, 'likes')) 
//{

if ($entity_guid) {
	$like = elgg_get_annotation_from_id($entity_guid);
}


if (!$like)
 {
	$likes = elgg_get_annotations(array(
		'guid' => $entity_guid,
		//'annotation_owner_guid' => elgg_get_logged_in_user_guid(),
		'annotation_name' => 'likes',
	));
	
	foreach($likes as $like)
	{
		$return[]=$like['owner_guid'];

	

}
}
//}
return $return;
}
