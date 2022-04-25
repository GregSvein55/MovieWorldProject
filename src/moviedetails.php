<?php
// Initialize the session
include('conn.php');
session_start();

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: index.php");
    exit;
}
$user=$_SESSION['id'];
if (isset($_GET['page']) && isset($_GET['poster']) && isset($_GET['title'])&& isset($_GET['overview'])&& isset($_GET['genre'])&& isset($_GET['rating'])&& isset($_GET['release']) )
  {
  $id=$_GET['page'];
    $api_url = 'https://api.themoviedb.org/3/movie/'.$id.'/videos?api_key=04c35731a5ee918f014970082a0088b1&language=en-US';

$poster=$_GET['poster'];
$date=$_GET['release'];
$user_name=$_SESSION['username'];
$title=$_GET['title'];
$overview=$_GET['overview'];
$genre=$_GET['genre'];
$rating=$_GET['rating'];
$json_data = file_get_contents($api_url);

 // Decode JSON data into PHP array
 $response_data = json_decode($json_data);
$user_data = $response_data->results;

$value=$user_data[0]->key;



$api_url2 = 'https://api.themoviedb.org/3/discover/movie?sort_by=popularity.desc&api_key=04c35731a5ee918f014970082a0088b1&page=1';
$IMGPATH = "https://image.tmdb.org/t/p/w1280";
// Read JSON file
$json_data2 = file_get_contents($api_url2);

// Decode JSON data into PHP array
$response_data2 = json_decode($json_data2);

// All user data exists in 'data' object
$user_data2 = $response_data2->results;


$api_url3='https://api.themoviedb.org/3/genre/movie/list?api_key=04c35731a5ee918f014970082a0088b1&language=en-US';

$json_data3 = file_get_contents($api_url3);

// Decode JSON data into PHP array
$response_data3 = json_decode($json_data3);
$user_data3 = $response_data3->genres;

foreach ($user_data3 as $user2) {
if ($genre== $user2->id  ){
$name=$user2->name;

}
    }



    echo <<<EOD
    <div class="navbar">
        <a> Movies World </a>
        <a href="home.php" style="float:right;display:inline;">Home Page </a>
        <a style="display:inline;float:right;"> Welcome $user_name</a>
    </div>
        
   <div class="movie-card">
  
  <div class="container" style="height:675px;">
    
    <img src="https://image.tmdb.org/t/p/w1280$poster" alt="cover" class="cover" style="border-radius: 25px;height:40%;" />
        
    <div class="hero">
            
      <div class="details">
      
        <div class="title1" style="font-size: 18px;"><h1>$title</h1></div>
           
        
      </div> <!-- end details -->
      
    </div> <!-- end hero -->
    
    <div class="description">
      
      <div class="column1">
      
        
        </br>
        <span class="tag" style="color:black;width:30px;">Release Date: $date </span> 
          <span class="tag" style="color:black;"> IMDb Rating : $rating </span> 
          </br>
          
      <span class="tag" style="color:black;"> Genre : $name </span>
        </br>
        <a href="youtubevideo.php?page={$value}"> 
         <input type="submit" class="a" style="background-color: #555555;" value="Watch Trailer"/> 
        </a> 
        
        
       <a href="home.php?unsubscribe={$id}">  
      <input type="submit" class="a" style="padding-bottom:11px;" value="Unsubscribe"/>  
     </a>
        
      </div> <!-- end column1 -->
      
      <div class="column2">
        
        <p style="color:black;">$overview</p>
        
        
        
      
      </div> <!-- end column2 -->
    </div> <!-- end description -->
    
   
  </div> <!-- end container -->
</div> <!-- end movie-card -->
 
EOD;

}

?>



<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>My title</title>
<link href="StyleSheet3.css" media="screen" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="StyleSheet1.css">
<style>
.a{
background-color: #f44336; /* Green */
border: none;
border-radius: 25px;
  color: white;
  padding: 15px 32px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin: 4px 2px;
  cursor: pointer;
}
.hero:before {
  content:'';
  width:100%; height:90%;
  position:absolute;
  overflow: hidden;
  top:0; left:0;
  background:red;
  background: url("https://image.tmdb.org/t/p/w1280<?php echo $poster; ?>");
  z-index:-1;
 
  transform: skewY(-2.2deg);
  transform-origin:0 0;
  
  //chrome antialias fix
  -webkit-backface-visibility: hidden; 
</style>
  
}
</head>

<body>
    

</body>
</html>