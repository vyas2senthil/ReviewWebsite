<?php require_once("includes/session.php"); ?>
<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>


    
    
    /**
     * Function to show appropriate views when the Question type is selected.
     */
    function ajaxCall(s) {
        $(select).change(function (){
            
                   var selected_value = $("options_list").val();
                    if(selected_value=='text'){
        
                    }else if(selected_value=='checkbox'){
                        
                       var htmlDiv = "";
                        
                        
                        
                        $("question_options").html(htmlDiv);
                    }else if(selected_value=='select'){
                        
                    }else if(selected_value=='multi-select'){
                        
                    }else if(selected_value=='radio-select'){
                        
                    }else{
                        
                    }
            
        })
               
    }


</script>

<?php confirm_logged_in(); ?>

<?php
    // make sure the subject id sent is an integer
    if (intval($_GET['surveySection']) == 0) {
        redirect_to('content.php');
    }

    include_once("includes/form_functions.php");

    // START FORM PROCESSING
    // only execute the form processing if the form has been submitted
    if (isset($_POST['submit'])) {


        // initialize an array to hold our errors
        $errors = array();

        // perform validations on the form data
        $required_fields = array('section_name', 'section_title', 'section_subheading');
        $errors = array_merge($errors, check_required_fields($required_fields, $_POST));
        $fields_with_lengths = array('section_name' => 30);
        $errors = array_merge($errors, check_max_field_lengths($fields_with_lengths, $_POST));

        // clean up the form data before putting it in the database
        $header_id = mysql_prep($_GET['surveyHeader']);
        $section_name = trim(mysql_prep($_POST['section_name']));
        $section_title = mysql_prep($_POST['section_title']);
        $section_subheading = mysql_prep($_POST['section_subheading']);
        $section_required = mysql_prep($_POST['section_required']);

        // Database submission only proceeds if there were NO errors.
        if (empty($errors)) {
            $query = "INSERT INTO survey_sections (
						survey_header_id,section_name, section_title, section_subheading, section_required
					) VALUES (
						'{$header_id}','{$section_name}', '{$section_title}', '{$section_subheading}', '{$section_required}'
					)";
            if ($result = mysql_query($query, $connection)) {
                // as is, $message will still be discarded on the redirect
                $message = "The page was successfully created.";
                // get the last id inserted over the current db connection
                $new_section_id = mysql_insert_id();
                redirect_to("content.php?surveySection={$new_section_id}");
            } else {
                $message = "The section could not be created.";
                $message .= "<br />" . mysql_error();
            }
        } else {
            if (count($errors) == 1) {
                $message = "There was 1 error in the form.";
            } else {
                $message = "There were " . count($errors) . " errors in the form.";
            }
        }
        // END FORM PROCESSING
    }
?>




<?php find_selected_section(); ?>
<?php include("includes/header.php"); ?> 
<table id="structure">
    <tr>
        <td id="navigation">
            <?php echo navigation($sel_header, $sel_section); ?>
            <br/>
            <a href="new_survey.php">+ Add a new Section </a>
        </td>
        <td id="page">
            <h2>Add New Question</h2>
            <?php
                if (!empty($message)) {
                    echo "<p class=\"message\">" . $message . "</p>";
                }
            ?>
            <?php
                if (!empty($errors)) {
                    display_errors($errors);
                }
            ?>

            <form action="new_question.php?surveySection=<?php echo $sel_section['id']; ?>" method="post">
<?php $new_section = true; ?>
                <p>Question text :
                    <input type="text" name="question_name" value="" id="question_name" size="64"/></p>
                <p>Question type :
                    <select id="options_list" name="options_list" onchange="ajaxCall(this)">
                        <?php
                            //Getting all the question types from the database.
                            $result = get_all_fields('input_types');
                            while ($row = mysql_fetch_array($result)) {
                                echo "<option>{$row['input_type_name']}</option>";
                            }
                        ?>

                    </select>

                    <!-- the below options are according to the question type selected. -->
                <div id="question_options">
                    <div id="text">
                        <textarea rows="4" cols="15"></textarea>
                    </div>
                    <div id="select">
                        <form>
                            <input name="group 1">
                        </form>
                    
                    </div>
                    
                </div>

                <p>Answer Required:
                    <input type="radio" name="answer_required" value="0" /> No
                    &nbsp;
                    <input type="radio" name="answer_required" value="1" /> Yes
                </p>
                <input type="submit" name="submit" value="Add Question" />

            </form>
            <br/>
            <a href="edit_section.php?surveyHeader=<?php echo $sel_header['id']; ?>">Cancel</a><br/>
        </td>
    </tr>
</table>
<?php require("includes/footer.php") ?>

