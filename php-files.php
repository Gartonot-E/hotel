<!-- Цены -->
 
<?php
    
    $result = $mysqli->query("SELECT * FROM `price`");

    while ($row = $result->fetch_accos()) {
      
      echo '<tr class="table-row">';
      echo '<th scope="row">' . $row['id'] . '</th>';
      echo '<td>' . $row['type_room'] . '</td>';
      echo '<td>' . $row['summa'] . '₽/в сутки</td>';
      echo '</tr>'; 

    }

?>

<!-- Все комнаты -->

<?php
    
    $result = $mysqli->query("SELECT * FROM `all_rooms`");

    while ($row = $result->fetch_accos()) {
      
      echo '<tr class="table-row">';
      echo '<th scope="col">' . $row['id'] . '</th>';
      echo '<td>' . $row['number_room'] . '</td>';
      echo '<td>' . $row['id_user'] . '</td>';
      echo '<td>' . $row['status'] . '</td>';
      echo '<td>' . $row['is_clear'] . '</td>';
      echo '<td>' . $row['count_days'] . '</td>';
      echo '<td>' . $row['type_room'] . '</td>';
      echo '<td>' . $row['checkin_date'] . '</td>';
      echo '<td>' . $row['checkout_date'] . '</td>';
      echo '<td>' . $row['summa'] . '₽/в сутки</td>';
      echo '</tr>'; 

    }

?>

<!-- Бронь -->

<?php
    
    $result = $mysqli->query("SELECT * FROM `all_rooms`");

    while ($row = $result->fetch_accos()) {
      
      if ($row['status'] == 'Забронирован') {   

        echo '<tr class="table-row">';
        echo '<th scope="col">' . $row['id'] . '</th>';
        echo '<td>' . $row['status'] . '</td>';
        echo '<td>' . $row['id_user'] . '</td>';
        echo '<td>' . $row['checkin_date'] . '</td>';
        echo '<td>' . $row['count_days'] . '</td>';
        echo '<td>' . $row['number_room'] . '</td>';
        echo '<td>' . $row['type_room'] . '</td>';
        echo '</tr>'; 

      }  
    }

?>  

<!-- Занят -->

<?php
    
    require 'connect.php';

    $dete_booked = $mysqli->query("SELECT `date`, `time` FROM `booked_room`");
    $result = $mysqli->query("SELECT `booked_room`.`id`, `status`.`status`, `booked_room`.`full_name`, `booked_room`.`date`, `booked_room`.`count_days`, `booked_room`.`room`, `price`.`type_room` FROM `booked_room` JOIN `status` ON `booked_room`.`status` = `status`.`id` JOIN `price` ON `booked_room`.`type_room` = `price`.`id`;");
    
    while ($row = $result->fetch_accos()) {
      
      if (date('Y-m-d', 'H:i') >= $date_booked && date('Y-m-d', 'H:i') <= $date_booked + $row['count_days']) {   

        echo '<tr class="table-row">';
        echo '<th scope="col">' . $row['id'] . '</th>';
        echo '<td>' . $row['status'] . '</td>';
        echo '<td>' . $row['id_user'] . '</td>';
        echo '<td>' . $row['checkin_date'] . '</td>';
        echo '<td>' . $row['count_days'] . '</td>';
        echo '<td>' . $row['number_room'] . '</td>';
        echo '<td>' . $row['type_room'] . '</td>';
        echo '</tr>'; 


      }  
    }

?> 

<?php

    $dete_booked = $mysqli->query("SELECT `date` FROM `booked_room`");
    if (date('Y-m-d') >= $date_booked && date('Y-m-d') <= $date_booked + $row['count_days']) {

    }


?>