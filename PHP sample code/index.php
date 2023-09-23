<!DOCTYPE html>
<html>

<head> <title> Test Page </title> </head>


<body>
    <!-- This forms sends its data to testForm.php using the post method -->
    <form action = "testForm.php" method = "post">

        <!-- The input for the Name of the user -->
        <label for = "name" >Name: </label>
        <input type = "text" id = "name" name = "name" required>

        <br><br>
        
        <!-- The input for the availability of the user, using checkboxes-->
        <label for = "weekdays" >Weekdays</label>
        <input type = "checkbox" id ="weekdays" name = "days[]" value = "Weekdays">
        
        <br><br>

        <label for = "weekends" >Weekends</label>
        <input type = "checkbox" id = "weekends" name = "days[]" value = "Weekends">


        <br><br>


        <!-- Button to submit the form -->
        <input type = "submit" value = "Submit">

    <!-- Upon submission, testForm.php is loaded -->
    </form>

    <!-- PHP Documentation on forms: https://www.php.net/manual/en/tutorial.forms.php
         Other helpful documentation on forms: https://www.w3schools.com/php/php_forms.asp -->



</html>