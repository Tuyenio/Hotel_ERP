<?php

/* 
    Số Lượng Loại Phòng Khách Sạn
 */

//1. Phòng đơn

$query = "SELECT COUNT(*) FROM `rooms` WHERE type ='Phòng đơn' ";
$stmt = $mysqli->prepare($query);
$stmt->execute();
$stmt->bind_result($single);
$stmt->fetch();
$stmt->close();

//2. Phòng đôi

$query = "SELECT COUNT(*) FROM `rooms` WHERE type ='Phòng đôi' ";
$stmt = $mysqli->prepare($query);
$stmt->execute();
$stmt->bind_result($double);
$stmt->fetch();
$stmt->close();


//3. Phòng deluxe

$query = "SELECT COUNT(*) FROM `rooms` WHERE type ='Phòng deluxe' ";
$stmt = $mysqli->prepare($query);
$stmt->execute();
$stmt->bind_result($deluxe);
$stmt->fetch();
$stmt->close();

//4. Phòng thường lớn

$query = "SELECT COUNT(*) FROM `rooms` WHERE type ='Phòng thường lớn' ";
$stmt = $mysqli->prepare($query);
$stmt->execute();
$stmt->bind_result($regular);
$stmt->fetch();
$stmt->close();


//5. Phòng penthouse

$query = "SELECT COUNT(*) FROM `rooms` WHERE type ='Phòng penthouse' ";
$stmt = $mysqli->prepare($query);
$stmt->execute();
$stmt->bind_result($penthouse);
$stmt->fetch();
$stmt->close();


//6. Phòng tổng thống

$query = "SELECT COUNT(*) FROM `rooms` WHERE type ='Phòng tổng thống' ";
$stmt = $mysqli->prepare($query);
$stmt->execute();
$stmt->bind_result($presidential);
$stmt->fetch();
$stmt->close();


/* 
    Doanh Thu Theo Loại Phòng
*/

//1. Phòng đơn

$query = "SELECT SUM(room_cost) FROM `reservations` WHERE room_type ='Phòng đơn' AND status ='Đã thanh toán'  ";
$stmt = $mysqli->prepare($query);
$stmt->execute();
$stmt->bind_result($Single);
$stmt->fetch();
$stmt->close();

//2. Phòng đôi

$query = "SELECT SUM(room_cost) FROM `reservations` WHERE room_type ='Phòng đôi' AND status ='Đã thanh toán'  ";
$stmt = $mysqli->prepare($query);
$stmt->execute();
$stmt->bind_result($Double);
$stmt->fetch();
$stmt->close();


//3. Phòng deluxe

$query = "SELECT SUM(room_cost) FROM `reservations` WHERE room_type ='Phòng deluxe' AND status ='Đã thanh toán'  ";
$stmt = $mysqli->prepare($query);
$stmt->execute();
$stmt->bind_result($Deluxe);
$stmt->fetch();
$stmt->close();

//4. Phòng thường lớn

$query = "SELECT SUM(room_cost) FROM `reservations` WHERE room_type ='Phòng thường lớn' AND status ='Đã thanh toán' ";
$stmt = $mysqli->prepare($query);
$stmt->execute();
$stmt->bind_result($Regular);
$stmt->fetch();
$stmt->close();


//5. Phòng penthouse

$query = "SELECT SUM(room_cost) FROM `reservations` WHERE room_type ='Phòng penthouse' AND status ='Đã thanh toán'  ";
$stmt = $mysqli->prepare($query);
$stmt->execute();
$stmt->bind_result($Penthouse);
$stmt->fetch();
$stmt->close();


//6. Phòng tổng thống

$query = "SELECT SUM(room_cost) FROM `reservations` WHERE room_type ='Phòng tổng thống' AND status ='Đã thanh toán'  ";
$stmt = $mysqli->prepare($query);
$stmt->execute();
$stmt->bind_result($Presidential);
$stmt->fetch();
$stmt->close();


