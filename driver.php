<?php
session_start();
require_once 'connection/connection.php';

// Check if user is logged in as driver
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] != 'driver') {
    header("Location: profile_selection.php");
    exit();
}

// Fetch driver data from database
$driver_id = $_SESSION['userid'];
$sql = "SELECT * FROM drivers WHERE driver_id = $driver_id";
$result = mysqli_query($connection, $sql);
$driver = mysqli_fetch_assoc($result);

// Fetch requests
$requests_sql = "SELECT * FROM delivery_requests WHERE driver_id = $driver_id ORDER BY request_date DESC LIMIT 5";
$requests_result = mysqli_query($connection, $requests_sql);

// Fetch notifications
$notifications_sql = "SELECT * FROM notifications WHERE user_id = $driver_id AND user_type = 'driver' ORDER BY created_at DESC LIMIT 5";
$notifications_result = mysqli_query($connection, $notifications_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Driver Dashboard | CoCoTrade</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #3498db;
            --secondary-color: #2980b9;
            --success-color: #2ecc71;
            --warning-color: #f39c12;
            --danger-color: #e74c3c;
            --dark-color: #2c3e50;
            --light-color: #ecf0f1;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f5f7fa;
            color: #333;
        }
        
        .driver-header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 2rem 0;
            margin-bottom: 2rem;
            border-radius: 0 0 20px 20px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }
        
        .profile-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            padding: 2rem;
            margin-bottom: 2rem;
        }
        
        .profile-pic {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 5px solid white;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        .section-title {
            position: relative;
            padding-bottom: 10px;
            margin-bottom: 1.5rem;
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
        
        .request-card, .notification-card {
            background: white;
            border-radius: 10px;
            padding: 1.2rem;
            margin-bottom: 1rem;
            box-shadow: 0 3px 10px rgba(0,0,0,0.05);
            border-left: 4px solid var(--primary-color);
            transition: all 0.3s ease;
        }
        
        .request-card:hover, .notification-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        .request-card.pending {
            border-left-color: var(--warning-color);
        }
        
        .request-card.accepted {
            border-left-color: var(--success-color);
        }
        
        .request-card.completed {
            border-left-color: var(--secondary-color);
        }
        
        .request-card.rejected {
            border-left-color: var(--danger-color);
        }
        
        .status-badge {
            padding: 0.3rem 0.8rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
            color: white;
        }
        
        .badge-pending {
            background-color: var(--warning-color);
        }
        
        .badge-accepted {
            background-color: var(--success-color);
        }
        
        .badge-completed {
            background-color: var(--secondary-color);
        }
        
        .badge-rejected {
            background-color: var(--danger-color);
        }
        
        .chat-container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            height: 400px;
            overflow: hidden;
        }
        
        .chat-header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 1rem;
        }
        
        .chat-messages {
            height: 300px;
            overflow-y: auto;
            padding: 1rem;
        }
        
        .message {
            margin-bottom: 1rem;
            max-width: 80%;
        }
        
        .message-in {
            background: var(--light-color);
            border-radius: 15px 15px 15px 0;
            padding: 0.8rem 1rem;
        }
        
        .message-out {
            background: var(--primary-color);
            color: white;
            border-radius: 15px 15px 0 15px;
            margin-left: auto;
        }
        
        .chat-input {
            border-top: 1px solid #eee;
            padding: 1rem;
        }
        
        .nav-tabs .nav-link {
            color: var(--dark-color);
            font-weight: 500;
        }
        
        .nav-tabs .nav-link.active {
            color: var(--primary-color);
            border-bottom: 3px solid var(--primary-color);
        }
        
        @media (max-width: 768px) {
            .profile-pic {
                width: 80px;
                height: 80px;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">CoCoTrade</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="driver_dashboard.php">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="driver_requests.php">Requests</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="driver_chat.php">Chat</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Driver Header -->
    <header class="driver-header">
        <div class="container text-center">
            <img src="images/drivers/<?= htmlspecialchars($driver['profile_pic'] ?? 'default.jpg') ?>" 
                 alt="Driver Profile" class="profile-pic mb-3">
            <h1><?= htmlspecialchars($driver['full_name']) ?></h1>
            <p class="mb-0">
                <i class="fas fa-map-marker-alt me-2"></i>
                <?= htmlspecialchars($driver['location']) ?>
            </p>
        </div>
    </header>

    <div class="container mb-5">
        <div class="row">
            <!-- Left Column -->
            <div class="col-lg-8">
                <!-- Requests Section -->
                <div class="profile-card">
                    <h3 class="section-title">Recent Delivery Requests</h3>
                    
                    <?php if(mysqli_num_rows($requests_result) > 0): ?>
                        <?php while($request = mysqli_fetch_assoc($requests_result)): ?>
                            <div class="request-card <?= htmlspecialchars($request['status']) ?>">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h5 class="mb-0">Order #<?= htmlspecialchars($request['order_id']) ?></h5>
                                    <span class="status-badge badge-<?= htmlspecialchars($request['status']) ?>">
                                        <?= ucfirst(htmlspecialchars($request['status'])) ?>
                                    </span>
                                </div>
                                <p class="mb-2">
                                    <i class="fas fa-map-marker-alt text-primary me-2"></i>
                                    From: <?= htmlspecialchars($request['pickup_location']) ?>
                                </p>
                                <p class="mb-2">
                                    <i class="fas fa-flag-checkered text-success me-2"></i>
                                    To: <?= htmlspecialchars($request['delivery_location']) ?>
                                </p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="text-muted">
                                        <i class="far fa-clock me-1"></i>
                                        <?= date('M j, Y h:i A', strtotime($request['request_date'])) ?>
                                    </small>
                                    <div>
                                        <button class="btn btn-sm btn-outline-primary me-2">View Details</button>
                                        <?php if($request['status'] == 'pending'): ?>
                                            <button class="btn btn-sm btn-success">Accept</button>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                        <div class="text-center mt-3">
                            <a href="driver_requests.php" class="btn btn-primary">View All Requests</a>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-info">No delivery requests found.</div>
                    <?php endif; ?>
                </div>
                
                <!-- Chat Section -->
                <div class="profile-card">
                    <h3 class="section-title">Chat with Buyers/Sellers</h3>
                    <div class="chat-container">
                        <div class="chat-header">
                            <h5 class="mb-0">Chat with Coconut Farm Ltd</h5>
                        </div>
                        <div class="chat-messages">
                            <div class="message message-in">
                                <p class="mb-1">Hi there! When can you pickup our order?</p>
                                <small class="text-muted">10:30 AM</small>
                            </div>
                            <div class="message message-out">
                                <p class="mb-1">I can come by in about 30 minutes.</p>
                                <small>10:35 AM</small>
                            </div>
                            <div class="message message-in">
                                <p class="mb-1">Great! We'll have it ready for you.</p>
                                <small class="text-muted">10:36 AM</small>
                            </div>
                        </div>
                        <div class="chat-input">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Type your message...">
                                <button class="btn btn-primary" type="button">Send</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Right Column -->
            <div class="col-lg-4">
                <!-- Notifications Section -->
                <div class="profile-card">
                    <h3 class="section-title">Notifications</h3>
                    
                    <?php if(mysqli_num_rows($notifications_result) > 0): ?>
                        <?php while($notification = mysqli_fetch_assoc($notifications_result)): ?>
                            <div class="notification-card">
                                <div class="d-flex align-items-start">
                                    <div class="flex-shrink-0 me-3">
                                        <i class="fas fa-bell text-warning"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1"><?= htmlspecialchars($notification['title']) ?></h6>
                                        <p class="mb-1"><?= htmlspecialchars($notification['message']) ?></p>
                                        <small class="text-muted">
                                            <?= date('M j, Y h:i A', strtotime($notification['created_at'])) ?>
                                        </small>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                        <div class="text-center mt-3">
                            <a href="driver_notifications.php" class="btn btn-outline-primary">View All Notifications</a>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-info">No new notifications.</div>
                    <?php endif; ?>
                </div>
                
                <!-- Driver Stats -->
                <div class="profile-card">
                    <h3 class="section-title">Your Stats</h3>
                    <div class="list-group list-group-flush">
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <span>Completed Deliveries</span>
                            <span class="badge bg-primary rounded-pill">24</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <span>Pending Requests</span>
                            <span class="badge bg-warning rounded-pill">3</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <span>Earnings This Month</span>
                            <span class="badge bg-success rounded-pill">Rs 25,500</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <span>Rating</span>
                            <span class="badge bg-info rounded-pill">4.8 ★</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Simple chat functionality
        document.querySelector('.chat-input button').addEventListener('click', function() {
            const input = document.querySelector('.chat-input input');
            const message = input.value.trim();
            
            if (message) {
                const chatMessages = document.querySelector('.chat-messages');
                const now = new Date();
                const timeString = now.getHours() + ':' + (now.getMinutes() < 10 ? '0' : '') + now.getMinutes();
                
                const messageDiv = document.createElement('div');
                messageDiv.className = 'message message-out';
                messageDiv.innerHTML = `
                    <p class="mb-1">${message}</p>
                    <small>${timeString}</small>
                `;
                
                chatMessages.appendChild(messageDiv);
                input.value = '';
                chatMessages.scrollTop = chatMessages.scrollHeight;
            }
        });
    </script>
</body>
</html>