<?php     
       $servername = "localhost";
       $username = "root";
       $password = "";
       $database = "weatherapp";
   
       $conn=mysqli_connect($servername,$username,$password, $database );
    if($conn){
     // echo"SQL connected";
    }else{
      echo"Failed to connect mysql".mysqli_connect_error();
    }
       if (isset($_GET['q'])) {
           $city_name = $_GET['q'];
       } else {
           $city_name = "kyoto";
       }
   
       $api_key = "33890943e5a402bf7dee35b9ee3706e3"; // Replace with your actual API key
       $url = "https://api.openweathermap.org/data/2.5/weather?q=".$city_name."&appid=".$api_key."&units=metric";
   
       $response = file_get_contents($url);
       //echo $response;
       if (!$response) {
           die("Failed to fetch data from the API");
       }
   
       $data = json_decode($response, true);
       if ($data && isset($data['cod']) && $data['cod'] === 200) {
           $city = $data['name'];
           $temperature = $data['main']['temp'];
           $weather_description = $data['weather'][0]['description'];
           $icon = $data['weather'][0]['icon'];
           $pressure = $data['main']['pressure'];
           $speed = $data['wind']['speed'];
           $humidity = $data['main']['humidity'];
           $weather_when = date("Y-m-d H:i:s");
           $day_of_week = date('l', strtotime($weather_when));
   
           $existingDataQuery = "SELECT * FROM users WHERE city = '$city_name'";
           $existingDataResult = mysqli_query($conn, $existingDataQuery);
   
           if ($existingDataResult && mysqli_num_rows($existingDataResult) > 0) {
               $updateDataQuery = "UPDATE users SET
                   temperature = $temperature,
                   weather_describe = '$weather_description',
                   icon = '$icon',
                   pressure = $pressure,
                   speed = $speed,
                   humidity = $humidity,
                   weather_when = '$weather_when'
                   WHERE city = '$city_name' AND day_of_week = '$day_of_week'";
   
               if (mysqli_query($conn, $updateDataQuery)) {
                   echo "Data updated successfully";
               } else {
                   echo "Failed to update data: " . mysqli_error($conn);
               }
           } else {
               $insertDataQuery = "INSERT INTO users (city, temperature, weather_describe, icon, pressure, speed, humidity, weather_when, day_of_week) 
                   VALUES ('$city', '$temperature', '$weather_description', '$icon', '$pressure', '$speed', '$humidity', '$weather_when', '$day_of_week')";
   
               if (mysqli_query($conn, $insertDataQuery)) {
                   echo "Data inserted successfully";
               } else {
                   echo "Failed to insert data: " . mysqli_error($conn);
               }
           }
       } else {
           echo "Failed to fetch data from the API or invalid response received";
       }
   
       mysqli_close($conn);
   ?>
    
    