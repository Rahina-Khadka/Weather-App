const searchInput = document.querySelector(".search input");
const searchBtn = document.querySelector(".search button");
const image = document.querySelector(".icon");
const form = document.querySelector("form");


async function getWeather(city) {
  const res = await fetch(
    `http://localhost/weatherapp/data.php?q=${city}`
  );
  console.log("dhfkjds")
  const data = await res.json();
  if (data.error !== true) {


    console.log(data);
    document.querySelector(".celcius").innerHTML = Math.round(data[0].temperature);
    document.querySelector(".City").innerHTML = data[0].city;
    document.querySelector(".description").innerHTML =
      data[0].weather_describe;
    document.querySelector(".humidityP").innerHTML = data[0].humidity + "";
    document.querySelector(".windS").innerHTML = data[0].speed + "";
    document.querySelector(".pressureB").innerHTML = data[0].pressure + "";
    document.querySelector(".date").innerHTML = data[0].weather_when;


    if (data[0].weather_describe == "Clouds") {
      image.src = "https://cdn-icons-png.flaticon.com/256/3767/3767036.png";
    } else if (data[0].weather_describe == "Clear") {
      image.src = "https://cdn-icons-png.flaticon.com/256/3222/3222800.png";
    } else if (
      data[0].weather_describe == "Rain" ||
      data[0].weather_describe == "Drizzle" ||
      data[0].weather_describe == "Thunderstorm"
    ) {
      image.src = "https://cdn-icons-png.flaticon.com/256/2864/2864448.png";
    } else if (
      data[0].weather_describe == "Fog" ||
      data[0].weather_describe == "Mist" ||
      data[0].weather_describe == "Haze"
    ) {
      image.src = "https://cdn-icons-png.flaticon.com/256/7774/7774309.png";
    } else if (data[0].weather_describe == "Snow") {
      image.src = "https://cdn-icons-png.flaticon.com/256/2315/2315377.png";
    }

  } else {
    document.querySelector(".celcius").innerHTML =
      "";
    document.querySelector(".City").innerHTML = data.message;
    document.querySelector(".describe").innerHTML =
      "";
    document.querySelector(".humidityP").innerHTML =
      "";
    document.querySelector(".windS").innerHTML =
      "";
    document.querySelector(".pressureB").innerHTML = "";
    document.querySelector(".date").innerHTML = "";
  }

}




//defultcity
getWeather("kyoto");


async function insertData(city_name) {
  const response = await fetch(`weather.php?q=${city_name}`);
  const data = await response.json();
  console.log(data);
}



form.addEventListener('submit', (event) => {     //after submitting the prcess of redirecting in next page is called event
  event.preventDefault();
  //insertData();
  insertData(searchInput.value);
  getWeather(searchInput.value);
})