<?php

$hostname = "localhost";
$username = "root";
$password = "appleslice_pass789432";
$database = "sensors_db";

$conn = mysqli_connect($hostname, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// If values sent by Arduino/NodeMCU are not empty then insert into MySQL database table
if (!empty($_POST['temperature']) && !empty($_POST['humidity']) && !empty($_POST['weight'])) {
    $temperature = $_POST['temperature'];
    $humidity = $_POST['humidity'];
    $weight = $_POST['weight'];

    // Update your table name here
    $sql = "INSERT INTO sensor_data (temperature, humidity, weight) VALUES ('$temperature', '$humidity', '$weight')";

    if ($conn->query($sql) === TRUE) {
        echo "Values inserted in MySQL database table.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close MySQL connection
$conn->close();
?>
