<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Profile View</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f4f4f4;
      margin: 0;
      padding: 20px;
    }
    .profile-card {
      max-width: 400px;
      margin: auto;
      background: white;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.2);
    }
    .profile-card h2 {
      margin-bottom: 20px;
      text-align: center;
      color: #333;
    }
    .profile-item {
      margin-bottom: 15px;
    }
    .profile-label {
      font-weight: bold;
      display: block;
      color: #555;
    }
    .profile-value {
      color: #222;
    }
  </style>
</head>
<body>
  <div class="profile-card">
    <h2>User Profile</h2>
    <div class="profile-item">
      <span class="profile-label">Username:</span>
      <span class="profile-value">januskar123</span>
    </div>
    <div class="profile-item">
      <span class="profile-label">Contact Number:</span>
      <span class="profile-value">+94 71 234 5678</span>
    </div>
    <div class="profile-item">
      <span class="profile-label">Email Address:</span>
      <span class="profile-value">januskar@example.com</span>
    </div>
    <div class="profile-item">
      <span class="profile-label">Orders Count:</span>
      <span class="profile-value">24</span>
    </div>
  </div>
</body>
</html>