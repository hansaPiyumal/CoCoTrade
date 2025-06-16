<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile - Cocotrade</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="css/main.css">
    <style>
        .profile-card {
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            margin-top: 30px;
            padding: 20px;
        }
        .profile-pic {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #fff;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .order-item {
            border: 1px solid #dee2e6;
            border-radius: 8px;
            margin-bottom: 15px;
            overflow: hidden;
        }
        .order-header {
            background-color: #f8f9fa;
            padding: 12px 20px;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .order-actions {
            display: flex;
            gap: 15px;
        }
        .order-content {
            padding: 15px 20px;
            border-top: 1px solid #dee2e6;
            display: none;
        }
        .order-item.active .order-content {
            display: block;
        }
    </style>
</head>
<body>
    <!-- Header will be included here -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white py-4 fixed-top">
        <div class="container">
            <a class="navbar-brand d-flex justify-content-between align-items-center order-lg-0" href="index.php">
                <img src="images/logo.jpg" alt="site icon">
                <span class="text-uppercase fw-lighter ms-2">Cocotrade</span>
            </a>

            <div class="order-lg-2 d-flex align-items-center">
                <div class="nav-btns d-flex align-items-center">
                    <a href="ShopingCart.php" class="btn position-relative me-2">
                        <i class="fa fa-shopping-cart"></i>
                        <span class="position-absolute top-0 start-100 translate-middle badge bg-primary">5</span>
                    </a>
                    <div class="input-group me-2" style="max-width: 200px;">
                        <input type="search" class="form-control form-control-sm" placeholder="Search...">
                        <button class="btn btn-outline-secondary" type="button">
                            <i class="fa fa-search"></i>
                        </button>
                    </div>
                    <a href="profile.php" class="btn active">
                        <i class="fa fa-user"></i>
                    </a>
                </div>
            </div>

            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse order-lg-1" id="navMenu">
                <ul class="navbar-nav mx-auto text-center">
                    <li class="nav-item px-2 py-2">
                        <a class="nav-link text-uppercase text-dark" href="index.php#header">home</a>
                    </li>
                    <li class="nav-item px-2 py-2">
                        <a class="nav-link text-uppercase text-dark" href="index.php#retailsale">Retail Sale</a>
                    </li>
                    <li class="nav-item px-2 py-2">
                        <a class="nav-link text-uppercase text-dark" href="index.php#wholesale">wholesale</a>
                    </li>
                    <li class="nav-item px-2 py-2">
                        <a class="nav-link text-uppercase text-dark" href="index.php#about">about us</a>
                    </li>
                    <li class="nav-item px-2 py-2 border-0">
                        <a class="btn text-uppercase text-dark" href="signup.php">Signup</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div style="height: 104px;"></div> <!-- Spacer for fixed navbar -->
    <div class="container py-5">
        <!-- Profile Card -->
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="profile-card bg-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="mb-1">John Doe</h3>
                            <p class="text-muted mb-0">Member since January 2023</p>
                        </div>
                        <div>
                            <img src="https://via.placeholder.com/100" alt="Profile Picture" class="profile-pic">
                        </div>
                    </div>
                </div>

                <!-- Orders Section -->
                <h4 class="mt-5 mb-4">Your Orders</h4>
                
                <!-- Order 1 -->
                <div class="order-item">
                    <div class="order-header" onclick="toggleOrder(this)">
                        <span>Order #12345 - Placed on June 10, 2023</span>
                        <div class="order-actions">
                            <a href="#" class="text-primary">Track</a>
                            <a href="#" class="text-primary">Contact</a>
                            <i class="fas fa-chevron-down"></i>
                        </div>
                    </div>
                    <div class="order-content">
                        <p><strong>Status:</strong> Shipped</p>
                        <p><strong>Items:</strong> 2</p>
                        <p><strong>Total:</strong> $99.99</p>
                        <p><strong>Estimated Delivery:</strong> June 20, 2023</p>
                    </div>
                </div>

                <!-- Order 2 -->
                <div class="order-item">
                    <div class="order-header" onclick="toggleOrder(this)">
                        <span>Order #12344 - Placed on June 5, 2023</span>
                        <div class="order-actions">
                            <a href="#" class="text-primary">Track</a>
                            <a href="#" class="text-primary">Contact</a>
                            <i class="fas fa-chevron-down"></i>
                        </div>
                    </div>
                    <div class="order-content">
                        <p><strong>Status:</strong> Delivered</p>
                        <p><strong>Items:</strong> 1</p>
                        <p><strong>Total:</strong> $49.99</p>
                        <p><strong>Delivered on:</strong> June 12, 2023</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleOrder(header) {
            const orderItem = header.parentElement;
            const content = header.nextElementSibling;
            const icon = header.querySelector('.fa-chevron-down');
            
            // Toggle active class
            orderItem.classList.toggle('active');
            
            // Toggle icon
            if (orderItem.classList.contains('active')) {
                icon.classList.remove('fa-chevron-down');
                icon.classList.add('fa-chevron-up');
            } else {
                icon.classList.remove('fa-chevron-up');
                icon.classList.add('fa-chevron-down');
            }
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
