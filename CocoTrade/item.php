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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Item Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }
        .item-image {
            max-height: 400px;
            object-fit: cover;
            border-radius: 10px;
        }
        .btn-primary {
            background-color: #ff6f61;
            border: none;
        }
        .btn-primary:hover {
            background-color: #e65a50;
        }
        .related-item img {
            max-height: 150px;
            object-fit: cover;
            border-radius: 10px;
        }
    </style>
</head>
<body>

<div class="container my-5">
    <div class="row">
        <?php
            $iid = $_GET['item'];
            $sql = "select * from items where itemid=$iid";
            $result = mysqli_query($connection,$sql);

            while($row = mysqli_fetch_assoc($result)){
        ?>
        <div class="col-md-6">
            <img src="images/uploads/<?php echo $row['imgname']; ?>" width="500px" height="500px">
        </div>

        <div class="col-md-6">
            <h1 class="mb-3"><?php echo $row['itemname']; ?></h1>
            <p class="text-muted">Category: <strong><?php echo $row['itemcategory']; ?></strong></p>
            <h3 class="text-danger">Rs <?php echo $row['itemprice']; ?></h3>
            <p class="mt-4"><?php echo $row['itemdetail']; } ?></p>
            <div class="d-grid gap-2">
                <button class="btn btn-primary btn-lg">Add to Cart</button>
                <button class="btn btn-outline-secondary btn-lg"  >Add to Wishlist</button>
            </div>
        </div>
    </div>


    <div class="mt-5">
        <h3 class="mb-4">Related Items</h3>
        <div class="row">
            <div class="col-md-3">
                <div class="card">
                    <img src="images/41eDzHxDWnL.jpg" class="card-img-top" alt="Related Item">
                    <div class="card-body text-center">
                        <h5 class="card-title">coconut oil</h5>
                        <p class="text-danger">Rs 400.00</p>
                        <a href="#" class="btn btn-sm btn-primary">View Item</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <img src="images/images (1).jpeg" class="card-img-top" alt="Related Item">
                    <div class="card-body text-center">
                        <h5 class="card-title">coconut water</h5>
                        <p class="text-danger">Rs 350.00</p>
                        <a href="#" class="btn btn-sm btn-primary">View Item</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <img src="images/natural-handmade-coconut-shell-serving-spoonset-of-2-173-05702-pala-natural-handmade-coconut-shell-serving-s-cookware-brown-living-132988_600x.webp" class="card-img-top" alt="Related Item">
                    <div class="card-body text-center">
                        <h5 class="card-title">coconut spoon</h5>
                        <p class="text-danger">Rs 250.00</p>
                        <a href="#" class="btn btn-sm btn-primary">View Item</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<footer class="bg-dark text-white py-4">
    <div class="container text-center">
        <p>&copy; 2025 ItemPage. All rights reserved.</p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
