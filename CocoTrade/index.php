<?php
    require_once 'connection/connection.php';
?>
<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cocotrade</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link rel = "stylesheet" href = "css/main.css">
</head>
<body>
    

    <nav class = "navbar navbar-expand-lg navbar-light bg-white py-4 fixed-top">
        <div class = "container">
            <a class = "navbar-brand d-flex justify-content-between align-items-center order-lg-0" href = "index.html">
                <img src = "images/logo.jpg" alt = "site icon">
                <span class = "text-uppercase fw-lighter ms-2">Cocotrade</span>
            </a>

            <div class = "order-lg-2 nav-btns">
                <button type = "button" class = "btn position-relative">
                    <a href="ShopingCart.php"><i class = "fa fa-shopping-cart"></i></a>
                    <span class = "position-absolute top-0 start-100 translate-middle badge bg-primary">5</span>
                </button>
                <button type = "button" class = "btn position-relative" >
                    <input type="search" name="" id="">
                    <i class = "fa fa-search"></i>
                </button>
            </div>

            <button class = "navbar-toggler border-0" type = "button" data-bs-toggle = "collapse" data-bs-target = "#navMenu">
                <span class = "navbar-toggler-icon"></span>
            </button>

            <div class = "collapse navbar-collapse order-lg-1" id = "navMenu">
                <ul class = "navbar-nav mx-auto text-center">
                    <li class = "nav-item px-2 py-2">
                        <a class = "nav-link text-uppercase text-dark" href = "#header">home</a>
                    </li>
                    <li class = "nav-item px-2 py-2">
                        <a class = "nav-link text-uppercase text-dark" href = "#retailsale">Retail Sale</a>
                    </li>
                    <li class = "nav-item px-2 py-2">
                        <a class = "nav-link text-uppercase text-dark" href = "#wholesale">wholesale</a>
                    </li>
                    <li class = "nav-item px-2 py-2">
                        <a class = "nav-link text-uppercase text-dark" href = "#about">about us</a>
                    </li>
                    <li class = "nav-item px-2 py-2 border-0">
                        <a class = "btn text-uppercase text-dark" href = "signup.php">Signup</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>



    <header id = "header" class = "vh-100 carousel slide" data-bs-ride = "carousel" style = "padding-top: 104px;">
        <div class = "container h-100 d-flex align-items-center carousel-inner">
            <div class = "text-center carousel-item active">
                <h2 class = "text-capitalize text-white">COCOTRADE</h2>
                <h1 class = "text-uppercase py-2 fw-bold text-white">JOING WITH US</h1>
                <a href = "adpost.php" class = "btn mt-3 text-uppercase">Add Post</a>
            </div>
            <div class = "text-center carousel-item">
                <h2 class = "text-capitalize text-white">COCOTRADE</h2>
                <h1 class = "text-uppercase py-2 fw-bold text-white">BEST SELLES SPOT</h1>
                <a href = "adpost.php" class = "btn mt-3 text-uppercase">Add Post</a>
            </div>
        </div>

        <button class = "carousel-control-prev" type = "button" data-bs-target="#header" data-bs-slide = "prev">
            <span class = "carousel-control-prev-icon"></span>
        </button>
        <button class = "carousel-control-next" type = "button" data-bs-target="#header" data-bs-slide = "next">
            <span class = "carousel-control-next-icon"></span>
        </button>
    </header>

    <section id = "retailsale" class = "py-5">
        <div class = "container">
            <div class = "title text-center">
                <h2 class = "position-relative d-inline-block">Retail Sale</h2>
            </div>

            <div class = "row g-0">
                <div class = "collection-list mt-4 row gx-0 gy-3">
                    <?php
                        $sql = "select * from items where itemcategory='retail'";
                        $result = mysqli_query($connection,$sql);

                        while($row = mysqli_fetch_assoc($result)){
                            echo "<div class='col-md-6 col-lg-4 col-xl-3 p-2 best'>";
                            echo "<div class='collection-img position-relative'>";
                                echo "<img src='images/uploads/" . $row['imgname'] . "' class='w-100'>" ;
                                echo "<span class='position-absolute bg-primary text-white d-flex align-items-center justify-content-center'>sale</span>";
                            echo "</div>";
                            echo "<div class='text-center'>";
                            echo "<a style='text-decoration:none;' href='item.php?item={$row['itemid']}' class='text-capitalize my-1'>" . $row['itemname'] . "</a>";
                                echo "<br><span class='fw-bold'>Rs " . $row['itemprice'] . "</span>";
                            echo "</div></div>";
                        }
                    ?>
                  
    <section id = "wholesale" class = "py-5">
        <div class = "container">
            <div class = "title text-center py-5">
                <h2 class = "position-relative d-inline-block">Wholesale</h2>
            </div>

            <div class = "special-list row g-0">
            <?php
                        $sql = "select * from items where itemcategory='wholesale'";
                        $result = mysqli_query($connection,$sql);

                        while($row = mysqli_fetch_assoc($result)){
                            echo "<div class='col-md-6 col-lg-4 col-xl-3 p-2 best'>";
                            echo "<div class='collection-img position-relative'>";
                                echo "<img src='images/uploads/" . $row['imgname'] . "' class='w-100'>";
                                echo "<span class='position-absolute bg-primary text-white d-flex align-items-center justify-content-center'>sale</span>";
                            echo "</div>";
                            echo "<div class='text-center'>";
                                echo "<a style='text-decoration:none;' href='item.php?item={$row['itemid']}' class='text-capitalize my-1'>" . $row['itemname'] . "</a>";
                                echo "<br><span class='fw-bold'>Rs " . $row['itemprice'] . "</span>";
                            echo "</div></div>";
                        }
                    ?>
            </div>
        </div>
    </section>


    <section id = "about" class = "py-5">
        <div class = "container">
            <div class = "row gy-lg-5 align-items-center">
                <div class = "col-lg-6 order-lg-1 text-center text-lg-start">
                    <div class = "title pt-3 pb-5">
                        <h2 class = "position-relative d-inline-block ms-4">About Us</h2>
                    </div>
                    <p class = "lead text-muted">CocoTrade: Where Quality Meets Convenience</p>
                    <p>Welcome to CocoTrade, your ultimate destination for quality, convenience, and affordability. At CocoTrade, we are dedicated to delivering an exceptional shopping experience by offering a wide range of premium products to meet your everyday needs.

                        From fresh produce and groceries to household essentials, we prioritize quality and value, ensuring that every item you purchase exceeds your expectations. Our commitment to sustainability and community drives us to source responsibly and support local suppliers, creating a positive impact for our customers and the environment.
                        
                        At CocoTrade, we believe shopping should be simple, enjoyable, and rewarding. Whether you visit us in-store or online, we’re here to serve you with exceptional customer service and a seamless shopping experience.
                        
                        Thank you for choosing CocoTrade, where quality meets convenience!</p>
                </div>
                <div class = "col-lg-6 order-lg-0">
                    <img src = "images/ai-generated-coconut-cocktails-on-the-beach-summer-tropical-background-ai-generated-photo.jpg" alt = "" class = "img-fluid">
                </div>
            </div>
        </div>
    </section>

   
    <section id = "newsletter" class = "py-5">
        <div class = "container">
            <div class = "d-flex flex-column align-items-center justify-content-center">
                <div class = "title text-center pt-3 pb-5">
                    <h2 class = "position-relative d-inline-block ms-4">Newsletter Subscription</h2>
                </div>

                <p class = "text-center text-muted">Stay with us with new products</p>
                <div class = "input-group mb-3 mt-3">
                    <input type = "text" class = "form-control" placeholder="Enter Your Email ...">
                    <button class = "btn btn-primary" type = "submit">Subscribe</button>
                </div>
            </div>
        </div>
    </section>

    <footer class = "bg-dark py-5">
        <div class = "container">
            <div class = "row text-white g-4">
                <div class = "col-md-6 col-lg-3">
                    <a class = "text-uppercase text-decoration-none brand text-white" href = "index.html">COCOTRADE</a>
                    <p class = "text-white text-muted mt-3">Your go-to destination for fresh, quality, and affordable essentials!</p>
                </div>

                <div class = "col-md-6 col-lg-3">
                    <h5 class = "fw-light">Links</h5>
                    <ul class = "list-unstyled">
                        <li class = "my-3">
                            <a href = "#" class = "text-white text-decoration-none text-muted">
                                <i class = "fas fa-chevron-right me-1"></i> Home
                            </a>
                        </li>
                        <li class = "my-3">
                            <a href = "#" class = "text-white text-decoration-none text-muted">
                                <i class = "fas fa-chevron-right me-1"></i> Wholesale
                            </a>
                        </li>
                        <li class = "my-3">
                            <a href = "#" class = "text-white text-decoration-none text-muted">
                                <i class = "fas fa-chevron-right me-1"></i> Retail Sale
                            </a>
                        </li>
                        <li class = "my-3">
                            <a href = "#" class = "text-white text-decoration-none text-muted">
                                <i class = "fas fa-chevron-right me-1"></i> About Us
                            </a>
                        </li>
                    </ul>
                </div>

                <div class = "col-md-6 col-lg-3">
                    <h5 class = "fw-light mb-3">Contact Us</h5>
                    <div class = "d-flex justify-content-start align-items-start my-2 text-muted">
                        <span class = "me-3">
                            <i class = "fas fa-map-marked-alt"></i>
                        </span>
                        <span class = "fw-light">
                            University of vavuniya,salambikulam,popeimadu
                        </span>
                    </div>
                    <div class = "d-flex justify-content-start align-items-start my-2 text-muted">
                        <span class = "me-3">
                            <i class = "fas fa-envelope"></i>
                        </span>
                        <span class = "fw-light">
                            cocotrade.support@gmail.com
                        </span>
                    </div>
                    <div class = "d-flex justify-content-start align-items-start my-2 text-muted">
                        <span class = "me-3">
                            <i class = "fas fa-phone-alt"></i>
                        </span>
                        <span class = "fw-light">
                            +94 07112346
                        </span>
                    </div>
                </div>

                <div class = "col-md-6 col-lg-3">
                    <h5 class = "fw-light mb-3">Follow Us</h5>
                    <div>
                        <ul class = "list-unstyled d-flex">
                            <li>
                                <a href = "#" class = "text-white text-decoration-none text-muted fs-4 me-4">
                                    <i class = "fab fa-facebook-f"></i>
                                </a>
                            </li>
                            <li>
                                <a href = "#" class = "text-white text-decoration-none text-muted fs-4 me-4">
                                    <i class = "fab fa-twitter"></i>
                                </a>
                            </li>
                            <li>
                                <a href = "#" class = "text-white text-decoration-none text-muted fs-4 me-4">
                                    <i class = "fab fa-instagram"></i>
                                </a>
                            </li>
                            <li>
                                <a href = "#" class = "text-white text-decoration-none text-muted fs-4 me-4">
                                    <i class = "fab fa-pinterest"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <script src = "js/jquery-3.6.0.js"></script>

    <script src="https://unpkg.com/isotope-layout@3/dist/isotope.pkgd.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <script src = "js/script.js"></script>
</body>
</html>