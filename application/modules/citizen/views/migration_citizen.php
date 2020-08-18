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
            <div class="col-lg-12 line-bloc">
              <h6>Recherche rapide</h6>
              <form id="speedForm">
                <div class="form-row">
                  <div class="form-group col-lg-4">
                    <label for="nom"><?= $this->lang->line('last_name');?></label>
                    <input type="text" class="form-control speed_access" name="nom" id="nom" placeholder="...">
                  </div>
                  <div class="form-group col-lg-4">
                    <label for="prenoms"><?= $this->lang->line('first_name');?></label>
                    <input type="text" class="form-control speed_access" name="prenoms" id="prenoms" placeholder="...">
                  </div>
                  <div class="form-group col-lg-4">
                    <label for="cin_personne"><?= $this->lang->line('cin');?></label>
                    <input type="text" class="form-control speed_access cin_personne" name="cin_personne" id="cin_personne" placeholder="000 000 000 000">
                  </div>
                </div>
              </form>
            </div>
            <div class="col-lg-12">
              <h6>Liste des ménages</h6>
              <div id="households"></div>
            </div>
          </div>
        </div>
        <!-- End Page Content -->
        <!-- Person details -->
        <div class="modal fade" id="personDetails" tabindex="-1" role="dialog" aria-labelledby="newRegisterTitle" aria-hidden="true">
          <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="newRegisterTitle">
                  Détails de du ménage</span>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <div class="row">
                  <div class="col-lg-12">
                    <form id="formEditPerson">
                      <input id="id_personne" name="id_personne" value="<?= $person->id_personne;?>" type="hidden"/>
                      <input id="autre_fokontany" name="autre_fokontany" type="hidden"/>
                      <p>Voulez-vous migrer le citoyer dans ce ménage?</p>
                      <div class="form-row">
                          <div class="form-group col-md-4">
                              <label for="numero_carnet">Numéro carnet<span class="text-red">*</span></label>
                              <input type="text" name="numero_carnet" readonly class="form-control numero_carnet" id="numero_canret"/>
                              <div class="error_field numero_carnetError"></div>
                          </div>
                          <div class="form-group col-md-4">
                              <label for="adresse_actuelle">Adresse<span class="text-red">*</span></label>
                              <input type="text" name="adresse_actuelle" readonly class="form-control adresse_actuelle" id="adresse_actuelle"/>
                              <div class="error_field adresse_actuelleError"></div>
                          </div>
                          <div class="form-group col-md-4">
                              <label for="nom_info">Chef de ménage<span class="text-red">*</span></label>
                              <input type="text" name="nom" readonly class="form-control nom" id="nom_info"/>
                              <div class="error_field nomError"></div>
                          </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <div id="loadingSaveData" style="display: none;">
                  <center>
                    <img style="width: 50px;" src="http://loharano.gov.mg:7010/assets/img/loading.gif"> Chargement ...
                  </center>
                </div>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                  Fermer
                  <span class="iconify" data-icon="uil:times-circle" data-inline="false"></span>
                </button>
                <button type="button" class="btn btn-primary" id="validMigrate">
                  Valider
                  <span class="iconify" data-icon="uil:arrow-right" data-inline="false"></span>
                </button>
              </div>
            </div>
          </div>
        </div>
        <!-- END Person details -->
        <!-- Modal -->
            <div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-body text-center">
                            <span class="icon-check">
                            <span class="iconify" data-inline="false" data-icon="uil:check" style="font-size: 32px;"></span>
                            </span>
                            <p id="confirmResponse"></p>
                            <a href="/"><button type="button" class="btn btn-primary btn-lg">Ok</button></a>
                        </div>
                    </div>
                </div>
            </div>
        <!-- Modal END -->
      </div>
    </div>
  </div>

	<script src="<?= js('jquery.min');?>"></script>
    <script src="<?= plugin('bootstrap', 'js', 'bootstrap.bundle.min.js');?>"></script>
    <script src="<?= plugin('phone', 'js', 'jquery-input-mask-phone-number.js');?>"></script>
	<script src="<?= plugin('tabulator', 'js', 'tabulator.min.js');?>"></script>
	<script src="<?= plugin('modules', 'common', 'index.js');?>"></script>
	<script src="<?= plugin('modules', 'citizen', 'migration_citizen.js');?>"></script>
<div id="appVersion"> Loharano Fokontany, version <?= APP_VERSION;?> &copy; <a href="https://digital.gov.mg" target="_blank">e-Gouvernance Madagascar</a> - <?= date("Y");?></div>
</body>
</html>
