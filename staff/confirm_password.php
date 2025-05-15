<?php
session_start();
include('../config/config.php');

if (isset($_POST['change_pass'])) {
    /* Xác nhận mật khẩu */
    $error = 0;
    if (isset($_POST['new_password']) && !empty($_POST['new_password'])) {
        $new_password = mysqli_real_escape_string($mysqli, trim(sha1(md5($_POST['new_password']))));
    } else {
        $error = 1;
        $err = "Mật khẩu mới không được để trống";
    }
    if (isset($_POST['confirm_password']) && !empty($_POST['confirm_password'])) {
        $confirm_password = mysqli_real_escape_string($mysqli, trim(sha1(md5($_POST['confirm_password']))));
    } else {
        $error = 1;
        $err = "Xác nhận mật khẩu không được để trống";
    }

    if (!$error) {
        $email = $_SESSION['email'];
        $sql = "SELECT * FROM  staffs  WHERE email = '$email'";
        $res = mysqli_query($mysqli, $sql);
        if (mysqli_num_rows($res) > 0) {
            $row = mysqli_fetch_assoc($res);
            if ($new_password != $confirm_password) {
                $err = "Mật khẩu không khớp";
            } else {
                $email = $_SESSION['email'];
                $query = "UPDATE staffs SET  password =? WHERE email =?";
                $stmt = $mysqli->prepare($query);
                $rc = $stmt->bind_param('ss', $new_password, $email);
                $stmt->execute();
                if ($stmt) {
                    $success = "Đổi mật khẩu thành công" && header("refresh:1; url=index.php");
                } else {
                    $err = "Vui lòng thử lại sau";
                }
            }
        }
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
        $stmt->execute(); //ok
        $res = $stmt->get_result();
        while ($sys = $res->fetch_object()) {
            /* Kiểm tra logo, nếu không có thì dùng mặc định */
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
                <?php
                $email  = $_SESSION['email'];
                $ret = "SELECT * FROM  admin  WHERE email = '$email'";
                $stmt = $mysqli->prepare($ret);
                $stmt->execute(); //ok
                $res = $stmt->get_result();
                while ($row = $res->fetch_object()) {
                ?>
                    <p class="login-box-msg">
                        <?php echo $row->username; ?>, bạn chỉ còn một bước nữa để đặt lại mật khẩu mới. Hãy khôi phục mật khẩu ngay bây giờ.
                        <span class="badge badge-success"><?php echo $row->password; ?></span>
                    </p>
                <?php } ?>
                <form method="post">
                    <div class="input-group mb-3">
                        <input type="password" class="form-control" name="new_password" placeholder="Mật khẩu mới">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" class="form-control" name="confirm_password" placeholder="Xác nhận mật khẩu">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" name="change_pass" class="btn btn-primary btn-block">Đổi mật khẩu</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- /.login-box -->
        <?php require_once('../partials/scripts.php'); ?>
    </div>
</body>


</html>