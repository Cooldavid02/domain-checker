<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Domain Availability Checker</title>
    <!-- Bootstrap 4 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h3 class="card-title mb-0">Domain Availability Checker</h3>
                    </div>
                    <div class="card-body">
                        <form id="domainForm" action="check.php" method="POST">
                            <div class="form-group">
                                <label for="domain">Enter Domain Name:</label>
                                <div class="input-group">
                                    <input type="text" 
                                           class="form-control" 
                                           id="domain" 
                                           name="domain" 
                                           placeholder="example" 
                                           required
                                           pattern="[a-zA-Z0-9-]+"
                                           title="Only letters, numbers, and hyphens allowed">
                                    <div class="input-group-append">
                                        <span class="input-group-text">.com</span>
                                    </div>
                                </div>
                                <small class="form-text text-muted">
                                    Enter domain name without extension (e.g., "google" for google.com)
                                </small>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">
                                Check Availability
                            </button>
                        </form>

                        <?php if (isset($_GET['result']) && isset($_GET['domain'])): ?>
                            <div class="mt-4">
                                <hr>
                                <h5>Result for: <strong><?php echo htmlspecialchars($_GET['domain']); ?>.com</strong></h5>
                                <?php if ($_GET['result'] === 'available'): ?>
                                    <div class="alert alert-success">
                                        <h6>✅ Domain Available!</h6>
                                        <p class="mb-0">This domain is available for registration.</p>
                                    </div>
                                    <button class="btn btn-success">Register Domain</button>
                                <?php elseif ($_GET['result'] === 'taken'): ?>
                                    <div class="alert alert-danger">
                                        <h6>❌ Domain Taken</h6>
                                        <p class="mb-0">This domain is already registered.</p>
                                    </div>
                                <?php else: ?>
                                    <div class="alert alert-warning">
                                        <h6>⚠️ Error</h6>
                                        <p class="mb-0">Could not check domain availability. Please try again.</p>
                                    </div>
                                <?php endif; ?>
                                
                                <a href="index.php" class="btn btn-outline-primary mt-2">Check Another Domain</a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Recent Checks -->
                <?php
                // Display recent checks from session
                session_start();
                if (isset($_SESSION['recent_checks']) && !empty($_SESSION['recent_checks'])):
                ?>
                <div class="card mt-4">
                    <div class="card-header">
                        <h6 class="mb-0">Recent Checks</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <?php foreach ($_SESSION['recent_checks'] as $check): ?>
                            <div class="col-md-6 mb-2">
                                <span class="badge badge-<?php echo $check['available'] ? 'success' : 'danger'; ?>">
                                    <?php echo htmlspecialchars($check['domain']); ?>.com
                                </span>
                                <small class="text-muted">
                                    - <?php echo $check['available'] ? 'Available' : 'Taken'; ?>
                                </small>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Bootstrap 4 JS -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Add some client-side validation
        document.getElementById('domainForm').addEventListener('submit', function(e) {
            const domainInput = document.getElementById('domain');
            const domainValue = domainInput.value.trim();
            
            if (!domainValue) {
                e.preventDefault();
                alert('Please enter a domain name');
                return;
            }
            
            // Basic validation - only alphanumeric and hyphens
            if (!/^[a-zA-Z0-9-]+$/.test(domainValue)) {
                e.preventDefault();
                alert('Domain name can only contain letters, numbers, and hyphens');
                return;
            }
        });
    </script>
</body>
</html>