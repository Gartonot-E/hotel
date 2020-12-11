<?php 
require_once '../connect.php';

// all_rooms1
// booked_room1
// occupied_rooms1
// clients +
// personal +
// clear_room +
// position +
// status +
// price +

$success = [];
$errors = [];

if(isset($_POST['done_status']) and !empty($_POST['status'])){
	$status = $_POST['status'];
	$res = $mysqli->query("INSERT INTO `status` (`status`) VALUES ('$status')");

	if($res){
		$success[] = "Статус \"".$status."\" добавлен";
	} else {
		$errors[] = "Ошибка с БД";
	}
}

if(isset($_POST['done_position']) and !empty($_POST['position'])){
	$position = $_POST['position'];
	$res = $mysqli->query("INSERT INTO `position` (`position`) VALUES ('$position')");

	if($res){
		$success[] = "Должность \"".$position."\" добавлен";
	} else {
		$errors[] = "Ошибка с БД";
	}
}

if(isset($_POST['done_clear']) and !empty($_POST['clear'])){
	$clear = $_POST['clear'];
	$res = $mysqli->query("INSERT INTO `clear_room` (`status`) VALUES ('$clear')");

	if($res){
		$success[] = "Статус \"".$clear."\" добавлен";
	} else {
		$errors[] = "Ошибка с БД";
	}
}

if(isset($_POST['done_personal']) and !empty($_POST['full_name']) and !empty($_POST['position'])){
	$full_name = $_POST['full_name'];
	$position = $_POST['position'];
	$res = $mysqli->query("INSERT INTO `personal` (`full_name`, `position`) VALUES ('$full_name', '$position')");
	$res1 = $mysqli->query("SELECT * FROM `position` WHERE `id` = '$position'");

	$row1 = $res1->fetch_assoc();
	// echo $row1;

	if($res){
		$success[] = "Сотрудник \"".$full_name."\" добавлен на должность ".$row1['position'];
	} else {
		$errors[] = "Ошибка с БД";
	}
}

if(isset($_POST['done_client']) and !empty($_POST['full_name']) and !empty($_POST['passport']) and !empty($_POST['phone'])){
	$full_name = $_POST['full_name'];
	$passport = $_POST['passport'];
	$phone = $_POST['phone'];

	$res = $mysqli->query("INSERT INTO `users_clients` (`full_name`, `passport`, `phone`) VALUES ('$full_name', '$passport', '$phone')");
	
	if($res){
		$success[] = "Клиент \"".$full_name."\" добавлен на в бд";
	} else {
		$errors[] = "Ошибка с БД";
	}
}



?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
	<title>Админка</title>
</head>
<body>


<header class="" role="banner" style="height: 6vh;">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
  <a class="navbar-brand" href="../index.php">Hotel</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="../index.php" target="_blank">На сайт</a>
      </li>
    </ul>
    <form class="form-inline my-2 my-lg-0">
      <a href="../index.php" class="btn btn-outline-secondary my-2 my-sm-0" type="submit">Выйти</a>
    </form>
  </div>
</nav>
</header>

