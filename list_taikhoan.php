<?php

require_once __DIR__ . '/../DB/DBConnect.php';
require_once __DIR__ . '/../model/User.php';

$conn = (new DBConnect())->getConnection();
$user = new User($conn);
$table = "tai_khoan";
$columns = "*";
$users = $user->selectUser($table, $columns);

// $condition = "role = 'user'";
// $users = $user->selectUser($table, $columns, $condition);

$content = '<a class="btn btn-primary" href="them_taikhoan.php" role="button">Thêm tài khoản</a><br><br>
<table class="table" id="myTable">
    <thead>
        <tr>
            <th scope="col">STT</th>
            <th scope="col">Tên tài khoản</th>
            <th scope="col">Mật khẩu</th>
            <th scope="col"></th>
            <th scope="col">Quyền</th>
            <th scope="col">Hoạt động</th>
            <th scope="col">Hành động</th>
        </tr>
    </thead>
    <tbody>';
foreach ($users as $key) {
    $content .= '<tr>
                    <th scope="row">' . $key['id'] . '</th>
                    <td>' . $key['username'] . '</td>
                    <td class="password-cell" data-password="' . $key['password'] . '">' . str_repeat("*", strlen($key['password'])) . '</td>
                    <td><i class="fa fa-eye show-password m-2" style="cursor: pointer;"></i></td>
                    <td>' . ($key['role'] == 'admin' ? '<i class="fas fa-user-shield" style="color: blue;"></i> Admin' : '<i class="fas fa-user" style="color: orange;"></i> User') . '</td>
                    <td>' . ($key['is_active'] == 1 ? '<i class="fas fa-check-circle" style="color: green;"></i> Hoạt động' : '<i class="fas fa-times-circle" style="color: red;"></i> Không hoạt động') . '</td>
                    <td>
                        <a class="btn btn-primary" href="../view/sua_taikhoan.php?id=' . $key['id'] . '" role="button">Sửa</a>
                        <a class="btn btn-danger" href="../controller/UserController.php?action=delete&id=' . $key['id'] . '" role="button">Xóa</a>
                    </td>
                </tr>';
}
$content .= '</tbody>
</table>


<script src="../../js/openpassword.js"></script>';


include '../view/admin/sua_taikhoan.php';
