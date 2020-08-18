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
              <div class="row">
                <div class="col-lg-6">
                  <div class="line-bloc">
                    <h6>Rapport global</h6>
                    <div class="container-bloc-link">
                      <a href="#" class="bloc-link color-7">
                        <span class="count"><?= $household_count;?></span> Ménages
                      </a>
                      <a href="#" class="bloc-link color-7">
                        <span class="count"><?= $citizen_count;?></span> Citoyens
                      </a>
                    </div>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="line-bloc">
                    <h6>Indicateurs démographiques</h6>
                    <div class="container-bloc-link">
                      <a href="#" class="bloc-link color-6" data-toggle="tooltip" data-placement="bottom" data-html="true" title="<ul class='m-0'><li>Moyenne d'age des hommes : <strong><?=$male_avg_age;?></strong></li><li>Moyenne d'age des femmes : <strong><?=$female_avg_age;?></strong></li></ul>">
                        <span class="pourcent"><?= $male_ratio;?>% / <?= $female_ratio;?>%</span> Hommes/Femmes
                      </a>
                      <a href="#" class="bloc-link color-6" data-toggle="tooltip" data-placement="bottom" data-html="true" title="<ul class='m-0'><li>Nombre de mineurs masculins : <strong><?=$minor_male;?></strong></li><li>Nombre de mineurs féminins : <strong><?=$minor_female;?></strong></li><li>Nombre de majeurs masculins : <strong><?=$major_male;?></strong></li><li>Nombre de majeurs féminins : <strong><?=$major_female;?></strong></li></ul>">
                        <span class="pourcent"><?= $minor_ratio;?>% / <?= $major_ratio;?>%</span> Mineurs/Majeurs
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-12">
              <div class="row">
                <div class="col-lg-12">
                  <div class="line-bloc">
                    <h6>Nombre de certificats générés ce mois</h6>
                    <div class="container-bloc-link">
                      <a href="#" class="bloc-link color-6">
                        <span class="count"><?= $nbr_total;?></span> Total
                      </a>
                      <a href="#" class="bloc-link color-7">
                        <span class="count"><?= $nbr_certificate[0];?></span> Résidence
                      </a>
                      <a href="#" class="bloc-link color-7">
                        <span class="count"><?= $nbr_certificate[1];?></span> Déménagement
                      </a>
                      <a href="#" class="bloc-link color-7">
                        <span class="count"><?= $nbr_certificate[2];?></span> Célibat
                      </a>
                      <a href="#" class="bloc-link color-7">
                        <span class="count"><?= $nbr_certificate[3];?></span> Vie individuelle
                      </a>
                      <a href="#" class="bloc-link color-7">
                        <span class="count"><?= $nbr_certificate[4];?></span> Prise en charge/garde
                      </a>
                      <a href="#" class="bloc-link color-7">
                        <span class="count"><?= $nbr_certificate[5];?></span> Bonne conduite
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-12">
              <div class="line-bloc">
                <h6>Accès rapide</h6>
                <div class="container-bloc-link">
                  <a href="ajout_de_chef" class="bloc-link color-2">
                    <span class="iconify" data-icon="ri:user-add-line" data-inline="false"></span> Ajout Chef District
                  </a>
                  <a href="liste_des_chefs" class="bloc-link color-6">
                    <span class="iconify" data-icon="ant-design:unordered-list-outlined" data-inline="false"></span> <?=$this->lang->line('list_chiefs');?>
                  </a>
                  <a href="ajout_utilisateur" class="bloc-link color-1">
                    <span class="iconify" data-icon="ant-design:user-add-outlined" data-inline="false"></span> <?=$this->lang->line('add_user');?>
                  </a>
                  <a href="liste_utilisateur" class="bloc-link color-3">
                  <span class="iconify" data-icon="ant-design:unordered-list-outlined" data-inline="false"></span> <?=$this->lang->line('list_users');?>
                  </a>
                  <a href="la_liste_citoyens" class="bloc-link color-5">
                    <span class="iconify" data-icon="ant-design:unordered-list-outlined" data-inline="false"></span> Liste des Citoyens
                  </a>
                  <a href="list_menage" class="bloc-link color-4">
                    <span class="iconify" data-icon="ant-design:unordered-list-outlined" data-inline="false"></span> Liste des Ménages
                  </a>
                  <a href="gestion_des_aides" class="bloc-link color-7">
                    <span class="iconify" data-icon="dashicons:products" data-inline="false"></span> Aides sociales
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- End Page Content -->
      </div>
    </div>
  </div>

  <!-- Modal -->
  <div class="modal fade" id="newFirm" tabindex="-1" role="dialog" aria-labelledby="newFirmTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="newFirmTitle">
            Nouveau compte société
          </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="accountCompanyOperator">
            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="n_company">Société</label>
                <input type="text" id="n_company" name="n_company" class="form-control">
                <div class="errorField" id="error_n_company"></div>
              </div>
              <div class="form-group col-md-6">
                <label for="n_email">Mail</label>
                <input type="text" id="n_email" name="n_email" class="form-control">
                <div class="errorField" id="error_n_email"></div>
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="n_password">Mot de passe</label>
                <input type="password" id="n_password" name="n_password" class="form-control">
                <div class="errorField" id="error_n_password"></div>
              </div>
              <div class="form-group col-md-6">
                <label for="n_confirm_pwd">Confirmation mot de passe</label>
                <input type="password" id="n_confirm_pwd" name="n_confirm_pwd" class="form-control">
                <div class="errorField" id="error_n_confirm_pwd"></div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <h5 class="modal-sub-title">Compte opérateur de saisie</h5>
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="no_operator">Opérateur</label>
                <input type="text" id="no_operator" name="no_operator" class="form-control">
                <div class="errorField" id="error_no_operator"></div>
              </div>
              <div class="form-group col-md-6">
                <label for="no_email">Mail</label>
                <input type="text" id="no_email" name="no_email" class="form-control">
                <div class="errorField" id="error_no_email"></div>
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="no_password">Mot de passe</label>
                <input type="password" id="no_password" name="no_password" class="form-control">
                <div class="errorField" id="error_no_password"></div>
              </div>
              <div class="form-group col-md-6">
                <label for="no_confirm_pwd">Confirmation mot de passe</label>
                <input type="password" id="no_confirm_pwd" name="no_confirm_pwd" class="form-control">
                <div class="errorField" id="error_no_confirm_pwd"></div>
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <div id="loadingDataCompany" style="display: none;">
            <center>
              <img src="<?= img('loading.gif');?>"> Chargement ...
            </center>
          </div>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">
            Annuler
            <span class="iconify" data-icon="uil:times-circle" data-inline="false"></span>
          </button>
          <button type="button" class="btn btn-primary" id="validCompanyAccount">
            Valider
            <span class="iconify" data-icon="uil:arrow-right" data-inline="false"></span>
          </button>
        </div>
      </div>
    </div>
  </div>
  <!-- Modal END -->
	<script src="<?= js('jquery.min');?>"></script>
  <script src="<?= plugin('bootstrap', 'js', 'bootstrap.bundle.min.js');?>"></script>
	<script src="<?= plugin('tabulator', 'js', 'tabulator.min.js');?>"></script>
	<script src="<?= plugin('modules', 'common', 'index.js');?>"></script>
  <script>
    $('.bloc-link').tooltip({ boundary: 'window' });
  </script>
<div id="appVersion"> Loharano Fokontany, version <?= APP_VERSION;?> &copy; <a href="https://digital.gov.mg" target="_blank">e-Gouvernance Madagascar</a> - <?= date("Y");?></div>
</body>
</html>
