<?php
include("../backend/db_admin.php");
session_start();

include("includes/flash.php");
/*
|-------------------------------------------------
| SESSION CHECK
|-------------------------------------------------
*/
if (
    !isset($_SESSION['user_id']) ||
    $_SESSION['role'] !== 'admin'
) {
    header("Location: ../login.php");
    exit();
}

/*
|-------------------------------------------------
| GET USER DATA
|-------------------------------------------------
*/
$user_id = $_SESSION['user_id'];
$user = null;

$sql = "SELECT * FROM users WHERE id = ?";

$stmt = $conn->prepare($sql);

if (!$stmt) {
    flash("error", "Database Error", $conn->error);
} else {

    if (!$stmt->bind_param("i", $user_id)) {
        flash("error", "System Error", "Bind failed.");
    } elseif (!$stmt->execute()) {
        flash("error", "Database Error", $stmt->error);
    } else {

        $result = $stmt->get_result();

        if ($result) {
            $user = $result->fetch_assoc();
        }
    }

    $stmt->close();
}

/*
|-------------------------------------------------
| UPDATE PROFILE
|-------------------------------------------------
*/
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $confirm_password = trim($_POST['confirm_password'] ?? '');

    if (empty($email) || empty($password) || empty($confirm_password)) {
        flash("error", "Validation Error", "All fields are required.");
    } elseif ($password !== $confirm_password) {
        flash("error", "Validation Error", "Passwords do not match.");
    } else {

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $update = "UPDATE users SET email = ?, password = ? WHERE id = ?";

        $stmt = $conn->prepare($update);

        if (!$stmt) {
            flash("error", "Database Error", $conn->error);
        } else {

            if (!$stmt->bind_param("ssi", $email, $hashed_password, $user_id)) {
                flash("error", "System Error", "Bind failed.");
            } elseif (!$stmt->execute()) {
                flash("error", "Database Error", $stmt->error);
            } else {

                $_SESSION['email'] = $email;

                $stmt->close();

                flash("success", "Updated", "Profile updated successfully!");

                header("Location: profile.php?update=success");
                exit();
            }

            $stmt->close();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Edit Profile | Alumni Association</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../assets/image/alumni_plp_newicon.png" type="image/x-icon">
    <?php include('includes/global_styles.php'); ?>
</head>

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <div class="app-wrapper">

        <?php
        include('includes/navbar.php');
        include('includes/sidebar.php');
        ?>

        <main class="app-main">
            <!-- Header -->
            <div class="app-content-header">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            <h3 class="mb-0">Edit Profile</h3>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-end">
                                <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Edit Profile</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="app-content">
                <div class="container-fluid">
                    <div class="row g-4">
                        <div class="col-md-12">
                            <div class="card card-primary card-outline mb-4">
                                <div class="card-header">
                                    <div class="card-title">Hello, <?php echo htmlspecialchars($user['role']); ?>! Please update the information below to improve your profile.</div>
                                </div>

                                <form method="POST" action="">
                                    <div class="card-body">

                                        <!-- User ID -->
                                        <div class="mb-3">
                                            <label for="user_id" class="form-label">User ID</label>
                                            <input type="text" class="form-control" id="user_id" name="user_id" value="<?php echo htmlspecialchars($user['id']); ?>" readonly>
                                        </div>

                                        <!-- Email -->
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Email address</label>
                                            <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" readonly>
                                        </div>

                                        <!-- Password -->
                                        <div class="mb-3">
                                            <label for="password" class="form-label">New Password</label>
                                            <input type="password" class="form-control" id="password" name="password" placeholder="Enter New Password" required>
                                        </div>

                                        <!-- Confirm Password -->
                                        <div class="mb-3">
                                            <label for="confirm_password" class="form-label">
                                                Confirm Password
                                            </label>

                                            <input
                                                type="password"
                                                class="form-control"
                                                id="confirm_password"
                                                name="confirm_password"
                                                placeholder="Confirm Password"
                                                required>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary"><i class="bi bi-floppy"></i>&nbsp; Save Changes</button>
                                        <a href="profile.php" class="btn float-end"><i class="bi bi-arrow-left-circle"></i>&nbsp; Back to Profile</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <?php include("includes/footer.php"); ?>
    </div>

    <?php include("includes/flash-swal.php"); ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function logout(event) {
            event.preventDefault();

            Swal.fire({
                title: "Are you sure?",
                text: "You will be logged out.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#dc3545",
                cancelButtonColor: "#6c757d",
                confirmButtonText: "Yes, log out",
                cancelButtonText: "Cancel"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "../logout.php";
                }
            });
        }
    </script>

    <!-- Password Validation -->
    <script>
        const password = document.getElementById('password');
        const confirmPassword = document.getElementById('confirm_password');
        confirmPassword.addEventListener("input", () => {
            if (password.value !== confirmPassword.value) {
                confirmPassword.setCustomValidity(
                    "Passwords do not match"
                );
            } else {
                confirmPassword.setCustomValidity("");
            }
        });
    </script>

</body>

</html>