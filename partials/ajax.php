<?php
include('../config/pdoconfig.php');

// Mã phòng
if (!empty($_POST["RNumber"])) {
    $id = $_POST['RNumber'];
    $stmt = $DB_con->prepare("SELECT * FROM rooms WHERE number = :id ");
    $stmt->execute(array(':id' => $id));
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo 'Mã phòng: ' . htmlentities($row['id']);
    }
}

// Giá phòng
if (!empty($_POST["RID"])) {
    $id = $_POST['RID'];
    $stmt = $DB_con->prepare("SELECT * FROM  rooms WHERE number = :id ");
    $stmt->execute(array(':id' => $id));
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo 'Giá phòng: ' . htmlentities($row['price']);
    }
}

// Loại phòng
if (!empty($_POST["RCost"])) {
    $id = $_POST['RCost'];
    $stmt = $DB_con->prepare("SELECT * FROM  rooms WHERE number = :id ");
    $stmt->execute(array(':id' => $id));
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo 'Loại phòng: ' . htmlentities($row['type']);
    }
}

/* Thông tin nhân viên */
if (!empty($_POST["StaffNumber"])) {
    $id = $_POST['StaffNumber'];
    $stmt = $DB_con->prepare("SELECT * FROM staffs WHERE number = :id ");
    $stmt->execute(array(':id' => $id));
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo 'Mã nhân viên: ' . htmlentities($row['id']);
    }
}

if (!empty($_POST["StaffID"])) {
    $id = $_POST['StaffID'];
    $stmt = $DB_con->prepare("SELECT * FROM staffs WHERE number = :id ");
    $stmt->execute(array(':id' => $id));
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo 'Tên nhân viên: ' . htmlentities($row['name']);
    }
}
