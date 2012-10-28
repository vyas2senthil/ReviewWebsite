<?php require_once("includes/session.php"); ?>
<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php require_once("includes/form_functions.php"); ?>

<?php confirm_logged_in(); ?>

<?php find_selected_section(); ?>
<?php include("includes/header.php"); ?> 
<table id="structure">
    <tr>
        <td id="navigation">
<?php echo navigation($sel_header, $sel_section); ?>
        </td>
        <td id="page">
            <h2>Edit Survey: <?php echo $sel_header['survey_name']; ?></h2>
            <?php if(!empty($message)){
                echo "<p class=\"message\">". $message . "</p>";
            } ?>
            <?php
            // Outputting a list with all the fields with errors in it.
            if(!empty($errors)){
                display_errors($errors);
                }
            ?>
            <form action="edit_survey.php?surveyHeader=<?php echo urlencode($sel_header['id']); ?>" method="post">
                <p>Survey name:
                    <input type="text" name="survey_name" value="<?php echo $sel_header['survey_name']; ?>" id="survey_name"/></p>
                <p>Position:
                    <select name="position" >
<?php
$survey_set = get_all_surveyHeaders();
$survey_count = mysql_num_rows($survey_set);
//$survey_count +1 because we are adding a new survey
for ($count = 1; $count <= $survey_count + 1; $count++) {
    echo "<option value=\"{$count}\"";
    if ($sel_header['position'] == $count) {
        echo " selected";
    }
    echo " >{$count}</option>";
}
?>
                    </select>
                </p>

                <p>Organization:
                    <select name="organization">
                        <?php
                        $option_set = get_all_organizations();
                        while($row=mysql_fetch_array($option_set)){
                            echo "<option value='" . $row[0] . "'>" . $row[1] . "</option>";
                        }
                        
                        ?>
                    </select>
                </p>

                <p>Visible:
                    <input type="radio" name="visible" value="0" 
                        <?php
                        if ($sel_header['visible'] == '0') {
                            echo " checked";
                        }
                        ?> /> No
                    &nbsp;
                    <input type="radio" name="visible" value="1"
<?php
if ($sel_header['visible'] == '1') {
    echo " checked";
}
?> /> Yes
                </p>
                <input type="submit" name="submit" value="Edit Subject" />
                &nbsp;&nbsp;
                <a href="delete_survey.php?surveyHeader=<?php echo
                urlencode($sel_header['id']); ?>" onclick="return confirm('Are you sure you want to delete the survey')"> Delete Survey</a>

            </form>
            <br/>
            <a href="content.php">Cancel</a><br/>
            <hr/>
<!------------------------------------------------------------------------------------------->
            <p>Sections in this survey Header:</p><br/>
             
            <ul>
            <?php
                $header_sections = get_sections_for_header($sel_header['id']);
                while($section = mysql_fetch_array($header_sections)){
                    echo "<li><a href=\"content.php?surveySection={$section['id']}\">
                    {$section['section_name']}</a></li>";
                }
            ?>
            </ul>    
            <br/>
            +<a href="new_section.php?surveyHeader=<?php echo $sel_header['id']; ?>"> Add a new Section to this Header </a>
            </div>   
        </td>
    </tr>
</table>
                    <?php require("includes/footer.php") ?>

