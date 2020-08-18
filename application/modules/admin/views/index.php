<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
  <link rel="icon" type="image/png" href="<?= img('favicon.png');?>" />
	<title>Loharano - Saisies des informations personnelles</title>
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
	<?= css('company_admin');?>

	<script src="https://code.iconify.design/1/1.0.4/iconify.min.js"></script>
</head>


<body class="loharano">

  <!-- Navigation -->

  <nav class="navbar navbar-expand-lg navbar-light bg-light static-top">
      <div class="logo-container">
        <img src="<?= img('sautRep.png');?>">
        <div class="separator"></div>
        <img src="<?= img('Logo-Loharano-mini.png');?>">
      </div>
      <div class="menu">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" href="tableau_menage" title="Tableau de bord">Tableau de bord des ménages</a>
          </li>
          <li class="nav-item separator"></li>
          <li class="nav-item active">
            <a class="nav-link" href="#" title="Sociétés de saisies">Tableau de bord des saisies</a>
          </li>
          <li class="nav-item separator-white"></li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <?=$this->lang->line('administrator');?>
              <span class="iconify" data-icon="uil:ellipsis-v" data-inline="false"></span>
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="registres_par_fokontany">Registres par fokontany</a>
              <a class="dropdown-item" href="#">Mon compte</a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="se_deconnecter">Se déconnecter</a>
            </div>
          </li>
        </ul>
      </div>
  </nav>

<!-- Page title -->
<div class="container-fluid page-title">
  <h1>Informations sur les saisies</span></h1>
    <button  type="submit" id="showNewFirm" class="btn btn-primary" data-toggle="modal" data-target="#newFirm">
      Nouveau compte société
    </button>
