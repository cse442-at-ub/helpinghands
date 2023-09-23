<?php

// default database setup
$servername = "localhost";
$username = "root"; 
$password = "";
$dbname = "volunteer_db";

// Connecting to database
$conn = new mysqli($servername, $username, $password, $dbname);


// Checking if a form has been submitted using the post method
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // storing the name
    $name = $_POST['name'];

    //storing the availability in the form of a string using implode() on the array
    $daysAvailable = implode( ", " , $_POST['days']);



    // Displaying the name and availability
    echo "Name: " . $name;
    echo "<br>"; // line break
    echo "Available on: " . $daysAvailable;
    echo "<br>"; // line break




    // Inserting name and availability into database
    $sql = "INSERT INTO volunteers (name, days_available) VALUES ('$name' , '$daysAvailable')";

    if($conn->query($sql) === TRUE){ // Checks if data was inserted into database by checking if the mysqli_result object is true
        echo "New record created successfully";
    } else {
        echo "Error";
    }

    /*
    Documentation I found helpful:
    https://www.w3schools.com/sql/sql_insert.asp inserting data into a table using SQL

    https://www.php.net/manual/en/mysqli.query.php checking if data was inserted into database
*/




    // Button to go back to the form page
    echo "<br><br><button onclick=\"location.href = 'index.php';\">Back</button>";
}

// Closing connection to database
$conn->close();

?>