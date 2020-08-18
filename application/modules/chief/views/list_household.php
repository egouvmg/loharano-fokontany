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
            <?=$this->session->user_name;?>
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
            <!-- Person details -->       
    <div class="modal fade" id="personDetails" tabindex="-1" role="dialog" aria-labelledby="personDetailsTitle" aria-hidden="true">
      <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="personDetailsTitle">
              Détails de   :  <span id="nom_complet"></span>
            </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <ul class="nav nav-pills mb-3 justify-content-center" id="citizen-details-tabs" role="tablist">
              <li class="nav-item">
                <a class="nav-link active extrem-left" id="pills-certificate-tab" data-toggle="pill" href="#pills-certificate" role="tab" aria-controls="pills-certificate" aria-selected="true">Certificat et historiques</a>
              </li>
              <li class="nav-item">
                <a class="nav-link extrem-right" id="pills-aid-tab" data-toggle="pill" href="#pills-aid" role="tab" aria-controls="pills-aid" aria-selected="false">Aides sociales reçues</a>
              </li>
            </ul>
            <div class="tab-content citizen-full-details" id="pills-tabContent">
              <div class="tab-pane fade show active" id="pills-certificate" role="tabpanel" aria-labelledby="pills-certificate-tab">
                <div class="row">
                  <div class="col-lg-7">
                      <input id="id_personne" readonly name="id_personne" type="hidden"/>
                      <div class="form-row">
                          <div class="form-group col-md-4">
                              <label for="numero_carnet">Numéro carnet<span class="text-red">*</span></label>
                              <input readonly type="text" name="numero_carnet" class="form-control numero_carnet" id="numero_carnet"/>
                              <div class="error_field numero_carnetError"></div>
                          </div>
                          <div class="form-group col-md-4">
                              <label for="adresse_actuelle">Adresse<span class="text-red">*</span></label>
                              <input readonly type="text" name="adresse_actuelle" class="form-control adresse_actuelle" id="adresse_actuelle"/>
                              <div class="error_field adresse_actuelleError"></div>
                          </div>
                      </div>
                      <div class="form-row">
                          <div class="form-group col-md-4">
                              <label for="nom_info">Nom<span class="text-red">*</span></label>
                              <input readonly type="text" name="nom" class="form-control nom" id="nom_info"/>
                              <div class="error_field nomError"></div>
                          </div>
                          <div class="form-group col-md-4">
                              <label for="prenoms_info">Prénom(s)</label>
                              <input readonly type="text" name="prenoms" class="form-control prenoms" id="prenoms_info"/>
                              <div class="error_field prenomsError"></div>
                          </div>
                          <div class="form-group col-md-4">
                              <label for="situation_matrimoniale">Situation matrimoniale</label>
                              <select disabled id="situation_matrimoniale" class="form-control"  name="situation_matrimoniale">
                                  <option value="5"></option>
                                  <option value="1">Célibataire</option>
                                  <option value="2">Marié(e)</option>
                                  <option value="3">Veuf/Veuve</option>
                                  <option value="4">Divorcé(e)</option>
                              </select>
                              <div class="error_field situation_matrimonialeError"></div>
                          </div>
                      </div>
                      <div class="form-row">
                          <div class="form-group col-md-4">
                              <label for="sexe">Sexe (H/F)</label>
                              <select disabled id="sexe" class="form-control" name="sexe">
                                  <option value="2"></option>
                                  <option value="1">Homme</option>
                                  <option value="0">Femme</option>
                              </select>
                              <div class="error_field sexeError"></div>
                          </div>
                          <div class="form-group col-md-4">
                              <label for="date_de_naissance">Date naissance<span class="text-red">*</span></label>
                              <input readonly type="date" class="form-control date_type" placeholder="jj/mm/aaaa" name="date_de_naissance" id="date_de_naissance"/>
                              <div class="error_field date_de_naissanceError"></div>
                          </div>
                          <div class="form-group col-md-4">
                              <label for="lieu_de_naissance">Lieu de naissance<span class="text-red">*</span></label>
                              <input readonly type="text" class="form-control" name="lieu_de_naissance" id="lieu_de_naissance"/>
                              <div class="error_field lieu_de_naissanceError"></div>
                          </div>
                      </div>
                      <div class="form-row">
                          <div class="form-group col-md-4">
                              <label for="handicape">Handicapé(e)</label>
                              <select disabled id="handicape" class="form-control" name="handicape">
                                  <option value="0">Non</option>
                                  <option value="1">Oui</option>
                              </select>
                              <div class="error_field handicapeError"></div>
                          </div>
                          <div class="form-group col-md-4">
                              <label for="nationality">Nationalité</label>
                              <select disabled class="form-control" name="nationality_id" id="nationality">
                                  <?php foreach($nationalities as $nationality) : ?>
                                      <option value="<?= $nationality->id;?>"><?= $this->lang->line('nationality_'.$nationality->id);?></option>
                                  <?php endforeach;?>
                              </select>
                              <div class="error_field nationality_idError"></div>
                          </div>
                      </div>
                      <div class="form-row cin-container">
                        <div class="form-group col-md-4">
                            <label for="cin_personne_info">Numéro CIN</label>
                            <input readonly type="text" maxlength="15" placeholder="000 000 000 000" class="form-control cin cin_personne" name="cin_personne" id="cin_personne_info"/>
                            <div class="error_field cin_personneError"></div>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="date_delivrance_cin">Date CIN</label>
                            <input readonly type="date" class="form-control date_type" placeholder="jj/mm/aaaa" name="date_delivrance_cin" id="date_delivrance_cin"/>
                            <div class="error_field date_delivrance_cinError"></div>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="lieu_delivrance_cin">Lieu CIN</label>
                            <input readonly type="text" class="form-control" name="lieu_delivrance_cin" id="lieu_delivrance_cin"/>
                            <div class="error_field lieu_delivrance_cinError"></div>
                        </div>
                      </div>
                      <div class="form-row passport-container"  style="display:none;">
                        <div class="form-group col-md-4">
                          <label for="passport">Numéro CIN/Passeport/Carte de résident</label>
                          <input readonly type="text" class="form-control" maxlenght="20" placeholder="xxxxxxxxxxxxxxxxxxxx" name="passport" id="passport"/>
                          <div class="error_field passportError"></div>
                        </div>
                        <div class="form-group col-md-4">
                          <label for="passport_date">Date CIN/Passeport/Carte de résident</label>
                          <input readonly type="date" class="form-control date_type" placeholder="jj/mm/aaaa" name="passport_date" id="passport_date"/>
                          <div class="error_field passport_dateError"></div>
                        </div>
                        <div class="form-group col-md-4">
                          <label for="passport_place">Lieu CIN/Passeport/Carte de résident</label>
                          <input readonly type="text" class="form-control" placeholder="..." name="passport_place" id="passport_place"/>
                          <div class="error_field passport_placeError"></div>
                        </div>
                      </div>
                      <div class="form-row">
                          <div class="form-group col-md-4">
                              <label for="father">Père</label>
                              <input readonly type="text" class="form-control father" name="father" id="father"/>
                              <div class="error_field fatherError"></div>
                          </div>
                          <div class="form-group col-md-2">
                              <label for="father_status">Mention</label>
                              <select disabled name="father_status"  class="form-control" id="father_status">
                                  <option value="2"></option>
                                  <option value="0">Vivant</option>
                                  <option value="1">Mort</option>
                              </select>
                              <div class="error_field father_statusError"></div>
                          </div>
                          <div class="form-group col-md-4">
                              <label for="mother">Mère</label>
                              <input readonly type="text" class="form-control" name="mother" id="mother"/>
                              <div class="error_field motherError"></div>
                          </div>
                          <div class="form-group col-md-2">
                              <label for="mother_status">Mention</label>
                              <select disabled name="mother_status"  class="form-control" id="mother_status">
                                  <option value="2"></option>
                                  <option value="0">Vivante</option>
                                  <option value="1">Morte</option>
                              </select>
                              <div class="error_field mother_statusError"></div>
                          </div>
                      </div>
                      <div class="form-row">
                          <div class="form-group col-md-6">
                              <label for="phone">Téléphone(s)</label>
                              <input readonly type="text" placeholder="032 00 000 00; 033 00 000 00; 034 00 000 00" class="form-control" name="phone" id="phone"/>
                              <div class="error_field phoneError"></div>
                          </div>
                      </div>
                      <div class="form-row">
                          <div class="form-group col-md-6">
                              <label for="job">Profession</label>
                              <select disabled id="job" class="form-control job" name="job_id">      
                                <?php foreach($jobs as $job) : ?>
                                    <option value="<?= $job->id;?>"><?= $this->lang->line('job_'.$job->id);?></option>
                                <?php endforeach;?>
                              </select>
                              <input type="text" name="job_other" id="otherJob" placeholder="Préciser la profession" style="display: none; margin-top: 3px;" class="form-control" />
                              <div class="error_field job_idError"></div>
                          </div>
                          <div class="form-group col-md-6">
                              <label for="job_status">Situation actuelle dans l'emploi</label>
                              <input readonly type="text" class="form-control" name="job_status" id="job_status"/>
                              <div class="error_field job_statusError"></div>
                          </div>
                      </div>
                      <div class="form-row">
                          <div class="form-group col-md-12">
                              <label for="observation">Observations</label>
                              <textarea readonly class="form-control" name="observation" id="observation"></textarea>
                              <div class="error_field observationError"></div>
                          </div>
                      </div>
                  </div>
                  <div class="col-lg-5">
                    <p class="mt-2">Historique des actions</p>
                    <div id="historyCertificate"></div>
                    <p class="mt-2">Historique de migration</p>
                    <div id="historyMigration"></div>                  
                  </div>
                </div>
              </div>
              <div class="tab-pane fade" id="pills-aid" role="tabpanel" aria-labelledby="pills-aid-tab">
                <p>Ménage</p>
                <div id="citizenHousehold"></div>
                <p class="mt-2">Aides sociales reçues</p>
                <div id="citizenAids"></div>
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
          </div>
        </div>
      </div>
    </div>
    <!-- END Person details -->
      </div>
    </div>
  </div>

	<script src="<?= js('jquery.min');?>"></script>
  <script src="<?= plugin('bootstrap', 'js', 'bootstrap.bundle.min.js');?>"></script>
	<script src="<?= plugin('tabulator', 'js', 'tabulator.min.js');?>"></script>
	<script src="<?= plugin('modules', 'common', 'index.js');?>"></script>
	<script src="<?= plugin('modules', 'chief', 'list_household.js');?>"></script>
<div id="appVersion"> Loharano Fokontany, version <?= APP_VERSION;?> &copy; <a href="https://digital.gov.mg" target="_blank">e-Gouvernance Madagascar</a> - <?= date("Y");?></div>
</body>
</html>
