<?php 

require_once 'connect.php';

$errors  = [];
$success = [];

if(isset($_POST['done_booked']) && !empty($_POST['full_name']) && !empty($_POST['phone']) && !empty($_POST['type_room']) && !empty($_POST['date']) && !empty($_POST['time']) && !empty($_POST['count_days'])  && !empty($_POST['room'])){

  $full_name  = $_POST['full_name'];
  $phone      = $_POST['phone'];
  $type_room  = $_POST['type_room'];
  $date       = $_POST['date'];
  $time       = $_POST['time'];
  $count_days = $_POST['count_days'];
  $room       = $_POST['room'];



  $mysqli->query("INSERT INTO `users_clients` (`full_name`, `phone`) VALUES ('$full_name', '$phone')");

  $res = $mysqli->query("SELECT * FROM `users_clients` WHERE `phone` = '$phone'");

  $rowUser = $res->fetch_assoc();

  $id_user_from_users_clients = $rowUser['id'];

  $res = $mysqli->query("INSERT INTO `booked_room`(`full_name`, `phone`, `type_room`, `date`, `time`, `count_days`, `room`) 
    VALUES ('$full_name', '$phone', '$type_room', '$date', '$time', '$count_days', '$room')");

  if($res){ 
    $success[] = "Всё хорошо, вы забронирвоали номер #".$room." на имя ".$full_name." на дату ".$date;

    $mysqli->query("UPDATE `all_rooms` SET `id_user` = '$id_user_from_users_clients' WHERE `number_room` = '$room'");
  } else {
    $errors[] = "Ошибка с базой данных";
   }

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Бронировать номер</title>
	<!-- CSS -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
	<link rel="stylesheet" href="css/style.css">
</head>
<body style="background: url('img/body-bg.jpg') no-repeat top center / cover">

<header class="mb-2" role="banner">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
  <a class="navbar-brand" href="index.php">Hotel</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li>
        <a class="nav-link text-secondary" target="_blank" href="booked.php">Забронировать номер</a>
      </li>
    </ul>
    <form class="form-inline my-2 my-lg-0">
      <a class="btn btn-outline-secondary my-2 my-sm-0" href="index.php">На главную</a>
    </form>
  </div>
</nav>
</header>

<div class="container">
<ul class="nav nav-tabs text-center" id="myTab" role="tablist">
  <li class="nav-item mb-2" role="presentation">
    <a class="nav-link active text-dark rounded" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Забронировать</a>
  </li>
</ul>
<div class="tab-content mt-2" id="myTabContent">
  <div class="tab-pane fade show active bg-light p-5 rounded" id="home" role="tabpanel" aria-labelledby="home-tab">
    <form method="POST">
      <?php 
        if(isset($errors) && !empty($errors)) echo '<div class="alert alert-danger" role="alert">'.array_shift($errors).'</div>';  
        if(isset($success) && !empty($success)) echo '<div class="alert alert-success" role="alert">'.array_shift($success).'</div>';

        ?>  
      <div class="form-group">
        <label for="full_name">Ваше ФИО</label>
        <input type="text" class="form-control" id="full_name" name="full_name" required>
      </div>
      <div class="form-group">
        <label for="phone">Ваш телефон</label>
        <input type="number" class="form-control" id="phone" name="phone" required>
      </div>
      <div class="form-group">
        <label for="type_room">Выберите класс номера</label>
        <select id="type_room" class="form-control" name="type_room" required>
            <?php 

              $res = $mysqli->query("SELECT * FROM `price`");
              while($row = $res->fetch_assoc()){
                echo "<option value='".$row['id']."'>".$row['type_room']."</option>";
              }
            ?>
        </select>
      </div>
      <div class="block-flex" style="display: flex; justify-content: space-between;">
        <div class="form-group">
          <label for="date">Выберите дату</label>
          <input type="date" class="form-control" value="<?=date('Y-m-d');?>" id="date" name="date" required>
        </div>
        <div class="form-group">
          <label for="time">Выберите время</label>
          <input type="time" class="form-control" value="<?=date('H:i');?>" id="time" name="time" required>
        </div>
        <div class="form-group">
          <label for="count_days">Кол-во суток</label>
          <input type="number" min="1" value="1" class="form-control" id="count_days" name="count_days" required>
        </div>
        <div class="form-group">
          <label for="room">Выберите номер, в котором будете жить</label>
          <select name="room" id="room" class="form-control" required>
          <?php 
              $res = $mysqli->query("SELECT * FROM `all_rooms` WHERE `id_user` = 0");
              while ($row = $res->fetch_assoc()) {
                echo "<option value='".$row['id']."'>".$row['number_room']."</option>";
              }
          ?>
          </select>
        </div>
      </div>
      <input type="submit" class="btn btn-primary" name="done_booked" value="Забронировать">
    </form>
  </div>
</div>
</div>




<!-- jQuery and JS bundle w/ Popper.js -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
</body>
</html>