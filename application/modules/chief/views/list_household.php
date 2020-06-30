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
            <?=$this->session->user_name;?>
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
            <ul class="sub-main-menu" style="display:none;">
              <li><a href="ajout_utilisateur_fokontany"><?=$this->lang->line('add_citizen');?></a></li>
              <li><a href="liste_utilisateur_fokontany"><?=$this->lang->line('list_citizen');?></a></li>
            </ul>
          </li>
          <li>
            <a href="#"><span class="iconify" data-icon="fa-solid:user" data-inline="false"></span> <?=$this->lang->line('households');?></a>
            <ul class="sub-main-menu">
              <li><a href="liste_menage_fokontany" class="active">Liste des ménages</a></li>
            </ul>
          </li>
          <li>
            <a href="#"><span class="iconify" data-icon="bi:people-fill" data-inline="false"></span> Citoyens</a>
            <ul class="sub-main-menu" style="display:none;">              
              <li><a href="chef_liste_citoyen">Liste des Citoyens</a></li>
            </ul>
          </li>
        </ul>
      </div>
      <div class="main-container admin-container">
        <!-- Page title -->
        <div class="container-fluid">
          <p class="info-fokontany">
              <span><span class="iconify" data-icon="ic:baseline-place" data-inline="false"></span> Province : </span>
              <?= $info_borough->province_name;?>
              <span><span class="iconify" data-icon="ic:baseline-place" data-inline="false"></span> Région : </span>
              <?= $info_borough->region_name;?>
              <span><span class="iconify" data-icon="ic:baseline-place" data-inline="false"></span> District : </span>
              <?= $info_borough->district_name;?>
              <span><span class="iconify" data-icon="ic:baseline-place" data-inline="false"></span> Commune : </span>
              <?= $info_borough->common_name;?>
              <span><span class="iconify" data-icon="ic:baseline-place" data-inline="false"></span> Arrondissement : </span>
              <?= $info_borough->borough_name;?>
          </p>
        </div>
        <div class="container-fluid page-title">
          <h1><?= $title;?></h1>
        </div>
        <!-- End Page title -->

        <!-- Page Content -->
        <div class="container-fluid">
          <div class="row">
              <div class="col-lg-12">
                  <div class="form-row">
                    <div class="form-group col-md-12">
                      Filtre par Fokontany :
                    </div>
                    <div class="form-group col-md-12">
                      <label for="fokontany">Fokontany</label>
                      <select id="fokontany" name="fokontany" class="form-control">
                        <?php foreach ($fokontanies as $fokontany): ?>
                          <option value="<?= $fokontany->id;?>"><?= $fokontany->name;?></option>
                        <?php endforeach ?>
                      </select>
                      <span class="error_field error_fokontany_id"></span>
                    </div>
                    <div class="form-group col-md-6">
                      <div id="loadingLocation" style="display:none;">
                        <img class="loading" src="<?= img('pulse.gif');?>"/>
                        Chargement ...
                      </div>
                    </div>
                  </div>
              </div>
            <div class="col-lg-12">
              <p><?= $this->lang->line('household_click_for_details');?></p>
              <div id="households"></div>
            </div>
            <div class="col-lg-12">
              <p><?= $this->lang->line('household_content');?></p>
              <div id="householdContent"></div>
            </div>
          </div>           
        </div>
        <!-- End Page Content -->
      </div>
    </div>
  </div>

	<script src="<?= js('jquery.min');?>"></script>
  <script src="<?= plugin('bootstrap', 'js', 'bootstrap.bundle.min.js');?>"></script>
	<script src="<?= plugin('tabulator', 'js', 'tabulator.min.js');?>"></script>
	<script src="<?= plugin('modules', 'common', 'index.js');?>"></script>
	<script src="<?= plugin('modules', 'chief', 'list_household.js');?>"></script>
</body>
</html>
