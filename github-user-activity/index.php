<?php

// echo 'Enter github username: ';
// $username = fgets(STDIN);
// echo $username;

// API
// https://api.github.com/users/<username>/events
$url = "https://api.github.com/users/LaurynasKl/repos";
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
print_r($response);