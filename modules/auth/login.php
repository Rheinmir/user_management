<?php

$data = [
    'pageTitle' => 'User Login'
];
layouts('header-login', $data);

if(isLogin()){
    redirect('?module=home&action=dashboard');
}

if (isPost()) {
    $filterAll = filter();

    // Verifies user login by comparing password from input with hashed password from DB.
    if (!empty(trim($filterAll['email'])) && !empty(trim($filterAll['password']))) {

        // Extracts email and password from filtered input.
        $email = $filterAll['email'];
        $password = $filterAll['password'];

        // Retrieves the password of a student from a database based on their email address.
        $userQuery = getOneRaw("SELECT password, id FROM student WHERE email = '$email'");

        if (!empty($userQuery)) {
            $passwordHash = $userQuery['password'];
            $userID = $userQuery['id'];
            if (password_verify($password, $passwordHash)) {
                //create tokenLogin
                $tokenLogin = sha1(uniqid().time());


                $dataInsert = [
                    'user_id' => $userID,
                    'token' => $tokenLogin,
                    'create_at' => date('Y-m-d H:i:s')
                ];

                $insertStatus = insert('loginToken',$dataInsert);
                if($insertStatus){
                    //Insert successful

                    //save login token to session
                    setSession('loginToken',$tokenLogin);
                    redirect('?module=home&action=dashboard');
                }else{
                    setFlashData('msg', 'Cant login, please try again later');
                    setFlashData('msg_type', 'danger');
                }

            } else {
                setFlashData('msg', 'Wrong password!');
                setFlashData('msg_type', 'danger');
                
            }
        } else {
            setFlashData('msg', 'Email not exist');
            setFlashData('msg_type', 'danger');
            
        }
    } else {
        setFlashData('msg', 'Please enter your account and password');
        setFlashData('msg_type', 'danger');
        
    }
    redirect('?module=auth&action=login');
}

$msg = getFlashData('msg');
$msg_type = getFlashData('msg_type');

?>
<div class="row">
    <div class="col-4" style="margin: 50px auto;">
        <h2 class="text-center text-uppercase">Login</h2>
        <?php
        if (!empty($msg)) {
            getMsg($msg, $msg_type);
        }
        ?>
        <form action="" method="post">
            <div class="form-group mg-form">
                <label for="">Email:</label>
                <input name="email" type="email" class="form-control" placeholder="Email">
            </div>
            <div class="form-group mg-form">
                <label for="">Password:</label>
                <input name="password" type="password" class="form-control" placeholder="Password">
            </div>
            <button type="submit" class=" user-btn btn btn-primary btn-block">Log In</button>
            <hr>
            <p class="text-center"><a href="?module=auth&action=forgot">Forgot the password?</a></p>
            <p class="text-center"><a href="?module=auth&action=register">Register</a></p>

        </form>
    </div>
</div>

<?php
layouts('footer-login');
?>