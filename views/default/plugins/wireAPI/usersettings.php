<?php
/**
* User settings edit code
* 
*/


ini_set('display_startup_errors',1);
ini_set('display_errors',1);
error_reporting(-1);


global $CONFIG;
$path=$CONFIG->site->url;
//echo $path;



$guid = elgg_get_page_owner_guid();

$settings = elgg_get_all_plugin_user_settings($guid, 'wireAPI');


$name='showwire';
$token=$post_token;
$secret=$post_secret;
$user = elgg_get_logged_in_user_entity();
$username=$user->username ;
$post_plugin = elgg_get_plugin_from_id('wireAPI');

if(!get_subtype_id('object','app'.$name))



	{
	
	register_error( elgg_echo($name." application not register!!"));
forward(REFERER);

}
else
{


	if( elgg_get_entities(array('types' => 'object',
	'subtypes' => 'appname', 'title'=>'app'.$name,'owner_guid'=> elgg_get_logged_in_user_guid())))
	{
$user_plugin = elgg_get_plugin_from_id('userAPI');

$user_public = $user_plugin->getUserSetting($name.'public', $user->guid );
$user_private = $user_plugin->getUserSetting($name.'private', $user->guid );

}

$entities= elgg_get_entities(array('types' => 'object',
	'subtypes' => $name.'token','owner_guid'=> elgg_get_logged_in_user_guid()));
	if($entities)
	{
	foreach($entities as $entity)
	{$post_token=$entity->title;
	
	echo "<br/>";
	}
	}
	
	$entities2= elgg_get_entities(array('types' => 'object',
	'subtypes' => $name.'secret','owner_guid'=> elgg_get_logged_in_user_guid()));
	if($entities2)
	{
		foreach($entities2 as $entity2)
		{
	$post_secret=$entity2->title;
	
	
	}}
		
$token=$post_token;
$secret=$post_secret;
if(!$secret && !$token)
{
	echo "</br> You must generate token and secret for use '".$name."' application</br>";

}




echo "</br></br></br>";

}

?>

<div >
<input type="text" id="app" name="app" hidden value="<?php echo $name; ?>" >

</div>
<div align="center">

<div align="center">
<label><h2>Authorize for show your posts</h2></label>


<div id="show_keys" align="left" style="color:green;display:none;">

<h2> <br />Enter your public and private keys<br/></h2>







<h3>Public Key:</h3> <input type="text" id="mypublic"  name="public" value="<?php echo $user_public;?>" >
<h3>Private Key:</h3> <input type="text" id="myprivate" name="private" value="<?php echo $user_private;?>"  >

</div>

<script type="text/javascript">
var user_public="<?php echo $user_public;?>";
var user_private="<?php echo $user_private;?>";

if  ( user_public && user_private)//
{
document.getElementById('show_keys').style.display='inline';
var x=1;
}
else
{
	var x=0;
}

</script>


<div align="left">
<form >
<h2> <br />Enter your access token and secret<br/></h2>

<h3>Secret key:</h3> <input type="text" id="usersecret2" name="usecret2" value="<?php echo $post_secret; ?>"  >
<h3>Token key:</h3> <input type="text" id="usertoken2" name="utoken2" value="<?php echo $post_token;?>"  >






<input type="Button" class="elgg_button" value="Authorize" width="610px" onclick = "enter()" >


<form/>

<div align="center" >

<div id="show" style="color:green;display:none;"><?php
echo '<br/>';
echo elgg_echo('thewire:user',array($user->username));
echo '<br/>';

print_r(array_values( wire_get_posts('mine',10,0,$username)));

echo '<br/>';

echo '<br/>';
echo '<br/>';

echo elgg_echo('thewire:everyone' , array($user->username));
echo '<br/>';

print_r(array_values( wire_get_posts('all',10,0,$username)));
echo '<br/>';
echo '<br/>';

echo '<br/>';

echo elgg_echo('thewire:friends' , array($user->username));
echo '<br/>';

print_r(array_values( wire_get_posts('friends',10,0,$username)));
echo '<br/>';
echo '<br/>';


 ?>
 
 <input type="Button" class="elgg_button" value="Like" width="610px" onclick = "Like()" >
  <input type="Button" class="elgg_button" value="ShowLikers" width="610px" onclick = "ShowLikers()" >


 </div>
 </div>

