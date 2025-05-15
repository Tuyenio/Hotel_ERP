<?php
session_start();
require_once('../config/config.php');
require_once('../config/codeGen.php');
require_once('../config/checklogin.php');
sudo(); /* Kiểm tra đăng nhập quản trị viên */

if (isset($_POST['Add_Staff'])) {
    /* Xử lý lỗi */
    $error = 0;
    if (isset($_POST['id']) && !empty($_POST['id'])) {
        $id = mysqli_real_escape_string($mysqli, trim($_POST['id']));
    } else {
        $error = 1;
        $err = "Mã nhân viên không được để trống";
    }

    if (isset($_POST['name']) && !empty($_POST['name'])) {
        $name = mysqli_real_escape_string($mysqli, trim($_POST['name']));
    } else {
        $error = 1;
        $err = "Tên nhân viên không được để trống";
    }

    if (isset($_POST['number']) && !empty($_POST['number'])) {
        $number = mysqli_real_escape_string($mysqli, trim($_POST['number']));
    } else {
        $error = 1;
        $err = "Số hiệu nhân viên không được để trống";
    }

    if (isset($_POST['phone']) && !empty($_POST['phone'])) {
        $phone = mysqli_real_escape_string($mysqli, trim($_POST['phone']));
    } else {
        $error = 1;
        $err = "Số điện thoại không được để trống";
    }

    if (isset($_POST['email']) && !empty($_POST['email'])) {
        $email = mysqli_real_escape_string($mysqli, trim($_POST['email']));
    } else {
        $error = 1;
        $err = "Email không được để trống";
    }

    if (isset($_POST['adr']) && !empty($_POST['adr'])) {
        $adr = mysqli_real_escape_string($mysqli, trim($_POST['adr']));
    } else {
        $error = 1;
        $err = "Địa chỉ không được để trống";
    }

    if (isset($_POST['password']) && !empty($_POST['password'])) {
        $password = mysqli_real_escape_string($mysqli, trim(sha1(md5($_POST['password']))));
    } else {
        $error = 1;
        $err = "Mật khẩu không được để trống";
    }

    if (!$error) {
        //Ngăn chặn nhập trùng
        $sql = "SELECT * FROM  staffs WHERE number = '$number'  ";
        $res = mysqli_query($mysqli, $sql);
        if (mysqli_num_rows($res) > 0) {
            $row = mysqli_fetch_assoc($res);
            if ($number == $row['number']) {
                $err =  "Nhân viên với số hiệu này đã tồn tại";
            } else {
                //
            }
        } else {

            $query = "INSERT INTO staffs (id, name, number, phone, email, adr, password) VALUES (?,?,?,?,?,?,?)";
            $stmt = $mysqli->prepare($query);
            $rc = $stmt->bind_param('sssssss', $id, $name, $number, $phone, $email, $adr, $password);
            $stmt->execute();
            if ($stmt) {
                $success = "Đã thêm" && header("refresh:1; url=staffs.php");
            } else {
                $info = "Vui lòng thử lại sau";
            }
        }
    }
}

