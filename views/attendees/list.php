<?php include '../layouts/header.php'; ?>
<h2>Attendees</h2>
<table class="table">
    <thead>
        <tr>
            <th>Username</th>
            <th>Email</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($attendee = $attendees->fetch_assoc()): ?>
            <tr>
                <td><?php echo $attendee["username"]; ?></td>
                <td><?php echo $attendee["email"]; ?></td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>
<?php include '../layouts/footer.php'; ?>