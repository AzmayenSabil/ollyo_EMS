<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event List</title>
</head>

<body>
    <h1>Event List</h1>

    <table>
        <thead>
            <tr>
                <th>Event Name</th>
                <th>Description</th>
                <th>Location</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($events as $event): ?>
                <tr>
                    <td><?php echo $event['name']; ?></td>
                    <td><?php echo $event['description']; ?></td>
                    <td><?php echo $event['location']; ?></td>
                    <td><?php echo $event['date']; ?></td>
                    <td>
                        <!-- Edit Button -->
                        <a href="/ollyo_EMS/event/edit/<?php echo $event['id']; ?>">Edit</a>
                        <!-- View Button -->
                        <a href="/ollyo_EMS/event/view/<?php echo $event['id']; ?>">View</a>
                        <!-- Export Attendees Button -->
                        <a href="/ollyo_EMS/attendee/export/<?php echo $event['id']; ?>" target="_blank">Export Attendees</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>

</html>