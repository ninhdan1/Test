<?php

require_once __DIR__ . '/../DB/DBConnect.php';
require_once __DIR__ . '/../model/User.php';
$conn = (new DBConnect())->getConnection();
$user = new User($conn);
$id = $_GET['id'];
$table = "tai_khoan";
$columns = "*";
$condition = "id = ?";
$user = $user->selectUserID($table, $columns, $condition, [$id]);


$content = '
    <div>
        <div class="pass-text">
            <p>Sửa tài khoản</p>
        </div>
    </div>
    <div id="password-form">
        <form action="../controller/UserController.php?action=update" method="post">
            <label for="username">Nhập tài khoản</label>
            <input type="hidden" name="id" value="' . $user['id'] . '">
            <input type="text" name="username" id="username" value="' . $user['username'] . '">
            <p class="error-p">';
if (isset($_SESSION["error_username"])) {
    $content .= $_SESSION["error_username"];
    unset($_SESSION["error_username"]);
}
$content .= '</p><br>
            <label for="password">Nhập mật khẩu</label>
            <input type="password" name="password" id="password" value="' . $user['password'] . '">
            <p class="error-p">';
if (isset($_SESSION["error_password"])) {
    $content .= $_SESSION["error_password"];
    unset($_SESSION["error_password"]);
}
$content .= '</p><br>
            <label for="role">Chọn quyền</label>
            <select name="role" id="role">
                <option value="admin" ' . ($user['role'] == 'admin' ? 'selected' : '') . '>Admin</option>
                <option value="user" ' . ($user['role'] == 'user' ? 'selected' : '') . '>User</option>
            </select><br>
            <label for="">Trạng thái hoạt động</label>
            <select name="status" id="status">
                <option value="1" ' . ($user['is_active'] == 1 ? 'selected' : '') . '>Hoạt động</option>
                <option value="0" ' . ($user['is_active'] == 0 ? 'selected' : '') . '>Không hoạt động</option>
            </select><br>
            <input type="hidden" name="giangvien" value="' . $user['ma_gv'] . '">
            <label for="giangvien">Giảng viên</label>
            <select name="giangvien_disabled" id="giangvien">';
$conn = (new DBConnect())->getConnection();
$userModel = new User($conn);
$teachers = $userModel->getTeacherNoUserUpdate();
foreach ($teachers as $teacher) {
    $selected = ($teacher['ma_gv'] == $user['ma_gv']) ? "selected" : "";
    $content .= '<option value="' . $teacher['ma_gv'] . '" ' . $selected . '>' . $teacher['ten_gv'] . '</option>';
}
$content .= '<option value="" ' . (empty($user['ma_gv']) ? 'selected' : "") . '>Giảng viên chưa xác định</option>
            </select><br>
            <button type="submit" name="submit" class="btn btn-primary" id="loginButton">Cập nhật</button>
        </form>
    </div>

    <script src="../js/login.js"></script>
';
include '../view/admin/sua_taikhoan.php';
