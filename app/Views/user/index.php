<!DOCTYPE html>
<html>

<head>
    <title>User List</title>
</head>

<body>
    <h1>User List</h1>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>email</th>
            <th>role</th>
        </tr>
        <?php foreach ($users as $user): ?>
            <tr>
                <td><?= $user->getId() ?></td>
                <td><?= $user->getName() ?></td>
                <td><?= $user->getEmail() ?></td>
                <td><?= $user->getRole() ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>

</html>