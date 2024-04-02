<h1>ACTIVE</h1>
<?php
layouts('header');
$token = filter()['token'];
if (!empty($token)) {
    $tokenQuery = getOneRaw("SELECT id FROM student WHERE activeToken = '$token'");
    if (!empty($tokenQuery)) {
        $userId = $tokenQuery['id'];
        $dateUpdate = [
            'status' => 1,
            'activeToken' => null
        ];

        $updateStatus = update('student', $dateUpdate, "id=$userId");

        if ($updateStatus) {
            setFlashData('msg', 'Account activate success, you can log in now');
            setFlashData('msg_type', 'success');
        } else {
            setFlashData('msg', 'Account activate fail, please try again later');
            setFlashData('msg_type', 'danger');
        }
        redirect('?module=auth&action=login');
    } else {
        getMsg('Link failed or expired', 'danger');
    }
} else {
    getMsg('Link failed or expired 2', 'danger');
}

?>