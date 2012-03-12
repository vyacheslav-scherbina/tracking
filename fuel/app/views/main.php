<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <?php echo Asset::css('bootstrap.css'); ?>
    <?php echo Asset::css('my.css'); ?>
    <?php echo Asset::js('jquery-latest.min.js'); ?>
    <?php echo Asset::js('jquery-ui.min.js'); ?>
    <?php echo Asset::js('bootstrap.js'); ?>
    <?php echo Asset::js('jquery.validate.js'); ?>
    <?php echo Asset::js('jquery.form.js')?>
    
	<title><?php echo $title; ?></title>
</head>
<body>
<div class="navbar navbar-fixed-top">
	<div class="navbar-inner">
		<div class="container-fluid">
			<?php echo Html::anchor('/', 'Tracking', array('class' => 'brand')) ;?>
			<div class="nav-collapse">
				<ul class="nav">
					<li>
                        <?php echo Html::anchor('employee', 'Employees') ;?>
                    </li>
					<li>
                        <?php echo Html::anchor('unit', 'Units') ;?>
                    </li>
					<li>
                        <?php echo Html::anchor('project', 'Projects') ;?>
                    </li>
					<li>
                        <?php echo Html::anchor('company', 'Companies') ;?>
                    </li>
					<li>
                        <?php echo Html::anchor('contact', 'Contacts') ;?>
                    </li>
				</ul>
                <p class="navbar-text pull-right">
                    <?php echo Html::anchor('auth/logout', 'Logout') ;?>
                </p>
			</div>
		</div>
	</div>
</div>
	<div class="container-fluid">
        <div class="row-fluid">
            <h1>
                <?php echo $title; ?>
                <? if ($superuser): ?>
                    <a class="btn btn-success btn-circle add">+</a>
                <? endif; ?>
            </h1>
        <?php if ($search) echo $search; ?>
        <?php echo $content; ?>
        </div>
	</div>
</body>
</html>
