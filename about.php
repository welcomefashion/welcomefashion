<?php
session_start();
require_once 'wfadmin/includes/db_connection.php';

function getCategoryIdByName($conn, $categoryName) {
    $categoryId = null;
    $stmt = $conn->prepare("SELECT id FROM categories WHERE name = ? LIMIT 1");
    if ($stmt) {
        $stmt->bind_param("s", $categoryName);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            $categoryId = $row['id'];
        }
        $stmt->close();
    } else {
        error_log("Error preparing statement for category ID: " . $conn->error);
    }
    return $categoryId;
}

function getSetting($conn, $key, $default = '') {
    $value = $default;
    $stmt = $conn->prepare("SELECT setting_value FROM settings WHERE setting_key = ? LIMIT 1");
    if ($stmt) {
        $stmt->bind_param("s", $key);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            $value = $row['setting_value'];
        }
        $stmt->close();
    } else {
        error_log("Error preparing statement for setting: " . $conn->error);
    }
    if ($key === 'logo_path' && $value && strpos($value, 'wfadmin/') !== 0) {
        if (strpos($value, 'uploads/logos/') === 0) {
            $value = 'wfadmin/' . $value;
        }
    }
    return $value;
}

$logoPath = getSetting($conn, 'logo_path', 'assets/images/logo.png');
$socialFacebook = getSetting($conn, 'social_facebook', '#');
$socialInstagram = getSetting($conn, 'social_instagram', '#');
$socialTwitter = getSetting($conn, 'social_twitter', '#');
$socialLinkedin = getSetting($conn, 'social_linkedin', '#');
$storeAddress = getSetting($conn, 'store_address', 'Sunny Isles Beach, FL 33160, United States');
$storePhone = getSetting($conn, 'store_phone', '010-020-0340');
$storeEmail = getSetting($conn, 'store_email', 'info@company.com');
$storeMapLink = getSetting($conn, 'store_map_link', '#');

$menCategoryId = getCategoryIdByName($conn, 'Men');
$womenCategoryId = getCategoryIdByName($conn, 'Women');
$kidsCategoryId = getCategoryIdByName($conn, 'Kids');
$accessoriesCategoryId = getCategoryIdByName($conn, 'Accessories');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900&display=swap" rel="stylesheet">
    <title>Welcome Fashion - About Page</title>
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/font-awesome.css">
    <link rel="stylesheet" href="assets/css/templatemo-hexashop.css">
    <link rel="stylesheet" href="assets/css/owl-carousel.css">
    <link rel="stylesheet" href="assets/css/lightbox.css">
    <link rel="stylesheet" href="assets/css/custom-styles.css">
