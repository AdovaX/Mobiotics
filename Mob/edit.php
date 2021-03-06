<?php

$id = $_POST['id'];

$handle = curl_init();
$url = "http://localhost:4247/search";
$data = [
  'id' => $id
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
}
else{
?>
<script>
alert("Invalid credentials");
window.location = "index.php";

</script>
<?php
 }


?>
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
 <h1> Edit user </h1>
  </div>
  <form action="" method="post" enctype="multipart/form-data">
  <input type="hidden" value="<?php echo $response->id;?>" name="id">
  username : <input type="text" class="form-control" value="<?php echo $response->Username;?>" name="Username"> <br>
  Email : <input type="text" class="form-control" value="<?php echo $response->email;?>" name="email"> <br>
  password : <input type="text" class="form-control" value="<?php echo $response->password;?>" name="password"> <br>
  Profile photo : <input type="file" required class="form-control" value="<?php echo $response->profilepic;?>" name="fileToUpload"> <br>
  <input type="submit" name="updates" class="btn btn-primary" value="Update" />
</form>
  </div>

<?php

if(isset($_POST["updates"])) { 
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
        $url = "http://localhost:4247/edit";
        $data = [
            'id' => $_POST['id'],
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
    if($response->message){
        ?>
        <script>
        alert("Updated");
        window.history.back(-3);
        
        </script>
        <?php
    }
    else{
    ?>
    <script>alert("Invalid data");</script>
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