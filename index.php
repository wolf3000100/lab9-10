<?php
require_once 'php/db_connect.php';
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>HTML5 Бронювання кімнат в готелі (JavaScript/PHP/MySQL)</title>
    <link href="css/styles.css" type="text/css" rel="stylesheet" />
    <script src="js/jquery-3.4.1.min.js" type="text/javascript"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css" />
    <script src="js/daypilot-all.min.js" type="text/javascript"></script>
</head>
<body>
<header>
    <div class="bg-help">
        <div class="inBox">
            <h1 id="logo">HTML5 Бронювання кімнат в готелі (JavaScript/PHP)</h1>
            <p id="claim">AJAX'овий Календар-застосунок з JavaScript/HTML5/jQuery</p>
            <!--<a href="php/new.php" >new</a>
            <p><a href="php/edit.php" >edit</a></p>-->
            <hr class="hidden" />
        </div>
    </div>
</header>
<main>
    <div style="width:auto; height: auto;">
        <div id="dp">тут будемо вставляти календар з бронюванням</div>
    </div>
</main>
<div class="clear">
</div>
<footer>
    <address>(с)ІУСТ-18001М, Петлицький Андрій</address>
</footer>
</body>

<script>



    var dp = new DayPilot.Scheduler("dp"); // створюємо новий примірник
    dp.startDate = DayPilot.Date.today().firstDayOfMonth(); //буде показуватися з першого дня поточного місяця
    dp.days = DayPilot.Date.today().daysInMonth();
    dp.scale = "Day"; //показувати тільки днями
    dp.timeHeaders = [ //налаштовуємо формат виводу заголовку
        { groupBy: "Month", format: "MMMM yyyy" },
        { groupBy: "Day", format: "d" }
    ];

    dp.rowHeaderColumns = [
        {title: "Room", width: 80},
        {title: "Capacity", width: 80},
        {title: "Status", width: 80}
    ];


    dp.onBeforeResHeaderRender = function(args) {
        var beds = function(count) {
            return count + " bed" + (count > 1 ? "s" : "");
        };

        args.resource.columns[0].html = beds(args.resource.capacity);
        args.resource.columns[1].html = args.resource.status;
        switch (args.resource.status) {
            case "Dirty":
                args.resource.cssClass = "status_dirty";
                break;
            case "Cleanup":
                args.resource.cssClass = "status_cleanup";
                break;
        }
    };



    dp.onTimeRangeSelected = function (args) {

        var modal = new DayPilot.Modal();
        modal.closed = function() {
            dp.clearSelection();

            var data = this.result;
            if (data && data.result === "OK") {
                loadEvents();
            }
        };
        modal.showUrl("php/new.php?start=" + args.start + "&end=" + args.end + "&resource=" + args.resource);

    };

    dp.onEventClick = function(args) {
        var modal = new DayPilot.Modal();
        modal.closed = function() {
            // reload all events
            var data = this.result;
            if (data && data.result === "OK") {
                loadEvents();
            }
        };
        modal.showUrl("php/edit.php?start=" + args.start + "&end=" + args.end+"&id=" + args.e.id()+ "&resource=" + args.resource);
    };


    dp.init(); //вивід

jQuery(document).ready(function() {

    function loadResources() {
        $.post("php/b_rooms.php",
            { capacity: $("#filter").val() },
            function(data) {
                dp.resources = data;
                dp.update();
            });
    }

    function loadEvents() {
        var start = dp.visibleStart();
        var end = dp.visibleEnd();

        $.post("php/b_events.php",
            {
                start: start.toString(),
                end: end.toString()
            },
            function(data) {
                dp.events.list = data;
                dp.update();
            }
        );
    }

    loadResources();
    loadEvents();

});
</script>

</html>


