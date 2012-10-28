<?php

//This file is to store all the basic functions
//The below function is used to check whether the browser has Magic Quotes or not(Escape character checking)
    function mysql_prep($value) {
        $magic_quotes_active = get_magic_quotes_gpc();
        $new_enough_php = function_exists("mysql_real_escape_string"); // i.e. PHP >=v4.3.0

        if ($new_enough_php) {
            //Undoing the magic quote effect so that the mysql_real_escape_string can do the work
            if ($magic_quotes_active) {
                $value = stripslashes($value);
            }
            $value = mysql_real_escape_string($value);
        } else { // Before PHP v4.3.0
            //if magic quotes are not on then add the slashes manually
            if (!$magic_quotes_active) {
                $value = addslashes($value);
            }// if the magic quotes are active , then the slashes already exists
        }
        return $value;
    }

//To Redirect to the location given as argument
    function redirect_to($location) {

        if ($location) {
            header("Location: " . $location);
            exit;
        }
    }

//To See if the query passed else an error message is displayed
    function confirm_query($result_set) {
        if (!$result_set) {
            die("Database query failed :" . mysql_error());
        }
    }

// To get all the organizations  in the database.
    function get_all_organizations(){
        global $connection;
        $query = "SELECT id,organization_name
                    FROM organizations";
        $query.= " ORDER BY organization_name DESC";
        $organization_set = mysql_query($query,$connection);
        confirm_query($organization_set);
        return $organization_set;
        
    }
    
//To get all the option group
    function get_all_options(){
        global $connection;
        $query= "SELECT * "
    }
    
//To get all the Survey Headers in the database(No WHERE condition given - Doesn't use ID)
# get_all_subjects ($public = true)
    function get_all_surveyHeaders($public = true) {
        global $connection;
        $query = "select * 
              from survey_headers";
        if ($public) {
            $query.=" where visible = 1";
        }
        $query.=" order by survey_name desc";
        $survey_header_set = mysql_query($query, $connection);
        confirm_query($survey_header_set);
        return $survey_header_set;
    }

//To get all the survey sections based on the given Survey Header(where id is Survey Header ID )
# get_pages_for_subject($subject_id, $public = true)
    function get_sections_for_header($header_id, $public = true) {
        global $connection;
        $query = "select *
                from survey_sections
                where survey_header_id={$header_id}";
        if ($public) {
            $query .= " and section_required = 1 ";
        }
        $query.= " order by section_name asc";
        $survey_set = mysql_query($query, $connection);
        confirm_query($survey_set);
        return $survey_set;
    }

//To get the Survey Header based on the Survey Header ID
# get_subject_by_id ($subject_id)
    function get_header_by_id($survey_header_id) {
        global $connection;
        $query = "select * ";
        $query .= " from survey_headers ";
        $query .= " where id=" . $survey_header_id . " ";
        $query .= " limit 1";
        $result_set = mysql_query($query, $connection);
        confirm_query($result_set);
        //Remember if no rows are returned, fetch array will return false
        if ($survey = mysql_fetch_array($result_set)) {
            return $survey;
        } else {
            return null;
        }
    }

//To get the Survey Section based on the Survey Section ID
# get_page_by_id($page_id)
    function get_section_by_id($survey_section_id) {
        global $connection;
        $query = "select * ";
        $query .= " from survey_sections ";
        $query .= " where id=" . $survey_section_id . " ";
        $query .= " limit 1";
        $result_set = mysql_query($query, $connection);
        confirm_query($result_set);
        //Remember if no rows are returned, fetch array will return false
        if ($survey1 = mysql_fetch_array($result_set)) {
            return $survey1;
        } else {
            return null;
        }
    }

// To get the default section in case there is no section.
    function get_default_section($survey_id) {
        //Get all visible pages.
        $section_set = get_sections_for_header($survey_id, true);
        if ($first_section = mysql_fetch_array($section_set)) {
            return $first_section;
        } else {
            return NULL;
        }
    }

//To receive the result set from either Survey Header or Section and to put them in two 
//Variables called $sel_surveyHeader_by_id and $sel_surveySection_by_id
# find_selected_page()
    function find_selected_section() {

        global $sel_header;
        global $sel_section;

        if (isset($_GET['surveyHeader'])) {
            $sel_header = get_header_by_id($_GET['surveyHeader']);
            $sel_section = get_default_section($sel_header['id']);
        } elseif (isset($_GET['surveySection'])) {
            $sel_section = get_section_by_id($_GET['surveySection']);
            $sel_header = NULL;
        } else {
            $sel_header = NULL;
            $sel_section = NULL;
        }
    }

