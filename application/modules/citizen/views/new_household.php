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
              <a class="dropdown-item" href="se_deconnecter"><?= $this->lang->line('logout');?></a>
            </div>
          </li>
        </ul>
      </div>
  </nav>

  <div class="container">
    <div class=row>
      <div class="main-container">
        <!-- Page title -->
        <div class="text-center">
          <p class="info-fokontany">
            <span>Province : </span><?= $info_fokontany->province_name;?>
            <span>Région : </span><?= $info_fokontany->region_name;?>
            <span>District : </span><?= $info_fokontany->district_name;?>
            <span>Commune : </span><?= $info_fokontany->common_name;?>
            <span>Arrondissement : </span><?= $info_fokontany->borough_name;?>
            <span>Fokontany : </span><?= $info_fokontany->fokontany_name;?>
          </p>
        </div>
        <div class="container page-title">
          <h1 class="float-left">Création de nouveau ménage</h1>
        </div>
          <a href="/" class="float-right mx-2"><button class="btn btn-warning"><span class="iconify" data-icon="ion:caret-back-circle-outline" data-inline="false"></span> Tableau de bord</button></a>
          <a href="liste_menage_fokontany" class="float-right"><button class="btn btn-warning"><span class="iconify" data-icon="ion:caret-back-circle-outline" data-inline="false"></span> Liste de ménages</button></a>
        <!-- End Page title -->

        <!-- Page Content -->
        <div class="container">
            <div class="row">
                <div class="col-lg-12 orange">
                    <p><?= $this->lang->line('locality_household');?></p>
                </div>
                <div class="col-lg-12">
                    <form id="localityHousehold">
                      <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="address"><?=$this->lang->line('address');?> *</label>
                            <input type="text" class="form-control" id="address" value="<?= $address;?>" name="address" placeholder="...">
                            <span class="error_field error_address"></span>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="locality">Secteur/Localité *</label>
                            <input type="text" class="form-control" id="locality" value="<?= $address;?>" name="locality" placeholder="...">
                            <span class="error_field error_locality"></span>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="household_size"><?=$this->lang->line('household_size');?> *</label>
                            <input type="text" class="form-control" id="household_size" value="<?= $household_size;?>" name="household_size" placeholder="...">
                            <span class="error_field error_household_size"></span>
                        </div>
                        <button type="submit" id="saveLocalityHousehold" class="btn btn-primary"><?= $this->lang->Line('next');?></button>
                        <span id="failedMsg" class="error_field"></span>
                        <div id="loadingSave" style="display:none;">
                            <img class="loading" src="<?= img('pulse.gif');?>"/>
                            Enregistrement ...
                        </div>
                      </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- End Page Content -->
        
        <!-- Modal -->
        <div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-body text-center">
                <span class="icon-check">
                <span class="iconify" data-inline="false" data-icon="uil:check" style="font-size: 32px;"></span>
                </span>
                <p id="confirmResponse"></p>
                <a href="recherche_menage"><button type="button" class="btn btn-primary btn-lg">Ok</button></a>
              </div>
            </div>
          </div>
        </div>
        <!-- Modal END -->
    </div>
    </div>

	<script src="<?= js('jquery.min');?>"></script>
  <script src="<?= plugin('bootstrap', 'js', 'bootstrap.bundle.min.js');?>"></script>
	<script src="<?= plugin('tabulator', 'js', 'tabulator.min.js');?>"></script>
	<script src="<?= plugin('modules', 'common', 'index.js');?>"></script>
	<script src="<?= plugin('modules', 'citizen', 'new_household.js');?>"></script>
<div id="appVersion"> Loharano Fokontany, version <?= APP_VERSION;?> &copy; <a href="https://digital.gov.mg" target="_blank">e-Gouvernance Madagascar</a> - <?= date("Y");?></div>
</body>
</html>
