<?= $this->include('template/header', ['title' => 'Dashboard']) ?>

<h2>Welcome, <?= isset($user['name']) ? esc($user['name']) : 'User' ?>!</h2>
<p>Your role: <strong><?= isset($user['role']) ? esc($user['role']) : (isset($role) ? esc($role) : 'user') ?></strong></p>

<?php $currentRole = isset($user['role']) ? $user['role'] : ($role ?? 'user'); ?>

<?php if ($currentRole === 'admin'): ?>
    <h3>All Users</h3>
    <?php if (!empty($users) && is_array($users)): ?>
        <ul>
            <?php foreach ($users as $u): ?>
                <li><?= esc($u['email'] ?? '') ?> - <?= esc($u['role'] ?? '') ?></li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>No users to display.</p>
    <?php endif; ?>

<?php elseif ($currentRole === 'teacher'): ?>
    <h3>Your Courses</h3>
    <?php if (!empty($courses) && is_array($courses)): ?>
        <ul>
            <?php foreach ($courses as $c): ?>
                <li><?= esc($c) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>No courses to display.</p>
    <?php endif; ?>

<?php else: ?>
    <h3>Enrolled Subjects</h3>
    <?php if (!empty($enrolled) && is_array($enrolled)): ?>
        <ul>
            <?php foreach ($enrolled as $e): ?>
                <li><?= esc($e) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>No enrolled subjects to display.</p>
    <?php endif; ?>
<?php endif; ?>

</div>
</body>
</html>
