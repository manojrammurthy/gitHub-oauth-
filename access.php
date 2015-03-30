<?php
session_start();
include('db.php'); //Database Connection. 

require_once('Github_Lib/githubConfig.php');
require_once('Github_Lib/githubApi.php');
if($_SERVER['REQUEST_METHOD'] == 'GET');
$git = new githubApi($config);
$_SESSION['data'] = $git->getUserDetails();
$_SESSION['github_data'] = $git->getAllUserDetails();

if(isset($_SESSION['data']) && isset($_SESSION['github_data']))
 {
 	
  		$val = $git->getAccessToken();
 		$userdata = $_SESSION['github_data'];
		$email = $userdata->email;
		$fullName = $userdata->name;
		$company = $userdata->company;
		$blog = $userdata->blog;
		$location = $userdata->location;
		$github_id = $userdata->id;
		$github_username = $userdata->login;
		$profile_image = $userdata->avatar_url;
		$github_url = $userdata->url;

		 $_SESSION['repo'] = $git->repo();
		//echo $_SESSION['repo'][1][0]->name;
		 //$max = sizeof($_SESSION['repo'][1]);

				$repository = array();
			 foreach ($_SESSION['repo'][1] as $key => $value)
			  {
			 	
			 	$repository[]= array('reponame'=>$value->name,'repourl'=>$value->html_url);
			 	// echo $value->name ."<br>"; 	
			 	// echo $value->html_url."<br>";
			  }
			  $val1 = json_encode($repository);
			  $repostring = json_decode($val1);
			  $repostring1 = serialize($repostring);
			  

			  $q=mysqli_query($connection,"SELECT id FROM gh_profile WHERE email='$email'");
			  if(mysqli_num_rows($q) == 0)
					{
					$insert =mysqli_query($connection,"INSERT INTO gh_profile(name,email,company,blog,location,githubid,githubusername,profileimage,githuburl,accesstoken,repository) VALUES('$fullName','$email','$company','$blog','$location','$github_id','$github_username','$profile_image','$github_url','$val','$repostring1')");
					}
				else{
						$userdatabase = mysqli_query($connection,"SELECT email , location  FROM gh_profile WHERE email='$email'");
						$uservalues = mysqli_fetch_array($userdatabase);
						
					}
	}
 echo "<pre>";
 
echo "i know you are re visitor from"  . $uservalues[1];
echo "</pre>";

echo "<h1>Welcome to ".$fullName."</h1>";

echo "<a href='logout.php'>Logout</a>";
else {
	header('location:index.php');
}
?>
