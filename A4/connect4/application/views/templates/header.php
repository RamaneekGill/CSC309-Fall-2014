<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title><? echo $title ?> - Connect 4</title>
  <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600' rel='stylesheet' type='text/css'>
  <link href='<? echo base_url(); ?>css/template.css' rel='stylesheet' type='text/css'>
  <script src="http://code.jquery.com/jquery-latest.js"></script>
</head>
<body>
  <header>
    <h1><a href='<? echo base_url(); ?>'>Connect 4</a></h1>

    <?php if (isset($user)): ?>
      <div>
        Hello <?= $user->fullName() ?> <?= anchor('account/logout','(Logout)') ?> <?= anchor('account/updatePasswordForm','(Change Password)') ?>
      </div>
    <?php endif; ?>
  </header>

  <main id="main">
