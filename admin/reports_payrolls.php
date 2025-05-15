<?php
session_start();
require_once('../config/config.php');
require_once('../config/codeGen.php');
require_once('../config/checklogin.php');
sudo(); /* Kiểm tra đăng nhập Quản trị viên */
require_once("../partials/head.php");
?>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
    <div class="wrapper">
        <!-- Thanh điều hướng -->
        <?php require_once("../partials/admin_nav.php"); ?>
        <!-- /.navbar -->

        <!-- Thanh bên chính -->
        <?php require_once("../partials/admin_sidebar.php"); ?>

        <!-- Nội dung trang -->
        <div class="content-wrapper">
            <!-- Tiêu đề nội dung -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Báo cáo bảng lương nhân viên</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
                                <li class="breadcrumb-item"><a href="dashboard.php">Bảng điều khiển</a></li>
                                <li class="breadcrumb-item"><a href="">Báo cáo</a></li>
                                <li class="breadcrumb-item active">Bảng lương</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </section>

            <section class="content">
                <div class="container-fluid">
                    <hr>
                    <div class="col-12">
                        <table id="reports" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Mã</th>
                                    <th>Tháng</th>
                                    <th>Số tiền</th>
                                    <th>Tên nhân viên</th>
                                    <th>Ngày tạo</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                $ret = "SELECT * FROM `payrolls` ";
                                $stmt = $mysqli->prepare($ret);
                                $stmt->execute(); //ok
                                $res = $stmt->get_result();
                                while ($payrolls = $res->fetch_object()) {
                                ?>
                                    <tr>
                                        <td>
                                            <?php echo $payrolls->code; ?>
                                        </td>
                                        <td><?php echo $payrolls->month; ?></td>
                                        <td>Ksh <?php echo $payrolls->salary; ?></td>
                                        <td><?php echo $payrolls->staff_name; ?></td>
                                        <td><?php echo date('d M Y g:ia', strtotime($payrolls->created_at)); ?></td>
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