if (isset($_POST['Update_Staff'])) {
    /* Xử lý lỗi và cập nhật nhân viên */
    $error = 0;
    if (isset($_POST['id']) && !empty($_POST['id'])) {
        $id = mysqli_real_escape_string($mysqli, trim($_POST['id']));
    } else {
        $error = 1;
        $err = "Mã nhân viên không được để trống";
    }

    if (isset($_POST['name']) && !empty($_POST['name'])) {
        $name = mysqli_real_escape_string($mysqli, trim($_POST['name']));
    } else {
        $error = 1;
        $err = "Tên nhân viên không được để trống";
    }

    if (isset($_POST['number']) && !empty($_POST['number'])) {
        $number = mysqli_real_escape_string($mysqli, trim($_POST['number']));
    } else {
        $error = 1;
        $err = "Số hiệu nhân viên không được để trống";
    }

    if (isset($_POST['phone']) && !empty($_POST['phone'])) {
        $phone = mysqli_real_escape_string($mysqli, trim($_POST['phone']));
    } else {
        $error = 1;
        $err = "Số điện thoại không được để trống";
    }

    if (isset($_POST['email']) && !empty($_POST['email'])) {
        $email = mysqli_real_escape_string($mysqli, trim($_POST['email']));
    } else {
        $error = 1;
        $err = "Email không được để trống";
    }

    if (isset($_POST['adr']) && !empty($_POST['adr'])) {
        $adr = mysqli_real_escape_string($mysqli, trim($_POST['adr']));
    } else {
        $error = 1;
        $err = "Địa chỉ không được để trống";
    }

    if (isset($_POST['password']) && !empty($_POST['password'])) {
        $password = mysqli_real_escape_string($mysqli, trim(sha1(md5($_POST['password']))));
    } else {
        $error = 1;
        $err = "Mật khẩu không được để trống";
    }

    if (!$error) {

        $query = "UPDATE staffs SET name =?, number =?, phone =?, email =?, adr =?, password =? WHERE id =?";
        $stmt = $mysqli->prepare($query);
        $rc = $stmt->bind_param('sssssss', $name, $number, $phone, $email, $adr, $password, $id);
        $stmt->execute();
        if ($stmt) {
            $success = "Đã cập nhật" && header("refresh:1; url=staffs.php");
        } else {
            $info = "Vui lòng thử lại sau";
        }
    }
}

if (isset($_GET['Delete_Staff'])) {
    $id = $_GET['Delete_Staff'];
    $adn = "DELETE FROM staffs WHERE id =?";
    $stmt = $mysqli->prepare($adn);
    $stmt->bind_param('s', $id);
    $stmt->execute();
    $stmt->close();
    if ($stmt) {
        $success = "Đã xóa" && header("refresh:1; url=staffs.php");
    } else {
        $info = "Vui lòng thử lại sau";
    }
}

/* Nhập khẩu danh sách nhân viên từ Excel */

use keaHotelERP\DataSource;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

require_once '../config/DataSource.php';
$db = new DataSource();
$conn = $db->getConnection();
require_once '../vendor/autoload.php';

