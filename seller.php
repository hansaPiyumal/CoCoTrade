<?php
session_start();
require_once 'connection/connection.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Get conversation partner (could be from GET parameter)
$partner_id = isset($_GET['partner']) ? (int)$_GET['partner'] : 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messages | CoCoTrade</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .chat-container {
            height: calc(100vh - 200px);
            border: 1px solid #ddd;
            border-radius: 10px;
            overflow: hidden;
        }
        .chat-sidebar {
            border-right: 1px solid #ddd;
            height: 100%;
            overflow-y: auto;
        }
        .chat-messages {
            height: calc(100% - 60px);
            overflow-y: auto;
            padding: 15px;
            background-color: #f9f9f9;
        }
        .chat-input {
            border-top: 1px solid #ddd;
            padding: 15px;
            background-color: #fff;
        }
        .conversation-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .conversation-item {
            padding: 10px;
            border-bottom: 1px solid #eee;
            cursor: pointer;
        }
        .conversation-item:hover, .conversation-item.active {
            background-color: #f0f0f0;
        }
        .message {
            margin-bottom: 15px;
            max-width: 70%;
        }
        .message-sent {
            margin-left: auto;
            background-color: #d4edda;
            border-radius: 15px 15px 0 15px;
            padding: 10px 15px;
        }
        .message-received {
            margin-right: auto;
            background-color: #fff;
            border-radius: 15px 15px 15px 0;
            padding: 10px 15px;
            border: 1px solid #eee;
        }
    </style>
</head>
<body>
    <?php include 'seller_header.php'; ?>
    
    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="fas fa-users me-2"></i>Conversations</h5>
                    </div>
                    <div class="card-body p-0">
                        <ul class="conversation-list" id="conversation-list">
                            <!-- Conversations will be loaded here via AJAX -->
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="fas fa-comments me-2"></i>Messages</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="chat-container">
                            <div class="row h-100">
                                <div class="col-md-4 p-0 chat-sidebar" id="chat-sidebar">
                                    <!-- Conversation list could also go here -->
                                </div>
                                <div class="col-md-8 p-0 d-flex flex-column">
                                    <div class="chat-messages" id="chat-messages">
                                        <?php if ($partner_id > 0): ?>
                                            <!-- Messages will be loaded here via AJAX -->
                                        <?php else: ?>
                                            <div class="text-center text-muted py-5">
                                                <i class="fas fa-comment-slash fa-3x mb-3"></i>
                                                <p>Select a conversation to start chatting</p>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <?php if ($partner_id > 0): ?>
                                    <div class="chat-input">
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="message-input" placeholder="Type your message...">
                                            <button class="btn btn-primary" id="send-message">
                                                <i class="fas fa-paper-plane"></i> Send
                                            </button>
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <script>
        $(document).ready(function() {
            // Load conversations
            function loadConversations() {
                $.ajax({
                    url: 'get_conversations.php',
                    type: 'GET',
                    success: function(response) {
                        $('#conversation-list').html(response);
                    }
                });
            }

            // Load messages for a specific conversation
            function loadMessages(partnerId) {
                if (partnerId > 0) {
                    $.ajax({
                        url: 'get_messages.php',
                        type: 'POST',
                        data: { 
                            conversation_with: partnerId
                        },
                        success: function(response) {
                            $('#chat-messages').html(response);
                            // Scroll to bottom
                            $('#chat-messages').scrollTop($('#chat-messages')[0].scrollHeight);
                        }
                    });
                }
            }

            // Send message
            $('#send-message').click(function() {
                var message = $('#message-input').val().trim();
                var partnerId = <?= $partner_id ?>;
                
                if (message !== '' && partnerId > 0) {
                    $.ajax({
                        url: 'send_message.php',
                        type: 'POST',
                        data: {
                            receiver_id: partnerId,
                            message: message
                        },
                        success: function(response) {
                            if (response.success) {
                                $('#message-input').val('');
                                loadMessages(partnerId);
                            }
                        }
                    });
                }
            });

            // Load conversations initially
            loadConversations();
            
            // Load messages if partner is selected
            <?php if ($partner_id > 0): ?>
                loadMessages(<?= $partner_id ?>);
                
                // Refresh messages every 5 seconds
                setInterval(function() {
                    loadMessages(<?= $partner_id ?>);
                }, 5000);
            <?php endif; ?>
        });
    </script>
</body>
</html>