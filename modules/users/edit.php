<?php

$filterAll = filter();
if (!empty($filterAll['id'])) {
    $userId = $filterAll['id'];
    
    $userDetail = getOneRaw("SELECT * FROM student WHERE id='$userId'");
    
    if (!empty($userDetail)) {
        setFlashData('user-detail', $userDetail);
    } else {
        redirect('?module=users&action=list');
        
    }
}
// Conditional code execution based on HTTP method: if the request is a POST, it applies a filter and initializes an empty error array.
if (isPost()) {


    $errors = []; //array fix error

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
        $sql = "SELECT id FROM student WHERE email = '$email' AND id <> $userId";
        if (getRow($sql) > 0) {
            $errors['email']['unique'] = "Email is exist";
        }
    }

    // Validates a phone number, ensuring it's not empty and has a valid format.
    if (empty($filterAll['phone'])) {
        $errors['phone']['required'] = "Phone number can not be null";
    } else {
        if (!isPhone($filterAll['phone'])) {
            $errors['phone']['isPhone'] = "Phone number not valid, must start with 0 and followed with 9 numbers ";
        }
    }

    // Validates password-confirm field: required and matches password.
    if (empty($filterAll['password'])) {
        if (empty($filterAll['password-confirm'])) {
            $errors['password-confirm']['required'] = "Password can not be null";
        } else {
            if (($filterAll['password-confirm']) != ($filterAll['password'])) {
                $errors['password-confirm']['match'] = " Re-type password is not correct";
            }
        }
}



    // Sets flash message and type based on whether errors exist.
    if (empty($errors)) {

        $dataUpdate = [
            'fullname' => $filterAll['name'],
            'email' => $filterAll['email'],
            'phone' => $filterAll['phone'],
            'status' => $filterAll['status'],
            'create_at' => date('Y-m-d H:i:s')
        ];

        if(!empty($filterAll['password'])){
            $dataUpdate['password'] = password_hash($filterAll['password'],PASSWORD_DEFAULT);
        }

        $condition ="id = $userId";
        $updateStatus = update('student', $dataUpdate, $condition);
        if ($updateStatus) {
            setFlashData('msg', "Update user success");
            setFlashData('msg_type', "success");
        } else {
            setFlashData('msg', "System error! please try again later");
            setFlashData('msg_type', "danger");
        }
    } else {
        setFlashData('msg', "Please check entered data again!");
        setFlashData('msg_type', "danger");
        setFlashData('errors', $errors);
        setFlashData('old', $filterAll);
    }
    redirect('?module=users&action=edit&id='.$userId);
}

layouts('header-login');

$msg = getFlashData('msg');
$msg_type = getFlashData('msg_type');
$errors = getFlashData('errors');
$old = getFlashData('old');
$userDetail = getFlashData('user-detail');
if(!empty($userDetail))


?>
<div class="container">
    <div class="row" style="margin: 50px auto;">
        <h2 class="text-center text-uppercase">Update User</h2>
        <?php
        if (!empty($msg)) {
            getmsg($msg, $msg_type);
        }
        ?>
        <form action="" method="post">
            <div class="row">
                <div class="col">
                    <div class="form-group mg-form">
                        <label for="">Your Name:</label>
                        <input type="name" class="form-control" name="name" placeholder="Your Name" value="<?php
                                                                                                            echo old('name', $old); ?>">

                        <?php
                        // Display errors for the 'name' field.
                        echo form_error('name', '<span class="error">', '</span>', $errors);
                        ?>

                    </div>
                    <div class="form-group mg-form">
                        <label for="">Email:</label>
                        <input type="email" class="form-control" name="email" placeholder="Email" value="<?php
                                                                                                            echo old('email', $old); ?>">
                        <?php
                        echo form_error('email', '<span class="error">', '</span>', $errors);
                        ?>
                    </div>
                    <div class="form-group mg-form">
                        <label for="">Phone Number:</label>
                        <input type="phone" class="form-control" name="phone" placeholder="Phone number" value="<?php
                                                                                                                echo old('phone', $old); ?>">
                        <?php
                        echo form_error('phone', '<span class="error">', '</span>', $errors);
                        ?>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group mg-form">
                        <label for="">Password:</label>
                        <input type="password" class="form-control" name="password" placeholder="Password (Don't input if you don't want to change)" value="<?php
                                                                                                                    echo old('password', $old); ?>">
                        <?php
                        echo form_error('password', '<span class="error">', '</span>', $errors);
                        ?>

                    </div>
                    <div class="form-group mg-form">
                        <label for="">Re-type Password:</label>
                        <input type="password" class="form-control" name="password-confirm" placeholder="Re-type password (Don't input if you don't want to change)" value="<?php
                                                                                                                                    echo old('password-confirm', $old); ?>">
                        <?php
                        echo form_error('password-confirm', '<span class="error">', '</span>', $errors);
                        ?>
                    </div>
                    <div class="form-group">
                        <label for="">Status</label>
                        <select name="status" id="" class="form-control">
                            <option value="0" <?php
                                                echo (old('status', $old) == 0) ? 'selected' : false; ?>>Not Activated</option>
                            <option value="1" <?php
                                                echo (old('status', $old) == 1) ? 'selected' : false; ?>>Activated</option>
                        </select>
                    </div>
                </div>
            </div>

            <input type="hidden" name="id" value="<?php echo $userId ?>">

            <button type="submit" class=" mg-btn btn btn-primary btn-block">Update User</button>
            <a href="?module=users&action=list" class=" mg-btn btn btn-success btn-block">Return</a>
            <hr>

    </div>
    </form>
</div>
</div>

<?php
layouts('footer-login');
?>