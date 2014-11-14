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
      <h1><?php echo anchor('/catalogue', 'Baseball Card Store') ?></h1>
    </div>
    <nav id="user">
      <?php echo anchor('/user/index', 'Login / Register') ?>
      <?php echo anchor('/cart/view', 'Cart') . " (" . "0" . ")" ?>
    </nav>
  </header>

  <section id="main">
