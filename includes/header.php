<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Review Website</title>
        <link href="stylesheets/public.css" media="all" rel="stylesheet"
              type="text/css" />
        <link href="stylesheets/ui-lightness/jquery-ui-1.9.1.custom.min.css" media="all" rel="stylesheet"
              type="text/css" />
        <script type="text/javascript" src="javascripts/jquery-1.8.2.js" ></script>
        <script type="text/javascript" src="javascripts/jquery-ui-1.9.1.custom.min.js" ></script> 
    </head>
    <body>

        <div id="header">
            <!-- if there are no users logged in then -->
            <?php if (!isset($_SESSION)) { ?>
                    <a href="login.php" style="color: yellow;"> LOGIN </a>
            <?php } ?>
            <h1>Review Website</h1>            

        </div>
        <div id="main">