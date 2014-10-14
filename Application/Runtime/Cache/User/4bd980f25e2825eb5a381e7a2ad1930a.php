<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Insert title here</title>
</head>
<body style="background:#D0EBCB">

	<h6 style="font-size:22px;">用户登录：）</h6>
	<form method="post" action="<?php echo U('User/Login/doLogin'); ?>">
		<dl>
			<dt>login:</dt>
			<dd><input type="text" name="login" title="login" id="login"></dd>
		</dl>
		<dl>
			<dt>password:</dt>
			<dd><input type="password" name="password" title="password" id="password"></dd>
		</dl>
		<dl>
			<dd>
				<?php if (isset($redirect_to)){ ?>
				<input type="hidden" name="redirect_to" title="redirect_to" value="<?php echo ($redirect_to); ?>">
				<?php } ?>
				<input type="submit" name="submit" title="submit" id="submit" >
			</dd>
		</dl>
	</form>
</body>
</html>