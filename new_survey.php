<?php require_once("includes/session.php"); ?>
<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php confirm_logged_in(); ?>
<?php find_selected_section(); ?>

<?php include("includes/header.php"); ?> 
<table id="structure">
    <tr>
        <td id="navigation">
            <?php echo navigation($sel_header, $sel_section); ?>
        </td>
        <td id="page">
            <h2>Add Survey</h2>
            <form action="create_survey.php" method="post">
                <p>Survey name:
                    <input type="text" name="survey_name" value="" id="survey_name"/></p>
                <p>Position:
                    <select name="position">
                        <?php
                            $survey_set = get_all_surveyHeaders();
                            $survey_count = mysql_num_rows($survey_set);
                            //$survey_count +1 because we are adding a new survey
                            for ($count = 1; $count <= $survey_count + 1; $count++) {
                                echo "<option value=\"{$count}\">{$count}</option>";
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
                    <input type="radio" name="visible" value="0" /> No
                    &nbsp;
                    <input type="radio" name="visible" value="1" /> Yes
                </p>
                <input type="submit" value="Add Subject" />

            </form>
            <br/>
            <a href="content.php">Cancel</a>
        </td>
    </tr>
</table>
<?php require("includes/footer.php") ?>

