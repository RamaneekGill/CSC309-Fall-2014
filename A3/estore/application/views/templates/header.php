<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title><? echo $title ?> - Baseball Card Store</title>
  <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600' rel='stylesheet' type='text/css'>
  <link href='<? echo base_url(); ?>css/template.css' rel='stylesheet' type='text/css'>
</head>
<body>
  <header>
    <div id="logo">
      <h1><?php echo anchor('/', 'Baseball Card Store') ?></h1>
    </div>
    <nav id="user">
      <?php
        if (!$this->session->userdata('logged_in') && !$this->session->userdata('admin_logged_in')) {
          echo anchor('/login', 'Login') . ' - ' . anchor('/register', 'Register');
        }
        elseif ($this->session->userdata('logged_in')) {
          echo $this->session->userdata('username') . ': ' . anchor('/logout', 'Logout') . ' - ' . anchor('/cart', 'Cart');
        }
        else {
          echo 'Admin: ' . anchor('/admin/logout', 'Logout');
        }
      ?>
    </nav>
  </header>

  <section id="main">
