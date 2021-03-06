<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">

<title>My APP | Mobiotics</title>
</head>
<body>
<div class="container">
  <div class="jumbotron">
    <h1>Register</h1>
    <p>Click to Register with our Application.
    </p>
  </div> 
  <div class="row">
  <div class="col-sm-4">
  <div class=" w3-padding ">
  <form action="" method="post" enctype="multipart/form-data">
  <p>Username</p>
  <input type=  "text" class="form-control" name="Username" required>
  <p>Email ID</p>
  <input type="email" class="form-control" name="email" required>
  <p>Password</p>
  <input type="password" class="form-control" name="password" required>
  <p>Profile photo</p>
  <input type="file" class="form-control" name="fileToUpload" required>
  <hr>
  <input type="submit" name="submit" class="btn btn-primary" value="Register" />
  </form>
</div>
  </div>
  <div class="col-sm-2"></div>
  <div class="col-sm-4">
  <div class="w3-card w3-padding ">
  <form action="dashboard.php" method="post"> 
  <p>Username</p>
  <input type="text" class="form-control" name="Username" required>
  <p>Password</p>
  <input type="password" class="form-control" name="Password" required> 
  <hr>
  <input type="submit" name="submit" class="btn btn-primary" value="Login now" />

   </form>
  </div>
  </div>
  </div>
</div>
<?php

 if(isset($_POST["submit"])) { 
$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
  $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
  if($check !== false) { 
    $uploadOk = 1;
  } else {
    echo "File is not an image.";
    $uploadOk = 0;
  }

 if (file_exists($target_file)) {
  echo "Sorry, file already exists.";
  $uploadOk = 0;
}

 if ($_FILES["fileToUpload"]["size"] > 5000000) {
  echo "Sorry, your file is too large.";
  $uploadOk = 0;
}

 if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
  echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
  $uploadOk = 0;
}

 if ($uploadOk == 0) {
  echo "Sorry, your file was not uploaded.";
 } else {
  if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {

    $handle = curl_init();
    $url = "http://localhost:4247/add";
    $data = [
      'Username' => $_POST['Username'],
      'email'  => $_POST['email'],
      'password'    => $_POST['password'],
    'profilepic' => $_FILES['fileToUpload']['name']
    ]; 
  $curl = curl_init($url);
 curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
 curl_setopt($curl, CURLOPT_POST, true);
 curl_setopt($curl, CURLOPT_POSTFIELDS,  json_encode($data));
 curl_setopt($curl, CURLOPT_HTTPHEADER, [
  'X-RapidAPI-Host: kvstore.p.rapidapi.com',
  'X-RapidAPI-Key: 7xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx',
  'Content-Type: application/json'
]);
 $response = curl_exec($curl);
 curl_close($curl);
 $response =json_decode($response);
if($response->id > 0){
echo "done";
}
else{
?>
<script>alert("Invalid credentials. Please check it.");</script>
<?php
}
     } else {
    echo "Sorry, there was an error uploading your file.";
  }
}

} 
?>
</body>
</html>