<?php
ob_start();
$TAB = 'LOG';

// Main include
include($_SERVER['DOCUMENT_ROOT']."/inc/main.php");

// Edit as someone else?
if (($_SESSION['userContext'] === 'admin') && (isset($_SESSION['look']))) {
    $v_username = escapeshellarg($_SESSION['look']);
} else if (($_SESSION['userContext'] === 'admin') && (!empty($_GET['user']))) {
    $v_username = escapeshellarg($_GET['user']);
} else {
    $v_username = escapeshellarg($_SESSION['user']);
}

exec(HESTIA_CMD."v-list-user-auth-log ".$v_username." json", $output, $return_var);
check_return_code($return_var,$output);
$data = json_decode(implode('', $output), true);
$data = array_reverse($data);
unset($output);

// Render page
render_page($user, $TAB, 'list_log_auth');

// Flush session messages
unset($_SESSION['error_msg']);
unset($_SESSION['ok_msg']);