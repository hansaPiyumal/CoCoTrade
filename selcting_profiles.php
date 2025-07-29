<?php
session_start();
require_once 'connection/connection.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Profile | CoCoTrade</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), 
                        url('images/coconut-farm.jpg') no-repeat center center fixed;
            background-size: cover;
            min-height: 100vh;
            color: #fff;
        }
        
        .profile-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 2rem;
            text-align: center;
        }
        
        .profile-header {
            margin-bottom: 3rem;
        }
        
        .profile-header h1 {
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }
        
        .profile-header p {
            font-size: 1.2rem;
            opacity: 0.9;
        }
        
        .profile-buttons {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 2rem;
        }
        
        .profile-btn {
            padding: 2rem 1rem;
            border-radius: 15px;
            border: none;
            font-size: 1.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: white;
            text-decoration: none;
        }
        
        .profile-btn:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.3);
        }
        
        .profile-btn i {
            font-size: 3rem;
            margin-bottom: 1rem;
        }
        
        .btn-buyer {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        }
        
        .btn-seller {
            background: linear-gradient(135deg, #a1c4fd 0%, #c2e9fb 100%);
        }
        
        .btn-driver {
            background: linear-gradient(135deg, #ff9a9e 0%, #fad0c4 100%);
        }
        
        .btn-admin {
            background: linear-gradient(135deg, #a18cd1 0%, #fbc2eb 100%);
        }
        
        @media (max-width: 768px) {
            .profile-buttons {
                grid-template-columns: 1fr;
            }
            
            .profile-header h1 {
                font-size: 2.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="profile-container">
        <div class="profile-header">
            <h1>Are YOU,</h1>
            <p>Select your profile type to continue</p>
        </div>
        
        <div class="profile-buttons">
            <a href="profile.php" class="profile-btn btn-buyer">
                <i class="fas fa-shopping-cart"></i>
                Buyer
            </a>
            
            <a href="seller.php" class="profile-btn btn-seller">
                <i class="fas fa-store"></i>
                Seller
            </a>
            
            <a href="driver.php" class="profile-btn btn-driver">
                <i class="fas fa-truck"></i>
                Driver
            </a>
            
            <a href="admin_dashboard.php" class="profile-btn btn-admin">
                <i class="fas fa-user-shield"></i>
                Admin
            </a>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>