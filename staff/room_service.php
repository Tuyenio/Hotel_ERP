<?php
session_start();
require_once('../config/config.php');
require_once('../config/codeGen.php');
require_once('../config/checklogin.php');
staff(); /* Kiểm tra đăng nhập nhân viên */

if (isset($_POST['Add_Roomservice'])) {
    /* Xử lý lỗi */
    $error = 0;
    if (isset($_POST['id']) && !empty($_POST['id'])) {
        $id = mysqli_real_escape_string($mysqli, trim($_POST['id']));
    } else {
        $error = 1;
        $err = "Mã dịch vụ phòng không được để trống";
    }

    if (isset($_POST['room_id']) && !empty($_POST['room_id'])) {
        $room_id = mysqli_real_escape_string($mysqli, trim($_POST['room_id']));
    } else {
        $error = 1;
        $err = "Mã phòng không được để trống";
    }

    if (isset($_POST['staff_id']) && !empty($_POST['staff_id'])) {
        $staff_id = mysqli_real_escape_string($mysqli, trim($_POST['staff_id']));
    } else {
        $error = 1;
        $err = "Mã nhân viên không được để trống";
    }

    if (isset($_POST['staff_name']) && !empty($_POST['staff_name'])) {
        $staff_name = mysqli_real_escape_string($mysqli, trim($_POST['staff_name']));
    } else {
        $error = 1;
        $err = "Tên nhân viên không được để trống";
    }

    if (isset($_POST['staff_number']) && !empty($_POST['staff_number'])) {
        $staff_number = mysqli_real_escape_string($mysqli, trim($_POST['staff_number']));
    } else {
        $error = 1;
        $err = "Số hiệu nhân viên không được để trống";
    }

    if (isset($_POST['room_number']) && !empty($_POST['room_number'])) {
        $room_number = mysqli_real_escape_string($mysqli, trim($_POST['room_number']));
    } else {
        $error = 1;
        $err = "Số phòng không được để trống";
    }

    if (!$error) {

        $query = "INSERT INTO room_service (id, room_id, staff_id, room_number, staff_number, staff_name) VALUES (?,?,?,?,?,?)";
        $stmt = $mysqli->prepare($query);
        $rc = $stmt->bind_param('ssssss', $id, $room_id, $staff_id, $room_number, $staff_number, $staff_name);
        $stmt->execute();
        if ($stmt) {
            $success = "Đã thêm" && header("refresh:1; url=room_service.php");
        } else {
            $info = "Vui lòng thử lại sau";
        }
    }
}

require_once("../partials/head.php");
?>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
    <div class="wrapper">
        <!-- Navbar -->
        <?php require_once("../partials/admin_nav.php"); ?>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <?php require_once("../partials/staff_sidebar.php"); ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Dịch Vụ Phòng Được Phân Công</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
                                <li class="breadcrumb-item"><a href="dashboard.php">Bảng điều khiển</a></li>
                                <li class="breadcrumb-item active">Dịch vụ phòng</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </section>

            <section class="content">
                <div class="container-fluid">

                    <hr>
                    <div class="col-12">
                        <table id="dt-1" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Mã nhân viên</th>
                                    <th>Tên nhân viên</th>
                                    <th>Phòng được giao</th>
                                    <th>Ngày giao</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                $staff_number = $_SESSION['number'];
                                $ret = "SELECT * FROM `room_service` WHERE staff_number = '$staff_number'  ";
                                $stmt = $mysqli->prepare($ret);
                                $stmt->execute(); //ok
                                $res = $stmt->get_result();
                                while ($service = $res->fetch_object()) {
                                ?>
                                    <tr>
                                        <td><?php echo $service->staff_number; ?></td>
                                        <td><?php echo $service->staff_name; ?></td>
                                        <td><?php echo $service->room_number; ?></td>
                                        <td><?php echo date('d/m/Y g:ia', strtotime($service->created_at)); ?></td>
                                    </tr>
                                <?php
                                } ?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
        </div>
        <?php require_once("../partials/footer.php"); ?>
    </div>
    <?php require_once("../partials/scripts.php"); ?>
</body>

</html>