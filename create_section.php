<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php require_once("includes/form_functions.php"); ?>
<?php confirm_logged_in(); ?>
<?php

// make sure the header id sent is an integer
  if (intval($_GET['surveyHeader']) == 0) {
      redirect_to('content.php');
  }

  

//Create an array to hold the errors                
      $errors = array();

// Form Validation
      $required_fields = array('section_name', 'section_title','section_subheading');

      check_required_fields($required_fields);
      foreach ($required_fields as $field_name) {
          if (!isset($_POST[$field_name]) || empty($_POST[$field_name])) {
              $errors[] = $field_name;
          }
      }

//To check maximum length of the links
      $fields_with_lengths = array('section_name' => 30);
      foreach ($fields_with_lengths as $field_name => $maxlength) {
          if (strlen(trim(mysql_prep($_POST[$field_name]))) > $maxlength) {
              $errors[] = $field_name;
          }
      }


      if (!empty($errors)) {
          redirect_to("new_section.php");
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

      /* $query = "insert into survey_headers(
        survey_name) values(
        '{$survey_name}')";
       */
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