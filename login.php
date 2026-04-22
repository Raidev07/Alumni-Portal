<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alumni Login</title>
    <link rel="icon" href="assets/image/alumni-logo.png">
    <link rel="stylesheet" href="assets/css/login.css">
    <link rel="stylesheet" href="assets/css/signUpDialog_style.css">
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
                        </div>
                    </div>

                    <a href="#" class="login__forgot">Forgot Password?</a>

                    <button type="submit" class="login__button">
                        Log In <i class="ri-send-plane-2-fill"></i>
                    </button>

                    <p class="login__sign">
                        Don't have an account?
                        <a href="#" id="openSignUp"
                            onclick="document.getElementById('signUpDialog').showModal(); return false;">
                            Sign Up
                        </a>
                    </p>
                </form>
            </div>

            <div class="login__image">
                <img src="assets/image/login.png" alt="" class="login__img" onclick="window.location.href='index.php'">
            </div>
        </div>
    </section>

    <dialog id="signUpDialog">
        <div class="title">Sign Up As...</div>
        <div class="registerButtons">
            <button onclick="window.location.href = 'student_form.php'">
                Register As Student
            </button>
            <button onclick="window.location.href = 'alumni_form.php'">
                Register As Alumni
            </button>
        </div>
        <button id="closeButton" onclick="document.getElementById('signUpDialog').close()">
            Close
        </button>
    </dialog>

    <script src="https://cdn.jsdelivr.net/npm/gsap@3.14.1/dist/gsap.min.js"></script>
    <script src="assets/js/login.js"></script>
</body>

</html>