<?php
$filterAll = filter();
if (!empty($filterAll['id'])) {
    $userId = $filterAll['id'];
    $userDetail = getRow("SELECT * FROM student WHERE id=$userId");
    if ($userDetail > 0) {
        $deleteToken = delete('logintoken', "user_id=$userId");
        if ($deleteToken) {
            $deleteUser = delete('student', "id=$userId");
            if ($deleteUser) {
                setFlashData('msg', 'Delete success');
                setFlashData('msg_type', 'success');
            }else {
                setFlashData('msg', 'System error ');
                setFlashData('msg_type', 'danger');
            }
        }
    } else {
        setFlashData('msg', 'User does not exist in database ');
        setFlashData('msg_type', 'danger');
    }
} else {
    setFlashData('msg', 'Link does not exist. ');
    setFlashData('msg_type', 'danger');
}

redirect('?module=users&action=list');
