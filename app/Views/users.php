<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Data</title>
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', sans-serif;
        }

        body {
            background: linear-gradient(135deg, #667eea, #764ba2);
            min-height: 100vh;
            padding: 40px;
        }

        .container {
            max-width: 1200px;
            margin: auto;
            background: #fff;
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, .15);
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        h2 {
            color: #2d3748;
            font-size: 30px;
            font-weight: 700;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            overflow: hidden;
            border-radius: 15px;
        }

        table th {
            background: #4f46e5;
            color: white;
            padding: 16px;
            font-size: 15px;
        }

        table td {
            padding: 15px;
            text-align: center;
            border-bottom: 1px solid #eee;
        }

        table tr:nth-child(even) {
            background: #f8fafc;
        }

        table tr:hover {
            background: #eef2ff;
            transition: .3s;
        }

        .add-btn {
            background: #4f46e5;
            color: white;
            border: none;
            padding: 12px 22px;
            border-radius: 10px;
            cursor: pointer;
            font-weight: 600;
        }

        .add-btn:hover {
            background: #4338ca;
        }

        .excel-btn {
            background: #16a34a;
            color: white;
            text-decoration: none;
            padding: 12px 18px;
            border-radius: 10px;
            margin-right: 8px;
            font-weight: 600;
        }

        .excel-btn:hover {
            background: #15803d;
        }

        .pdf-btn {
            background: #dc2626;
            color: white;
            text-decoration: none;
            padding: 12px 18px;
            border-radius: 10px;
            margin-right: 8px;
            font-weight: 600;
        }

        .pdf-btn:hover {
            background: #b91c1c;
        }

        .edit-btn {
            background: #0ea5e9;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 8px;
            cursor: pointer;
        }

        .edit-btn:hover {
            background: #0284c7;
        }

        .delete-btn {
            background: #ef4444;
            color: white;
            text-decoration: none;
            padding: 8px 15px;
            border-radius: 8px;
        }

        .delete-btn:hover {
            background: #dc2626;
        }

        .badge {
            background: #fee2e2;
            color: #dc2626;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }
    </style>
</head>

<body>

    <div class="container">

        <div class="header">

            <h2>User Data Table</h2>

            <div>
                <a href="<?= base_url('home/exportExcel') ?>"
                    class="excel-btn">
                    Excel
                </a>

                <a href="<?= base_url('home/exportPdf') ?>"
                    class="pdf-btn"
                    target="_blank">
                    PDF
                </a>

                <button class="add-btn" onclick="addUser()">
                    + Add User
                </button>
            </div>

        </div>

        <table>
            <tr>
                <th>ID</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Password</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>

            <tbody id="userTableBody">

                <?php foreach ($users as $row): ?>
                    <tr id="row_<?= $row['id'] ?>">

                        <td><?= esc($row['id']) ?></td>
                        <td><?= esc($row['email']) ?></td>
                        <td><?= esc($row['phone']) ?></td>
                        <td>********</td>

                        <td>
                            <button class="edit-btn"
                                onclick="editUser(
                <?= $row['id'] ?>,
                '<?= esc($row['email']) ?>',
                '<?= esc($row['phone']) ?>',
                '<?= esc($row['password']) ?>'
            )">
                                Edit
                            </button>
                        </td>

                        <td>
                            <button class="delete-btn"
                                onclick="deleteUser(<?= $row['id'] ?>)">
                                Delete
                            </button>
                        </td>

                    </tr>
                <?php endforeach; ?>

            </tbody>
        </table>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <?php if (session()->getFlashdata('success')): ?>
        <script>
            document.addEventListener('DOMContentLoaded', function() {

                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: '<?= session()->getFlashdata('success') ?>',
                    background: '#ffffff',
                    color: '#333',
                    width: '500px',
                    confirmButtonColor: '#4f46e5',
                    timer: 2500,
                    timerProgressBar: true,
                    showClass: {
                        popup: 'animate__animated animate__zoomIn'
                    },
                    hideClass: {
                        popup: 'animate__animated animate__zoomOut'
                    }
                });

            });
        </script>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <script>
            document.addEventListener('DOMContentLoaded', function() {

                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: '<?= session()->getFlashdata('error') ?>',
                    width: '500px',
                    confirmButtonColor: '#dc2626'
                });

            });
        </script>
    <?php endif; ?>


    <script>
        function refreshTable() {
            $("#userTableBody").load(
                location.href + " #userTableBody>*"
            );
        }

        function addUser() {

            Swal.fire({
                title: '<h2 style="color:#4f46e5">Add New User</h2>',
                width: '550px',
                confirmButtonColor: '#4f46e5',
                background: '#fff',
                html: `
        <input id="email"
               class="swal2-input"
               placeholder="📧 Email">

        <input id="phone"
               class="swal2-input"
               placeholder="📱 Mobile Number">

        <input id="password"
               type="password"
               class="swal2-input"
               placeholder="🔒 Password">
    `,
                showCancelButton: true,
                confirmButtonText: 'Save User',
                cancelButtonText: 'Cancel'
            }).then((result) => {

                if (result.isConfirmed) {

                    let email = document.getElementById('email').value;
                    let password = document.getElementById('password').value;
                    let phone = document.getElementById('phone').value;

                    if (email == '' || password == '' || phone == '') {

                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'All fields are required'
                        });

                        return;
                    }

                    $.ajax({

                        url: "<?= base_url('home/savedata') ?>",
                        type: "POST",
                        dataType: "json",

                        data: {
                            email: email,
                            phone: phone,
                            password: password
                        },

                        success: function(response) {

                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: response.message
                            }).then(() => {

                                refreshTable();

                            });

                        },

                        error: function(xhr) {

                            let msg = "Something went wrong";

                            if (xhr.responseJSON) {
                                msg = xhr.responseJSON.message;
                            }

                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: msg
                            });

                        }

                    });

                }

            });

        }

        // Edit User

        function editUser(id, email, phone, password) {

            Swal.fire({
                title: 'Update User',
                width: '500px',
                confirmButtonColor: '#28a745',
                html: `
            <input id="email"
                   class="swal2-input"
                   value="${email}"
                   placeholder="Email">

            <input id="phone"
                   class="swal2-input"
                   value="${phone}"
                   placeholder="Phone">

            <input id="password"
                   type="password"
                   class="swal2-input"
                   value="${password}"
                   placeholder="Password">
        `,
                showCancelButton: true,
                confirmButtonText: 'Update'
            }).then((result) => {

                if (result.isConfirmed) {

                    let newEmail = document.getElementById('email').value;
                    let newPhone = document.getElementById('phone').value;
                    let newPassword = document.getElementById('password').value;

                    $.ajax({

                        url: "<?= base_url('home/update/') ?>" + id,

                        type: "POST",

                        dataType: "json",

                        data: {
                            email: newEmail,
                            phone: newPhone,
                            password: newPassword
                        },

                        success: function(response) {

                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: response.message,
                                confirmButtonColor: '#28a745'
                            }).then(() => {

                                refreshTable();

                            });
                        },

                        error: function(xhr) {

                            let msg = "Something went wrong";

                            if (xhr.responseJSON) {
                                msg = xhr.responseJSON.message;
                            }

                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: msg,
                                confirmButtonColor: '#dc3545'
                            });
                        }
                    });
                }
            });
        }

        //Delelte User

        function deleteUser(id) {

            Swal.fire({
                title: 'Delete User?',
                text: 'This action cannot be undone!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, Delete',
                cancelButtonText: 'Cancel'
            }).then((result) => {

                if (result.isConfirmed) {

                    $.ajax({

                        url: "<?= base_url('home/delete/') ?>" + id,

                        type: "POST",

                        dataType: "json",

                        success: function(response) {

                            Swal.fire({
                                icon: 'success',
                                title: 'Deleted!',
                                text: response.message,
                                confirmButtonColor: '#28a745'
                            }).then(() => {

                                refreshTable();

                            });

                        },

                        error: function(xhr) {

                            let msg = "Delete Failed";

                            if (xhr.responseJSON) {
                                msg = xhr.responseJSON.message;
                            }

                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: msg,
                                confirmButtonColor: '#dc3545'
                            });

                        }

                    });

                }

            });

        }
    </script>


</body>

</html>