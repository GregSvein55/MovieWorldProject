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
if (isset($_GET['page']))
  {
  $id=$_GET['page'];
    $query=mysqli_query($conn,"insert into User_Movies (UserID,movieID) values ('$user','$id')");
  }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link rel="stylesheet" href="StyleSheet1.css">
<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <style>
        body {
            font: 14px sans-serif;
            text-align: center;
        }
    .a{
background-color: #555555; /* Green */
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
    </style>
</head>
<body>
    <div class="navbar">
        <a> Movies World </a>
        <a href="home.php" style="float:right;display:inline;">Home Page </a>
        <a style="display:inline;float:right;"> Welcome <?php echo htmlspecialchars($_SESSION["username"]); ?></a>

    </div>
    


<?php

// All user data exists in 'data' object
$user_data = $_SESSION["movies"];


$data = array();
$userid=$_SESSION['id'];
 $sql = "SELECT movieID FROM Movies WHERE EXISTS(SELECT 1 FROM User_Movies WHERE User_Movies.movieID=Movies.movieID AND User_Movies.UserID='$userid')";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc())
                array_push($data, $row);
        }



        foreach ($data as $movie) {
        foreach ($user_data as $user) {
        if ($movie['movieID'] == $user->id){
            echo <<<EOD
            <div class="column">
        <div class="flip-card">
            <div class="flip-card-inner">
                <div class="flip-card-front">
                    <img style="width: 300px;height: 425px;border-radius: 30px; "
                src="https://image.tmdb.org/t/p/w1280{$user->poster_path}"
                alt="{$user->title}"/>
                </div>
                <div class="flip-card-back">
                </br>
                    <h1>{$user->title}</h1>
                    <a href="moviedetails.php?page={$user->id}&amp;poster={$user->poster_path}&amp;title={$user->title}&amp;overview={$user->overview}&amp;genre={$user->genre_ids[0]}&amp;rating={$user->vote_average}&amp;release={$user->release_date}">  
         <input type="submit" class="a" value="Movie Details"/> 
        </a> 
                    
                    <div>
                    </div>
                </div>
            </div>
        </div>
    </div>
       
EOD;
        }
        }
        }
 
?>
</body>
</html>