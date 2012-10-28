<?php require_once("includes/session.php"); ?>
<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php require_once("includes/form_functions.php"); ?>
<?php confirm_logged_in(); ?>
<?php
if (intval($_GET['surveySection']) == 0) {
    redirect_to('content.php');
}

if (isset($_POST['submit'])) {
    $errors = array();

    // Form Validation
    $required_fields = array('section_name', 'section_title', 'section_subheading');

    $errors =  array_merge($errors,check_required_fields($required_fields));
    //To check maximum length of the links
    $fields_with_lengths = array('section_name' => 30);
    $errors=array_merge($errors,check_max_field_lengths($fields_with_lengths));


    if (empty($errors)) {
        //Perform update
        /**
         *  ID of the survey section 
         */
        $id = mysql_prep($_GET['surveySection']);
        // The trim command removes the white space before and after the field value to keep it clean.
        $section_name = trim(mysql_prep($_POST['section_name'])); 
        $section_title = mysql_prep($_POST['section_title']);
        $section_subheading = mysql_prep($_POST['section_subheading']);
        $section_required = mysql_prep($_POST['section_required']);

        $query = "update survey_sections set 
                    section_name='{$section_name}',
                    section_title='{$section_title}',
                    section_subheading='{$section_subheading}',
                    section_required='{$section_required}' 
                     where id={$id} ";
        $result = mysql_query($query, $connection);

        if (mysql_affected_rows() == 1) {
            //Update success
            $message = "The survey was updated successfully";
        } else {
            //Update failed
            $message = "The survey update failed";
            $message.="<br/>" . mysql_error();
        }
    } else {
        if(count($errors)==1){
        // Errors occurred
        $message = "There was " . count($errors) . " error in the form";
    
        }else{
        $message = "There were " . count($errors) . " errors in the form";

        }
    }
} // end: if (isset($_POST['submit']))
?>
<?php find_selected_section(); ?>
<?php include("includes/header.php"); ?> 
<table id="structure">
    <tr>
        <td id="navigation">
<?php echo navigation($sel_header, $sel_section); ?>
        </td>
        <td id="page">
            <h2>Edit Survey Section: <?php echo $sel_section['section_name']; ?></h2>
<?php
if (!empty($message)) {
    echo "<p class=\"message\">" . $message . "</p>";
}
?>
            <?php
            // Outputting a list with all the fields with errors in it.
            if (!empty($errors)) { display_errors($errors);} ?>
            <form action="edit_section.php?surveySection=<?php echo urlencode($sel_section['id']); ?>" method="post">
                <p>Section name:
                    <input type="text" name="section_name" value="<?php echo $sel_section['section_name']; ?>" id="section_name"/></p>
                <p>Section title:
                    <input type="text" name="section_title" value="<?php echo $sel_section['section_title']; ?>" id="section_title"/></p>
                <p>Section subheading:
                    <input type="text" name="section_subheading" value="<?php echo $sel_section['section_subheading']; ?>" id="section_subheading"/></p>


                <p>Section Required:
                    <input type="radio" name="section_required" value="0" 
                    <?php
                    if ($sel_section['section_required'] == '0') {
                        echo " checked";
                    }
                    ?> /> No
                    &nbsp;
                    <input type="radio" name="section_required" value="1"
                    <?php
                    if ($sel_section['section_required'] == '1') {
                        echo " checked";
                    }
                    ?> /> Yes
                </p>
                
                <input type="submit" name="submit" value="Edit Section" />
                &nbsp;&nbsp;
                <a href="delete_section.php?surveySection=<?php echo
                           urlencode($sel_section['id']);
                    ?>" onclick="return confirm('Are you sure you want to delete the Section')"> Delete Section</a>
            </form>
            <br/>
            <a href="content.php">Cancel</a><hr/>
            <!-- Question Section here -->
            <p>Questions in this survey Section :</p>
            <ul>
                <?php 
                    $survey_section_id = $sel_section['id'];                    
                    $section_questions = get_questions_by_sectionID($survey_section_id, false);
                    while ($section=  mysql_fetch_array($section_questions)) {
                        echo "<li class=\"questions\">
                                {$section['question_name']}
                             </li>";
                    }
                ?>
            </ul>
            <hr/>
            <!-- Questions are added here -->
            <p> Add Questions in this section :</p>
            <ul>
                <a href="new_question.php?surveySection=<?php echo
                           urlencode($sel_section['id']);
                    ?>" > + Add New Question</a>
                
                
                
            </ul>
        </td>
    </tr>
</table>
<?php require("includes/footer.php") ?>