<div id="like" align="left" style="color:green;display:none;">

<h2> <br />Enter post guid for like<br/></h2>


<h3>Post GUID:</h3> <input type="text" id="pid" name="pid" value=""  >
<label style="color:#3FF">For save in DB,click save button</label>



</div>

<div id="likers" align="left" style="color:green;display:none;">

<h2> <br />likers guid for all posts<br/></h2>



<?php echo show_likers();?>


</div>

<br/>
<h2>--------------------------------------------------------------------------<h2/>
<h2>--------------------------------------------------------------------------<h2/>
<h2>--------------------------------------------------------------------------<h2/>


<br />
<div align="center">
<label><h3>Generate access token and access secret</h3></label>
<br />
<div align="left">
<h4>Generate access token and secret for showwire Application.Allow?</h4>
<br />



<div align="left">




<form>

<h5>Your secret:</h5><input type="text" id="mysecret" name="secret" value="" readonly>

<h5>Your token:</h5><input type="text" id="mytoken" name="token" value="" readonly>

<input type="Button" class="elgg_button" value="generate access token and secret" width="610px" onclick = "newSecret()" >


</form>
<br/>
<label style="color:#3FF">For save in DB,click save button</label>
<script type="text/javascript">

function Like()
{
	document.getElementById('like').style.display='inline';


}
function ShowLikers()
{
		document.getElementById('likers').style.display='inline';


}
function enter()
{
if(x==1)
{


var user_public="<?php echo $user_public;?>";
var user_private="<?php echo $user_private;?>";
var post_token="<?php echo $post_token;?>";
var post_secret="<?php echo $post_secret;?>";

var secret2=document.getElementById('usersecret2').value;
var token2=document.getElementById('usertoken2').value;

var public= document.getElementById('mypublic').value;
var private= document.getElementById('myprivate').value;



token2=$.trim(token2);
secret2=$.trim(secret2);
public=$.trim(public);
private=$.trim(private);

if( public == "" || private == "" || secret2=="" || token2=="" )
    {
       
 alert("Keys is empty!!!");
    }

else
{
if( user_public == "" || user_private == ""  || post_token== "" || post_secret == "")
{
alert("no  Keys is DB!!!");


}

else
{
if(  (public == user_public) &&(private == user_private) && (secret2 == post_secret) && (token2 == post_token))
{


document.getElementById('show').style.display='inline';


  
}



else
{
alert("enter Right Keys!");
}
}
}
}


else
{
	//for client


var post_token="<?php echo $post_token;?>";
var post_secret="<?php echo $post_secret;?>";

var secret2=document.getElementById('usersecret2').value;
var token2=document.getElementById('usertoken2').value;



token2=$.trim(token2);
secret2=$.trim(secret2);


//var public2= document.getElementById('mypublic2').value;
//var private2= document.getElementById('myprivate2').value;


if( token2=="" || secret2=="" )
    {
       
 alert("Keys is empty!!!");
    }

else
{
if(  post_token== "" || post_secret == "")
{
alert("no  Keys is DB!!!");


}

else
{
if(   (secret2 == post_secret) && (token2 == post_token))
{

//alert("authorized");
document.getElementById('show').style.display='inline';


  
}



else
{
alert("enter Right Keys!");
}
}
}


}
}



function newSecret()
{
    var xstr = "";
    qrurl = "";
    
    window.XMLHttpRequest
    {
        xmlhttp = new XMLHttpRequest();
    }
    
    //xmlhttp=new XMLHttpRequest();
    xmlhttp.onreadystatechange=function() 
    {
        if (xmlhttp.readyState==4 && xmlhttp.status==200) 
        {

            //alert(xmlhttp.responseText);
          xstr=xmlhttp.responseText;
		  if(xstr != "")
		  {
             var res = xstr.split(";");
             document.getElementById('mytoken').value = res[1];
             document.getElementById('mysecret').value = res[0];
		  }
		  else
          {
             alert("You don't have a secret!");
          }
        }
    }
var path='<?php echo $path;?>';
    xmlhttp.open("GET",path+"mod/wireAPI/views/default/wireAPI/coder.php",true);
    xmlhttp.send();
}
 

</script>
