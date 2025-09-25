<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'ITE311 Project') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    
<nav class="navbar navbar-expand-lg navbar-white bg-success">
    <div class="container-fluid">
        <a class="navbar-brand" href="/dashboard">ITE311 System</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">

                <!-- Show for all logged-in users -->
                <li class="nav-item">
                    <a class="nav-link" href="/dashboard">Dashboard</a>
                </li>

                <?php if (session()->get('role') === 'admin'): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/manage-users">Manage Users</a>
                    </li>
                <?php endif; ?>

                <?php if (session()->get('role') === 'teacher'): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/my-courses">My Courses</a>
                    </li>
                <?php endif; ?>

                <?php if (session()->get('role') === 'student'): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/my-subjects">My Subjects</a>
                    </li>
                <?php endif; ?>

            </ul>

            <ul class="navbar-nav ms-auto">
                <?php if (session()->get('isLoggedIn')): ?>
                    <li class="nav-item">
                        <span class="navbar-text text-light me-2">
                            <?= esc(session()->get('email')) ?> (<?= esc(session()->get('role')) ?>)
                        </span>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn btn-danger btn-sm text-white" href="/logout">Logout</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/login">Login</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-4">
