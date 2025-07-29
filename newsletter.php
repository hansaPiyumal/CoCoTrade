<?php
// Include your database connection
require_once 'connection/connection.php';

// Fetch all coconut diseases from database
$sql = "SELECT * FROM coconut_diseases ORDER BY disease_name ASC";
$result = mysqli_query($connection, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coconut Diseases Newsletter | CoCoTrade</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(rgba(255, 255, 255, 0.1), rgba(255, 255, 255, 0.1)), 
                        url('images/coconut-farm.jpg') no-repeat center center fixed;
            background-size: cover;
            min-height: 100vh;
        }
        
        .hero-section {
            background: rgba(0, 0, 0, 0.5);
            color: white;
            padding: 100px 0;
            margin-bottom: 50px;
        }
        
        .disease-card {
            transition: all 0.3s ease;
            border-radius: 10px;
            overflow: hidden;
            height: 100%;
            border: 1px solid rgba(255, 255, 255, 0.3);
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(5px);
        }
        
        .disease-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
            background: rgba(255, 255, 255, 0.95);
        }
        
        .disease-img-container {
            height: 200px;
            overflow: hidden;
            position: relative;
        }
        
        .disease-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }
        
        .disease-card:hover .disease-img {
            transform: scale(1.05);
        }
        
        .accordion-button:not(.collapsed) {
            background-color: rgba(248, 249, 250, 0.7);
            color: #0d6efd;
        }
        
        .badge-scientific {
            background-color: #6c757d;
            font-weight: normal;
        }
        
        .no-image-icon {
            font-size: 4rem;
            color: #6c757d;
        }
        
        .image-missing-text {
            font-size: 0.8rem;
            color: #dc3545;
        }
        
        #subscribe {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(5px);
        }
        
        @media (max-width: 768px) {
            .hero-section {
                padding: 60px 0;
            }
            
            .disease-img-container {
                height: 150px;
            }
        }
    </style>
</head>
<body>
    
    <!-- Hero Section -->
    <section class="hero-section text-center">
        <div class="container">
            <h1 class="display-4 fw-bold">Coconut Diseases Newsletter</h1>
            <p class="lead">Learn about common coconut diseases and how to protect your crops</p>
            <a href="subscribe_newsletter.php" class="btn btn-primary btn-lg mt-3">Subscribe for Updates</a>
        </div>
    </section>
    
    <!-- Diseases Listing -->
    <section class="container mb-5">
        <div class="row mb-4">
            <div class="col-12">
                <h2 class="text-center mb-4">Common Coconut Diseases</h2>
                <p class="text-center">Click on any disease to learn more about symptoms, prevention, and treatment</p>
            </div>
        </div>
        
        <div class="row g-4">
            <?php if(mysqli_num_rows($result) > 0): ?>
                <?php while($row = mysqli_fetch_assoc($result)): ?>
                    <?php
                    // Check if image exists
                    $image_path = 'images/diseases/'.htmlspecialchars($row['images']);
                    $image_exists = (!empty($row['images']) && file_exists($image_path));
                    ?>
                    <div class="col-md-6 col-lg-4">
                        <div class="disease-card card h-100">
                            <div class="disease-img-container">
                                <?php if($image_exists): ?>
                                    <img src="<?= $image_path ?>" 
                                         class="disease-img" 
                                         alt="<?= htmlspecialchars($row['disease_name']) ?>"
                                         title="<?= htmlspecialchars($row['disease_name']) ?>">
                                <?php else: ?>
                                    <div class="d-flex flex-column align-items-center justify-content-center h-100 bg-light">
                                        <i class="fas fa-leaf no-image-icon mb-2"></i>
                                        <?php if(!empty($row['images'])): ?>
                                            <span class="image-missing-text">Image not found</span>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            
                            <div class="card-body">
                                <h3 class="h5 card-title"><?= htmlspecialchars($row['disease_name']) ?></h3>
                                <?php if(!empty($row['scientific_name'])): ?>
                                    <span class="badge badge-scientific mb-2"><?= htmlspecialchars($row['scientific_name']) ?></span>
                                <?php endif; ?>
                                
                                <div class="accordion accordion-flush" id="accordion-<?= $row['disease_id'] ?>">
                                    <!-- Symptoms -->
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button collapsed" type="button" 
                                                    data-bs-toggle="collapse" 
                                                    data-bs-target="#symptoms-<?= $row['disease_id'] ?>">
                                                Symptoms
                                            </button>
                                        </h2>
                                        <div id="symptoms-<?= $row['disease_id'] ?>" 
                                             class="accordion-collapse collapse" 
                                             data-bs-parent="#accordion-<?= $row['disease_id'] ?>">
                                            <div class="accordion-body">
                                                <?= nl2br(htmlspecialchars($row['symptoms'])) ?>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Prevention -->
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button collapsed" type="button" 
                                                    data-bs-toggle="collapse" 
                                                    data-bs-target="#prevention-<?= $row['disease_id'] ?>">
                                                Prevention Methods
                                            </button>
                                        </h2>
                                        <div id="prevention-<?= $row['disease_id'] ?>" 
                                             class="accordion-collapse collapse" 
                                             data-bs-parent="#accordion-<?= $row['disease_id'] ?>">
                                            <div class="accordion-body">
                                                <?= nl2br(htmlspecialchars($row['prevention_methods'])) ?>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <?php if(!empty($row['treatment_methods'])): ?>
                                    <!-- Treatment -->
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button collapsed" type="button" 
                                                    data-bs-toggle="collapse" 
                                                    data-bs-target="#treatment-<?= $row['disease_id'] ?>">
                                                Treatment Methods
                                            </button>
                                        </h2>
                                        <div id="treatment-<?= $row['disease_id'] ?>" 
                                             class="accordion-collapse collapse" 
                                             data-bs-parent="#accordion-<?= $row['disease_id'] ?>">
                                            <div class="accordion-body">
                                                <?= nl2br(htmlspecialchars($row['treatment_methods'])) ?>
                                            </div>
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            
                            <div class="card-footer bg-transparent">
                                <small class="text-muted">
                                    Last updated: <?= date('M j, Y', strtotime($row['updated_at'] ?? 'now')) ?>
                                </small>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="col-12">
                    <div class="alert alert-info text-center">
                        No disease information available at the moment. Please check back later.
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </section>
    
    <!-- Newsletter Subscription -->
    <section id="subscribe" class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center">
                    <h2 class="mb-4">Subscribe to Our Newsletter</h2>
                    <p class="lead mb-4">Get the latest updates on coconut diseases and farming tips</p>
                    
                    <form class="row g-3 justify-content-center" action="subscribe_newsletter.php" method="POST">
                        <div class="col-md-8">
                            <input type="email" class="form-control form-control-lg" 
                                   placeholder="Your email address" name="email" required>
                        </div>
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-primary btn-lg w-100">
                                Subscribe
                            </button>
                        </div>
                        <div class="col-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="termsCheck" required>
                                <label class="form-check-label" for="termsCheck">
                                    I agree to receive email updates
                                </label>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>