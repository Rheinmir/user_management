<?php

$data = [
    'pageTitle' => 'User Login'
];
layouts('header', $data);

$password = '123456';
// $md5 = md5($password);
// $sha1 = sha1($password);

// echo 'MD5-' . $md5 ;
// echo 'SHA1-' . $sha1 ;
$passwordhash = password_hash($password,PASSWORD_DEFAULT);

$checkPass = password_verify('0123456',$passwordhash);

var_dump($checkPass);
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