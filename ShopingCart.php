<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }
        .cart-container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .btn-primary {
            background-color: #ff6f61;
            border: none;
        }
        .btn-primary:hover {
            background-color: #e65a50;
        }
        .cart-header {
            font-weight: bold;
            color: #343a40;
        }
    </style>
</head>
<body>

<div class="container my-5">
    <h1 class="text-center mb-4">Shopping Cart</h1>
    <div class="cart-container">
        <table class="table">
            <thead>
                <tr class="cart-header">
                    <th scope="col">Item</th>
                    <th scope="col">Price</th>
                    <th scope="col">Quantity</th>
                    <th scope="col">Total</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Coconut Spoon</td>
                    <td>100</td>
                    <td><input type="number" class="form-control" value="1" min="1" style="width: 80px;"></td>
                    <td>100</td>
                    <td><button class="btn btn-danger btn-sm">Remove</button></td>
                </tr>
                <tr>
                    <td>coconut water</td>
                    <td>150</td>
                    <td><input type="number" class="form-control" value="2" min="1" style="width: 80px;"></td>
                    <td>300</td>
                    <td><button class="btn btn-danger btn-sm">Remove</button></td>
                </tr>
            </tbody>
        </table>
        <div class="d-flex justify-content-between align-items-center mt-4">
            <h4>Total: 400</h4>
            <button class="btn btn-primary btn-lg">Proceed to Checkout</button>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
