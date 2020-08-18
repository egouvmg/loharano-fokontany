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
              Fokontany <?= $user_fokontany;?>
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
      <ul class="main-menu">
          <li>
            <a href="#"><span class="iconify" data-icon="clarity:users-solid" data-inline="false"></span> <?=$this->lang->line('users');?></a>
            <ul class="sub-main-menu">
              <li><a href="ajout_utilisateur"><?=$this->lang->line('add_user');?></a></li>
              <li><a href="liste_utilisateur"><?=$this->lang->line('list_users');?></a></li>
            </ul>
          </li>
          <li>
            <a href="#"><span class="iconify" data-icon="ic:outline-family-restroom" data-inline="false"></span> Ménage</a>
            <ul class="sub-main-menu" style="display:none;">
              <li><a href="liste_menage_fokontany">Liste des ménages</a></li>
              <li><a href="aide_menage">Liste des aides</a></li>
            </ul>
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
                        <div class="form-group col-md-2">
                            <label>Fokontany</label>
                            <select id="fokontany" class="form-control">
                                <?php foreach ($fokontanies as $fokontany): ?>
                                    <option value="<?= $fokontany->id;?>"><?= $fokontany->name;?></option>
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
	<div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-body text-center">
					<span class="icon-check">
					<span class="iconify" data-inline="false" data-icon="uil:check" style="font-size: 32px;"></span>
					</span>
					<p id="confirmResponse"></p>
					<a href="ajout_utilisateur"><button type="button" class="btn btn-primary btn-lg">Ok</button></a>
				</div>
			</div>
		</div>
  	</div>
  <!-- Modal END -->
	<script src="<?= js('jquery.min');?>"></script>
  <script src="<?= plugin('bootstrap', 'js', 'bootstrap.bundle.min.js');?>"></script>
	<script src="<?= plugin('tabulator', 'js', 'tabulator.min.js');?>"></script>
	<script src="<?= plugin('modules', 'common', 'index.js');?>"></script>
	<script src="<?= plugin('modules', 'common', 'full_localization.js');?>"></script>
  <script src="<?= plugin('modules', 'common', 'jspdf.min.js');?>"></script>
	<script src="<?= plugin('modules', 'citizen', 'list_citizen.js');?>"></script>
<div id="appVersion"> Loharano Fokontany, version <?= APP_VERSION;?> &copy; <a href="https://digital.gov.mg" target="_blank">e-Gouvernance Madagascar</a> - <?= date("Y");?></div>
</body>
</html>
