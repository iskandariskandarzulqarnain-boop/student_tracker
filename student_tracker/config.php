<?php
// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "student_tracker";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create database if it doesn't exist
$sql = "CREATE DATABASE IF NOT EXISTS $dbname";
if ($conn->query($sql) === TRUE) {
    // Select the database
    $conn->select_db($dbname);
    
    // Create students table if it doesn't exist
    $sql = "CREATE TABLE IF NOT EXISTS students (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        student_id VARCHAR(20) NOT NULL UNIQUE,
        email VARCHAR(100) NOT NULL,
        faculty VARCHAR(100) NOT NULL,
        status ENUM('Active', 'Inactive') DEFAULT 'Active',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    
    if ($conn->query($sql) === FALSE) {
        echo "Error creating table: " . $conn->error;
    }
    
    // Insert sample data if table is empty
    $check_data = "SELECT COUNT(*) as count FROM students";
    $result = $conn->query($check_data);
    $row = $result->fetch_assoc();
    
    if ($row['count'] == 0) {
        $sample_data = [
            ["Iskandar Zulqamain", "AM2408016624", "iskandar@student.edu", "Computer Science", "Active"],
            ["Ahmad Farhan", "AM2408016625", "ahmad@student.edu", "Computer Science", "Active"],
            ["Siti Nurhaliza", "AM2408016626", "siti@student.edu", "Information Technology", "Inactive"]
        ];
        
        foreach ($sample_data as $data) {
            $sql = "INSERT INTO students (name, student_id, email, faculty, status) 
                    VALUES ('$data[0]', '$data[1]', '$data[2]', '$data[3]', '$data[4]')";
            $conn->query($sql);
        }
    }
} else {
    echo "Error creating database: " . $conn->error;
}
?>