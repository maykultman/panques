<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="author" content=""><meta charset="utf-8">
<link rel='stylesheet' href='http://fonts.googleapis.com/css?family=PT+Sans:400,700'>
<link rel="stylesheet" href="<?=base_url().'css/csslogin/reset.css'?>"      type="text/css">
<link rel="stylesheet" href="<?=base_url().'css/csslogin/supersized.css'?>" type="text/css">
<link rel="stylesheet" href="<?=base_url().'css/csslogin/style.css'?>"      type="text/css">
 <!-- Javascript -->
<script type="text/javascript" src="<?=base_url().'js/jquery.js'?>">                     </script>
<script type="text/javascript" src="<?=base_url().'js/login/supersized.3.2.7.min.js'?>"> </script>
<script type="text/javascript" src="<?=base_url().'js/login/supersized-init.js'?>">      </script>
<script type="text/javascript" src="<?=base_url().'js/login/scripts.js'?>">              </script>
</head>
<body>
<?php
    $user = array('name' => 'user', 'class'=>'username', 'placeholder' => 'Username' );
    $pass = array('name' => 'pass', 'class'=>'password', 'placeholder' => 'Password' );
?>
<div class="page-container">
    <h1>Clientum</h1>
    <?=form_open(base_url().'escritorio/login')?>
        <?=form_input($user)?><p><?=form_error('user')?></p>
        <?=form_password($pass)?><p><?=form_error('pass')?></p>
        <?=form_hidden('token', $token)?>
        <button type="submit" name="login">Sign me in</button>
        <div class="error"><span>+</span></div>
    <?=form_close()?>
    <p> <?php if($this->session->flashdata('mensaje')){ echo $this->session->flashdata('mensaje'); }?></p>
</div>
</body>
</html>