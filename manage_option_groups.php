<?php require_once("includes/session.php"); ?>
<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php require_once("includes/form_functions.php"); ?>
<?php confirm_logged_in(); ?>
<?php


if (isset($_POST['submit'])) {
    $errors = array();

    // Form Validation
    $required_fields = array('survey_name', 'position','organization');

    $errors =  array_merge($errors,check_required_fields($required_fields));
   
    

    //To check maximum length of the links
    $fields_with_lengths = array('survey_name' => 30);
    $errors=array_merge($errors,check_max_field_lengths($fields_with_lengths));
    
    if (empty($errors)) {
        //Perform update
        $id = mysql_prep($_GET['surveyHeader']);
        $survey_name = mysql_prep($_POST['survey_name']);
        $position = mysql_prep($_POST['position']);
        $visible = mysql_prep($_POST['visible']);
        $organization = mysql_prep($_POST['organization']);

        $query = "update survey_headers set 
                    survey_name='{$survey_name}',
                    position='{$position}',
                    organization_id='{$organization}',
                    visible='{$visible}' 
                    where id='{$id}' ";

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
            <script>
                $(function(){
                    $("#accordion").accordion();
                });
            </script>
            <div id="accordion"><p>Organization:
                    <select name="organization">
                        <?php
                        $option_set = get_all_organizations();
                        while($row=mysql_fetch_array($option_set)){
                            echo "<option value='" . $row[0] . "'>" . $row[1] . "</option>";
                        }
                        
                        ?>
                    </select>
                </p>
                <?php 
                
                
                
                
                
                
                
                
                ?>
                <h3>Section 1</h3>
                <div>
                    <p>
                     Mauris mauris ante, blandit et, ultrices a, suscipit eget, quam. Integer
                     ut neque. Vivamus nisi metus, molestie vel, gravida in, condimentum sit
                     amet, nunc. Nam a nibh. Donec suscipit eros. Nam mi. Proin viverra leo ut
                     odio. Curabitur malesuada. Vestibulum a velit eu ante scelerisque vulp   
                    </p>
                </div>
                <h3>Section 2</h3>
                <div>
                    <p>
                     Mauris mauris ante, blandit et, ultrices a, suscipit eget, quam. Integer
                     ut neque. Vivamus nisi metus, molestie vel, gravida in, condimentum sit
                     amet, nunc. Nam a nibh. Donec suscipit eros. Nam mi. Proin viverra leo ut
                     odio. Curabitur malesuada. Vestibulum a velit eu ante scelerisque vulp   
                    </p>
                </div>
                
            </div>   
        </td>
    </tr>
</table>
                    <?php require("includes/footer.php") ?>

