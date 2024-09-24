function checkRole($roles) {
    if (!in_array($_SESSION['role'], $roles)) {
        header("Location: access_denied.php");  // Redirect if the role doesn't match
        exit();
    }
}
