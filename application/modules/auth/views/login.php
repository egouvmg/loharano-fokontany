<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Loharano - <?= $title;?></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.4.6/css/flag-icon.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
  <link href="<?= plugin('bootstrap', 'css', 'bootstrap.min.css');?>" rel="stylesheet">
  <?= css('login');?>
</head>
<body class="login">
    <div class="login-container">
      <div class="login-bloc">
        <div class="logo">
          <img src="<?= img('Logo-Loharano.png');?>" alt="Loharano" title="Projet Loharano" />
        </div>
        <center>
          <input type="radio" <?= ($this->session->site_lang == 'malagasy')? 'checked' : '';?> name="site_lang" value="malagasy"/> <span class="flag-icon flag-icon-mg"></span> Malagasy 
          <input type="radio" <?= ($this->session->site_lang == 'french')? 'checked' : '';?> name="site_lang" value="french"/> <span class="flag-icon flag-icon-fr"></span> Français
        </center> 

        <div class="login-form">
          <?php echo form_open("se_connecter");?>

          <div id="infoMessage"><?php echo $message;?></div>
          <div class="form-group">
            <?php echo form_input($identity);?>
          </div>

          <div class="form-group">
            <?php echo form_input($password);?>
          </div>

          <p><?php echo form_submit('submit', $this->lang->line('login_heading'), 'class="btn btn-primary btn-lg btn-block"');?></p>
        
        <p class="info float-left">
          <?= $this->lang->line('login_save_me');?>
          <?php echo form_checkbox('remember', '1', FALSE, 'id="remember"');?>
        </p>
        <p class="info float-right"><a href="forgot_password"><?= $this->lang->line('login_forgot_password');?></a></p>
      <?php echo form_close();?>
      </div>
    </div>
    </div>
	<script src="<?= js('jquery.min');?>"></script>
  <script src="<?= plugin('bootstrap', 'js', 'bootstrap.bundle.min.js');?>"></script>
	<script src="<?= plugin('modules', 'person', 'login.js');?>"></script>
<div id="appVersion"> Loharano Fokontany, version <?= APP_VERSION;?> &copy; <a href="https://digital.gov.mg" target="_blank">e-Gouvernance Madagascar</a> - <?= date("Y");?></div>
</body>