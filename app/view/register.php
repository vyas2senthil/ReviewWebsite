<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<html>
    
    
    
    <body>
        <div id="registrationForm">            
            <form id="register" action="register.php" method="post">
                <fieldset>
                    <legend>Register</legend>
                    <input type="hidden" name="submitted" id="submitted" value="1" /><br/>
                    <label for="firstName">First Name* : </label>
                    <input type="text" name="firstName" id="firstName" maxlength="50" /><br/>
                    <label for="lastName">Last Name* :</label>
                    <input type="text" name="lastName" id="lastName" maxlength="50" /><br/>
                    <label for="address">Address     :</label>
                    <input type="text" name="address" id="address" maxlength="50" /><br/>
                    <label for="phone">Phone    :</label>
                    <input type="text" name="phone" id="phone" maxlength="50" /><br/>
                    <label for="mobile">Mobile    :</label>
                    <input type="text" name="mobile" id="mobile" maxlength="50" /><br/>
                    <label for="username">Username* :</label>
                    <input type="text" name="username" id="username" maxlength="50" /><br/>
                    <label for="password">Password* :</label>
                    <input type="password" name="password" id="password" maxlength="50" /><br/>
                    <label for="passwordRepeat">Re-type Password* :</label>
                    <input type="password" name="passwordRepeat" id="passwordRepeat" maxlength="50" /><br/>
                    <input type="submit" id="submit"><input type="reset" id="reset">                </fieldset>
            </form>
        </div> <!-- Registration Form ends here -->
    </body>
    
</html>