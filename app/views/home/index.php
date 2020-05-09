<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/app/public/static/cssLogin/style-container.css">
    <link rel="stylesheet" href="/app/public/static/cssLogin/style-buttons.css">
    <link rel="stylesheet" href="/app/public/static/cssLogin/style-forms-items.css">
    <link rel="stylesheet" href="/app/public/static/cssLogin/style-mobile.css">
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
            <form id="login" class="grid-container" action="home/login" method="POST">
                <div class="left-side">
                    <!-- left side -->
                    <div class="flex-logo">
                        <img src="/app/public/static/images/recicleaza1.jpg" alt="LOGO" class="logo-login">
                    </div>
                </div>
                <div class="right-side">
                    <!-- right side -->
                    <input type="text" id="email" name="email" placeholder="Email adress" class="icon-email" required>
                    <input type="password" id="pass" name="password" placeholder="Password" class="icon-pass" required>
                </div>
                <div class="down-side">
                    <!-- down side -->
                    <button type="submit" class="submit-button">Submit</button>
                    <div>
                        <a href="">Forgot password?</a>
                    </div>
                </div>
            </form>

            <!-- register -->
            <form id="register" class="grid-container" style="display:none;" action="home/register" method="POST">
                <div class="left-side">
                    <!-- left side -->
                    <div class="flex-logo">
                        <img src="/app/public/static/images/recicleaza1.jpg" alt="LOGO" class="logo-register">
                    </div>
                    <input type="text" id="fname" name="firstname" placeholder="First Name" class="icon-user" required>
                    <input type="text" id="lname" name="lastname" placeholder="Last Name" class="icon-user" required>
                    <div class="account">
                        <input type="radio" id="user" name="accountType" value="user" required>
                        <label for="user">User</label>
                        <input type="radio" id="employee" name="accountType" value="employee" required>
                        <label for="employee">Employee</label>
                    </div>
                    
                </div>
                <div class="right-side">
                    <!-- right side -->
                    <input type="email" id="email" name="email" placeholder="Email adress" class="icon-email" required>
                    <input type="password" id="pass1" name="password" placeholder="Password"
                        pattern="^(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$" title="Must contain at least one number, at least
one special character and at least 8  characters" class="icon-pass" required>
                    <input type="password" id="pass2" name="password" placeholder="Validate Password" class="icon-pass"
                        required>
                    <select id="street" class="chooseStreet icon-map">
                        <option value="" disabled selected>Choose your street</option>
                        <option>Street1</option>
                        <option>Street2</option>
                        <option>Street3</option>
                    </select>
                </div>
                <div class="down-side">
                    <!-- down side -->
                    <button type="submit" class="submit-button" >Submit</button>
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