<?php
session_start();
include('../config/config.php');
//xử lý đăng nhập
if (isset($_POST['login'])) {

    $email = $_POST['email'];
    $password = sha1(md5($_POST['password'])); //mã hóa hai lớp để tăng bảo mật
    $stmt = $mysqli->prepare("SELECT email, password, id, number  FROM staffs  WHERE (email =? AND password =?)");
    $stmt->bind_param('ss', $email, $password); //gán tham số
    $stmt->execute(); //thực thi
    $stmt->bind_result($email, $password, $id, $staff_number); //gán kết quả
    $rs = $stmt->fetch();
    $_SESSION['id'] = $id;
    $_SESSION['number'] = $staff_number;
    if ($rs) {
        //nếu thành công
        header("location:dashboard.php");
    } else {
        $err = "Truy cập bị từ chối. Vui lòng kiểm tra lại thông tin đăng nhập.";
    }
}

require_once('../partials/head.php');
?>

<body class="hold-transition login-page">
    <div class="login-box">
        <?php
        /* Lấy thông tin cấu hình hệ thống */
        $ret = "SELECT * FROM `system_settings` ";
        $stmt = $mysqli->prepare($ret);
        $stmt->execute();
        $res = $stmt->get_result();
        while ($sys = $res->fetch_object()) {
            /* Kiểm tra logo, nếu thiếu thì dùng mặc định */
            if ($sys_logo = '') {
                $logo_dir = '../public/uploads/sys_logo/logo.png';
            } else {
                $logo_dir = "../public/uploads/sys_logo/$sys->sys_logo";
            }
        ?>
            <div class="login-logo">
                <!-- Điều chỉnh kích thước logo tại đây -->
                <img class="img-fluid" height="100" width="150" src="<?php echo $logo_dir; ?>" alt="">
            </div>
        <?php
        } ?>
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Đăng nhập nhân viên</p>
                <form method="post">
                    <div class="input-group mb-3">
                        <input type="email" required class="form-control" name="email" placeholder="Email">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>

                    <div class="input-group mb-3">
                        <input type="password" required class="form-control" name="password" placeholder="Mật khẩu">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <a href="../admin/" class="btn btn-primary btn-block">Đăng nhập Quản trị viên</a>
                        </div>
                        <div class="col-4">
                            <button type="submit" name="login" class="btn btn-primary btn-block">Nhân viên</button>
                        </div>
                    </div>
                </form>

                <p class="mb-1">
                    <a href="../">Trang chủ</a>
                </p>
                <p class="mb-1">
                    <a href="reset_password.php">Quên mật khẩu?</a>
                </p>
            </div>
        </div>
    </div>
    <!-- /.login-box -->
    <?php require_once('../partials/scripts.php'); ?>

</body>


</html>