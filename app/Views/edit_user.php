<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <title>Edit User</title>
    <h2>Edit User</h2>
    <form action="<?= base_url('home/update/' . $user['id']) ?>" method="post">

        <input type="email"
            name="email"
            value="<?= $user['email'] ?>">

        <br><br>

        <input type="password"
            name="password"
            value="<?= $user['password'] ?>">

        <br><br>

        <button type="submit">Edit</button>

    </form>
</body>

</html>