if (isset($_POST['upload'])) {
    $allowedFileType = [
        'application/vnd.ms-excel',
        'text/xls',
        'text/xlsx',
        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
    ];

    if (in_array($_FILES['file']['type'], $allowedFileType)) {
        $targetPath =
            '../public/uploads/sys_data/xls/' . $_FILES['file']['name'];
        move_uploaded_file($_FILES['file']['tmp_name'], $targetPath);

        $Reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();

        $spreadSheet = $Reader->load($targetPath);
        $excelSheet = $spreadSheet->getActiveSheet();
        $spreadSheetAry = $excelSheet->toArray();
        $sheetCount = count($spreadSheetAry);

        for ($i = 1; $i <= $sheetCount; $i++) {
            $id = '';
            if (isset($spreadSheetAry[$i][0])) {
                $id = mysqli_real_escape_string($conn, $spreadSheetAry[$i][0]);
            }

            $name  = '';
            if (isset($spreadSheetAry[$i][1])) {
                $name  = mysqli_real_escape_string(
                    $conn,
                    $spreadSheetAry[$i][1]
                );
            }

            $number  = '';
            if (isset($spreadSheetAry[$i][2])) {
                $number  = mysqli_real_escape_string(
                    $conn,
                    $spreadSheetAry[$i][2]
                );
            }

            $phone  = '';
            if (isset($spreadSheetAry[$i][3])) {
                $phone  = mysqli_real_escape_string($conn, $spreadSheetAry[$i][3]);
            }

            $email = '';
            if (isset($spreadSheetAry[$i][4])) {
                $email = mysqli_real_escape_string(
                    $conn,
                    $spreadSheetAry[$i][4]
                );
            }

            $adr = '';
            if (isset($spreadSheetAry[$i][5])) {
                $adr = mysqli_real_escape_string(
                    $conn,
                    $spreadSheetAry[$i][5]
                );
            }

            /* Mã hóa mật khẩu */
            $password = '';
            if (isset($spreadSheetAry[$i][6])) {
                $password = sha1(md5(mysqli_real_escape_string(
                    $conn,
                    $spreadSheetAry[$i][6]
                )));
            }


            if (
                !empty($id) ||
                !empty($number) ||
                !empty($phone) ||
                !empty($email) ||
                !empty($password)
            ) {
                $query = 'INSERT INTO staffs (id, name, number, phone, email, adr, password) VALUES (?,?,?,?,?,?,?)';
                $paramType = 'sssssss';
                $paramArray = [$id, $name, $number, $phone, $email, $adr, $password];
                $insertId = $db->insert($query, $paramType, $paramArray);
                if (!empty($insertId)) {
                    $err = 'Có lỗi xảy ra khi nhập dữ liệu';
                } else {
                    $success = 'Nhập dữ liệu nhân viên thành công';
                }
            }
        }
    } else {
        $info = 'Định dạng file không hợp lệ. Vui lòng tải lên file Excel.';
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
        <?php require_once("../partials/admin_sidebar.php"); ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Nhân viên</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
                                <li class="breadcrumb-item"><a href="dashboard.php">Bảng điều khiển</a></li>
                                <li class="breadcrumb-item"><a href="">Quản lý nhân sự</a></li>
                                <li class="breadcrumb-item active">Nhân viên</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </section>

            <section class="content">
                <div class="container-fluid">
                    <form class="form-inline">
                    </form>
                    <div class="text-right">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#import_modal">Nhập danh sách nhân viên</button>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#add_modal">Thêm nhân viên</button>
                    </div>
                    <!-- Add  Modal -->
                    <div class="modal fade" id="add_modal">
                        <div class="modal-dialog  modal-xl">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Điền đầy đủ thông tin</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Đóng">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form method="POST" enctype="multipart/form-data">
                                        <div class="form-row mb-4">
                                            <div style="display:none" class="form-group col-md-6">
                                                <label for="inputEmail4">Mã nhân viên</label>
                                                <input type="text" name="id" value="<?php echo $ID; ?>" class="form-control">
                                            </div>
                                        </div>

                                        <div class="form-row mb-4">
                                            <div class="form-group col-md-6">
                                                <label for="inputEmail4">Số hiệu nhân viên</label>
                                                <input type="text" name="number" value="<?php echo $a; ?>-<?php echo $b; ?>" class="form-control">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="inputEmail4">Họ và tên</label>
                                                <input required type="text" name="name" class="form-control">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="inputEmail4">Số điện thoại</label>
                                                <input required type="text" name="phone" class="form-control">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="inputEmail4">Email</label>
                                                <input required type="text" name="email" class="form-control">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="inputEmail4">Địa chỉ</label>
                                                <input required type="text" name="adr" class="form-control">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="inputEmail4">Mật khẩu</label>
                                                <input required type="text" name="password" class="form-control">
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <button type="submit" name="Add_Staff" class="btn btn-warning mt-3">Lưu</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer justify-content-between">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End  Modal -->

                    <!-- Import Modal -->
                    <div class="modal fade" id="import_modal">
                        <div class="modal-dialog  modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="text-center">
                                        Định dạng file cho phép: XLS, XLSX.
                                        <a class="text-primary" target="_blank" href="../public/templates/Staff.xlsx">Tải về</a> file mẫu.
                                    </h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Đóng">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form method="post" enctype="multipart/form-data" role="form">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="form-group col-md-12">
                                                    <label for="exampleInputFile">Chọn file</label>
                                                    <div class="input-group">
                                                        <div class="custom-file">
                                                            <input required name="file" accept=".xls,.xlsx" type="file" class="custom-file-input" id="exampleInputFile">
                                                            <label class="custom-file-label" for="exampleInputFile">Chọn file</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <button type="submit" name="upload" class="btn btn-primary">Tải lên</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer justify-content-between">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Import -->
                    <hr>
                    <div class="col-12">
                        <table id="dt-1" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Số hiệu</th>
                                    <th>Họ và tên</th>
                                    <th>Email</th>
                                    <th>Số điện thoại</th>
                                    <th>Địa chỉ</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                $ret = "SELECT * FROM `staffs`  ORDER BY `staffs`.`name` ASC ";
                                $stmt = $mysqli->prepare($ret);
                                $stmt->execute(); //ok
                                $res = $stmt->get_result();
                                while ($staff = $res->fetch_object()) {
                                ?>
                                    <tr>
                                        <td><?php echo $staff->number; ?></td>
                                        <td><?php echo $staff->name; ?></td>
                                        <td><?php echo $staff->email; ?></td>
                                        <td><?php echo $staff->phone; ?></td>
                                        <td><?php echo $staff->adr; ?></td>
                                        <td>

                                            <a class="badge badge-primary" data-toggle="modal" href="#update_<?php echo $staff->id; ?>">Cập nhật</a>
                                            <!-- Update Modal -->
                                            <div class="modal fade" id="update_<?php echo $staff->id; ?>">
                                                <div class="modal-dialog modal-xl">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Cập nhật thông tin <?php echo $staff->name; ?></h4>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Đóng">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form method="POST" enctype="multipart/form-data">
                                                                <div class="form-row mb-4">
                                                                    <div style="display:none" class="form-group col-md-6">
                                                                        <label for="inputEmail4">Mã nhân viên</label>
                                                                        <input type="text" name="id" value="<?php echo $staff->id; ?>" class="form-control">
                                                                    </div>
                                                                </div>
                                                                <div class="form-row mb-4">
                                                                    <div class="form-group col-md-6">
                                                                        <label for="inputEmail4">Số hiệu nhân viên</label>
                                                                        <input type="text" name="number" value="<?php echo $staff->number; ?>" class="form-control">
                                                                    </div>
                                                                    <div class="form-group col-md-6">
                                                                        <label for="inputEmail4">Họ và tên</label>
                                                                        <input required type="text" value="<?php echo $staff->name; ?>" name="name" class="form-control">
                                                                    </div>
                                                                    <div class="form-group col-md-6">
                                                                        <label for="inputEmail4">Số điện thoại</label>
                                                                        <input required type="text" value="<?php echo $staff->phone; ?>" name="phone" class="form-control">
                                                                    </div>
                                                                    <div class="form-group col-md-6">
                                                                        <label for="inputEmail4">Email</label>
                                                                        <input required type="text" value="<?php echo $staff->email; ?>" name="email" class="form-control">
                                                                    </div>

                                                                    <div class="form-group col-md-6">
                                                                        <label for="inputEmail4">Địa chỉ</label>
                                                                        <input required type="text" value="<?php echo $staff->adr; ?>" name="adr" class="form-control">
                                                                    </div>
                                                                    <div class="form-group col-md-6">
                                                                        <label for="inputEmail4">Mật khẩu</label>
                                                                        <input required type="text" name="password" class="form-control">
                                                                    </div>
                                                                </div>
                                                                <div class="text-right">
                                                                    <button type="submit" name="Update_Staff" class="btn btn-warning mt-3">Lưu</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                        <div class="modal-footer justify-content-between">
                                                            <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <a class="badge badge-danger" data-toggle="modal" href="#delete_<?php echo $staff->id; ?>">Xóa</a>
                                            <!-- Delete Modal -->
                                            <div class="modal fade" id="delete_<?php echo $staff->id; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">XÁC NHẬN</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Đóng">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body text-center text-danger">
                                                            <h4>Bạn có chắc muốn xóa <?php echo $staff->name; ?> - <?php echo $staff->number; ?>?</h4>
                                                            <br>
                                                            <button type="button" class="text-center btn btn-success" data-dismiss="modal">Không</button>
                                                            <a href="staffs.php?Delete_Staff=<?php echo $staff->id; ?>" class="text-center btn btn-danger"> Xóa </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </td>
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