<div class="container-fluid" style="height: 94vh;">
<div class="row" style="height: 100%;">
  <div class="col-2 bg-light pt-5">
    <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
      <h4>Уведомления</h4>
      <a class="nav-link active" id="v-pills-alert-tab" data-toggle="pill" href="#v-pills-alert" role="tab" aria-controls="v-pills-home" aria-selected="true">Уведомления</a>

      <h4>Добавление в базу</h4>
      <a class="nav-link " id="v-pills-home-tab" data-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home" aria-selected="true">Добавить статус для комнат</a>

      <a class="nav-link" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="false">Добавить должность</a>

      <a class="nav-link" id="v-pills-messages-tab" data-toggle="pill" href="#v-pills-messages" role="tab" aria-controls="v-pills-messages" aria-selected="false">Добавить статус в  "очистку комнат"</a>

      <a class="nav-link" id="v-pills-settings-tab" data-toggle="pill" href="#v-pills-settings" role="tab" aria-controls="v-pills-settings" aria-selected="false">Добавление персонала</a>

      <h4>Информация по номерам</h4>
      <a class="nav-link" id="v-pills-booked-tab" data-toggle="pill" href="#v-pills-booked" role="tab" aria-controls="v-pills-booked" aria-selected="false">Забронированные номера</a>
    
      <a class="nav-link" id="v-pills-occupied-tab" data-toggle="pill" href="#v-pills-occupied" role="tab" aria-controls="v-pills-occupied" aria-selected="false">Занятые номера</a>

      <a class="nav-link" id="v-pills-all_room-tab" data-toggle="pill" href="#v-pills-all_room" role="tab" aria-controls="v-pills-all_room" aria-selected="false">Все номера</a>
    
    </div>
  </div>
  <div class="col-10">
    <div class="tab-content" id="v-pills-tabContent">

      <!-- Вывод уведомлений  -->
      <div class="tab-pane pt-5 fade show active" id="v-pills-alert" role="tabpanel" aria-labelledby="v-pills-alert-tab">
      	<?php 
      	if(isset($errors) && !empty($errors)) echo '<div class="alert alert-danger" role="alert">'.array_shift($errors).'</div>';  
      	if(isset($success) && !empty($success)) echo '<div class="alert alert-success" role="alert">'.array_shift($success).'</div>';
      	?>	
      </div>

      <!-- Добавить статусы -->
      <div class="tab-pane pt-5 fade" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
	      <form method="POST">
			  <div class="form-group">
			    <label for="status">Статус</label>
			    <input type="text" class="form-control" name="status" id="status">
			  </div>
			  <input type="submit" class="btn btn-primary" name="done_status" value="Добавить">
			</form>
      </div>

      <!-- Добавить должности в БД -->
      <div class="tab-pane pt-5 fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
	      <form method="POST">
			  <div class="form-group">
			    <label for="status">Должность</label>
			    <input type="text" class="form-control" name="position" id="position">
			  </div>
			  <input type="submit" class="btn btn-primary" name="done_position" value="Добавить">
			</form>
      </div>
      
      <!-- Добавить статусы к очисткам -->
      <div class="tab-pane pt-5 fade" id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab">
	      <form method="POST">
			  <div class="form-group">
			    <label for="clear">Очистка комнат</label>
			    <input type="text" class="form-control" name="clear" id="clear">
			  </div>
			  <input type="submit" class="btn btn-primary" name="done_clear" value="Добавить">
			</form>
      </div>

      <!-- Работники -->
      <div class="tab-pane pt-5 fade" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab">
      	<form method="POST">
			  <div class="form-group">
			    <label for="full_name">Введите ФИО работника</label>
			    <input type="text" class="form-control" name="full_name" id="full_name">
			  </div>
			  <div class="form-group">
			    <label for="position">Выберите должность</label>
			    <select name="position" id="position" class="form-control">
			    	<?php 
			    		$res = $mysqli->query("SELECT * FROM `position`");
			    		while ($row = $res->fetch_assoc()) {
			    			echo "<option value='".$row['id']."'>".$row['position']."</option>";
			    		}
			    	?>
			    </select>
			  </div>
			  <input type="submit" class="btn btn-primary" name="done_personal" value="Добавить">
			</form>
      </div>
     
      <!-- Забронированные комнаты -->
      <div class="tab-pane pt-5 fade" id="v-pills-booked" role="tabpanel" aria-labelledby="v-pills-booked-tab">
      	<p>*Вывод таблицы с <b>бронированными</b> комнаты*</p>
      </div>

       <!-- Занятые комнаты -->
      <div class="tab-pane pt-5 fade" id="v-pills-occupied" role="tabpanel" aria-labelledby="v-pills-occupied-tab">
      	<p>*Вывод таблицы с <b>занятыми</b> комнаты*</p>
      </div>

       <!-- Все комнаты -->
      <div class="tab-pane pt-5 fade" id="v-pills-all_room" role="tabpanel" aria-labelledby="v-pills-all_room-tab">
      	<p>*Вывод таблицы с <b>всеми</b> комнатами*</p>
      </div>
    </div>
  </div>
</div>
</div>





<!-- jQuery and JS bundle w/ Popper.js -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
</body>
</html>