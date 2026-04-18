<?php
/**
 * Admin Logout
 * Sakura Florist Solo
 */
session_start();
session_destroy();
header('Location: login.php');
exit;
