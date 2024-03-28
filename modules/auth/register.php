<?php
$data = [
    'fullname' => 'Karen',
    'email' => 'karen@dtb.edu',
    'phone' => '12376681',
];


$rs = getRow('SELECT * FROM student');
layouts('header', $data);

var_dump($rs);
?>
<div class="row">
    <div class="col-6" style="margin: 50px auto;">
        <form action="/submit-your-login-form" method="post">
            <h2 class="text-center text-uppercase">Register</h2>
            <div class="form-group mg-form">
                <label for="">Your Name:</label>
                <input type="name" class="form-control" name="name" placeholder="Your Name" required>
            </div>
            <div class="form-group mg-form">
                <label for="">Email:</label>
                <input type="email" class="form-control" name="email" placeholder="Email" required>
            </div>
            <div class="form-group mg-form">
                <label for="">Phone Number:</label>
                <input type="phone" class="form-control" name="phone" placeholder="Phone number" required>
            </div>
            <div class="form-group mg-form">
                <label for="">Password:</label>
                <input type="password" class="form-control" name="password" placeholder="Password" required>
            </div>
            <div class="form-group mg-form">
                <label for="">Re-type Password:</label>
                <input type="password" class="form-control" name="password" placeholder="Password" required>
            </div>
            <div>
                <button type="submit" class=" mg-btn btn btn-primary btn-block">Register</button>
                <hr>
                <p class="text-center"><a href="?module=auth&action=login">Already have an account?</a></p>
                <p class="text-center"><a href="?module=auth&action=forgot">Forgot the password?</a></p>
            </div>
        </form>
    </div>
</div>

<?php
layouts('footer');
?>