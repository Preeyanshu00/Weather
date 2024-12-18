<!--Name=Preeyanshu Singh student number=2417739 -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weather</title>
    <link rel="stylesheet" href="preeyanshu_singh_2417739.css">
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,400;1,200&family=Roboto:wght@300&display=swap" rel="stylesheet">

</head>
<body>
<?php
error_reporting(0);
$cityNotFound = false;

$servername = "localhost";
$username = "root";
$password = "";
$database = "weather_data";

$conn = mysqli_connect($servername, $username, $password, $database);



if (isset($_GET['q']) && !empty($_GET['q'])) {
    $city = $_GET['q'];
} else {
    $city = "gold coast";
}

$url = "https://api.openweathermap.org/data/2.5/weather?q=$city&units=metric&appid=cd2946f7a5b90d824e2add03b8a1a91a";
$response = file_get_contents($url);

$data = json_decode($response, true);

if (isset($data['main'])) {
    $temp = $data['main']['temp'];
    $pressure = $data['main']['pressure'];
    $humidity = $data['main']['humidity'];
    $wind = $data['wind']['speed'];
    $name = $data['name'];
    $date = date("Y-m-d");
    $condition = $data['weather'][0]['description'] ?? '';
    $iconCode = $data['weather'][0]['icon'] ?? '';
    $iconUrl = "http://openweathermap.org/img/wn/{$iconCode}.png";

    mysqli_select_db($conn, $database);

    $selectData = "SELECT * FROM weatherdata WHERE city='$city' AND date='$date'";
    $result = mysqli_query($conn, $selectData);

    if (mysqli_num_rows($result) > 0) {
        $updateData = "UPDATE weatherdata 
                    SET `condition`='$condition', temp=$temp, humidity=$humidity, wind=$wind, pressure=$pressure, icon='$iconCode' 
                    WHERE city='$city' AND date='$date'";
        mysqli_query($conn, $updateData);
            

    } else {
        $insertData = "INSERT INTO weatherdata(city, `condition`, temp, humidity, wind, pressure, icon, date)
                    VALUES ('$city', '$condition', $temp, $humidity, $wind, $pressure, '$iconCode', '$date')";
        mysqli_query($conn, $insertData);
            
       
    }
} else {
    // City not found or error occurred
    $cityNotFound = true;
    // Set other variables to null or a default value
    $temp = $pressure = $humidity = $wind = $name = $date = $condition = $iconCode = null;
}




?>


<!--parent is main div in which all the data is shown-->
<div class="parent">
    <!--search div contains input and button-->
    <form action="preeyanshu_singh_2417739.php" method="POST">    
        <div class="search">
            <input type="text" placeholder="City Name" id="p1" name="q">
            <button type="submit" class="button1"><img src="https://cdn-icons-png.flaticon.com/512/954/954591.png" alt="search" height="35px" ></button>
            
        </div>
    </form>
    <a href="sevenDay.php" class="button-link"><button class="button-link">seven day data</button></a>

    <?php if (!$cityNotFound): ?>
        <!-- Display weather details if the city is found -->
        <!--weather div contain condition, temp ,city ,datetime and icon-->
        <div class="weather">
            <img src="<?php echo "http://openweathermap.org/img/wn/{$iconCode}.png" ?>" class="icon" height="65px" >
            <p class="condition"></p>
            <h1 class="temp"></h1>
            <h2 class="city"></h2>
            <p class="dateTime"></p>
        </div>
        <h1 class="error">  </h1>
        <!--details div contains weather condition like pressure, humidity, windspeed-->
        <div class="details">
            <div class="col">
                <img src="https://cdn-icons-png.flaticon.com/512/728/728093.png" alt="humidity" height="45px">
                <div>
                    <p class="humidity"></p>
                    <p>Humidity</p>
                </div>
            </div>
            <div class="col">
                <img src="https://cdn-icons-png.flaticon.com/512/4005/4005767.png" alt="wind" height="45px">
                <div>
                    <p class="wind"></p >
                    <p>Wind speed</p>
                </div>
            </div>
            <div class="col">
                <img src="https://cdn-icons-png.flaticon.com/512/4005/4005826.png" alt="pressure" height="45px">
                <div>
                    <p class="pressure"></p>
                    <p>Pressure</p>
                </div>
            </div>
        </div>





    <?php endif; ?>

    <!-- h1 class error is displayed when error occur in weather application-->
    <h1 class="error"><?php echo $cityNotFound ? "City not found" : ""; ?></h1>
</div>





<!--footer is at bottom of the page it contains copy right-->   
<footer><p class="footer">© preeyanshusingh(2417739) all right reserved </p></footer>
<script src="preeyanshu_singh_2417739.js"></script>
</body>
</html> 