</div>

  <!-- Page Content -->
  <div class="container-fluid main-container">
    <div class="row">

      <!-- dashboard -->
      <div class="col-md-3">
        <ul class="dashboard-list">
          <li class="dashboard-item" id="fokontanyTreaty" data-toggle="modal" data-target="#listFokontanyTreaty">
            <span class="number"><?= format_number($number_fokontany_done);?></span>
            <span class="text">Fokontany traités</span>
          </li>
          <li class="dashboard-item"  id="fokontanyAffectedNeedTreat" data-toggle="modal" data-target="#listFokontanyAffectedNeedTreat">
            <span class="number"><?= format_number($total_fokontany_affected_pending);?></span>
            <span class="text">Fokontany affectés et à traiter</span>
					</li>
					<li class="dashboard-item"  id="fokontanyTreat">
            <span class="number"><?= format_number($total_fokontany_remainig_process);?></span>
            <span class="text">Fokontany restant à traiter</span>
					</li>
					<li class="dashboard-item" id="peopleTreaty" data-toggle="modal" data-target="#listPeopleTreaty">
            <span class="number"><?= format_number($number_population_done);?></span>
            <span class="text">Personnes traitées</span>
          </li>
					<li class="dashboard-item" id="peopleTreat">
            <span class="number"><?= format_number($number_population_pendind);?></span>
            <span class="text">Personnes à traiter</span>
          </li>
        </ul>
      </div><!-- end dashboard -->

      <!-- Firm list & infos -->
      <div class="col-md-4">
        <ul class="firm-list" id="firmContent">
          <?= (!empty($firm_item)) ? $firm_item : 'Traitement encours.';?>
        </ul>
      </div><!-- end firm list -->

      <div class="col-md-5">
        <div class="firm-infos">
          <!-- firm infos head -->
          <div class="firm-infos-head">
            <div class="head-left">
              <button type="submit" class="btn btn-more" id="littleBack" style="display: none;">
                <span class="iconify" data-icon="uil:arrow-left" data-inline="false"></span>
                Retour
              </button>
              <h5 id="companyName" class="companyName"><?= (empty($companies)) ? '...' : $companies[0]->company_name;?></h5>
            </div>
            <div class="head-right">
              <button type="submit" id="addRegister" class="btn btn-primary fnt-14">
                Nouvelle saisie
              </button>
              <div class="dropdown">
                <button type="submit" class="btn btn-more dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <span class="iconify" data-icon="uil:ellipsis-v" data-inline="false"></span>
                </button>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                  <a class="dropdown-item" href="#" id="analyticsCompany">Suivi des saisies</a>
                  <a class="dropdown-item" href="#" id="companyAccountDetails">Compte société</a>
                </div>
              </div>
            </div>
          </div>
          <!-- firm infos body -->
          <div id="loadingData" style="display: none;">
            <center>
              <img src="<?= img('loading.gif');?>"> Chargement ...
            </center>
          </div>
          <div id="pills-tabContent-popup" style="margin-top: 30px;"></div>
          <div class="firm-infos-body tab-content" id="pills-tabContent">
            <!-- Register infos -->
            <?= $firms_registers;?>
            <!-- end register infos -->
          </div>
        </div>
      </div><!-- end firm infos -->

    </div>

  <!-- Modal new firm -->
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
  <!-- Modal new firm - END -->
  <!-- Modal edit firm -->
  <div class="modal fade" id="editFirm">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">
            Compte de la société : <span id="editCompanyTitle"></span>
          </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="editAccountCompanyOperator">
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
          <button type="button" class="btn btn-primary" id="validEditCompanyAccount">
            Valider
            <span class="iconify" data-icon="uil:arrow-right" data-inline="false"></span>
          </button>
        </div>
      </div>
    </div>
  </div>
  <!-- Modal edit firm - END -->
  <!-- Modal new register -->
  <div class="modal fade" id="newRegister" tabindex="-1" role="dialog" aria-labelledby="newRegisterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="newRegisterTitle">
            Nouvelle saisie   :  <span class="companyName"><?= (empty($companies)) ? '...' : $companies[0]->company_name;?></span>
          </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-row">
            <div class="form-group col-md-4">
              <label for="n_province">Province</label>
              <select id="n_province" class="form-control">
                <?php foreach ($provinces as $province): ?>
                  <option value="<?= $province->id;?>"><?= $province->name;?></option>
                <?php endforeach ?>
              </select>
            </div>
            <div class="form-group col-md-4">
              <label for="n_region">Région</label>
              <select id="n_region" class="form-control">
                <?php foreach ($regions as $region): ?>
                  <option value="<?= $region->id;?>"><?= $region->name;?></option>
                <?php endforeach ?>
              </select>
            </div>
            <div class="form-group col-md-4">
              <label for="n_district">District</label>
              <select id="n_district" class="form-control">
                <?php foreach ($districts as $district): ?>
                  <option value="<?= $district->id;?>"><?= $district->name;?></option>
                <?php endforeach ?>
              </select>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-4">
              <label for="n_common">Commune</label>
              <select id="n_common" class="form-control">
                <?php foreach ($commons as $common): ?>
                  <option value="<?= $common->id;?>"><?= $common->name;?></option>
                <?php endforeach ?>
              </select>
            </div>
            <div class="form-group col-md-4">
              <label for="n_fokontany">Fokontany</label>
              <select id="n_fokontany" class="form-control">
                <?php foreach ($fkt_avilables as $fokotany): ?>
                  <option value="<?= $fokotany->id;?>"><?= $fokotany->name;?></option>
                <?php endforeach ?>
              </select>
            </div>
            <div class="form-group col-md-4 btn-ctnr">
              <button type="button" id="addFokontanyRegister" class="btn add align-self-end">
                <span class="iconify" data-icon="uil:plus" data-inline="false"></span>
                Ajouter
              </button>
            </div>
          </div>
          <div class="row" id="listCompanyRegister">
            <div class="col-md-12">
              <ul class="fkt">
                <?php
                  $tr = 0;
                  $tp = 0;
                  foreach ($company_fokontany as $cf):
                    $tr += $cf->nbr_register;
                    $tp += $cf->nbr_people;
                ?>
                  <li class="fkt-item">
                    <div class="text">
                      <span class="fkt-name"><?= $cf->fokontany_name;?></span>
                      <span class="fkt-nbr">Registres : <?= format_number($cf->nbr_register);?></span>
                      <span class="fkt-nbr">Personnes : <?= format_number($cf->nbr_people);?></span>
                    </div>
                    <div class="delete-btn" data-index="<?= $cf->fokontany_id;?>">
                      <span class="iconify" data-icon="uil:multiply" data-inline="false" class="fon-size:24px"></span>
                    </div>
                  </li>
                <?php endforeach ?>
              </ul>
            </div>
            <div class="col-md-12">
              <div class="fkt-total">
                <span class="nbr"><?= format_number($tr);?> registres</span>
                <span>-</span>
                <span class="nbr"><?= format_number($tp);?> populations</span>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">
            Annuler
            <span class="iconify" data-icon="uil:times-circle" data-inline="false"></span>
          </button>
          <a href="tableau_bord" ><button type="button" class="btn btn-primary">
            Valider
            <span class="iconify" data-icon="uil:arrow-right" data-inline="false"></span>
          </button></a>
        </div>
      </div>
    </div>
  </div>
  <!-- Modal new register - END -->
	<!-- Modal fokontany treaty  -->
	<div class="modal fade" id="listFokontanyTreaty" tabindex="-1" role="dialog" aria-labelledby="listFokontanyTreatyTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="listFokontanyTreatyTitle">
            Liste des fokontany traités
          </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
					<div id="loadingData" style="display: none;">
						<center>
							<img src="<?= img('loading.gif');?>"> Chargement ...
						</center>
					</div>
					<div id="fokontanyTreaty-table"></div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">
						Fermer
						<span class="iconify" data-icon="uil:times-circle" data-inline="false"></span>
					</button>
				</div>
			</div>
    </div>
  </div>
	<!-- Modal fokontany treaty - END -->

	<!-- Modal fokontany to process  -->
	<div class="modal fade" id="listFokontanyAffectedNeedTreat" tabindex="-1" role="dialog" aria-labelledby="listFokontanyTreatyTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="listFokontanyAffectedNeedTreatTitle">
            Liste des fokontany traités
          </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
					<div id="loadingData" style="display: none;">
						<center>
							<img src="<?= img('loading.gif');?>"> Chargement ...
						</center>
					</div>
					<div id="fokontanyProcess-table"></div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">
						Fermer
						<span class="iconify" data-icon="uil:times-circle" data-inline="false"></span>
					</button>
				</div>
			</div>
    </div>
  </div>
	<!-- Modal fokontany to process - END -->

	<!-- Modal personne treaty -->
	<div class="modal fade" id="listPeopleTreaty" tabindex="-1" role="dialog" aria-labelledby="listPeopleTreatyTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="listPeopleTreatyTitle">
            Liste des personnes traitées
          </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
					<div id="loadingData" style="display: none;">
						<center>
							<img src="<?= img('loading.gif');?>"> Chargement ...
						</center>
					</div>
					<div id="personTreaty-table"></div>
				</div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">
            Fermer
            <span class="iconify" data-icon="uil:times-circle" data-inline="false"></span>
          </button>
        </div>
      </div>
    </div>
  </div>
	<!-- Modal personne treaty - END -->
	<!-- Modal personne treaty -->
	<div class="modal fade" id="listPeopleTreatyDaily" tabindex="-1" role="dialog" aria-labelledby="listPeopleTreatyDailyTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="listPeopleTreatyDailyTitle">
            Liste des personnes traitées
          </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
					<div id="personTreatyDaily-table"></div>
				</div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">
            Fermer
            <span class="iconify" data-icon="uil:times-circle" data-inline="false"></span>
          </button>
        </div>
      </div>
    </div>
  </div>
	<!-- Modal personne treaty - END -->
  </div><!-- End page Content -->
	<script src="<?= js('jquery.min');?>"></script>
  <script src="<?= plugin('bootstrap', 'js', 'bootstrap.bundle.min.js');?>"></script>
	<script src="<?= plugin('tabulator', 'js', 'tabulator.min.js');?>"></script>
	<script src="<?= plugin('modules', 'admin', 'index.js');?>"></script>
	<script src="<?= plugin('modules', 'admin', 'popup_list.js');?>"></script>
<div id="appVersion"> Loharano Fokontany, version <?= APP_VERSION;?> &copy; <a href="https://digital.gov.mg" target="_blank">e-Gouvernance Madagascar</a> - <?= date("Y");?></div>
</body>
</html>
