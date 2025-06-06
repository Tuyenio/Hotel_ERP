<?php
require_once('config/config.php');
/* Persiste System Settigs On Landing Pages */
$ret = "SELECT * FROM `system_settings` ";
$stmt = $mysqli->prepare($ret);
$stmt->execute(); //ok
$res = $stmt->get_result();
while ($sys = $res->fetch_object()) {
    if ($sys_logo = '') {
        $logo_dir = 'public/uploads/sys_logo/logo.png';
    } else {
        $logo_dir = "public/uploads/sys_logo/$sys->sys_logo";
    }
    require_once('partials/cms_head.php');
?>

    <body>
        <div class="super_container">
            <?php require_once("partials/cms_nav.php"); ?>
            <div class="home">
                <div class="parallax_background parallax-window" data-parallax="scroll" data-image-src="public/cms_assets/images/home.jpg" data-speed="0.8"></div>
                <div class="home_container d-flex flex-column align-items-center justify-content-center">
                    <div class="home_title">
                        <h1><?php echo $sys->sys_name; ?></h1>
                    </div>
                    <div class="home_text text-center">
                        <?php echo $sys->sys_tagline; ?>
                    </div>
                    <div class="button home_button"><a href="#">Xem phòng ngay</a></div>
                </div>
            </div>

            <div class="intro">
                <div class="container">
                    <div class="row">
                        <div class="col">
                            <div class="section_title text-center">
                                <div>Chào mừng</div>
                                <h1><?php echo $sys->welcome_heading; ?></h1>
                            </div>
                        </div>
                    </div>
                    <div class="row intro_row">
                        <div class="col-xl-8 col-lg-10 offset-xl-2 offset-lg-1">
                            <div class="intro_text text-center">
                                <p>
                                    <?php echo $sys->welcome_content; ?>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="row gallery_row">
                        <div class="col">

                            <div class="gallery_slider_container">
                                <div class="owl-carousel owl-theme gallery_slider">

                                    <div class="gallery_slide">
                                        <img src="public/cms_assets/images/gallery_1.jpg" alt="">
                                        <div class="gallery_overlay">
                                            <div class="text-center d-flex flex-column align-items-center justify-content-center">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="gallery_slide">
                                        <img src="public/cms_assets/images/gallery_2.jpg" alt="">
                                        <div class="public/cms_assets/gallery_overlay">
                                            <div class="text-center d-flex flex-column align-items-center justify-content-center">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="gallery_slide">
                                        <img src="public/cms_assets/images/gallery_3.jpg" alt="">
                                        <div class="gallery_overlay">
                                            <div class="text-center d-flex flex-column align-items-center justify-content-center">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="gallery_slide">
                                        <img src="public/cms_assets/images/gallery_4.jpg" alt="">
                                        <div class="gallery_overlay">
                                            <div class="text-center d-flex flex-column align-items-center justify-content-center">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <footer class="footer">
                <div class="parallax_background parallax-window" data-parallax="scroll" data-image-src="public/cms_assets/images/footer.jpg" data-speed="0.8"></div>
                <div class="container">
                    <div class="row">
                        <div class="col">
                            <div class="footer_logo text-center">
                                <a href="#"><img src="images/logo.png" alt=""></a>
                            </div>
                            <div class="footer_content">
                                <div class="row">
                                    <div class="col-lg-4 footer_col">
                                        <div class="footer_info d-flex flex-column align-items-lg-end align-items-center justify-content-start">
                                            <div class="text-center">
                                                <div>Điện thoại:</div>
                                                <div><?php echo $sys->contacts_phone; ?></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 footer_col">
                                        <div class="footer_info d-flex flex-column align-items-center justify-content-start">
                                            <div class="text-center">
                                                <div>Địa chỉ:</div>
                                                <div><?php echo $sys->contacts_addres; ?></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 footer_col">
                                        <div class="footer_info d-flex flex-column align-items-lg-start align-items-center justify-content-start">
                                            <div class="text-center">
                                                <div>Email:</div>
                                                <div><?php echo $sys->contacts_email; ?></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php require_once("partials/cms_footer.php"); ?>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
        <?php require_once("partials/cms_scripts.php"); ?>
    </body>

    </html>
<?php
} ?>