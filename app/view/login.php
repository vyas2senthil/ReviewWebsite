<?php

$loginUsername= $_POST[username];
$loginPassword= $_POST[password];

if($loginUsername == 'a' && $loginPassword == 'b'){
    $header = header("Location: surverTakerPage.php");
}
else{
    echo "invalid username or password";
}
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>



<html>
    <head>
        <title>Login Page</title>
        <link rel="stylesheet" type="text/css" href="../../stylesheets/stylesheet.css" />
    </head>
    
    
    <body>
        <div id="loginForm">
            <form id="login" action="post">
                <legend><h1>LOGIN : </h1></legend>
                <input type="text" value="Username :" /><br/>
                <input type="password" value="Password :" /><br/>
                <input type="button" value="Submit" />
                <input type="reset">
            </form>
        </div>
    </body>
    
    
</html>