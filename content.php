<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php find_selected_section(); ?>
<?php include("includes/header.php"); ?> 
<table id="structure">
    <tr>
        <td id="navigation">
               <?php echo navigation($sel_header, $sel_section); ?>
            <br />
            <a href="new_survey.php">+ Add a new Survey </a>
        </td>
        <td id="page">
            <h2><?php if(!is_null($sel_header)){ //subject selected
                ?>
<h2><?php echo $sel_header['survey_name']; ?></h2>
<?php } elseif (!is_null($sel_section)){ // Survey Section selected
                ?><h2><?php echo $sel_section['section_name']; ?></h2>
                <div class="page-content">
                    // for the page content
                    <?php echo $sel_section['section_subheading']; ?>
                </div>
                <?php }else { //nothing happened 
                    ?><h2>Select a survey header or survey section to edit</h2>
                    <?php } ?>
                    
        </td>
    </tr>
</table>
<?php require("includes/footer.php") ?>

