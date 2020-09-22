<?php

include_once 'database.php';

$settings = $mysqli->query(
  'SELECT * FROM settings')->fetch_assoc();

if (count($settings)) {
  $app_name = $settings['app_name'];
  $admin_email = $settings['admin_email'];
}else {
  $app_name = 'Service app';
  $admin_email = 'alaa140011@localhost';
}

$config = [
  'lang' => 'en',
  'dir' => 'ltr',
  'app_name' => $app_name,
  'app_url' => 'http://localhost/flexCourses/1-project/',
  'upload_dir' => 'uploads/',
  'admin_email' => $admin_email,
  'admin_plugins' => 'http://localhost/flexCourses/1-project/admin/plugins',
  'admin_dist' => 'http://localhost/flexCourses/1-project/admin/dist'
];