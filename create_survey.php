<?php require_once("includes/session.php"); ?>
<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php require_once("includes/form_functions.php"); ?>
<?php confirm_logged_in(); ?>
<?php

    $errors = array();

// Form Validation
    $required_fields = array('survey_name', 'position');



// To check if the field are empty and if they are to add it to the error array
    $errors = array_merge($errors, check_required_fields($required_fields));

//To check maximum length of the links
    $fields_with_lengths = array('survey_name' => 30);
    $errors = array_merge($errors, check_max_field_lengths($fields_with_length));

    if (!empty($errors)) {
        redirect_to("new_survey.php");
    }
?>


<?php

    $survey_name = mysql_prep($_POST['survey_name']);
    $position = mysql_prep($_POST['position']);
    $visible = mysql_prep($_POST['visible']);
    $organization = mysql_prep($_POST['organization']);
?>

<?php

    $query = "insert into survey_headers(
              survey_name,position,visible,organization_id
              ) values (
                    '{$survey_name}',{$position},{$visible},{$organization}
                        )";

    $result = mysql_query($query, $connection);
    if ($result) {
        //Success !
        header("Location: content.php");
        exit;
    } else {
        //Display error message
        echo "<p>Survey creation failed.</p>";
        echo "<p>" . mysql_error() . "</p>";
    }
?>
<?php mysql_close($connection); ?>