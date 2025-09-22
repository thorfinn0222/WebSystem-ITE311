<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - ITE311 Auth System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-success">
        <div class="container">
            <a class="navbar-brand" href="<?= base_url('/dashboard') ?>">
                <i class="fas fa-tachometer-alt"></i> ITE311 Dashboard
            </a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="<?= base_url('/logout') ?>">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show">
                <?= session()->getFlashdata('success') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show">
                <?= session()->getFlashdata('error') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-success text-white">
                        <h5><i class="fas fa-home"></i> Welcome to Your Dashboard</h5>
                    </div>
                    <div class="card-body">
                        <h4>Hello, <?= esc($user['name']) ?>!</h4>
                        <p class="text-muted">You have successfully logged into the ITE311 Authentication System.</p>
                        
                        <div class="row mt-4">
                            <div class="col-md-6">
                                <div class="card bg-info text-white">
                                    <div class="card-body text-center">
                                        <i class="fas fa-user fa-3x mb-3"></i>
                                        <h5>Profile</h5>
                                        <p>Manage your account</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card bg-info text-white">
                                    <div class="card-body text-center">
                                        <i class="fas fa-cog fa-3x mb-3"></i>
                                        <h5>Settings</h5>
                                        <p>Configure preferences</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header bg-success text-white">
                        <h6><i class="fas fa-info-circle"></i> Account Information</h6>
                    </div>
                    <div class="card-body">
                        <table class="table table-borderless">
                            <tr>
                                <td><strong>Name:</strong></td>
                                <td><?= esc($user['name']) ?></td>
                            </tr>
                            <tr>
                                <td><strong>Email:</strong></td>
                                <td><?= esc($user['email']) ?></td>
                            </tr>
                            <tr>
                                <td><strong>Role:</strong></td>
                                <td>
                                    <span class="badge bg-<?= $user['role'] === 'admin' ? 'danger' : 'success' ?>">
                                        <?= ucfirst(esc($user['role'])) ?>
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>User ID:</strong></td>
                                <td><?= esc($user['id']) ?></td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="card mt-3">
                    <div class="card-header bg-success text-dark">
                        <h6><i class="fas fa-clock"></i> Quick Actions</h6>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <button class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-edit"></i> Edit Profile
                            </button>
                            <button class="btn btn-outline-secondary btn-sm">
                                <i class="fas fa-key"></i> Change Password
                            </button>
                            <a href="<?= base_url('/logout') ?>" class="btn btn-outline-danger btn-sm">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
