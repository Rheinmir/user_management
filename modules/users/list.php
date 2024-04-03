<?php
$data = [
    'pageTitle' => 'User List'
];

layouts('header', $data);

// Checks if the user is logged in by verifying the login token in the database, and redirects to the login page if not logged in.
if (!isLogin()) {
    redirect('?module=auth&action=login');
}
?>

<?php
// SELECT FROM DTB
$listUser = getRaw("SELECT * FROM student ORDER BY update_at");

$msg = getFlashData('msg');
$msg_type = getFlashData('msg_type');
// $errors = getFlashData('errors');
// $old = getFlashData('old');

?>

<div class="container">
    <hr>
    <h2>User management</h2>
    <?php
        if (!empty($msg)) {
            getmsg($msg, $msg_type);
        }
        ?>
    <p>
        <a href="?module=users&action=add" class="btn btn-success btn-sm"><i class="fa-solid fa-plus"></i> Add user</a>
    </p>
    <table class="table table-bordered">
        <thead>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Tel</th>
            <th>Status</th>
            <th width="5%">Update</th>
            <th width="5%">Delete</th>
        </thead>
        <tbody>
            
            <?php
            if (!empty($listUser)) :
                $count = 0; // counting
                foreach ($listUser as $item) :
                    $count++;
            ?>
                    <tr>
                        <td><?php echo $count; ?></td>
                        <td><?php echo $item['fullname']; ?></td>
                        <td><?php echo $item['email']; ?></td>
                        <td><?php echo $item['phone']; ?></td>
                        <td><?php echo $item['status'] == 1 ? '<button class="btn btn-success btn-sm">Activated</button>' : '<button class="btn btn-danger btn-sm">Not activated</button>'; ?></td>
                        <td><a href="" class="btn btn-warning btn-sm"><i class="fa-solid fa-pen-to-square"></i></a></td>
                        <td><a href="" onclick="return confirm('Are you sure to delete?')" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i></a></td>
                    </tr>
                <?php
                endforeach;
            else :
                ?>
                <tr colspan="7">
                    <div class="alert alert-danger text-center">There are no user in the database</div>
                </tr>
            <?php
            endif;
            ?>
        </tbody>
    </table>
</div>

<?php
layouts('footer', $data);
?>