/*
    Số Lượng Đặt Phòng Theo Loại Phòng
 */


//1. Phòng đơn

$query = "SELECT COUNT(*) FROM `reservations` WHERE room_type ='Phòng đơn'   ";
$stmt = $mysqli->prepare($query);
$stmt->execute();
$stmt->bind_result($resSingle);
$stmt->fetch();
$stmt->close();

//2. Phòng đôi

$query = "SELECT COUNT(*) FROM `reservations` WHERE room_type ='Phòng đôi'   ";
$stmt = $mysqli->prepare($query);
$stmt->execute();
$stmt->bind_result($resDouble);
$stmt->fetch();
$stmt->close();


//3. Phòng deluxe

$query = "SELECT COUNT(*) FROM `reservations` WHERE room_type ='Phòng deluxe'  ";
$stmt = $mysqli->prepare($query);
$stmt->execute();
$stmt->bind_result($resDeluxe);
$stmt->fetch();
$stmt->close();

//4. Phòng thường lớn

$query = "SELECT COUNT(*) FROM `reservations` WHERE room_type ='Phòng thường lớn' ";
$stmt = $mysqli->prepare($query);
$stmt->execute();
$stmt->bind_result($resRegular);
$stmt->fetch();
$stmt->close();


//5. Phòng penthouse

$query = "SELECT COUNT(*) FROM `reservations` WHERE room_type ='Phòng penthouse'   ";
$stmt = $mysqli->prepare($query);
$stmt->execute();
$stmt->bind_result($resPenthouse);
$stmt->fetch();
$stmt->close();


//6. Phòng tổng thống

$query = "SELECT COUNT(*) FROM `reservations` WHERE room_type ='Phòng tổng thống'   ";
$stmt = $mysqli->prepare($query);
$stmt->execute();
$stmt->bind_result($resPresidential);
$stmt->fetch();
$stmt->close();


/* Cấu Trúc Bảng Điều Khiển Phân Tích */

//1. Nhân viên
$query = "SELECT COUNT(*) FROM `staffs` ";
$stmt = $mysqli->prepare($query);
$stmt->execute();
$stmt->bind_result($staffs);
$stmt->fetch();
$stmt->close();

//Phòng
$query = "SELECT COUNT(*) FROM `rooms` ";
$stmt = $mysqli->prepare($query);
$stmt->execute();
$stmt->bind_result($rooms);
$stmt->fetch();
$stmt->close();

//Phòng đã có khách
$query = "SELECT COUNT(*) FROM `rooms` WHERE status ='Đã có khách' ";
$stmt = $mysqli->prepare($query);
$stmt->execute();
$stmt->bind_result($rooms_occupied);
$stmt->fetch();
$stmt->close();

//Phòng trống
$query = "SELECT COUNT(*) FROM `rooms` WHERE status !='Đã có khách' ";
$stmt = $mysqli->prepare($query);
$stmt->execute();
$stmt->bind_result($rooms_vacant);
$stmt->fetch();
$stmt->close();

//Doanh thu nhà hàng
$query = "SELECT SUM(amt) FROM `payments` WHERE service_paid ='Doanh thu nhà hàng' ";
$stmt = $mysqli->prepare($query);
$stmt->execute();
$stmt->bind_result($Resturant_Service);
$stmt->fetch();
$stmt->close();

//Doanh thu lưu trú
$query = "SELECT SUM(amt) FROM `payments` WHERE service_paid !='Doanh thu nhà hàng' ";
$stmt = $mysqli->prepare($query);
$stmt->execute();
$stmt->bind_result($accomodation);
$stmt->fetch();
$stmt->close();


//Tổng doanh thu
$total_revenue = $Resturant_Service + $accomodation;

/* Lương nhân viên */
$query = "SELECT SUM(salary) FROM `payrolls` ";
$stmt = $mysqli->prepare($query);
$stmt->execute();
$stmt->bind_result($salary);
$stmt->fetch();
$stmt->close();

