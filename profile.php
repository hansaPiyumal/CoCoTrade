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
        :root {
            --primary-color: #27ae60;
            --secondary-color: #2ecc71;
            --dark-color: #2c3e50;
            --light-color: #ecf0f1;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
            color: #333;
        }
        
        .profile-header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            border-radius: 15px;
            padding: 2rem;
            margin-top: 30px;
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
            position: relative;
            overflow: hidden;
        }
        
        .profile-header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 100%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0) 70%);
            transform: rotate(30deg);
        }
        
        .profile-pic {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid white;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
            transition: all 0.3s ease;
        }
        
        .profile-pic:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 25px rgba(0,0,0,0.3);
        }
        
        .profile-stats {
            background: white;
            border-radius: 10px;
            padding: 1.5rem;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            margin-top: -50px;
            position: relative;
            z-index: 1;
        }
        
        .stat-item {
            text-align: center;
            padding: 0.5rem;
        }
        
        .stat-value {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary-color);
        }
        
        .stat-label {
            font-size: 0.9rem;
            color: #7f8c8d;
        }
        
        .order-card {
            border: none;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            margin-bottom: 20px;
            transition: all 0.3s ease;
        }
        
        .order-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }
        
        .order-header {
            background-color: white;
            padding: 1.2rem 1.5rem;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #eee;
        }
        
        .order-title {
            font-weight: 600;
            color: var(--dark-color);
        }
        
        .order-date {
            color: #7f8c8d;
            font-size: 0.9rem;
        }
        
        .order-actions {
            display: flex;
            gap: 10px;
        }
        
        .btn-track, .btn-chat {
            padding: 0.5rem 1rem;
            border-radius: 50px;
            font-weight: 500;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 5px;
        }
        
        .btn-track {
            background-color: #e3f2fd;
            color: #1976d2;
            border: 1px solid #bbdefb;
        }
        
        .btn-track:hover {
            background-color: #bbdefb;
            color: #0d47a1;
        }
        
        .btn-chat {
            background-color: #e8f5e9;
            color: #388e3c;
            border: 1px solid #c8e6c9;
        }
        
        .btn-chat:hover {
            background-color: #c8e6c9;
            color: #1b5e20;
        }
        
        .order-content {
            padding: 1.5rem;
            background-color: #fafafa;
            display: none;
        }
        
        .order-item.active .order-content {
            display: block;
            animation: fadeIn 0.3s ease;
        }
        
        .order-detail {
            display: flex;
            margin-bottom: 0.8rem;
        }
        
        .order-detail-label {
            font-weight: 600;
            width: 150px;
            color: #7f8c8d;
        }
        
        .order-detail-value {
            flex: 1;
        }
        
        .status-badge {
            padding: 0.3rem 0.8rem;
            border-radius: 50px;
            font-size: 0.8rem;
            font-weight: 500;
        }
        
        .status-shipped {
            background-color: #fff8e1;
            color: #ff8f00;
        }
        
        .status-delivered {
            background-color: #e8f5e9;
            color: #388e3c;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .section-title {
            position: relative;
            padding-bottom: 10px;
            margin-bottom: 2rem;
            color: var(--dark-color);
        }
        
        .section-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 50px;
            height: 3px;
            background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
            border-radius: 3px;
        }
        
        @media (max-width: 768px) {
            .profile-header {
                text-align: center;
                padding: 1.5rem;
            }
            
            .profile-stats {
                margin-top: -30px;
            }
            
            .order-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }
            
            .order-actions {
                width: 100%;
                justify-content: flex-end;
            }
        }
    </style>
</head>
<body>
    <!-- Header will be included here -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white py-4 fixed-top shadow-sm">
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
        <!-- Profile Header -->
        <div class="profile-header">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h2 class="mb-2">Hansa</h2>
                    <p class="mb-0"><i class="far fa-calendar-alt me-2"></i> Member since January 2023</p>
                </div>
                <div class="col-md-4 text-md-end">
                    <img src="images/Dummy-image.webp" alt="Profile Picture" class="profile-pic">
                </div>
            </div>
        </div>
        
        <!-- Profile Stats -->
        <div class="profile-stats row text-center mb-5">
            <div class="col-md-4 stat-item">
                <div class="stat-value">12</div>
                <div class="stat-label">Total Orders</div>
            </div>
            <div class="col-md-4 stat-item">
                <div class="stat-value">4</div>
                <div class="stat-label">Pending</div>
            </div>
            <div class="col-md-4 stat-item">
                <div class="stat-value">8</div>
                <div class="stat-label">Completed</div>
            </div>
        </div>
        
        <!-- Orders Section -->
        <h3 class="section-title">Your Orders</h3>
        
        <!-- Order 1 -->
        <div class="order-card">
            <div class="order-header" onclick="toggleOrder(this)">
                <div>
                    <div class="order-title">Order #12345</div>
                    <div class="order-date">Placed on June 10, 2023</div>
                </div>
                <div class="order-actions">
                    <button class="btn-track">
                        <i class="fas fa-truck"></i> Track
                    </button>
                    <button class="btn-chat">
                        <i class="fas fa-comments"></i> Chat
                    </button>
                    <i class="fas fa-chevron-down ms-2"></i>
                </div>
            </div>
            <div class="order-content">
                <div class="order-detail">
                    <div class="order-detail-label">Status:</div>
                    <div class="order-detail-value">
                        <span class="status-badge status-shipped">Shipped</span>
                    </div>
                </div>
                <div class="order-detail">
                    <div class="order-detail-label">Items:</div>
                    <div class="order-detail-value">2</div>
                </div>
                <div class="order-detail">
                    <div class="order-detail-label">Total:</div>
                    <div class="order-detail-value">Rs 5,999.00</div>
                </div>
                <div class="order-detail">
                    <div class="order-detail-label">Estimated Delivery:</div>
                    <div class="order-detail-value">June 20, 2023</div>
                </div>
            </div>
        </div>

        <!-- Order 2 -->
        <div class="order-card">
            <div class="order-header" onclick="toggleOrder(this)">
                <div>
                    <div class="order-title">Order #12344</div>
                    <div class="order-date">Placed on June 5, 2023</div>
                </div>
                <div class="order-actions">
                    <button class="btn-track">
                        <i class="fas fa-truck"></i> Track
                    </button>
                    <button class="btn-chat">
                        <i class="fas fa-comments"></i> Chat
                    </button>
                    <i class="fas fa-chevron-down ms-2"></i>
                </div>
            </div>
            <div class="order-content">
                <div class="order-detail">
                    <div class="order-detail-label">Status:</div>
                    <div class="order-detail-value">
                        <span class="status-badge status-delivered">Delivered</span>
                    </div>
                </div>
                <div class="order-detail">
                    <div class="order-detail-label">Items:</div>
                    <div class="order-detail-value">1</div>
                </div>
                <div class="order-detail">
                    <div class="order-detail-label">Total:</div>
                    <div class="order-detail-value">Rs 2,499.00</div>
                </div>
                <div class="order-detail">
                    <div class="order-detail-label">Delivered on:</div>
                    <div class="order-detail-value">June 12, 2023</div>
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
        
        // Make Track and Chat buttons functional
        document.querySelectorAll('.btn-track').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.stopPropagation();
                window.location.href = 'vehicle-tracking.html';
            });
        });
        
        document.querySelectorAll('.btn-chat').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.stopPropagation();
                window.location.href = 'chat.php';
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>