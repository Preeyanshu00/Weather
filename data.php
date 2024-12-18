<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "weather_data";

$conn = mysqli_connect($servername, $username, $password, $database);

if (!$conn) {
    echo "SQL failed to connect" . mysqli_connect_error();
} else {
    // echo "SQL connected";
}

if (isset($_GET['q']) && !empty($_GET['q'])) {
    $city = $_GET['q'];
} else {
    $city = "gold coast";
}

$selectAllData = "SELECT * FROM weatherdata WHERE city='$city' AND DATE(date)=CURDATE()";
$result = mysqli_query($conn, $selectAllData);

if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }

    $json_data = json_encode($rows);//converts associative array to JSON format;
    echo $json_data;

    header('Content-Type: application/json');
} else {
    $errorResponse = ['error' => true, 'message' => 'City not found'];
    $json_data = json_encode($errorResponse);
    echo $json_data;
    header('Content-Type: application/json');
}
?>
