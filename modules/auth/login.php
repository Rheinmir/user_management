<?php

$data = [
    'pageTitle' => 'User Login'
];
layouts('header', $data);

// $result = filter();
// echo '<pre>';
// print_r($result);
// echo '</pre>';
$check = isNumberFloat('22.2');
var_dump($check);

?>
<div class="row">
    <div class="col-6" style="margin: 50px auto;">
        <form action="" method="post">
            <h2 class="text-center text-uppercase">Login</h2>
            <div class="form-group mg-form">
                <label for="">Email:</label>
                <input name="email" type="email" class="form-control" placeholder="Email" required>
            </div>
            <div class="form-group mg-form">
                <label for="">Password:</label>
                <input name="password" type="password" class="form-control" placeholder="Password" required>
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