//To show the navigation part of the page based on the Header ID and Section ID
    function navigation($sel_surveyHeader_by_id, $sel_surveySection_by_id) {
        $output = "<ul class=\"survey_headers\">";

        // 3. Perform database query
        $public = false;
        $survey_header_set = get_all_surveyHeaders($public);

        // 4. Use returned data
        while ($row = mysql_fetch_array($survey_header_set)) {
            $output .= "<li";
            if ($row["id"] == $sel_surveyHeader_by_id['id']) {
                $output .= " class=\"selected\"";
            }
            $output .= "><a href=\"edit_survey.php?surveyHeader=" . urlencode($row["id"]) .
                    "\"> {$row["survey_name"]}</a></li>";
            $survey_set = get_sections_for_header($row["id"]);

            $output .= "<ul class=\"survey_section\">";
            while ($survey = mysql_fetch_array($survey_set)) {
                $output .= "<li";
                if ($survey["id"] == $sel_surveySection_by_id['id']) {
                    $output .= " class=\"selected\"";
                }
                $output .= "><a href=\"edit_section.php?surveySection=" .
                        urlencode($survey["id"]) .
                        "\"> {$survey["section_name"]}</a></li>";
            }
            $output .= "</ul>";
        }


        $output .= "</ul>";
        $output.="<ul>";
        $output.="<li><a href='manage_option_groups.php'>Manage Option Groups</a></li>";
        $output.="</ul>";
        

        return $output;
    }

//To show the navigation part of the page for the public
    function public_navigation($sel_header, $sel_section, $public = true) {
        $output = "<ul class=\"survey_headers\">";
        $survey_header_set = get_all_surveyHeaders($public);
        while ($header = mysql_fetch_array($survey_header_set)) {
            $output .= "<li";
            if ($header["id"] == $sel_header['id']) {
                $output .= " class=\"selected\"";
            }
            $output .= "><a href=\"index.php?surveyHeader=" . urlencode($header["id"]) .
                    "\">{$header["survey_name"]}</a></li>";
            if ($header["id"] == $sel_header['id']) {
                $section_set = get_sections_for_header($header["id"], $public);
                $output .= "<ul class=\"survey_section\">";
                while ($section = mysql_fetch_array($section_set)) {
                    $output .= "<li";
                    if ($section["id"] == $sel_section['id']) {
                        $output .= " class=\"selected\"";
                    }
                    $output .= "><a href=\"index.php?surveySection=" . urlencode($section["id"]) .
                            "\">{$section["section_name"]}</a></li>";
                }
                $output .= "</ul>";
            }
        }
        $output .= "</ul>";
        return $output;
    }

//To get the Questions for the Survey Sections based on the Section ID
    function get_questions_by_sectionID($survey_section_id, $public = true) {
        global $connection;
        $query = "select question_name
                from questions
                where survey_section_id='{$survey_section_id}'";
        $result_set = mysql_query($query, $connection);
        confirm_query($result_set);
        //Remember if no rows are returned, fetch array will return false
        return $result_set;
    }

//To display the message.
    function display($message) {
        if ($message) {
            
        }
        echo "<br/>" . $message . "<br/>";
    }

    /** Prints the contents of an array with HTML special characters, linebreaks and spaces
     * @param array $array
     * @param bool $echo (default: true)
     * @result bool/array
     */
# use like this to print/echo the contents to the screen
#print_arr($yourArray);
# use like this to not print/echo but catch the contents in a variable
#$result = $print_arr($yourArray);

    function print_arr($array, $echo = true) {
        echo "<br/>";
        $array = print_r($array, true);
        $array = htmlspecialchars($array);
        $array = str_replace(" ", " ", $array);
        $array = nl2br("”.$array.”");
        echo "<br/>";
        if ($echo == true) {
            echo $array;
            return true;
        }

        return $array;
    }
    
//to display a query 
    function dquery($query){
        echo "<br/> The query is ".$query."<br/>";
    }
    
//Getting all the fields using the given ID
    function get_fields_by_ID($id,$idname,$table){
        global $connection;
        $query = "select * 
                    from {$table} 
                    where {$idname}={$id} " ;
        $result= mysql_query($query,$connection);
        confirm_query($result);
        return $result;
    }

//Getting all the fields
    function get_all_fields($tablename){
         global $connection;
        $query = "select * 
                    from {$tablename} " ;
        $result= mysql_query($query,$connection);
        confirm_query($result);
        return $result;
    }


?>