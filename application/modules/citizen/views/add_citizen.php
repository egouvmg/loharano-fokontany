<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Loharano - <?= $title;?></title>
	<!-- Tell the browser to be responsive to screen width -->
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
	<!-- Ionicons -->
	<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
	<!-- Google Font: Source Sans Pro -->
	<link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@300;400;700&family=Roboto+Slab:wght@300;400;500&display=swap" rel="stylesheet">
	<link href="<?= plugin('bootstrap', 'css', 'bootstrap.min.css');?>" rel="stylesheet">
	<link href="<?= plugin('tabulator', 'css', 'tabulator.min.css');?>" rel="stylesheet">
	<?= css('admin');?>

	<script src="https://code.iconify.design/1/1.0.4/iconify.min.js"></script>
</head>


<body class="loharano">

  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-light bg-light static-top">
      <div class="logo-container">
        <a href="/"><img src="<?= img('Logo-Loharano-mini.png');?>"/></a>
      </div>
      
      <img src="<?= img('sautRep.png');?>">
      <div class="menu">
        <ul class="navbar-nav">
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <?= $user_fokontany;?>
              <span class="iconify" data-icon="uil:ellipsis-v" data-inline="false"></span>
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="#"><?= $this->lang->line('settings');?></a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="se_deconnecter"><?= $this->lang->line('logout');?></a>
            </div>
          </li>
        </ul>
      </div>
  </nav>

  <div class="container-fluid">
    <div class=row>
      <div class="main-side-bar">
        <ul class="main-menu">
          <li>
            <a href="gestion_citoyens"><span class="iconify" data-icon="bi:people-fill" data-inline="false"></span> <?=$this->lang->line('citizens');?></a>
            <ul class="sub-main-menu">
              <li><a href="ajout_citoyen" class="active"><?=$this->lang->line('add_citizen');?></a></li>
              <li><a href="liste_citoyens"><?=$this->lang->line('list_citizen');?></a></li>
            </ul>
          </li>
          <li>
            <a href="#"><span class="iconify" data-icon="fa-solid:user" data-inline="false"></span> <?=$this->lang->line('households');?></a>
          </li>
          <li>
            <a href="#"><span class="iconify" data-icon="ant-design:setting-filled" data-inline="false"></span> <?=$this->lang->line('settings');?></a>
          </li>
        </ul>
      </div>
      <div class="main-container">
        <!-- Page title --> 
        <div class="container-fluid page-title">
          <h1><?= $title;?></h1>
        </div>
        <!-- End Page title -->

        <!-- Page Content -->
        <div class="container-fluid">
            <form id="addCitizen">
                <div class="row">   
                    <div class="col-lg-3">
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <?=$this->lang->line('info_citizen');?>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="last_name"><?=$this->lang->line('last_name');?> *</label>
                                <input type="text" class="form-control" id="last_name" name="last_name" placeholder="...">
                                <span class="error_field error_last_name"></span>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="first_name"><?=$this->lang->line('first_name');?> *</label>
                                <input type="text" class="form-control" id="first_name" name="first_name" placeholder="...">
                                <span class="error_field error_first_name"></span>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="birth"><?=$this->lang->line('sexe');?> *</label>
                                <select name="sexe" id="sexe" class="form-control">
                                    <option value="1"><?=$this->lang->line('sexe_male');?></option>
                                    <option value="2"><?=$this->lang->line('sexe_female');?></option>
                                </select>
                                <span class="error_field error_sexe"></span>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="birth"><?=$this->lang->line('birth');?> *</label>
                                <input type="date" class="form-control" id="birth" name="birth" placeholder="jj/mm/aaaa">
                                <span class="error_field error_birth"></span>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="birth"><?=$this->lang->line('birth_place');?> *</label>
                                <input type="text" class="form-control" id="birth" name="birth" placeholder="...">
                                <span class="error_field error_birth"></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                .
                            </div>
                            <div class="form-group col-md-12">
                                <label for="marital_status"><?=$this->lang->line('marital_status');?></label>
                                <input type="text" class="form-control" id="marital_status" name="marital_status" placeholder="...">
                                <span class="error_field error_marital_status"></span>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="address"><?=$this->lang->line('address');?> *</label>
                                <input type="text" class="form-control" id="address" name="address" placeholder="...">
                                <span class="error_field error_address"></span>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="phone"><?=$this->lang->line('phone');?> *</label>
                                <input type="text" class="form-control" id="phone" name="phone" placeholder="...">
                                <span class="error_field error_phone"></span>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="job"><?=$this->lang->line('job');?> *</label>
                                <input type="date" class="form-control" id="job" name="job" placeholder="...">
                                <span class="error_field error_job"></span>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="job_description"><?=$this->lang->line('job_description');?> *</label>
                                <input type="text" class="form-control" id="job_description" name="job_description" placeholder="...">
                                <span class="error_field error_job_description"></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <?=$this->lang->line('info_parent');?>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="father"><?=$this->lang->line('father');?></label>
                                <input type="text" class="form-control" id="father" name="father" placeholder="...">
                                <span class="error_field error_father"></span>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="father_status"><?=$this->lang->line('father_status');?> *</label>
                                <input type="text" class="form-control" id="father_status" name="father_status" placeholder="...">
                                <span class="error_field error_father_status"></span>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="mother"><?=$this->lang->line('mother');?></label>
                                <input type="text" class="form-control" id="mother" name="mother" placeholder="...">
                                <span class="error_field error_mother"></span>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="mother_status"><?=$this->lang->line('mother_status');?> *</label>
                                <input type="text" class="form-control" id="mother_status" name="mother_status" placeholder="...">
                                <span class="error_field error_mother_status"></span>
                            </div>
                        </div>
                    </div>
                </div>
                            <button type="submit" id="saveOperator" class="btn btn-primary">Enregistrer</button>
                <span id="failedMsg" class="error_field"></span>
                <div id="loadingSave" style="display:none;">
                    <img class="loading" src="<?= img('pulse.gif');?>"/>
                    Enregistrement ...
                </div>
            </form>
        </div>
        <!-- End Page Content -->
    </div>
    </div>

	<script src="<?= js('jquery.min');?>"></script>
  <script src="<?= plugin('bootstrap', 'js', 'bootstrap.bundle.min.js');?>"></script>
	<script src="<?= plugin('tabulator', 'js', 'tabulator.min.js');?>"></script>
	<script src="<?= plugin('modules', 'common', 'index.js');?>"></script>
</body>
</html>
