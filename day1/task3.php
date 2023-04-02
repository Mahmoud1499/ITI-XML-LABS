<?php
// MySQL database connection details
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "grades";
$port = "3307";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname, $port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// MySQL query to retrieve data from a table
$sql = "SELECT * FROM courses";

// Execute query and get result set
$result = $conn->query($sql);

// Create a new XML document
$xml = new DOMDocument();

// Create the root element
$courses = $xml->createElement("courses");
$xml->appendChild($courses);

// Loop through each row in the result set and add it as a child element of the root element
while ($row = $result->fetch_assoc()) {
    $courses = $xml->createElement("course");
    $coursess->appendChild($course);

    $course_id = $xml->createElement("course_id", $row["course_id"]);
    $courses->appendChild($course_id);

    $course_name = $xml->createElement("course_name");
    $courses->appendChild($course_name);

    $credit_hour = $xml->createElement("credit_hour");
    $courses->appendChild($credit_hour);
}

// Save the XML document to a file
$xml->save("courses.xml");

// Close database connection
$conn->close();