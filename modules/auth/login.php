<?php

$data = [
    'pageTitle' => 'User Login'
];
layouts('header', $data);
?>
<div class="row">
    <div class="col-6" style="margin: 50px auto;">
        <form action="/submit-your-login-form" method="post">
            <h2 class="text-center text-uppercase">Login</h2>
            <div class="form-group mg-form">
                <label for="">Email:</label>
                <input type="email" class="form-control" name="email" placeholder="Email" required>
            </div>
            <div class="form-group mg-form">
                <label for="">Password:</label>
                <input type="password" class="form-control" name="password" placeholder="Password" required>
            </div>
            <div>
                <button type="submit" class=" mg-btn btn btn-primary btn-block">Log In</button>
                <hr>
                <p class="text-center"><a href="?module=auth&action=forgot">Forgot the password?</a></p>
                <p class="text-center"><a href="?module=auth&action=register">Register</a></p>
            </div>
        </form>
    </div>
</div>

<?php
layouts('footer');
?>