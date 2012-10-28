<?php require_once("includes/functions.php"); ?>
<?php 
    //Closing the session
    
    //Finding the session
    session_start();
    
    //Unsetting all the session variables
    $_SESSION = array();
    
    //Destroy the session cookie
    if(isset($_COOKIE[session_name()])){
        setcookie(session_name(),'',time()-42000,'/');
    }

    //Destroy the session
    session_destroy();
    
    redirect_to("login.php?logout=1");
?>
