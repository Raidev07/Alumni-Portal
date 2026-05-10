<?php
$error = '';
if (isset($_GET['error'])) {

    if ($_GET['error'] === 'wrong_password') {
        $error = 'Incorrect password. Please try again.';
    } elseif ($_GET['error'] === 'user_not_found') {
        $error = 'No account found with that email.';
    } elseif ($_GET['error'] === 'pending') {
        $error = 'Your account is still pending approval.';
    } elseif ($_GET['error'] === 'inactive') {
        $error = 'Your account has been deactivated.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alumni Login</title>
    <link rel="icon" href="assets/image/alumni-logo.png">
    <link rel="stylesheet" href="assets/css/login.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.6.0/remixicon.min.css">
</head>

<body>
    <section class="login">
        <div class="login__content">
            <div>
                <h2 class="login__title">Welcome Back</h2>

                <form action="backend/login_process.php" method="POST" class="login__form">
                    <div class="login__group">
                        <div class="login__box">
                            <i class="ri-mail-fill login__icon"></i>
                            <input type="email" name="email" autocomplete="email" required placeholder=" "
                                class="login__input" id="email">
                            <label for="email" class="login__label">Email</label>
                        </div>

                        <div class="login__box">
                            <i class="ri-lock-2-fill login__icon"></i>
                            <input type="password" name="password" autocomplete="current-password" required
                                placeholder=" " class="login__input" id="password">
                            <label for="password" class="login__label">Password</label>

                            <span class="login__toggle" id="togglePassword">
                                <i class="ri-eye-line"></i>
                            </span>
                        </div>
                    </div>

                    <a href="#" class="login__forgot">Forgot Password?</a>

                    <!-- Login Process -->
                    <?php if ($error): ?>
                        <div class="login__error">
                            <i class="ri-error-warning-fill"></i>
                            <?= htmlspecialchars($error) ?>
                        </div>
                    <?php endif; ?>

                    <button type="submit" class="login__button">
                        Log In <i class="ri-send-plane-2-fill"></i>
                    </button>

                    <p class="login__sign">
                        Don't have an account?
                        <a href="DPA.php">
                            Sign Up
                        </a>
                    </p>
                </form>
            </div>

            <div class="login__image">
                <img src="assets/image/login.png" alt="" class="login__img">
            </div>
            <a href="index.php" class="back__home">
                <i class="ri-arrow-left-s-line"></i>
                <span>Homepage</span>
            </a>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/gsap@3.14.1/dist/gsap.min.js"></script>
    <script src="assets/js/login.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const passwordInput = document.getElementById("password");
            const togglePassword = document.getElementById("togglePassword");
            const icon = togglePassword.querySelector("i");

            togglePassword.addEventListener("click", () => {
                const isPassword = passwordInput.type === "password";

                passwordInput.type = isPassword ? "text" : "password";

                icon.classList.toggle("ri-eye-line");
                icon.classList.toggle("ri-eye-off-line");
            });
        });
    </script>
</body>

</html>