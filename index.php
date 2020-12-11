<?php 

	require_once 'connect.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Система гостиницы</title>
	<!-- CSS -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
	<link rel="stylesheet" href="css/style.css">
</head>
<body style="background: url('img/body-bg.jpg') no-repeat top center / cover">

<div class="container-fluid">
  <header class="mb-2" role="banner">
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <a class="navbar-brand" href="#">Hotel</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">
        <li>
          <a class="nav-link text-secondary" href="booked.php">Забронировать номер</a>
        </li>
      </ul>
      <form class="form-inline my-2 my-lg-0">
        <a class="btn btn-outline-secondary my-2 my-sm-0" href="../admin/" target="_blank" type="submit">Админка</a>
      </form>
    </div>
  </nav>
  </header>
  </div>  

	<div class="container">
<ul class="nav nav-tabs" id="myTab" role="tablist">
  <li class="nav-item" role="presentation">
    <a class="nav-link active text-dark" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Свободные комнаты</a>
  </li>
  <li class="nav-item" role="presentation">
    <a class="nav-link text-dark" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Бронь</a>
  </li>
  <li class="nav-item" role="presentation">
    <a class="nav-link text-dark" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Занято</a>
  </li>
  <li class="nav-item" role="presentation">
    <a class="nav-link text-dark" id="flap-tab" data-toggle="tab" href="#flap" role="tab" aria-controls="flap" aria-selected="false">Цены</a>
  </li>
</ul>
<div class="tab-content" id="myTabContent">
  <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
  <table class="table" style="background: #ffffffbb; border-radius: 2px;">
  <thead>
    <tr>
	   <th scope="col">#</th>
      <th scope="col">Номер</th>
      <th scope="col">Тип Номера</th>
      <th scope="col">Ценна</th>
    </tr>
  </thead>
  <tbody>
    <?php 
      $res = $mysqli->query("SELECT `all_rooms`.`id`, `all_rooms`.`number_room`, `price`.`type_room`, `price`.`summa` FROM `all_rooms` JOIN `price` ON `all_rooms`.`type_room` = `price`.`id` WHERE `all_rooms`.`id_user` = 0");
      while ($row = $res->fetch_assoc()) {
        echo "<tr>
                <th>".$row['id']."</th>
                <td>".$row['number_room']."</td>
                <td>".$row['type_room']."</td>
                <td>".$row['summa']."</t>
              </tr>";
      }
    ?>
  </tbody>
</table>
  </div>
  <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
  <table class="table" style="background: #ffffffbb; border-radius: 2px;">
  <thead>
    <tr>
  	  <th scope="col">#</th>
      <th scope="col">Статус</th>
      <th scope="col">ФИО гостя</th>
  	  <th scope="col">Заселения</th>
  	  <th scope="col">Дни</th>
      <th scope="col">Номер</th>
  	  <th>Тип</th>
    </tr>
  </thead>
  <tbody>
    <?php

      $res = $mysqli->query("SELECT `booked_room`.`id`, `status`.`status`, `booked_room`.`full_name`, `booked_room`.`date`, `booked_room`.`count_days`, `booked_room`.`room`, `price`.`type_room` FROM `booked_room` JOIN `status` ON `booked_room`.`status` = `status`.`id` JOIN `price` ON `booked_room`.`type_room` = `price`.`id`;"); 

      while($row = $res->fetch_assoc()){
        echo "<tr class='table-row'>
                <th scope='row'>".$row['id']."</th>
                <td>".$row['status']."</td>
                <td>".$row['full_name']."</td>
                <td>".$row['date']."</td>
                <td>".$row['count_days']."</td>
                <td>#".$row['room']."</td>
                <td>".$row['type_room']."</td>
              </tr>";
      }

    ?>
  </tbody>
</table>
  </div>
  <div class="tab-pane fade" id="flap" role="tabpanel" aria-labelledby="flap-tab">
  <table class="table" style="background: #ffffffbb; border-radius: 2px;">
  <thead>
    <tr>
	  <th scope="col">#</th>
      <th scope="col">Тип</th>
      <th scope="col">Стоимость</th>
    </tr>
  </thead>
  <tbody>
    
    <?php

      $res = $mysqli->query("SELECT * FROM `price`"); 
      while($row = $res->fetch_assoc()){
        echo '<tr class="table-row">
              <th scope="row">' . $row['id'] . '</th>
              <td>' . $row['type_room'] . '</td>
              <td>' . $row['summa'] . '₽/в сутки</td> 
              </tr>'; 
      }

    ?>
  </tbody>
</table>
  </div>
  <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
  <table class="table" style="background: #ffffffbb; border-radius: 2px;">
  <thead>
    <tr>
     <th scope="col">#</th>
      <th scope="col">Номер</th>
      <th scope="col">ФИО гостя</th>
      <th scope="col">Статус</th>
      <th scope="col">Уборка</th>
      <th scope="col">Дни</th>
      <th scope="col">Тип</th>
      <th scope="col">Заселения</th>
      <th scope="col">Стоимость</th>
    </tr>
  </thead>
  <tbody>
    <?php 
      $res = $mysqli->query("SELECT `all_rooms`.`id`, `all_rooms`.`number_room`, `users_clients`.`full_name`, `status`.`status`, `clear_room`.`status` AS `clear`, `booked_room`.`count_days`, `price`.`type_room`, `booked_room`.`date`, `price`.`summa` FROM `all_rooms` JOIN `users_clients` ON `all_rooms`.`id_user` = `users_clients`.`id` JOIN `booked_room` ON `all_rooms`.`number_room` = `booked_room`.`room` JOIN `price` ON `booked_room`.`type_room` = `price`.`id` JOIN `status` ON `all_rooms`.`status` = `status`.`id` JOIN `clear_room` ON `all_rooms`.`is_clear` = `clear_room`.`id`");
      while ($row = $res->fetch_assoc()) {
        echo "<tr>
               <th>".$row['id']."</th>
                <td>".$row['number_room']."</td>
                <td>".$row['full_name']."</td>
                <td>".$row['status']."</t>
                <td>".$row['crear']."</td>
                <td>".$row['count_days']."</td>
                <td>".$row['type_room']."</td>
                <td>".$row['date']."</td>
                <td>".$row['summa']*$row['count_days']."</td>
              </tr>";
      }
    ?>
  </tbody>
</table>
  </div>
</div>
</div>


<!-- jQuery and JS bundle w/ Popper.js -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
</body>
</html>
