<?php
function check_required_fields($required_fields){
    $errors = array();
    foreach ($required_fields as $field_name) { // checking if the fields are set, empty or 0
        if (!isset($_POST[$field_name]) || empty($_POST[$field_name])) {
            $errors[] = $field_name;
            
        }
    }
    return $errors;
}

function check_max_field_lengths($field_length_array){
    $field_errors = array();
    //To check maximum length of the links
    foreach ($field_length_array as $field_name => $maxlength) {
        if (strlen(trim(mysql_prep($_POST[$field_name]))) > $maxlength) {
            $field_errors[] = $field_name;
        }
    }
    return $field_errors;
}

function display_errors($error_array){
    echo "<p class =\"errors\">";
    echo "Please review the following fields:<br/>";
    foreach($error_array as $error){
        echo " - " . $error . "<br/>";
        
    }
    echo "</p>";
}
?>



