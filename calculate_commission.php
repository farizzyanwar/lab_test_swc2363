<?php
// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sales_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form inputs are set
if (isset($_POST['name'], $_POST['month'], $_POST['sales_amount'])) {
    $name = $_POST['name'];
    $month = $_POST['month'];
    $sales_amount = is_numeric($_POST['sales_amount']) ? (float)$_POST['sales_amount'] : 0;

    // Calculate the commission
    if ($sales_amount >= 1 && $sales_amount <= 2000) {
        $commission_rate = 0.03;
    } elseif ($sales_amount > 2000 && $sales_amount <= 5000) {
        $commission_rate = 0.04;
    } elseif ($sales_amount > 5000 && $sales_amount <= 7000) {
        $commission_rate = 0.07;
    } else {
        $commission_rate = 0.10;
    }

    $commission = $sales_amount * $commission_rate;

    // Insert the data into the database
    $sql = "INSERT INTO sales (name, month, sales_amount, commission) VALUES ('$name', '$month', '$sales_amount', '$commission')";

    if ($conn->query($sql) === TRUE) {
        echo "<h2>Sales Commission</h2>";
        echo "<p><strong>Name</strong>: " . $name . "</p>";
        echo "<p><strong>Month</strong>: " . $month . "</p>";
        echo "<p><strong>Sales Amount</strong>: RM " . number_format($sales_amount, 2) . "</p>";
        echo "<p><strong>Sales Commission</strong>: RM " . number_format($commission, 2) . "</p>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} else {
    echo "Please fill out all fields.";
}

// Close connection
$conn->close();
?>
