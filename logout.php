<?php
/**
 * logout.php
 * File shortcut logout — redirect ke AuthController::logout()
 * untuk penghancuran session yang benar dan aman.
 */
header('Location: index.php?url=auth/logout');
exit;
