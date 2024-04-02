<?php

$data = [
    'pageTitle' => 'Forgot Password'
];
layouts('header', $data);

// if(isLogin()){
//     redirect('?module=home&action=dashboard');
// }

if (isPost()) {
    $filterAll = filter();
    if(!empty($filterAll['email'])){
        $email = $filterAll['email'];
        
        $queryUser = getOneRaw("SELECT id FROM student WHERE email = '$email'");
        if(!empty($queryUser)){
            $userId = $queryUser['id'];

            //create forgot token
            $forgotToken = sha1(uniqid().time());

            $dataUpdate = [
                'forgotToken'=> $forgotToken
            ];

            $updateStatus = update('student',$dataUpdate, "id=$userId");
            if($updateStatus){
                //create link reset password
                $linkReset = _WEB_HOST.'?module=auth&action=reset&token='.$forgotToken;
                //send mail to user
                $subject = "Reset password request";
                $content = nl2br('Dear student, '. "\n\n\n\n");
                $content .= nl2br("Here is your reset password link. Please click the link below to reset your password:\n");
                $content .= nl2br($linkReset . "\n\n\n\n");
                $content .= "Best regards.";

                $sendMail = sendMail($email, $subject, $content);

                if ($sendMail) {
                    setFlashData('msg', "Check your mail for reset link!");
                    setFlashData('msg_type', "success");
                } else {
                    setFlashData('msg', "System error! please try again later");
                    setFlashData('msg_type', "danger");
                }
            }else{
                setFlashData('msg','System error, please try again later');
        setFlashData('msg_type','danger');
            }
        }
    }else{
        setFlashData('msg','Please enter your email');
        setFlashData('msg_type','danger');
        };

    redirect('?module=auth&action=forgot');
}
$msg = getFlashData('msg');
$msg_type = getFlashData('msg_type');

?>
<div class="row">
    <div class="col-6" style="margin: 50px auto;">
        <h2 class="text-center text-uppercase">Forgot Password</h2>
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
            
            <button type="submit" class=" mg-btn btn btn-primary btn-block">Submit</button>
            <hr>
            <p class="text-center"><a href="?module=auth&action=login">Remembered your password?</a></p>
            <p class="text-center"><a href="?module=auth&action=register">Register</a></p>

        </form>
    </div>
</div>

<?php
layouts('footer');
?>