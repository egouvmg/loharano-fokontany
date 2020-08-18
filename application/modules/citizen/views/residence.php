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
          <h1><?= $title;?></h1><a href="gestion_citoyens"><button class="btn float-right btn-warning"><span class="iconify" data-icon="ion:caret-back-circle-outline" data-inline="false"></span> Retour</button></a>
        </div>
        <!-- End Page title -->

        <!-- Page Content -->
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <p><?=$this->lang->line('certificats_introduction');?></p>
                </div>
            </div>
            <div class="row"><div class="col-lg-12 line-bloc">
              <h6>Filtre de recherche</h6>
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
                    <div id="citizens"></div>
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
    </div>
        <!-- Person details -->
        <div class="modal fade" id="personDetails" tabindex="-1" role="dialog" aria-labelledby="newRegisterTitle" aria-hidden="true">
          <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="newRegisterTitle">
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
                        <form id="formEditPerson">
                          <input id="id_personne" name="id_personne" type="hidden"/>
                          <div class="form-row">
                              <div class="form-group col-md-4">
                                  <label for="numero_carnet">Numéro carnet<span class="text-red">*</span></label>
                                  <input type="text" name="numero_carnet" class="form-control numero_carnet" id="numero_carnet"/>
                                  <div class="error_field numero_carnetError"></div>
                              </div>
                              <div class="form-group col-md-4">
                                  <label for="adresse_actuelle">Adresse<span class="text-red">*</span></label>
                                  <input type="text" name="adresse_actuelle" class="form-control adresse_actuelle" id="adresse_actuelle"/>
                                  <div class="error_field adresse_actuelleError"></div>
                              </div>
                          </div>
                          <div class="form-row">
                              <div class="form-group col-md-4">
                                  <label for="nom_info">Nom<span class="text-red">*</span></label>
                                  <input type="text" name="nom" class="form-control nom" id="nom_info"/>
                                  <div class="error_field nomError"></div>
                              </div>
                              <div class="form-group col-md-4">
                                  <label for="prenoms_info">Prénom(s)</label>
                                  <input type="text" name="prenoms" class="form-control prenoms" id="prenoms_info"/>
                                  <div class="error_field prenomsError"></div>
                              </div>
                              <div class="form-group col-md-4">
                                  <label for="situation_matrimoniale">Situation matrimoniale</label>
                                  <select id="situation_matrimoniale" class="form-control"  name="situation_matrimoniale">
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
                                  <select id="sexe" class="form-control" name="sexe">
                                      <option value="2"></option>
                                      <option value="1">Homme</option>
                                      <option value="0">Femme</option>
                                  </select>
                                  <div class="error_field sexeError"></div>
                              </div>
                              <div class="form-group col-md-4">
                                  <label for="date_de_naissance">Date naissance<span class="text-red">*</span></label>
                                  <input type="date" class="form-control date_type" placeholder="jj/mm/aaaa" name="date_de_naissance" id="date_de_naissance"/>
                                  <div class="error_field date_de_naissanceError"></div>
                              </div>
                              <div class="form-group col-md-4">
                                  <label for="lieu_de_naissance">Lieu de naissance<span class="text-red">*</span></label>
                                  <input type="text" class="form-control" name="lieu_de_naissance" id="lieu_de_naissance"/>
                                  <div class="error_field lieu_de_naissanceError"></div>
                              </div>
                          </div>
                          <div class="form-row">
                              <div class="form-group col-md-4">
                                  <label for="handicape">Handicapé(e)</label>
                                  <select id="handicape" class="form-control" name="handicape">
                                      <option value="0">Non</option>
                                      <option value="1">Oui</option>
                                  </select>
                                  <div class="error_field handicapeError"></div>
                              </div>
                              <div class="form-group col-md-4">
                                  <label for="nationality">Nationalité</label>
                                  <select class="form-control" name="nationality_id" id="nationality">
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
                                <input type="text" maxlength="15" placeholder="000 000 000 000" class="form-control cin cin_personne" name="cin_personne" id="cin_personne_info"/>
                                <div class="error_field cin_personneError"></div>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="date_delivrance_cin">Date CIN</label>
                                <input type="date" class="form-control date_type" placeholder="jj/mm/aaaa" name="date_delivrance_cin" id="date_delivrance_cin"/>
                                <div class="error_field date_delivrance_cinError"></div>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="lieu_delivrance_cin">Lieu CIN</label>
                                <input type="text" class="form-control" name="lieu_delivrance_cin" id="lieu_delivrance_cin"/>
                                <div class="error_field lieu_delivrance_cinError"></div>
                            </div>
                          </div>
                          <div class="form-row passport-container"  style="display:none;">
                            <div class="form-group col-md-4">
                              <label for="passport">Numéro CIN/Passeport/Carte de résident</label>
                              <input type="text" class="form-control" maxlenght="20" placeholder="xxxxxxxxxxxxxxxxxxxx" name="passport" id="passport"/>
                              <div class="error_field passportError"></div>
                            </div>
                            <div class="form-group col-md-4">
                              <label for="passport_date">Date CIN/Passeport/Carte de résident</label>
                              <input type="date" class="form-control date_type" placeholder="jj/mm/aaaa" name="passport_date" id="passport_date"/>
                              <div class="error_field passport_dateError"></div>
                            </div>
                            <div class="form-group col-md-4">
                              <label for="passport_place">Lieu CIN/Passeport/Carte de résident</label>
                              <input type="text" class="form-control" placeholder="..." name="passport_place" id="passport_place"/>
                              <div class="error_field passport_placeError"></div>
                            </div>
                          </div>
                          <div class="form-row">
                              <div class="form-group col-md-4">
                                  <label for="father">Père</label>
                                  <input type="text" class="form-control father" name="father" id="father"/>
                                  <div class="error_field fatherError"></div>
                              </div>
                              <div class="form-group col-md-2">
                                  <label for="father_status">Mention</label>
                                  <select name="father_status"  class="form-control" id="father_status">
                                      <option value="2"></option>
                                      <option value="0">Vivant</option>
                                      <option value="1">Mort</option>
                                  </select>
                                  <div class="error_field father_statusError"></div>
                              </div>
                              <div class="form-group col-md-4">
                                  <label for="mother">Mère</label>
                                  <input type="text" class="form-control" name="mother" id="mother"/>
                                  <div class="error_field motherError"></div>
                              </div>
                              <div class="form-group col-md-2">
                                  <label for="mother_status">Mention</label>
                                  <select name="mother_status"  class="form-control" id="mother_status">
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
                                  <input type="text" placeholder="032 00 000 00; 033 00 000 00; 034 00 000 00" class="form-control" name="phone" id="phone"/>
                                  <div class="error_field phoneError"></div>
                              </div>
                          </div>
                          <div class="form-row">
                              <div class="form-group col-md-6">
                                  <label for="job">Profession</label>
                                  <select id="job" class="form-control job" name="job_id">      
                                    <?php foreach($jobs as $job) : ?>
                                        <option value="<?= $job->id;?>"><?= $this->lang->line('job_'.$job->id);?></option>
                                    <?php endforeach;?>
                                  </select>
                                  <input type="text" name="job_other" id="otherJob" placeholder="Préciser la profession" style="display: none; margin-top: 3px;" class="form-control" />
                                  <div class="error_field job_idError"></div>
                              </div>
                              <div class="form-group col-md-6">
                                  <label for="job_status">Situation actuelle dans l'emploi</label>
                                  <input type="text" class="form-control" name="job_status" id="job_status"/>
                                  <div class="error_field job_statusError"></div>
                              </div>
                          </div>
                          <div class="form-row">
                              <div class="form-group col-md-12">
                                  <label for="observation">Observations</label>
                                  <textarea class="form-control" name="observation" id="observation"></textarea>
                                  <div class="error_field observationError"></div>
                              </div>
                          </div>
                        </form>
                      </div>
                      <div class="col-lg-5">
                        <h6>Cliquez sur un bouton pour générer un certificat</h6>
                        <div>
                          <a id="certificat_residence" href="">
                            <button class="btn btn-color-2 mb-1 mr-1"><span class="iconify" data-icon="carbon:certificate" data-inline="false"></span> Certificat de Résidence</button>
                          </a>
                        </div>
                        <div>
                          <a id="certificat_move" href="">
                            <button class="btn btn-color-6 mb-1 mr-1"><span class="iconify" data-icon="carbon:certificate" data-inline="false"></span> Certificat de Déménagement</button>
                          </a>
                        </div>
                        <div>
                          <a id="certificat_celibat" href="">
                            <button class="btn btn-color-3 mb-1 mr-1"><span class="iconify" data-icon="carbon:certificate" data-inline="false"></span> Certificat de Célibat</button>
                          </a>
                        </div>
                        <div>
                          <a id="certificat_life" href="">
                            <button class="btn btn-color-4 mb-1 mr-1"><span class="iconify" data-icon="carbon:certificate" data-inline="false"></span> Certificat de Vie Individuelle</button>
                          </a>
                        </div>
                        <div>
                          <a id="certificat_supported" href="">
                            <button class="btn btn-color-5 mb-1 mr-1"><span class="iconify" data-icon="carbon:certificate" data-inline="false"></span> Certificat de Prise en charge et de garde</button>
                          </a>
                        </div>
                        <div>
                          <a id="certificat_behavior" href="">
                            <button class="btn btn-color-7 mb-1 mr-1"><span class="iconify" data-icon="carbon:certificate" data-inline="false"></span> Certificat de Bonne conduite - de Bonne Vie - Moeurs</button>
                          </a>
                        </div>
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
                <button type="button" class="btn btn-primary" id="validEditPerson">
                  Valider les modifications
                  <span class="iconify" data-icon="uil:arrow-right" data-inline="false"></span>
                </button>
              </div>
            </div>
          </div>
        </div>
        <!-- END Person details -->

	<script src="<?= js('jquery.min');?>"></script>
  <script src="<?= plugin('bootstrap', 'js', 'bootstrap.bundle.min.js');?>"></script>
  <script src="<?= plugin('phone', 'js', 'jquery-input-mask-phone-number.js');?>"></script>
	<script src="<?= plugin('tabulator', 'js', 'tabulator.min.js');?>"></script>
	<script src="<?= plugin('modules', 'common', 'index.js');?>"></script>
	<script src="<?= plugin('modules', 'citizen', 'residence.js');?>"></script>
<div id="appVersion"> Loharano Fokontany, version <?= APP_VERSION;?> &copy; <a href="https://digital.gov.mg" target="_blank">e-Gouvernance Madagascar</a> - <?= date("Y");?></div>
</body>
</html>
