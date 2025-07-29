<?php
session_start();
require_once 'connection/connection.php';

// Calculate cart total
$cart_total = 0;
if(isset($_SESSION['cart']) {
    foreach($_SESSION['cart'] as $item) {
        $cart_total += $item['price'] * $item['quantity'];
    }
}

// Process payment
if(isset($_POST['confirm_order'])) {
    // Validate payment method
    if(empty($_POST['payment_method'])) {
        $error = "Please select a payment method";
    } else {
        // Process payment (this would be replaced with actual payment processing)
        $payment_method = $_POST['payment_method'];
        $order_id = uniqid();
        
        // Store order in database (simplified example)
        $user_id = $_SESSION['userid'] ?? null;
        $sql = "INSERT INTO orders (order_id, user_id, total_amount, payment_method, status) 
                VALUES ('$order_id', '$user_id', '$cart_total', '$payment_method', 'pending')";
        mysqli_query($connection, $sql);
        
        // Clear cart and redirect to confirmation
        unset($_SESSION['cart']);
        header("Location: order_confirmation.php?order_id=$order_id");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - COCO TRADE</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Montserrat', sans-serif;
        }
        .checkout-container {
            max-width: 1200px;
            margin: 30px auto;
            padding: 20px;
        }
        .checkout-card {
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            margin-bottom: 20px;
            overflow: hidden;
        }
        .checkout-header {
            background-color: #034b16;
            color: white;
            padding: 15px 20px;
        }
        .payment-method {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
            cursor: pointer;
            transition: all 0.3s;
        }
        .payment-method:hover {
            border-color: #034b16;
            background-color: #f8f9fa;
        }
        .payment-method.selected {
            border-color: #034b16;
            background-color: #e8f5e9;
        }
        .payment-icon {
            font-size: 24px;
            margin-right: 10px;
            color: #034b16;
        }
        .btn-checkout {
            background-color: #034b16;
            color: white;
            padding: 12px 30px;
            font-weight: bold;
            border: none;
            width: 100%;
        }
        .btn-checkout:hover {
            background-color: #023a10;
        }
        .summary-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }
        .total-price {
            font-size: 24px;
            font-weight: bold;
            color: #034b16;
        }
    </style>
</head>
<body>
    <div class="checkout-container">
        <div class="row">
            <div class="col-md-8">
                <div class="checkout-card">
                    <div class="checkout-header">
                        <h3><i class="fas fa-shopping-bag"></i> Order Summary</h3>
                    </div>
                    <div class="card-body">
                        <?php if(isset($_SESSION['cart']) && count($_SESSION['cart']) > 0): ?>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Product</th>
                                            <th>Price</th>
                                            <th>Quantity</th>
                                            <th>Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($_SESSION['cart'] as $id => $item): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($item['name']) ?></td>
                                            <td>$<?= number_format($item['price'], 2) ?></td>
                                            <td><?= $item['quantity'] ?></td>
                                            <td>$<?= number_format($item['price'] * $item['quantity'], 2) ?></td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <p>Your cart is empty.</p>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="checkout-card">
                    <div class="checkout-header">
                        <h3><i class="fas fa-credit-card"></i> Payment Method</h3>
                    </div>
                    <div class="card-body">
                        <form id="paymentForm" method="post">
                            <?php if(isset($error)): ?>
                                <div class="alert alert-danger"><?= $error ?></div>
                            <?php endif; ?>

                            <div class="payment-method" onclick="selectPayment('credit_card')">
                                <input type="radio" name="payment_method" value="credit_card" id="credit_card" style="display: none;">
                                <label for="credit_card">
                                    <i class="fas fa-credit-card payment-icon"></i>
                                    <span style="font-weight: bold;">Credit/Debit Card</span>
                                </label>
                                <div class="card-details mt-3" id="creditCardDetails" style="display: none;">
                                    <div class="mb-3">
                                        <label class="form-label">Card Number</label>
                                        <input type="text" class="form-control" placeholder="1234 5678 9012 3456">
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Expiry Date</label>
                                            <input type="text" class="form-control" placeholder="MM/YY">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">CVV</label>
                                            <input type="text" class="form-control" placeholder="123">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="payment-method" onclick="selectPayment('paypal')">
                                <input type="radio" name="payment_method" value="paypal" id="paypal" style="display: none;">
                                <label for="paypal">
                                    <i class="fab fa-paypal payment-icon"></i>
                                    <span style="font-weight: bold;">PayPal</span>
                                </label>
                            </div>

                            <div class="payment-method" onclick="selectPayment('bank_transfer')">
                                <input type="radio" name="payment_method" value="bank_transfer" id="bank_transfer" style="display: none;">
                                <label for="bank_transfer">
                                    <i class="fas fa-university payment-icon"></i>
                                    <span style="font-weight: bold;">Bank Transfer</span>
                                </label>
                            </div>

                            <div class="payment-method" onclick="selectPayment('cash_on_delivery')">
                                <input type="radio" name="payment_method" value="cash_on_delivery" id="cash_on_delivery" style="display: none;">
                                <label for="cash_on_delivery">
                                    <i class="fas fa-money-bill-wave payment-icon"></i>
                                    <span style="font-weight: bold;">Cash on Delivery</span>
                                </label>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="checkout-card">
                    <div class="checkout-header">
                        <h3><i class="fas fa-receipt"></i> Order Total</h3>
                    </div>
                    <div class="card-body">
                        <div class="summary-item">
                            <span>Subtotal:</span>
                            <span>$<?= number_format($cart_total, 2) ?></span>
                        </div>
                        <div class="summary-item">
                            <span>Shipping:</span>
                            <span>$5.00</span>
                        </div>
                        <div class="summary-item">
                            <span>Tax:</span>
                            <span>$<?= number_format($cart_total * 0.1, 2) ?></span>
                        </div>
                        <hr>
                        <div class="summary-item">
                            <span class="total-price">Total:</span>
                            <span class="total-price">$<?= number_format($cart_total + 5 + ($cart_total * 0.1), 2) ?></span>
                        </div>
                        <button type="submit" form="paymentForm" name="confirm_order" class="btn btn-checkout mt-4">
                            <i class="fas fa-lock"></i> Confirm & Pay
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function selectPayment(method) {
            // Remove selected class from all payment methods
            document.querySelectorAll('.payment-method').forEach(el => {
                el.classList.remove('selected');
            });
            
            // Add selected class to clicked method
            event.currentTarget.classList.add('selected');
            
            // Check the radio button
            document.getElementById(method).checked = true;
            
            // Show/hide card details
            const cardDetails = document.getElementById('creditCardDetails');
            if(method === 'credit_card') {
                cardDetails.style.display = 'block';
            } else {
                cardDetails.style.display = 'none';
            }
        }
    </script>
</body>
</html>