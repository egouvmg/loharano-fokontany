<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
  <link rel="icon" type="image/png" href="<?= img('favicon.png');?>" />
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
              <?=$this->lang->line('administrator');?>
              <span class="iconify" data-icon="uil:ellipsis-v" data-inline="false"></span>
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="#">Mon compte</a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="se_deconnecter">Se déconnecter</a>
            </div>
          </li>
        </ul>
      </div>
  </nav>

  <div class="container-fluid">
    <div class=row>
      <div class="main-side-bar">
        <?= $side_main_menu;?>
      </div>
      <div class="main-container admin-container">
        <!-- Page title --> 
        <div class="container-fluid page-title">
          <h1><?= $title;?></h1>
        </div>
        <!-- End Page title -->

        <!-- Page Content -->
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <!-- Location Filter-->
                    <div class="form-row">
                        <div class="form-group col-md-2">
                            <label>Province</label>
                            <select id="province" class="form-control">
                                <?php foreach ($provinces as $province): ?>
                                    <option value="<?= $province->id;?>"><?= $province->name;?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="form-group col-md-2">
                            <label>Région</label>
                            <select id="region" class="form-control">
                                <?php foreach ($regions as $region): ?>
                                    <option value="<?= $region->id;?>"><?= $region->name;?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="form-group col-md-2">
                            <label>District</label>
                            <select id="district" class="form-control">
                                <?php foreach ($districts as $district): ?>
                                    <option value="<?= $district->id;?>"><?= $district->name;?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="form-group col-md-2">
                            <label>Commune</label>
                            <select id="common" class="form-control">
                                <?php foreach ($commons as $common): ?>
                                    <option value="<?= $common->id;?>"><?= $common->name;?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="form-group col-md-2">
                            <label>Arrondissement</label>
                            <select id="borough" class="form-control">
                                <?php foreach ($boroughs as $borough): ?>
                                    <option value="<?= $borough->id;?>"><?= $borough->name;?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>
                    <!-- Location -->
                </div>
                <div class="col-lg-12">
                    <div id="users"></div>
                </div>
            </div>
        </div>
        <!-- End Page Content -->
      </div>
    </div>
  </div>

  
  <!-- Modal -->
	<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-body">
          <form id="editForm">
          <div class="form-row">
            <div class="form-group col-md-12">
              Informations du compte utilisateur Fokontany
            </div>
            <div class="form-group col-md-6">
              <label for="first_name">Nom</label>
              <input type="text" class="form-control" id="first_name" name="first_name" placeholder="...">
              <span class="error_field error_first_name"></span>
            </div>
            <div class="form-group col-md-6">
              <label for="email">Email</label>
              <input type="text" class="form-control" id="email" readonly placeholder="...">
              <span class="error_field error_email"></span>
            </div>
            <div class="form-group col-md-6">
              <label for="phone">Téléphones</label>
                <input type="text" class="form-control" id="phone" name="phone" placeholder="...">
                <span class="error_field error_phone"></span>
            </div>
            <div class="form-group col-md-6">
              <label for="address">Adresse</label>
              <input type="text" class="form-control" id="address" name="address" placeholder="...">  
              <span class="error_field error_address"></span>
            </div>
            <input type="hidden" name="email" id="currentEmail"/>
            <input type="hidden" name="old_pwd" id="old_pwd"/>
            <div class="form-group col-md-6">
              <label for="password">Mot de passe</label>
              <input type="text" class="form-control" id="password" name="password" placeholder="...">  
              <span class="error_field error_password"></span>
            </div>
            <div class="col-lg-12">
              <button type="submit" id="editOperator" class="btn btn-primary">Enregistrer</button>
              <span id="failedMsg" class="error_field"></span>
              <div id="loadingSave" style="display:none;">
                <img class="loading" src="<?= img('pulse.gif');?>"/>
                Enregistrement ...
              </div>
            </div>
          </div>
          </form>
        </div>
			</div>
		</div>
  </div>

    <!-- Modal -->
    <div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <span class="icon-check">
                    <span class="iconify" data-inline="false" data-icon="uil:check" style="font-size: 32px;"></span>
                    </span>
                    <p id="confirmResponse"></p>
                    <a href="liste_des_chefs"><button type="button" class="btn btn-primary btn-lg">Ok</button></a>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal END -->
    <script src="<?= js('jquery.min');?>"></script>
    <script src="<?= plugin('bootstrap', 'js', 'bootstrap.bundle.min.js');?>"></script>
    <script src="<?= plugin('phone', 'js', 'jquery-input-mask-phone-number.js');?>"></script>
    <script src="<?= plugin('tabulator', 'js', 'tabulator.min.js');?>"></script>
    <script src="<?= plugin('modules', 'common', 'index.js');?>"></script>
    <script src="<?= plugin('modules', 'superadmin', 'list_chief.js');?>"></script>
<div id="appVersion"> Loharano Fokontany, version <?= APP_VERSION;?> &copy; <a href="https://digital.gov.mg" target="_blank">e-Gouvernance Madagascar</a> - <?= date("Y");?></div>
</body>
</html>
