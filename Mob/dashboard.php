<?php
$Username = $_POST['Username'];
$Password = $_POST['Password'];
  

$handle = curl_init();
$url = "http://localhost:4247/login";
$data = [
  'Username' => $Username,
  'Password'    => $Password
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
    session_start(); 
    $_SESSION["user"] = $Username;
}
else{
?>
<script>
alert("Invalid credentials");
window.location = "index.php";

</script>
<?php
 }


 $url = 'http://localhost:4247/';
 $crl = curl_init();
 
 curl_setopt($crl, CURLOPT_URL, $url);
 curl_setopt($crl, CURLOPT_FRESH_CONNECT, true);
 curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
 $response = curl_exec($crl);
  
 curl_close($crl);
 
$response = json_decode($response);
 
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
<style>
body {
    background-color: #fff;
    color: #24292e;
    font-family: "Poppins", -apple-system, BlinkMacSystemFont, Segoe UI, Helvetica, Arial, sans-serif;
    font-size: 14px;
    line-height: 1.5;
}



.pager-nav {
    margin: 16px 0;
}
.pager-nav span {
    display: inline-block;
    padding: 4px 8px;
    margin: 1px;
    cursor: pointer;
    font-size: 14px;
    background-color: #FFFFFF;
    border: 1px solid #e1e1e1;
    border-radius: 3px;
    box-shadow: 0 1px 1px rgba(0,0,0,.04);
}
.pager-nav span:hover,
.pager-nav .pg-selected {
    background-color: #f9f9f9;
    border: 1px solid #CCCCCC;
}
</style>
<div class="container">
  <div class="jumbotron">
    <h1>Welcome <?php echo $_SESSION['user']; ?></h1>
    <p>Have a greate day ahead.</p>
  </div>
  <div class="row">
  <div class="col-sm-12">
  List of users

  <table class="table wp-list-table widefat striped posts" id="pager">
    <thead>
      <tr>
        <th>No</th>
        <th>Username</th>
        <th>Email</th>
        <th>Profile Photo</th>
        <th>Edit</th> 
      </tr>
    </thead>
    <tbody>
    <?php 
    $n =0;
foreach($response as $value){
    $n++;
    ?>
      <tr>
        <td><?php echo $n; ?></td>
        <td><?php echo $value->Username; ?></td>
        <td><?php echo $value->email; ?></td>
        <td>
        <img src="./uploads/<?php echo $value->profilepic; ?>" style="width:50px;">
         </td>
        <td>

  <form action="edit.php" method="post"> 
        <input type="hidden" value="<?php echo $value->id;?>" name="id">
        <input type="submit" name="submit" class="btn btn-primary" value="Edit" />
 </form>
        </td>
      </tr>
      <?php
}
      ?>
    </tbody>
  </table>
  <div id="pageNavPosition" class="pager-nav"></div>

  </div>
  </div>
</div>
<script>
/* eslint-env browser */
/* global document */

function Pager(tableName, itemsPerPage) {
    'use strict';

    this.tableName = tableName;
    this.itemsPerPage = itemsPerPage;
    this.currentPage = 1;
    this.pages = 0;
    this.inited = false;

    this.showRecords = function (from, to) {
        let rows = document.getElementById(tableName).rows;

        // i starts from 1 to skip table header row
        for (let i = 1; i < rows.length; i++) {
            if (i < from || i > to) {
                rows[i].style.display = 'none';
            } else {
                rows[i].style.display = '';
            }
        }
    };

    this.showPage = function (pageNumber) {
        if (!this.inited) {
            // Not initialized
            return;
        }

        let oldPageAnchor = document.getElementById('pg' + this.currentPage);
        oldPageAnchor.className = 'pg-normal';

        this.currentPage = pageNumber;
        let newPageAnchor = document.getElementById('pg' + this.currentPage);
        newPageAnchor.className = 'pg-selected';

        let from = (pageNumber - 1) * itemsPerPage + 1;
        let to = from + itemsPerPage - 1;
        this.showRecords(from, to);

        let pgNext = document.querySelector('.pg-next'),
            pgPrev = document.querySelector('.pg-prev');

        if (this.currentPage == this.pages) {
            pgNext.style.display = 'none';
        } else {
            pgNext.style.display = '';
        }

        if (this.currentPage === 1) {
            pgPrev.style.display = 'none';
        } else {
            pgPrev.style.display = '';
        }
    };

    this.prev = function () {
        if (this.currentPage > 1) {
            this.showPage(this.currentPage - 1);
        }
    };

    this.next = function () {
        if (this.currentPage < this.pages) {
            this.showPage(this.currentPage + 1);
        }
    };

    this.init = function () {
        let rows = document.getElementById(tableName).rows;
        let records = (rows.length - 1);

        this.pages = Math.ceil(records / itemsPerPage);
        this.inited = true;
    };

    this.showPageNav = function (pagerName, positionId) {
        if (!this.inited) {
            // Not initialized
            return;
        }

        let element = document.getElementById(positionId),
            pagerHtml = '<span onclick="' + pagerName + '.prev();" class="pg-normal pg-prev">&#171;</span>';

        for (let page = 1; page <= this.pages; page++) {
            pagerHtml += '<span id="pg' + page + '" class="pg-normal pg-next" onclick="' + pagerName + '.showPage(' + page + ');">' + page + '</span>';
        }

        pagerHtml += '<span onclick="' + pagerName + '.next();" class="pg-normal">&#187;</span>';

        element.innerHTML = pagerHtml;
    };
}



//
let pager = new Pager('pager', 2);

pager.init();
pager.showPageNav('pager', 'pageNavPosition');
pager.showPage(1);
</script>
</body>
</html>