</head>
<body>
    <div id="preloader">
        <div class="jumper">
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>
    <?php include('header.php'); ?>
    <div class="page-heading about-page-heading" id="top">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="inner-content">
                        <h2>About Our Company</h2>
                        <span>Awesome, clean &amp; creative HTML5 Template</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="about-us">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="left-image">
                        <img src="assets/images/about-left-image.jpg" alt="">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="right-content">
                        <h4>About Us &amp; Our Skills</h4>
                        <span>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod kon tempor incididunt ut labore.</span>
                        <div class="quote">
                            <i class="fa fa-quote-left"></i><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiuski smod kon tempor incididunt ut labore.</p>
                        </div>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod kon tempor incididunt ut labore et dolore magna aliqua ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip.</p>
                        <ul>
                            <li><a href="<?php echo htmlspecialchars($socialFacebook); ?>" target="_blank"><i class="fa fa-facebook"></i></a></li>
                            <li><a href="<?php echo htmlspecialchars($socialTwitter); ?>" target="_blank"><i class="fa fa-twitter"></i></a></li>
                            <li><a href="<?php echo htmlspecialchars($socialLinkedin); ?>" target="_blank"><i class="fa fa-linkedin"></i></a></li>
                            <li><a href="<?php echo htmlspecialchars($socialInstagram); ?>" target="_blank"><i class="fa fa-instagram"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="our-team">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-heading">
                        <h2>Our Amazing Team</h2>
                        <span>Details to details is what makes Welcome Fashion different from the other themes.</span>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="team-item">
                        <div class="thumb">
                            <div class="hover-effect">
                                <div class="inner-content">
                                    <ul>
                                        <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                                        <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                                        <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                                        <li><a href="#"><i class="fa fa-behance"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                            <img src="assets/images/team-member-01.jpg">
                        </div>
                        <div class="down-content">
                            <h4>Ragnar Lodbrok</h4>
                            <span>Product Caretaker</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="team-item">
                        <div class="thumb">
                            <div class="hover-effect">
                                <div class="inner-content">
                                    <ul>
                                        <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                                        <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                                        <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                                        <li><a href="#"><i class="fa fa-behance"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                            <img src="assets/images/team-member-02.jpg">
                        </div>
                        <div class="down-content">
                            <h4>Ragnar Lodbrok</h4>
                            <span>Product Caretaker</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="team-item">
                        <div class="thumb">
                            <div class="hover-effect">
                                <div class="inner-content">
                                    <ul>
                                        <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                                        <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                                        <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                                        <li><a href="#"><i class="fa fa-behance"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                            <img src="assets/images/team-member-03.jpg">
                        </div>
                        <div class="down-content">
                            <h4>Ragnar Lodbrok</h4>
                            <span>Product Caretaker</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="our-services">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-heading">
                        <h2>Our Services</h2>
                        <span>Details to details is what makes Welcome Fashion different from the other themes.</span>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="service-item">
                        <h4>Synther Vaporware</h4>
                        <p>Lorem ipsum dolor sit amet, consecteturti adipiscing elit, sed do eiusmod temp incididunt ut labore, et dolore quis ipsum suspend.</p>
                        <img src="assets/images/service-01.jpg" alt="">
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="service-item">
                        <h4>Locavore Squidward</h4>
                        <p>Lorem ipsum dolor sit amet, consecteturti adipiscing elit, sed do eiusmod temp incididunt ut labore, et dolore quis ipsum suspend.</p>
                        <img src="assets/images/service-02.jpg" alt="">
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="service-item">
                        <h4>Health Gothfam</h4>
                        <p>Lorem ipsum dolor sit amet, consecteturti adipiscing elit, sed do eiusmod temp incididunt ut labore, et dolore quis ipsum suspend.</p>
                        <img src="assets/images/service-03.jpg" alt="">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="subscribe">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="section-heading">
                        <h2>By Subscribing To Our Newsletter You Can Get 30% Off</h2>
                        <span>Details to details is what makes Welcome Fashion different from the other themes.</span>
                    </div>
                    <form id="subscribe" action="" method="get">
                        <div class="row">
                          <div class="col-lg-5">
                            <fieldset>
                              <input name="name" type="text" id="name" placeholder="Your Name" required="">
                            </fieldset>
                          </div>
                          <div class="col-lg-5">
                            <fieldset>
                              <input name="email" type="text" id="email" pattern="[^ @]*@[^ @]*" placeholder="Your Email Address" required="">
                            </fieldset>
                          </div>
                          <div class="col-lg-2">
                            <fieldset>
                              <button type="submit" id="form-submit" class="main-dark-button"><i class="fa fa-paper-plane"></i></button>
                            </fieldset>
                          </div>
                        </div>
                    </form>
                </div>
                <div class="col-lg-4">
                    <div class="row">
                        <div class="col-6">
                            <ul>
                                <li>Store Location:<br><span><?php echo htmlspecialchars($storeAddress); ?></span></li>
                                <li>Phone:<br><span><?php echo htmlspecialchars($storePhone); ?></span></li>
                                <li>Office Location:<br><span><a href="<?php echo htmlspecialchars($storeMapLink); ?>" target="_blank">View on Map</a></span></li>
                            </ul>
                        </div>
                        <div class="col-6">
                            <ul>
                                <li>Work Hours:<br><span>07:30 AM - 9:30 PM Daily</span></li>
                                <li>Email:<br><span><?php echo htmlspecialchars($storeEmail); ?></span></li>
                                <li>Social Media:<br>
                                    <span>
                                        <a href="<?php echo htmlspecialchars($socialFacebook); ?>" target="_blank"><i class="fa fa-facebook"></i></a>,
                                        <a href="<?php echo htmlspecialchars($socialInstagram); ?>" target="_blank"><i class="fa fa-instagram"></i></a>,
                                        <a href="<?php echo htmlspecialchars($socialTwitter); ?>" target="_blank"><i class="fa fa-twitter"></i></a>,
                                        <a href="<?php echo htmlspecialchars($socialLinkedin); ?>" target="_blank"><i class="fa fa-linkedin"></i></a>
                                    </span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="first-item">
                        <div class="logo">
                            <img src="<?php echo htmlspecialchars($logoPath); ?>" alt="Welcome Fashion ecommerce templatemo" onerror="this.onerror=null;this.src='assets/images/white-logo.png';">
                        </div>
                        <ul>
                            <li><a href="<?php echo htmlspecialchars($storeMapLink); ?>" target="_blank"><?php echo htmlspecialchars($storeAddress); ?></a></li>
                            <li><a href="mailto:<?php echo htmlspecialchars($storeEmail); ?>"><?php echo htmlspecialchars($storeEmail); ?></a></li>
                            <li><a href="tel:<?php echo htmlspecialchars($storePhone); ?>"><?php echo htmlspecialchars($storePhone); ?></a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3">
                    <h4>Shopping &amp; Categories</h4>
                    <ul>
                        <li><a href="products.php?category_id=<?php echo htmlspecialchars($menCategoryId); ?>">Men’s Shopping</a></li>
                        <li><a href="products.php?category_id=<?php echo htmlspecialchars($womenCategoryId); ?>">Women’s Shopping</a></li>
                        <li><a href="products.php?category_id=<?php echo htmlspecialchars($kidsCategoryId); ?>">Kid's Shopping</a></li>
                        <li><a href="products.php?category_id=<?php echo htmlspecialchars($accessoriesCategoryId); ?>">Accessories Shopping</a></li>
                    </ul>
                </div>
                <div class="col-lg-3">
                    <h4>Useful Links</h4>
                    <ul>
                        <li><a href="index.php">Homepage</a></li>
                        <li><a href="about.php">About Us</a></li>
                        <li><a href="#">Help</a></li>
                        <li><a href="contact.php">Contact Us</a></li>
                    </ul>
                </div>
                <div class="col-lg-3">
                    <h4>Help &amp; Information</h4>
                    <ul>
                        <li><a href="#">Help</a></li>
                        <li><a href="#">FAQ's</a></li>
                        <li><a href="#">Shipping</a></li>
                        <li><a href="#">Tracking ID</a></li>
                    </ul>
                </div>
                <div class="col-lg-12">
                    <div class="under-footer">
                        <p>Copyright © 2022 Welcome Fashion Co., Ltd. All Rights Reserved.
                        
                        <br>Design: <a href="https://templatemo.com" target="_parent" title="free css templates">TemplateMo</a>

                        <br>Distributed By: <a href="https://themewagon.com" target="_blank" title="free & premium responsive templates">ThemeWagon</a></p>
                        <ul>
                            <li><a href="<?php echo htmlspecialchars($socialFacebook); ?>" target="_blank"><i class="fa fa-facebook"></i></a></li>
                            <li><a href="<?php echo htmlspecialchars($socialTwitter); ?>" target="_blank"><i class="fa fa-twitter"></i></a></li>
                            <li><a href="<?php echo htmlspecialchars($socialLinkedin); ?>" target="_blank"><i class="fa fa-linkedin"></i></a></li>
                            <li><a href="<?php echo htmlspecialchars($socialInstagram); ?>" target="_blank"><i class="fa fa-instagram"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    

    <script src="assets/js/jquery-2.1.0.min.js"></script>

    <script src="assets/js/popper.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>

    <script src="assets/js/owl-carousel.js"></script>
    <script src="assets/js/accordions.js"></script>
    <script src="assets/js/datepicker.js"></script>
    <script src="assets/js/scrollreveal.min.js"></script>
    <script src="assets/js/waypoints.min.js"></script>
    <script src="assets/js/jquery.counterup.min.js"></script>
    <script src="assets/js/imgfix.min.js"></script> 
    <script src="assets/js/slick.js"></script> 
    <script src="assets/js/lightbox.js"></script> 
    <script src="assets/js/isotope.js"></script> 
    
    <script src="assets/js/custom.js"></script>

    <script>
        // Removed the problematic jQuery selector block.
        // If you need specific portfolio filtering, it should be re-implemented
        // with a clear understanding of its selectors and data attributes.
    </script>

  </body>

</html>
