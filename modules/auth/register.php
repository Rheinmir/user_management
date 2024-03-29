<?php
$data = [
    'fullname' => 'Karen',
    'email' => 'karen@dtb.edu',
    'phone' => '12376681',
];


if (isPost()) {
    $filterAll = filter();
    $errors = []; //array fix error

    //validate fullname
    // Validates that the name field is not empty and has a minimum length of 5 characters.
    if (empty($filterAll['name'])) {
        $errors['name']['required'] = "Your name can not be null";
    } else {
        if (strlen($filterAll['name']) < 5) {
            $errors['name']['min'] = "Your name need to have at least 5 characters";
        }
    }

    // Validates if an email is empty and if it already exists.
    if (empty($filterAll['email'])) {
        $errors['email']['required'] = "Email can not be null";
    } else {
        $email = $filterAll['email'];
        $sql = "SELECT id FROM student WHERE email = '$email' ";
        if (getRow($sql) > 0) {
            $errors['email']['unique'] = "Email is exist";
        }
    }

    // Validates a phone number, ensuring it's not empty and has a valid format.
if (empty($filterAll['phone'])) {
        $errors['phone']['required'] = "Phone number can not be null";
    } else {
        if(!isPhone($filterAll['phone'])){
            $errors['phone']['isPhone'] = "Phone number not valid";
        }
    } 
    echo '<pre>';
    print_r($errors);
    echo '</pre>';
}
layouts('header', $data);

?>
<div class="row">
    <div class="col-6" style="margin: 50px auto;">
        <form action="" method="post">
            <h2 class="text-center text-uppercase">Register</h2>
            <div class="form-group mg-form">
                <label for="">Your Name:</label>
                <input type="name" class="form-control" name="name" placeholder="Your Name">
            </div>
            <div class="form-group mg-form">
                <label for="">Email:</label>
                <input type="email" class="form-control" name="email" placeholder="Email">
            </div>
            <div class="form-group mg-form">
                <label for="">Phone Number:</label>
                <input type="phone" class="form-control" name="phone" placeholder="Phone number">
            </div>
            <div class="form-group mg-form">
                <label for="">Password:</label>
                <input type="password" class="form-control" name="password" placeholder="Password">
            </div>
            <div class="form-group mg-form">
                <label for="">Re-type Password:</label>
                <input type="password" class="form-control" name="password-confirm" placeholder="Password">
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