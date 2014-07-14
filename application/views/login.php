<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="author" content="">
<link rel='stylesheet' href='http://fonts.googleapis.com/css?family=PT+Sans:400,700'>
<link rel="stylesheet" href="<?=base_url().'css/csslogin/reset.css'?>" type="text/css">
<link rel="stylesheet" href="<?=base_url().'css/csslogin/supersized.css'?>" type="text/css">
<link rel="stylesheet" href="<?=base_url().'css/csslogin/style.css'?>" type="text/css">
 <!-- Javascript -->
 <script type="text/javascript" src="<?=base_url().'js/jquery.js'?>"></script>
<script type="text/javascript" src="<?=base_url().'js/login/supersized.3.2.7.min.js'?>">
</script>
<script type="text/javascript" src="<?=base_url().'js/login/supersized-init.js'?>">
</script>
<script type="text/javascript" src="<?=base_url().'js/login/scripts.js'?>">
</script>


<div class="page-container">
    <h1>Login</h1>
    <form action="" method="post">
        <input type="text" name="username" class="username" placeholder="Username">
        <input type="password" name="password" class="password" placeholder="Password">
        <button type="submit">Sign me in</button>
        <div class="error"><span>+</span></div>
    </form>
    <!--  <div class="connect">
        <p>Or connect with:</p>
        <p>
            <a class="facebook" href=""></a>
            <a class="twitter" href=""></a>
        </p>
    </div> -->
</div>
