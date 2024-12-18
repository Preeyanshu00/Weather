<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seven day data</title>
    <link rel="stylesheet" href="preeyanshu_singh_2417739.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,400;1,200&family=Roboto:wght@300&display=swap" rel="stylesheet">
</head>
<body>

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
    };

?>

<div class="sevenDay">
    <?php 
    $sqlSevenDays = "SELECT * FROM weatherdata WHERE city='gold coast' AND date >= CURDATE() - INTERVAL 7 DAY ORDER BY date DESC";
    
    $resultSevenDays = mysqli_query($conn, $sqlSevenDays);

    if ($resultSevenDays && mysqli_num_rows($resultSevenDays) > 0) {
        while ($rowSevenDays = mysqli_fetch_assoc($resultSevenDays)) {
            // Adding the associative array inside the data array
            $sevenDaysData[] = $rowSevenDays;
        }

        // Loop through the seven-day data and display it
        echo "<h1>" . "Gold coast seven day data " . "</h1>"; echo "<a href='preeyanshu_singh_2417739.php' class='button-link'><button>HOME</button></a>";

        foreach ($sevenDaysData as $dayData) {
            echo '<div class="dayData">';
            echo "<img src='http://openweathermap.org/img/wn/{$dayData['icon']}.png'>";
            echo "<p>Date: " . $dayData['date'] . "</p>";
            echo "<p>Temperature: " . $dayData['temp'] . "°C</p>";
            echo "<p>Humidity: " . $dayData['humidity'] . "%</p>";
            echo "<p>Pressure: " . $dayData['pressure'] . "Pa</p>";
            echo "<p>Wind: " . $dayData['wind'] . "k/m</p>";
            echo "<p>Condition: " . $dayData['condition'] . "</p>";
            echo '</div>';
        }
    } else {
        echo "No data in the last seven days for that city";
    }
    ?>
</div>




    
</body>
</html>