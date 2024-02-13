<?php
$servername="localhost";
$username="root";
$password="";
$database="weatherapp";

$conn=mysqli_connect($servername,$username,$password,$database);
if($conn){
    //echo "SQL connected";
}else{
    echo "Failed to connect MySql".mysqli_connect_error();
}
if(isset($_GET['q'])){
$cityName=$_GET['q'];
}else{
    $cityName="kyoto";
}
$selectAllData="SELECT * FROM users WHERE city='$cityName' AND DATE(weather_when)=CURDATE() ";
$result=mysqli_query($conn,$selectAllData);
if(mysqli_num_rows($result)>0){
  while($row=mysqli_fetch_assoc($result)){
    $rows[]=$row;
  }
  $json_data=json_encode($rows);
  echo $json_data;
  header('Content-Type:application/json');
}else{
  $errorResponse=['error'=>true,'message'=>'City not found.'];
  $json_data=json_encode($errorResponse);
  echo $json_data;
  
  header ('Content-Type:application/json');
}
?>