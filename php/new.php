<?php
require_once 'db_connect.php';
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>New Reservation</title>
    <script src="../js/jquery-3.4.1.min.js" type="text/javascript"></script>
    <script src="../js/daypilot-all.min.js" type="text/javascript"></script>
</head>
<body>
<?php
// перевірка додавання броні
//is_numeric($_GET['id']) or die("invalid URL");



$rooms = $db->query('SELECT * FROM rooms');

$start = $_GET['start']; //'2019-05-11 00:00:00' ЗРОБИТИ правильне форматування
$end =  $_GET['end']; //'2019-05-20 00:00:00' ЗРОБИТИ правильне форматування
echo  $_GET['start'].", ".$_GET['end'].", ".$_GET['resource'];
?>
<form id="f" method="post" action="b_create.php" style="padding:20px;">
    <h1>New Reservation</h1>
    <div>Name: </div>
    <div><input type="text" id="name" name="name" value="" /></div>
    <div>Start:</div>
    <div><input type="text" id="start" name="start" value="<?php echo $start ?>" /></div>
    <div>End:</div>
    <div><input type="text" id="end" name="end" value="<?php echo $end ?>" /></div>
    <div>Room:</div>
    <div>
        <select id="room" name="room">
            <?php
            foreach ($rooms as $room) {
                $selected = $_GET['resource'] == $room['id'] ? ' selected="selected"' : '';
                $id = $room['id'];
                $name = $room['name'];
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
