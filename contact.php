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
    <title>Welcome Fashion - Contact Page</title>
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
    <?php include('pages/header.php'); ?>
    <div class="page-heading about-page-heading" id="top">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="inner-content">
                        <h2>Contact Us</h2>
                        <span>Awesome, clean &amp; creative HTML5 Template</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="contact-us">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div id="map">
                      <iframe src="<?php echo htmlspecialchars($storeMapLink); ?>" width="100%" height="400px" frameborder="0" style="border:0" allowfullscreen></iframe>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="section-heading">
                        <h2>Say Hello. Don't Be Shy!</h2>
                        <span>Details to details is what Welcome Fashion different from the other themes.</span>
                    </div>
                    <form id="contact" action="" method="post">
                        <div class="row">
                          <div class="col-lg-6">
                            <fieldset>
                              <input name="name" type="text" id="name" placeholder="Your name" required="">
                            </fieldset>
                          </div>
                          <div class="col-lg-6">
                            <fieldset>
                              <input name="email" type="text" id="email" placeholder="Your email" required="">
                            </fieldset>
                          </div>
                          <div class="col-lg-12">
                            <fieldset>
                              <textarea name="message" rows="6" id="message" placeholder="Your message" required=""></textarea>
                            </fieldset>
                          </div>
                          <div class="col-lg-12">
                            <fieldset>
                              <button type="submit" id="form-submit" class="main-dark-button"><i class="fa fa-paper-plane"></i></button>
                          </div>
                        </div>
                      </form>
                </div>
            </div>
        </div>
    </div>
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
    </div>
    <?php include('pages/footer.php'); ?>
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
</body>
</html>
<?php
if (isset($conn) && $conn instanceof mysqli) {
    $conn->close();
}
?>
