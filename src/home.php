<?php
// Initialize the session
include('conn.php');
session_start();

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: index.php");
    exit;

 
}
$u=$_SESSION['id'];
if (isset($_GET['unsubscribe']) )
  {
  $unsubscribe=$_GET['unsubscribe'];
$query=mysqli_query($conn,"delete from User_Movies where movieID='$unsubscribe' AND UserID='$u'");

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
    </style>
</head>
<body>
    <div class="navbar">
        <a> Movies World </a>
        <a href="myvideos.php" style="float:right;display:inline;"> My Subscriptions  </a>
        <a href="logout.php" style="float:right;display:inline;">Logout </a>

        <a style="display:inline;float:right;"> Welcome <?php echo htmlspecialchars($_SESSION["username"]); ?></a>

    </div>
    


<?php
$api_url = 'https://api.themoviedb.org/3/discover/movie?sort_by=popularity.desc&api_key=04c35731a5ee918f014970082a0088b1&page=1';
$IMGPATH = "https://image.tmdb.org/t/p/w1280";
// Read JSON file
$json_data = file_get_contents($api_url);

// Decode JSON data into PHP array
$response_data = json_decode($json_data);

// All user data exists in 'data' object
$user_data = $response_data->results;

$_SESSION["movies"] = $user_data;
foreach ($user_data as $user) {
 $query=mysqli_query($conn,"insert into Movies (movieID) values ('$user->id')");
}


$data = array();
$userid=$_SESSION['id'];



 $sql = "SELECT movieID FROM Movies WHERE NOT EXISTS(SELECT 1 FROM User_Movies WHERE User_Movies.movieID=Movies.movieID AND User_Movies.UserID='$userid')";
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
                    </br>
                        <a href="myvideos.php?page={$user->id}">
         <input type="submit" class="a" value="Subscribe"/> 
        </a>
                    
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