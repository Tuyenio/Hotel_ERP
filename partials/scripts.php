<!-- jQuery -->
<script src="../public/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../public/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- Ứng dụng -->
<script src="../public/js/back_office.min.js"></script>
<!-- Bảng điều khiển -->
<script src="../public/js/pages/dashboard2.js"></script>
<!-- overlayScrollbars -->
<script src="../public/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- DataTables -->
<script src="../public/plugins/datatables/jquery.dataTables.js"></script>
<script src="../public/plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
<!-- Khởi tạo Data Tables -->
<script>
    $(function() {
        $("#dt-1").DataTable();
        $('#dt-2').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false,
        });
    });
</script>
<!-- Báo cáo Data Tables -->
<script src="../public/plugins/table/datatable/datatables.js"></script>
<!-- LƯU Ý: Để sử dụng các tuỳ chọn Sao chép, CSV, Excel, PDF, In, bạn phải bao gồm các tệp này -->
<script src="../public/plugins/table/datatable/button-ext/dataTables.buttons.min.js"></script>
<script src="../public/plugins/table/datatable/button-ext/jszip.min.js"></script>
<script src="../public/plugins/table/datatable/button-ext/buttons.html5.min.js"></script>
<script src="../public/plugins/table/datatable/button-ext/buttons.print.min.js"></script>
<script>
    $('#reports').DataTable({
        dom: '<"row"<"col-md-12"<"row"<"col-md-6"B><"col-md-6"f> > ><"col-md-12"rt> <"col-md-12"<"row"<"col-md-5"i><"col-md-7"p>>> >',
        buttons: {
            buttons: [{
                    extend: 'copy',
                    className: 'btn',
                    text: 'Sao chép'
                },
                {
                    extend: 'csv',
                    className: 'btn',
                    text: 'Xuất CSV'
                },
                {
                    extend: 'excel',
                    className: 'btn',
                    text: 'Xuất Excel'
                },
                {
                    extend: 'print',
                    className: 'btn',
                    text: 'In'
                }

            ]
        },
        "oLanguage": {
            "oPaginate": {
                "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>',
                "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>'
            },
            "sInfo": "Hiển thị trang _PAGE_ trên tổng số _PAGES_",
            "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
            "sSearchPlaceholder": "Tìm kiếm...",
            "sLengthMenu": "Kết quả: _MENU_",
            "sZeroRecords": "Không tìm thấy dữ liệu phù hợp",
            "sInfoEmpty": "Không có dữ liệu để hiển thị",
            "sInfoFiltered": "(lọc từ tổng số _MAX_ bản ghi)",
            "sLoadingRecords": "Đang tải...",
            "sProcessing": "Đang xử lý...",
            "sEmptyTable": "Không có dữ liệu trong bảng"
        },
        "stripeClasses": [],
        "lengthMenu": [7, 10, 20, 50],
        "pageLength": 7
    });
</script>
<!-- Tuỳ chỉnh tải tệp -->
<script src="../public/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<script>
    $(document).ready(function() {
        bsCustomFileInput.init();
    });
</script>
<!-- Chọn -->
<script src="../public/plugins/select2/js/select2.full.min.js"></script>
<script>
    var ss = $(".basic").select2({
        tags: true,
        language: {
            noResults: function() {
                return "Không tìm thấy kết quả";
            },
            searching: function() {
                return "Đang tìm kiếm...";
            }
        }
    });
</script>
<script>
    /* Lấy thông tin phòng (bất đồng bộ) */
    function layThongTinPhong(val) {
        $.ajax({
            type: "POST",
            url: "../partials/ajax.php",
            data: 'RNumber=' + val,
            success: function(data) {
                $('#RID').val(data);
            }
        });

        $.ajax({
            type: "POST",
            url: "../partials/ajax.php",
            data: 'RID=' + val,
            success: function(data) {
                $('#RCost').val(data);
            }
        });

        $.ajax({
            type: "POST",
            url: "../partials/ajax.php",
            data: 'RCost=' + val,
            success: function(data) {
                $('#RType').val(data);
            }
        });
    }

    /* Lấy thông tin nhân viên */
    function layThongTinNhanVien(val) {
        $.ajax({
            type: "POST",
            url: "../partials/ajax.php",
            data: 'StaffNumber=' + val,
            success: function(data) {
                $('#StaffID').val(data);
            }
        });

        $.ajax({
            type: "POST",
            url: "../partials/ajax.php",
            data: 'StaffID=' + val,
            success: function(data) {
                $('#StaffName').val(data);
            }
        });
    }
</script>
<!-- In nội dung trong một thẻ div -->
<script>
    function inNoiDung(el) {
        var restorepage = $('body').html();
        var printcontent = $('#' + el).clone();
        $('body').empty().html(printcontent);
        window.print();
        $('body').html(restorepage);
    }
</script>