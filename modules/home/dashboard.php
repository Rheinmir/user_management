<?php
$data = [
    'pageTitle' => 'Dashboard page'
];


layouts('header', $data);


// Checks if the user is logged in by verifying the login token in the database, and redirects to the login page if not logged in.

if(!isLogin()){
    redirect('?module=auth&action=login');
}
?>
<h1>DASHBOARD</h1>


<?php
layouts('footer');
?>