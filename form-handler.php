<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize form input
    $name = htmlspecialchars(trim($_POST['name']));
    $company_name = htmlspecialchars(trim($_POST['company_name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $contact_number = htmlspecialchars(trim($_POST['contact_number']));
    $services = isset($_POST['services']) ? implode(", ", $_POST['services']) : '';
    $message = htmlspecialchars(trim($_POST['message']));

    // Database connection settings
    $servername = "localhost";
    $username = "root"; // Default XAMPP MySQL username
    $password = ""; // Default XAMPP MySQL password
    $dbname = "contactform"; // Database name

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO msg (name, company_name, email, contact_number, services, message) VALUES (?, ?, ?, ?, ?, ?)");
    if ($stmt === false) {
        die("Error preparing the statement: " . $conn->error);
    }
    $stmt->bind_param("ssssss", $name, $company_name, $email, $contact_number, $services, $message);

    // Execute the statement
    if ($stmt->execute()) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
}
?>
