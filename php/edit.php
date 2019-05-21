<?php

require_once 'db_connect.php';
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Edit Reservation</title>
    <script src="../js/jquery-3.4.1.min.js" type="text/javascript"></script>
    <script src="../js/daypilot-all.min.js" type="text/javascript"></script>
</head>
<body>
<?php
// перевірка додавання броні
is_numeric($_GET['id']) or die("invalid URL");



$rooms = $db->query('SELECT * FROM rooms');
$reservations = $db->query("SELECT * FROM reservations WHERE id='".$_GET['id']."'");

$name = '';
$start = '';
$end = '';
$room = '';
$status = '';
$paid = '';
foreach($reservations as $reservation){
    $name_customer = $reservation['name'];
    $start = $reservation['start'];
    $end = $reservation['end'];
    $room_id = $reservation['room_id'];
    $status = $reservation['status'];
    $paid = $reservation['paid'];
}
$r_id = $_GET['id'];
echo $name_customer." , ".$start.", ".$r_id;
//$start = $_GET['start']; //'2019-05-11 00:00:00' ЗРОБИТИ правильне форматування
//$end =  $_GET['end']; //'2019-05-20 00:00:00' ЗРОБИТИ правильне форматування


?>
<form id="f" action="b_update.php" method="post" style="padding:20px;">
    <h1>Edit Reservation</h1>
    <input id="r_id" style="display: none;" type="text" name="id" value="<?php echo $r_id ?>" />
    <div>Name: </div>
    <div><input type="text" id="name" name="name" value="<?php echo $name_customer ?>" /></div>
    <div>Start:</div>
    <div><input type="text" id="start" name="start" value="<?php echo $start ?>" /></div>
    <div>End:</div>
    <div><input type="text" id="end" name="end" value="<?php echo $end ?>" /></div>
    <div>Room:</div>
    <div>
        <select id="room" name="room">
            <?php
            foreach ($rooms as $room) {
                $selected = $room_id == $room['id'] ? ' selected="selected"' : '';
                $id = $room['id'];
                $name = $room['name'];
                print "<option value='$id' $selected>$name</option>";
            }
            ?>
        </select>

    </div>
    <div>Status:</div>
    <div>
        <select id="status" name="status">
            <?php
            $options = array("New", "Confirmed", "Arrived", "CheckedOut");
            foreach ($options as $option) {
                $selected = $option == $status ? ' selected="selected"' : '';
                $id = $option;
                $name = $option;
                print "<option value='$id' $selected>$name</option>";
            }
            ?>
        </select>
    </div>
    <div>Paid:</div>
    <div>
        <select id="paid" name="paid">
            <?php
            $options = array(0, 50, 100);
            foreach ($options as $option) {
                $selected = $option == $paid ? ' selected="selected"' : '';
                $id = $option;
                $name = $option."%";
                print "<option value='$id' $selected>$name</option>";
            }
            ?>
        </select>

    </div>
    <div class="space"><input type="submit" value="Save" style="margin-top: 10px" /> <a href="javascript:close();">Cancel</a></div>
</form>
</body>

<script type="text/javascript">
    function close(result) {
        if (parent && parent.DayPilot && parent.DayPilot.ModalStatic) {
            parent.DayPilot.ModalStatic.close(result);
        }
    }

    $("#f").submit(function () {
        var f = $("#f");
        $.post(f.attr("action"), f.serialize(), function (result) {
            close(eval(result));
        });
        return false;
    });

    $(document).ready(function () {
        $("#name").focus();
    });

</script>

</html>
