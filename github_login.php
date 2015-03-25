<?php
require_once('Github_Lib/githubConfig.php');

$url = "https://github.com/login/oauth/authorize?client_id=".$config['client_id']."&redirect_uri=".$config['redirect_url']."&scope=user,user:email,public_repo,read:org";
header("Location: $url");

?>