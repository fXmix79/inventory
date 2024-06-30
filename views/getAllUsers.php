<h1>All Users</h1>
<ul>
    <?php foreach ($data['users'] as $user): ?>
        <li><?php echo htmlspecialchars($user['username']); ?></li>
    <?php endforeach; ?>
</ul>