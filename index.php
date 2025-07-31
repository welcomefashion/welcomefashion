<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900&display=swap" rel="stylesheet">

    <title>Welcome Fashion Ecommerce HTML CSS Template</title>

    <!-- Additional CSS Files -->
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/font-awesome.css">
    <link rel="stylesheet" href="assets/css/templatemo-hexashop.css">
    <link rel="stylesheet" href="assets/css/owl-carousel.css">
    <link rel="stylesheet" href="assets/css/lightbox.css">

    <?php
    // Include database connection from the admin panel folder
    // CORRECTED PATH: Since wfadmin is inside welcomefashion
    require_once 'wfadmin/includes/db_connection.php';

    // Function to fetch products by category name
    function getProductsByCategory($conn, $categoryName, $limit = 4) {
        $products = [];
        // Prepare statement to prevent SQL injection
        $stmt = $conn->prepare("SELECT p.id, p.name, p.price, p.main_image FROM products p JOIN categories c ON p.category_id = c.id WHERE c.name = ? ORDER BY p.created_at DESC LIMIT ?");
        if ($stmt) {
            $stmt->bind_param("si", $categoryName, $limit);
            $stmt->execute();
            $result = $stmt->get_result();
            while ($row = $result->fetch_assoc()) {
                $products[] = $row;
            }
            $stmt->close();
        } else {
            error_log("Error preparing statement for category: " . $conn->error);
        }
        return $products;
    }

    // Function to fetch a single category ID by name
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

    // Function to fetch a single setting value
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
        return $value;
    }

    // Fetch website settings
    $logoPath = getSetting($conn, 'logo_path', 'assets/images/logo.png'); // Default logo
    $socialFacebook = getSetting($conn, 'social_facebook', '#');
    $socialInstagram = getSetting($conn, 'social_instagram', '#');
    $socialTwitter = getSetting($conn, 'social_twitter', '#');
    $socialLinkedin = getSetting($conn, 'social_linkedin', '#');
    $storeAddress = getSetting($conn, 'store_address', 'Sunny Isles Beach, FL 33160, United States');
    $storePhone = getSetting($conn, 'store_phone', '010-020-0340');
    $storeEmail = getSetting($conn, 'store_email', 'info@company.com');
    $storeMapLink = getSetting($conn, 'store_map_link', '#');


    // Fetch products for each section
    $menProducts = getProductsByCategory($conn, 'Men');
    $womenProducts = getProductsByCategory($conn, 'Women');
    $kidsProducts = getProductsByCategory($conn, 'Kids');
    $accessoriesProducts = getProductsByCategory($conn, 'Accessories'); // Fetch products for Accessories

    // Fetch category IDs for linking in the header
    $menCategoryId = getCategoryIdByName($conn, 'Men');
    $womenCategoryId = getCategoryIdByName($conn, 'Women');
    $kidsCategoryId = getCategoryIdByName($conn, 'Kids');
    $accessoriesCategoryId = getCategoryIdByName($conn, 'Accessories');

    ?>

  </head>
    
  <body>
    
    <!-- ***** Preloader Start ***** -->
    <div id="preloader">
        <div class="jumper">
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>  
    <!-- ***** Preloader End ***** -->
    
    
    <!-- ***** Header Area Start ***** -->
    <header class="header-area header-sticky">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <nav class="main-nav">
                        <!-- ***** Logo Start ***** -->
                        <a href="index.php" class="logo">
                            <img src="<?php echo htmlspecialchars($logoPath); ?>" alt="Welcome Fashion Logo" onerror="this.onerror=null;this.src='assets/images/logo.png';">
                        </a>
                        <!-- ***** Logo End ***** -->
                        <!-- ***** Menu Start ***** -->
                        <ul class="nav">
                            <li class="scroll-to-section"><a href="#top" class="active">Home</a></li>
                            <li class="submenu">
                                <a href="javascript:;">Categories</a>
                                <ul>
                                    <li><a href="products.php?category_id=<?php echo htmlspecialchars($menCategoryId); ?>">Men's</a></li>
                                    <li><a href="products.php?category_id=<?php echo htmlspecialchars($womenCategoryId); ?>">Women's</a></li>
                                    <li><a href="products.php?category_id=<?php echo htmlspecialchars($kidsCategoryId); ?>">Kid's</a></li>
                                    <li><a href="products.php?category_id=<?php echo htmlspecialchars($accessoriesCategoryId); ?>">Accessories</a></li>
                                </ul>
                            </li>
                            <li class="submenu">
                                <a href="javascript:;">Pages</a>
                                <ul>
                                    <li><a href="about.php">About Us</a></li>
                                    <li><a href="products.php">Products</a></li>
                                    <li><a href="single-product.php">Single Product</a></li>
                                    <li><a href="contact.php">Contact Us</a></li>
                                </ul>
                            </li>
                        </ul>        
                        <a class='menu-trigger'>
                            <span>Menu</span>
                        </a>
                        <!-- Added Cart, Login/Signup, Wishlist Icons -->
                        <ul class="header-icons">
                            <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                            <li><a href="#"><i class="fa fa-user"></i></a></li>
                            <li><a href="#"><i class="fa fa-heart"></i></a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </header>
    <!-- ***** Header Area End ***** -->

    <!-- ***** Main Banner Area Start ***** -->
    <div class="main-banner" id="top">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-6">
                    <div class="left-content">
                        <div class="thumb">
                            <div class="inner-content">
                                <h4>We Are Welcome Fashion</h4>
                                <span>Awesome, clean &amp; creative HTML5 Template</span>
                                <div class="main-border-button">
                                    <a href="#">Purchase Now!</a>
                                </div>
                            </div>
                            <img src="assets/images/left-banner-image.jpg" alt="">
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="right-content">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="right-first-image">
                                    <div class="thumb">
                                        <div class="inner-content">
                                            <h4>Women</h4>
                                            <span>Best Clothes For Women</span>
                                        </div>
                                        <div class="hover-content">
                                            <div class="inner">
                                                <h4>Women</h4>
                                                <p>Lorem ipsum dolor sit amet, conservisii ctetur adipiscing elit incid.</p>
                                                <div class="main-border-button">
                                                    <a href="products.php?category_id=<?php echo htmlspecialchars($womenCategoryId); ?>">Discover More</a>
                                                </div>
                                            </div>
                                        </div>
                                        <img src="assets/images/baner-right-image-01.jpg">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="right-first-image">
                                    <div class="thumb">
                                        <div class="inner-content">
                                            <h4>Men</h4>
                                            <span>Best Clothes For Men</span>
                                        </div>
                                        <div class="hover-content">
                                            <div class="inner">
                                                <h4>Men</h4>
                                                <p>Lorem ipsum dolor sit amet, conservisii ctetur adipiscing elit incid.</p>
                                                <div class="main-border-button">
                                                    <a href="products.php?category_id=<?php echo htmlspecialchars($menCategoryId); ?>">Discover More</a>
                                                </div>
                                            </div>
                                        </div>
                                        <img src="assets/images/baner-right-image-02.jpg">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="right-first-image">
                                    <div class="thumb">
                                        <div class="inner-content">
                                            <h4>Kids</h4>
                                            <span>Best Clothes For Kids</span>
                                        </div>
                                        <div class="hover-content">
                                            <div class="inner">
                                                <h4>Kids</h4>
                                                <p>Lorem ipsum dolor sit amet, conservisii ctetur adipiscing elit incid.</p>
                                                <div class="main-border-button">
                                                    <a href="products.php?category_id=<?php echo htmlspecialchars($kidsCategoryId); ?>">Discover More</a>
                                                </div>
                                            </div>
                                        </div>
                                        <img src="assets/images/baner-right-image-03.jpg">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="right-first-image">
                                    <div class="thumb">
                                        <div class="inner-content">
                                            <h4>Accessories</h4>
                                            <span>Best Trend Accessories</span>
                                        </div>
                                        <div class="hover-content">
                                            <div class="inner">
                                                <h4>Accessories</h4>
                                                <p>Lorem ipsum dolor sit amet, conservisii ctetur adipiscing elit incid.</p>
                                                <div class="main-border-button">
                                                    <a href="products.php?category_id=<?php echo htmlspecialchars($accessoriesCategoryId); ?>">Discover More</a>
                                                </div>
                                            </div>
                                        </div>
                                        <img src="assets/images/baner-right-image-04.jpg">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ***** Main Banner Area End ***** -->

    <!-- ***** Men Area Starts ***** -->
    <section class="section" id="men">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="section-heading">
                        <h2>Men's Latest</h2>
                        <span>Details to details is what makes Welcome Fashion different from the other themes.</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="men-item-carousel">
                        <div class="owl-men-item owl-carousel">
                            <?php if (!empty($menProducts)): ?>
                                <?php foreach ($menProducts as $product): ?>
                                    <div class="item">
                                        <div class="thumb">
                                            <div class="hover-content">
                                                <ul>
                                                    <li><a href="single-product.php?id=<?php echo htmlspecialchars($product['id']); ?>"><i class="fa fa-eye"></i></a></li>
                                                    <li><a href="single-product.php?id=<?php echo htmlspecialchars($product['id']); ?>"><i class="fa fa-star"></i></a></li>
                                                    <li><a href="single-product.php?id=<?php echo htmlspecialchars($product['id']); ?>"><i class="fa fa-shopping-cart"></i></a></li>
                                                </ul>
                                            </div>
                                            <img src="<?php echo htmlspecialchars($product['main_image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" onerror="this.onerror=null;this.src='https://placehold.co/400x300/E0E0E0/808080?text=No+Image';">
                                        </div>
                                        <div class="down-content">
                                            <h4><?php echo htmlspecialchars($product['name']); ?></h4>
                                            <span>INR <?php echo number_format($product['price'], 2); ?></span>
                                            <ul class="stars">
                                                <li><i class="fa fa-star"></i></li>
                                                <li><i class="fa fa-star"></i></li>
                                                <li><i class="fa fa-star"></i></li>
                                                <li><i class="fa fa-star"></i></li>
                                                <li><i class="fa fa-star"></i></li>
                                            </ul>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <div class="item">
                                    <div class="down-content">
                                        <h4>No Men's Products Found</h4>
                                        <span>Please add products in the admin panel.</span>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ***** Men Area Ends ***** -->

    <!-- ***** Women Area Starts ***** -->
    <section class="section" id="women">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="section-heading">
                        <h2>Women's Latest</h2>
                        <span>Details to details is what makes Welcome Fashion different from the other themes.</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="women-item-carousel">
                        <div class="owl-women-item owl-carousel">
                            <?php if (!empty($womenProducts)): ?>
                                <?php foreach ($womenProducts as $product): ?>
                                    <div class="item">
                                        <div class="thumb">
                                            <div class="hover-content">
                                                <ul>
                                                    <li><a href="single-product.php?id=<?php echo htmlspecialchars($product['id']); ?>"><i class="fa fa-eye"></i></a></li>
                                                    <li><a href="single-product.php?id=<?php echo htmlspecialchars($product['id']); ?>"><i class="fa fa-star"></i></a></li>
                                                    <li><a href="single-product.php?id=<?php echo htmlspecialchars($product['id']); ?>"><i class="fa fa-shopping-cart"></i></a></li>
                                                </ul>
                                            </div>
                                            <img src="<?php echo htmlspecialchars($product['main_image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" onerror="this.onerror=null;this.src='https://placehold.co/400x300/E0E0E0/808080?text=No+Image';">
                                        </div>
                                        <div class="down-content">
                                            <h4><?php echo htmlspecialchars($product['name']); ?></h4>
                                            <span>INR <?php echo number_format($product['price'], 2); ?></span>
                                            <ul class="stars">
                                                <li><i class="fa fa-star"></i></li>
                                                <li><i class="fa fa-star"></i></li>
                                                <li><i class="fa fa-star"></i></li>
                                                <li><i class="fa fa-star"></i></li>
                                                <li><i class="fa fa-star"></i></li>
                                            </ul>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <div class="item">
                                    <div class="down-content">
                                        <h4>No Women's Products Found</h4>
                                        <span>Please add products in the admin panel.</span>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ***** Women Area Ends ***** -->

    <!-- ***** Kids Area Starts ***** -->
    <section class="section" id="kids">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="section-heading">
                        <h2>Kid's Latest</h2>
                        <span>Details to details is what makes Welcome Fashion different from the other themes.</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="kid-item-carousel">
                        <div class="owl-kid-item owl-carousel">
                            <?php if (!empty($kidsProducts)): ?>
                                <?php foreach ($kidsProducts as $product): ?>
                                    <div class="item">
                                        <div class="thumb">
                                            <div class="hover-content">
                                                <ul>
                                                    <li><a href="single-product.php?id=<?php echo htmlspecialchars($product['id']); ?>"><i class="fa fa-eye"></i></a></li>
                                                    <li><a href="single-product.php?id=<?php echo htmlspecialchars($product['id']); ?>"><i class="fa fa-star"></i></a></li>
                                                    <li><a href="single-product.php?id=<?php echo htmlspecialchars($product['id']); ?>"><i class="fa fa-shopping-cart"></i></a></li>
                                                </ul>
                                            </div>
                                            <img src="<?php echo htmlspecialchars($product['main_image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" onerror="this.onerror=null;this.src='https://placehold.co/400x300/E0E0E0/808080?text=No+Image';">
                                        </div>
                                        <div class="down-content">
                                            <h4><?php echo htmlspecialchars($product['name']); ?></h4>
                                            <span>INR <?php echo number_format($product['price'], 2); ?></span>
                                            <ul class="stars">
                                                <li><i class="fa fa-star"></i></li>
                                                <li><i class="fa fa-star"></i></li>
                                                <li><i class="fa fa-star"></i></li>
                                                <li><i class="fa fa-star"></i></li>
                                                <li><i class="fa fa-star"></i></li>
                                            </ul>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <div class="item">
                                    <div class="down-content">
                                        <h4>No Kid's Products Found</h4>
                                        <span>Please add products in the admin panel.</span>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ***** Kids Area Ends ***** -->

    <!-- ***** Accessories Area Starts ***** -->
    <section class="section" id="accessories">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="section-heading">
                        <h2>Latest Accessories</h2>
                        <span>Discover our newest collection of fashion accessories.</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="acc-item-carousel">
                        <div class="owl-acc-item owl-carousel">
                            <?php if (!empty($accessoriesProducts)): ?>
                                <?php foreach ($accessoriesProducts as $product): ?>
                                    <div class="item">
                                        <div class="thumb">
                                            <div class="hover-content">
                                                <ul>
                                                    <li><a href="single-product.php?id=<?php echo htmlspecialchars($product['id']); ?>"><i class="fa fa-eye"></i></a></li>
                                                    <li><a href="single-product.php?id=<?php echo htmlspecialchars($product['id']); ?>"><i class="fa fa-star"></i></a></li>
                                                    <li><a href="single-product.php?id=<?php echo htmlspecialchars($product['id']); ?>"><i class="fa fa-shopping-cart"></i></a></li>
                                                </ul>
                                            </div>
                                            <img src="<?php echo htmlspecialchars($product['main_image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" onerror="this.onerror=null;this.src='https://placehold.co/400x300/E0E0E0/808080?text=No+Image';">
                                        </div>
                                        <div class="down-content">
                                            <h4><?php echo htmlspecialchars($product['name']); ?></h4>
                                            <span>INR <?php echo number_format($product['price'], 2); ?></span>
                                            <ul class="stars">
                                                <li><i class="fa fa-star"></i></li>
                                                <li><i class="fa fa-star"></i></li>
                                                <li><i class="fa fa-star"></i></li>
                                                <li><i class="fa fa-star"></i></li>
                                                <li><i class="fa fa-star"></i></li>
                                            </ul>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <div class="item">
                                    <div class="down-content">
                                        <h4>No Accessories Found</h4>
                                        <span>Please add products to the 'Accessories' category in the admin panel.</span>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ***** Accessories Area Ends ***** -->


    <!-- ***** Subscribe Area Starts ***** -->
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
                                        <a href="<?php echo htmlspecialchars($socialFacebook); ?>" target="_blank">Facebook</a>,
                                        <a href="<?php echo htmlspecialchars($socialInstagram); ?>" target="_blank">Instagram</a>,
                                        <a href="<?php echo htmlspecialchars($socialTwitter); ?>" target="_blank">Twitter</a>,
                                        <a href="<?php echo htmlspecialchars($socialLinkedin); ?>" target="_blank">Linkedin</a>
                                    </span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ***** Subscribe Area Ends ***** -->
    
    <!-- ***** Footer Start ***** -->
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
                        <li><a href="#top">Homepage</a></li>
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
    

    <!-- jQuery -->
    <script src="assets/js/jquery-2.1.0.min.js"></script>

    <!-- Bootstrap -->
    <script src="assets/js/popper.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>

    <!-- Plugins -->
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
    
    <!-- Global Init -->
    <script src="assets/js/custom.js"></script>

    <script>

        $(function() {
            var selectedClass = "";
            $("p").click(function(){
            selectedClass = $(this).attr("data-rel");
            $("#portfolio").fadeTo(50, 0.1);
                $("#portfolio div").not("."+selectedClass).fadeOut();
            setTimeout(function() {
              $("."+selectedClass).fadeIn();
              $("#portfolio").fadeTo(50, 1);
            }, 500);
                
            });
        });

    </script>

  </body>
</html>
<?php
// Close the database connection at the very end of the script
if (isset($conn) && $conn instanceof mysqli) {
    $conn->close();
}
?>
