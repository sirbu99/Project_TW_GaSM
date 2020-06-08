<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Garbage site">
    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/public/static/cssLogin/style-container.css">
    <link rel="stylesheet" href="/public/static/cssLogin/style-buttons.css">
    <link rel="stylesheet" href="/public/static/cssLogin/style-forms-items.css">
    <link rel="stylesheet" href="/public/static/cssLogin/style-mobile.css">
    <script type="text/javascript" src="/public/static/js/misc.js"></script>
    <script type="text/javascript" src="/public/static/js/auth.js"></script>
</head>

<body>
<div class="main-display">
    <div class="container">

        <div class="switch-buttons">
            <button type="button" id="button-login" class="switch-button-login" onclick="openForm(this)">Log In
            </button>
            <button type="button" id="button-register" class="switch-button-green switch-button-register"
                    onclick="openForm(this)">Register
            </button>
        </div>

        <!-- login -->
        <main>
            <form id="login" class="grid-container" action="<?= BASE_URL . "/home/login" ?>" method="POST">
                <div class="left-side">
                    <!-- left side -->
                    <div class="flex-logo">
                        <img src="/public/static/images/recicleaza1.jpg" alt="LOGO" class="logo-login">
                    </div>
                </div>
                <div class="right-side">
                    <!-- right side -->
                    <input type="text" id="email" name="email" placeholder="Email address" class="icon-email"
                           required>
                    <input type="password" id="pass" name="password" placeholder="Password" class="icon-pass"
                           required>
                    <div id="error-message"></div>
                </div>

                <div class="down-side">
                    <!-- down side -->
                    <button onclick="login(event)" type="submit" class="submit-button">Submit</button>
                    <div>
                        <a href="">Forgot password?</a>
                    </div>
                </div>
            </form>
        </main>
        <!-- register -->
        <form id="register" class="grid-container" style="display:none;" action="<?= BASE_URL . "/home/register" ?>"
              method="POST">
            <div class="left-side">
                <!-- left side -->
                <div class="flex-logo">
                    <img src="/public/static/images/recicleaza1.jpg" alt="LOGO" class="logo-register">
                </div>
                <input type="text" id="fname" name="firstname" placeholder="First Name" class="icon-user" required>
                <input type="text" id="lname" name="lastname" placeholder="Last Name" class="icon-user" required>

            </div>
            <div class="right-side">
                <!-- right side -->
                <input type="email" id="register-email" name="email" placeholder="Email adress" class="icon-email" required>
                <input type="password" id="pass1" name="password" placeholder="Password"
                       pattern="^(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$" title="Must contain at least one number, at least
one special character and at least 8  characters" class="icon-pass" required>
                <input type="password" id="pass2" name="password" placeholder="Validate Password" class="icon-pass"
                       required>
                <select id="street" name="street" class="chooseStreet icon-map">
                    <option value="" disabled selected>Choose your street</option>
                    <?php
                    foreach ($data['locations'] as $id => $loc) {
                        echo '<option value = "' . $id . '">' . $loc . '</option>';
                    }
                    ?>
                </select>
                <div id="error-message-register"></div>
            </div>
            <div class="down-side">
                <!-- down side -->
                <button onclick="register(event)" type="submit" class="submit-button">Submit</button>
            </div>
        </form>
    </div>
</div>
<script>
    //function which make switch between login form and register form
    let currentPage = 'login';

    function openForm(elem) {
        if (elem.id === 'button-register' && currentPage === 'login') {
            document.getElementById('login').style.display = 'none';
            document.getElementById('register').removeAttribute('style');
            document.getElementById('button-login').classList.toggle('switch-button-green');
            document.getElementById('button-register').classList.toggle('switch-button-green');
            currentPage = 'register';
        } else if (elem.id === 'button-login' && currentPage === 'register') {
            document.getElementById('register').style.display = 'none';
            document.getElementById('login').removeAttribute('style');
            document.getElementById('button-login').classList.toggle('switch-button-green');
            document.getElementById('button-register').classList.toggle('switch-button-green');
            currentPage = 'login';
        }
    }
</script>
</body>

</html>