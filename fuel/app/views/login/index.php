<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <?php echo Asset::css('bootstrap.css'); ?>
    <?php echo Asset::js('jquery-latest.min.js'); ?>
    <?php echo Asset::js('jquery-ui.min.js'); ?>
    <?php echo Asset::js('bootstrap.js'); ?>
    <?php echo Asset::js('jquery.validate.js'); ?>
    <?php echo Asset::css('login/login.css'); ?>
	<title>Login</title>
</head>
<body>
    <div class="container">
        <div class="login_error">
            <?= Session::get_flash('error') ?>
        </div>
        <div class="login_form">
            <?= Form::open('auth/login') ?>
                <div>
                    <?= Form::input('username', Session::get_flash('username'), array('class' => 'span2')) ?>
                </div>
                <div>
                    <?= Form::password('password', null, array('class' => 'span2')) ?>
                </div>
                <div>
                    <?= Form::submit('Submit', 'Login', array('class' => 'btn pull-right')) ?>
                </div>
            <?= Form::close() ?>
        </div>
    </div>
</body>
</html>
