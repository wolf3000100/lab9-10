<?php

require_once 'db_connect.php';


$stmt = $db->prepare("INSERT INTO reservations (name, start, end, room_id, status, paid) VALUES (:name, :start, :end, :room, 'New', 0)");
$stmt->bindParam(':start', $_POST['start']);//$start
$stmt->bindParam(':end', $_POST['end']);//$end
$stmt->bindParam(':name', $_POST['name']);//$name
$stmt->bindParam(':room', $_POST['room']);//$room
$stmt->execute();

class Result {}

$response = new Result();
$response->result = 'OK';
$response->message = 'Created with id: '.$db->lastInsertId();
$response->id = $db->lastInsertId();

header('Content-Type: application/json');
echo json_encode($response);
