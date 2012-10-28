<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html>
<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php confirm_logged_in(); ?>
<?php
if (intval($_GET['surveyHeader']) == 0) {
    redirect_to('content.php');
}

$id = mysql_prep($_GET['surveyHeader']);

if ($survey = get_header_by_id($id)) {


    $query = "delete from survey_headers where id = {$id} limit 1";
    $result = mysql_query($query, $connection);

    if (mysql_affected_rows() == 1) {
        redirect_to("content.php");
    } else {
        //Deletion failed
        echo "<p>Survey Deletion failed . </p>";
        echo "<p>" . mysql_error() . "</p>";
        echo "<a href=\"content.php\">Return to Main Page</a>";
    }
} else {
    //subject didn't exist in database
    redirect_to("content.php");
}
?>

<?php mysql_close($connection); ?>