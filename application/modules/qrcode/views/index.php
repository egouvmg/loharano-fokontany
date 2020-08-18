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
            <span>Fokontany : </span><?= $info_fokontany->fokontany_name;?></p>
        </div>
        <div class="container page-title">
          <h1><?= $title;?></h1><a href="gestion_citoyens"><button class="btn float-right btn-warning"><span class="iconify" data-icon="ion:caret-back-circle-outline" data-inline="false"></span> Retour</button></a>
        </div>
        <!-- End Page title -->

        <!-- Page Content -->
        <div class="container">
          <div class="row">
            <div class="col-lg-12">
              <p><?= $this->lang->line('household_aid_for_details');?></p>
              <div id="households"></div>
            </div>
            <div class="col-lg-12">
              <p><?= $this->lang->line('household_aid_content');?> : <strong class="household">...</strong></p>
              <button id="addAid" class="btn btn-color-2 mb-1">Ajout une aide</button>
              <div id="aidsContent"></div>
            </div>
          </div>           
        </div>
        <!-- End Page Content -->
      </div>
    </div>
  </div>

  <!-- Aid details -->
  <div class="modal fade" id="aidModal" tabindex="-1" role="dialog" aria-labelledby="aidTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="aidTitle">
            Ajout d'aide pour le ménage   :  <span class="household"></span>
          </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="aidForm">
            <input id="numero_carnet" name="numero_carnet" type="hidden"/>
            <div class="row">
              <!--Form at left side -->
              <div class=" col-md-12">
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label for="aid">Programme d'aide</label>
                    <select id="aid" class="form-control"  name="aid_id">
                      <?php foreach ($aids as $aid): ?>
                        <option value="<?= $aid->id;?>"><?= $aid->name;?></option>
                      <?php endforeach ?>
                    </select>
                    <div class="error_field error_aid"></div>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="created_on">Reçu le<span class="text-red">*</span></label>
                    <input type="date" name="created_on" class="form-control" id="created_on"/>
                    <div class="error_field error_created_on"></div>
                  </div>
                </div>
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">
            Fermer
            <span class="iconify" data-icon="uil:times-circle" data-inline="false"></span>
          </button>
          <button type="button" class="btn btn-primary" id="validAid">
            Valider
            <span class="iconify" data-icon="uil:arrow-right" data-inline="false"></span>
          </button>
          <div id="loadingSave" style="display:none;">
            <img class="loading" src="<?= img('pulse.gif');?>"/>
            Enregistrement ...
          </div>
        </div>
      </div>
    </div>
  </div>

 <!-- End Aid details -->

	<script src="<?= js('jquery.min');?>"></script>
  <script src="<?= plugin('bootstrap', 'js', 'bootstrap.bundle.min.js');?>"></script>
	<script src="<?= plugin('tabulator', 'js', 'tabulator.min.js');?>"></script>
	<script src="<?= plugin('modules', 'common', 'index.js');?>"></script>
	<script src="<?= plugin('modules', 'aid', 'list_aid.js');?>"></script>
<div id="appVersion"> Loharano Fokontany, version <?= APP_VERSION;?> &copy; <a href="https://digital.gov.mg" target="_blank">e-Gouvernance Madagascar</a> - <?= date("Y");?></div>
</body>
</html>
