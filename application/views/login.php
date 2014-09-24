<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="author" content=""><meta charset="utf-8">
<?=
    link_tag('http://fonts.googleapis.com/css?family=PT+Sans:400,700').
    link_tag('css/csslogin/reset.css').
    link_tag('css/csslogin/supersized.css').
    link_tag('css/csslogin/style.css');
?>
 <!-- Javascript -->
<?= script_tag('js/jquery.js').
    script_tag('js/login/supersized.3.2.7.min.js').
    script_tag('js/login/supersized-init.js').
    script_tag('js/login/scripts.js');
?>         
</head>
<body class="smallscreen">
<?php
    $user = array('name' => 'user', 'class'=>'username', 'placeholder' => 'Username' );
    $pass = array('name' => 'pass', 'class'=>'password', 'placeholder' => 'Password' );
?>
<div class="page-container">
    <img src="http://crmqualium.com/img/imglogin/backgrounds/logoq.png" alt="" style="height: 125px; margin-top: -100px;">
    <!-- <h1>Cliente</h1> -->
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