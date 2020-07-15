<html>
<body>
	<h1><?php echo sprintf(lang('email_forgot_password_heading'), $identity);?></h1>
	<p><?php echo sprintf(lang('email_forgot_password_subheading'), anchor('auth/reset_password/'. $forgotten_password_code, lang('email_forgot_password_link')));?></p>
<div id="appVersion"> Loharano Fokontany, version <?= APP_VERSION;?> &copy; <a href="https://digital.gov.mg" target="_blank">e-Gouvernance Madagascar</a> - <?= date("Y");?></div>
</body>
</html>