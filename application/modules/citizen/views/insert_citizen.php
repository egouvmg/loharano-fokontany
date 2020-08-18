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

  <div class="container-fluid">
    <div class=row>
      <div class="main-side-bar">
        <ul class="main-menu">
          <li>
            <a href="gestion_citoyens"><span class="iconify" data-icon="bi:people-fill" data-inline="false"></span> <?=$this->lang->line('citizens');?></a>
            <ul class="sub-main-menu">
              <li><a href="recherche_menage" class="active"><?=$this->lang->line('add_citizen');?></a></li>
              <li><a href="liste_citoyens"><?=$this->lang->line('list_citizen');?></a></li>
            </ul>
          </li>
          <li>
            <a href="#"><span class="iconify" data-icon="fa-solid:user" data-inline="false"></span> <?=$this->lang->line('households');?></a>
            <ul class="sub-main-menu" style="display:none;">
              <li><a href="liste_menage_fokontany">Liste des ménages</a></li>
              <li><a href="#">Créer nouveau menage</a></li>
            </ul>
          </li>
          <li>
            <a href="#"><span class="iconify" data-icon="ant-design:setting-filled" data-inline="false"></span> <?=$this->lang->line('settings');?></a>
          </li>
        </ul>
      </div>
      <div class="main-container">
        <!-- Page title -->
        <p class="info-fokontany"><span>Province : </span><?= $info_fokontany->province_name;?> <span>Région : </span><?= $info_fokontany->region_name;?> <span>District : </span><?= $info_fokontany->district_name;?> <span>Commune : </span><?= $info_fokontany->common_name;?></p>
        <div class="container-fluid page-title">
          <h1><?= $title;?></h1>
        </div>
        <!-- End Page title -->

        <!-- Page Content -->
        <div class="container-fluid">
          <div class="row">
            <div class="col-lg-12">
            <?= $this->lang->line('number_notebook');?> : <?= $this->session->reference;?> <?= $this->lang->line('address');?> : <?= $this->session->address;?> <?= $this->lang->line('household_size');?> : <?= $this->session->household_size;?>
            </div>
          </div>
          <form id="addCitizen">
              <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                <?= $tabs_link;?>
              </ul>
              <div class="tab-content" id="pills-tabContent">
                <?= $tabs_content;?>
              </div>
          </form>
          <button id="nextCitizen" class="btn btn-primary"><?= $this->lang->line('next_citizen');?></button>
          <button id="previousCitizen" class="btn btn-primary"><?= $this->lang->line('previous_citizen');?></button>
          <div class="float-right">
            <a href="nouveau_menage_fokontany"><button class="btn btn-primary">Retour au localité</button></a>
            <button id="saveOperator" class="btn btn-primary">Enregistrer</button>
            <span id="failedMsg" class="error_field"></span>
            <div id="loadingSave" style="display:none;">
                <img class="loading" src="<?= img('pulse.gif');?>"/>
                Enregistrement ...
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
                <a href="liste_citoyens"><button type="button" class="btn btn-primary btn-lg">Ok</button></a>
              </div>
            </div>
          </div>
        </div>
        
        <div class="modal fade" id="failedModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-body text-center">
                <span class="icon-check">
                <span class="iconify" data-icon="si-glyph:button-error" style="font-size: 32px;" data-inline="false"></span>
                </span>
                <p id="failedResponse"></p>
                <button type="button" class="btn btn-primary btn-lg">Ok</button>
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
	<script src="<?= plugin('modules', 'citizen', 'insert_citizen.js');?>"></script>
<div id="appVersion"> Loharano Fokontany, version <?= APP_VERSION;?> &copy; <a href="https://digital.gov.mg" target="_blank">e-Gouvernance Madagascar</a> - <?= date("Y");?></div>
</body>
</html>
