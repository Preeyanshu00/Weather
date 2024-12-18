// This statement selects search input and button, stores them in variables searchBox and searchBtn
const searchBox = document.querySelector(".search input");
const form = document.querySelector("form");

// async/await method is used to fetch API
async function checkWeather(city) {
    if (city === "") {
        city = 'gold coast';
    }
console.log('Initially ' + (window.navigator.onLine ? 'on' : 'off') + 'line');


window.addEventListener('offline', () => document.querySelector(".button-link").style.visibility="hidden");



    if (localStorage.getItem(city.toLowerCase()) === null) {
        const response = await fetch(`http://localhost/preeyanshu_singh_2417739/data.php?q=${city}`);
        var data = await response.json();
        
        if(!data.error){
            localStorage.setItem(city.toLowerCase(), JSON.stringify(data))
        }
    } else {
        var data = JSON.parse(localStorage.getItem(city.toLowerCase()));
    }

    // If-else condition is used to handle error conditions
    if (data.error === true) {
        console.log(data);
        // Here styling is done targeting the error value when no data is found 
        document.querySelector(".error").innerHTML = "404";
        document.querySelector(".error").style.visibility = "visible";
        document.querySelector(".weather").style.visibility = "hidden";
        document.querySelector(".details").style.visibility = "hidden";
    } else {
        // Data is a variable in which weather data is stored in JSON format

        // Here styling is done targeting the error value when no data is found
        document.querySelector(".error").style.visibility = "hidden";
        document.querySelector(".weather").style.visibility = "visible";
        document.querySelector(".details").style.visibility = "visible";

        // Different data is fetched and allotted in specified places
        document.querySelector(".city").innerHTML = data[0].city;
        document.querySelector(".condition").innerHTML = data[0].condition;
        document.querySelector(".temp").innerHTML = Math.round(data[0].temp) + "°C";
        document.querySelector(".humidity").innerHTML = data[0].humidity + "%";
        document.querySelector(".wind").innerHTML = data[0].wind + "Km/h";
        document.querySelector(".pressure").innerHTML = data[0].pressure + "ATM";
        document.querySelector(".dateTime").innerHTML = data[0].date;
        document.querySelector(".icon").src = `http://openweathermap.org/img/wn/${data[0].icon}.png`;

        // Here, the background image is fetched from the Unsplash website and placed in CSS 
        //document.body.style.backgroundImage = `url('https://source.unsplash.com/1600x900/?${city}')`;

        console.log(data);
    }
}

async function saveInDatbase(city){
    const response = await fetch(`preeyanshu_singh_2417739.php?q=${city}`);
}
// Call the checkWeather function with the default city when the page loads
checkWeather(searchBox.value)

form.addEventListener("submit", function (event) {
    event.preventDefault();
    checkWeather(searchBox.value);
    saveInDatbase(searchBox.value);
});
