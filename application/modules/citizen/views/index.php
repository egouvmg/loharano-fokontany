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
          <h1><?= $title;?></h1>
          <button id="showInsightCertificate" class="btn float-right btn-warning"><span class="iconify" data-icon="gg:insights" data-inline="false"></span> Statisque des opérations</button>
        </div>
        <!-- End Page title -->
        <!-- Page Content -->
        <div class="container">
          <div class="row mt-3">
            <div class="col-lg-12">
              <div class="row">
                <div class="col-lg-6">
                  <div class="line-bloc">
                    <h6>Rapport global</h6>
                    <div class="container-bloc-link">
                      <a href="liste_menage_fokontany" class="bloc-link color-7">
                        <span class="count"><?= $household_count;?></span> <?=$this->lang->line('count_citizen');?> Ménages
                      </a>
                      <a href="liste_citoyens" class="bloc-link color-7">
                        <span class="count"><?= $citizen_count;?></span> <?=$this->lang->line('count_household');?> Citoyens
                      </a>
                    </div>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="line-bloc">
                    <h6>Indicateurs démographiques</h6>
                    <div class="container-bloc-link">
                      <a href="#" class="bloc-link color-6" data-toggle="tooltip" data-placement="bottom" data-html="true" title="Moyenne d'age des hommes : <?=$male_avg_age;?>. Moyenne d'age des femmes : <?=$female_avg_age;?>">
                        <span class="pourcent"><?= $male_ratio;?>% / <?= $female_ratio;?>%</span> <?=$this->lang->line('count_citizen');?> Hommes/Femmes
                      </a>
                      <a href="#" class="bloc-link color-6" data-toggle="tooltip" data-placement="bottom" data-html="true" title="<?=$minor_male;?> mineurs masculins. <?=$minor_female;?> mineurs féminins. <?=$major_male;?> majeurs masculins. <?=$major_female;?> majeurs féminins">
                        <span class="pourcent"><?= $minor_ratio;?>% / <?= $major_ratio;?>%</span> <?=$this->lang->line('count_household');?> Mineurs/Majeurs
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-12">
              <div class="row">
                <div class="col-lg-6">
                  <div class="line-bloc">
                    <h6>Gestion citoyens</h6>
                    <div class="container-bloc-link">
                      <a href="liste_citoyens" class="bloc-link color-2">
                        <span class="iconify" data-icon="bi:person-lines-fill" data-inline="false"></span> <?=$this->lang->line('list_citizen');?>
                      </a>
                      <a href="liste_menage_fokontany" class="bloc-link color-3">
                        <span class="iconify" data-icon="ic:outline-family-restroom" data-inline="false"></span> <?=$this->lang->line('list_household');?>
                      </a>
                    </div>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="line-bloc">
                    <h6>Services administratifs</h6>
                    <div class="container-bloc-link">
                      <a href="residence" class="bloc-link color-4">
                        <span class="iconify" data-icon="bi:card-list" data-inline="false"></span> Générer un certificat
                      </a>
                      <a href="aide_menage" class="bloc-link color-5">
                        <span class="iconify" data-icon="dashicons:products" data-inline="false"></span> Aides sociales
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
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
            <div class="col-lg-12 mb-2">
              <a href="nouveau_menage_fokontany"><button id="createHousehold" class="btn btn-color-1" style="display:none;">Créer un nouveau ménage</button></a>
            </div>
            <div class="col-lg-12">
              <h6>Liste des individus</h6>
              <div id="citizens"></div>
            </div>
            <div class="col-lg-12 mt-3">
              <h6>Visible dans d'autres Fokontany</h6>
              <div id="other_citizens"></div>
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
        <!-- Other Citizen details -->
        <div class="modal fade" id="otherCitizenDetails" tabindex="-1" role="dialog" aria-labelledby="otherCitizenDetailsTitle" aria-hidden="true">
          <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="otherCitizenDetailsTitle">
                  Détails de   :  <span id="nom_complet_autre"></span>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <div class="row">
                  <div class="col-lg-7">
                    <form id="formOtherPerson">
                      <input id="o_id_personne" name="id_personne" type="hidden"/>
                      <div class="form-row">
                          <div class="form-group col-md-4">
                              <label for="fokontany_name">Fokontany<span class="text-red">*</span></label>
                              <input type="text" readonly class="form-control o_fokontany_name" id="fokontany_name"/>
                              <div class="error_field fokontany_nameError"></div>
                          </div>
                          <div class="form-group col-md-4">
                              <label for="o_adresse_actuelle">Adresse<span class="text-red">*</span></label>
                              <input type="text" name="adresse_actuelle" readonly class="form-control o_adresse_actuelle" id="o_adresse_actuelle"/>
                              <div class="error_field o_adresse_actuelleError"></div>
                          </div>
                      </div>
                      <div class="form-row">
                          <div class="form-group col-md-4">
                              <label for="o_nom_info">Nom<span class="text-red">*</span></label>
                              <input type="text" name="nom" class="form-control nom" id="o_nom_info"/>
                              <div class="error_field o_nomError"></div>
                          </div>
                          <div class="form-group col-md-4">
                              <label for="o_prenoms_info">Prénom(s)</label>
                              <input type="text" name="prenoms" class="form-control o_prenoms" id="o_prenoms_info"/>
                              <div class="error_field o_prenomsError"></div>
                          </div>
                          <div class="form-group col-md-4">
                              <label for="o_situation_matrimoniale">Situation matrimoniale</label>
                              <select id="o_situation_matrimoniale" class="form-control"  name="situation_matrimoniale">
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
                              <label for="o_sexe">Sexe (H/F)</label>
                              <select id="o_sexe" class="form-control" name="sexe">
                                  <option value="2"></option>
                                  <option value="1">Homme</option>
                                  <option value="0">Femme</option>
                              </select>
                              <div class="error_field o_sexeError"></div>
                          </div>
                          <div class="form-group col-md-4">
                              <label for="o_date_de_naissance">Date naissance<span class="text-red">*</span></label>
                              <input type="date" class="form-control date_type" placeholder="jj/mm/aaaa" name="date_de_naissance" id="o_date_de_naissance"/>
                              <div class="error_field o_date_de_naissanceError"></div>
                          </div>
                          <div class="form-group col-md-4">
                              <label for="o_lieu_de_naissance">Lieu de naissance<span class="text-red">*</span></label>
                              <input type="text" class="form-control" name="lieu_de_naissance" id="o_lieu_de_naissance"/>
                              <div class="error_field o_lieu_de_naissanceError"></div>
                          </div>
                      </div>
                      <div class="form-row">
                          <div class="form-group col-md-4">
                              <label for="o_handicape">Handicapé(e)</label>
                              <select id="o_handicape" class="form-control" name="handicape">
                                  <option value="0">Non</option>
                                  <option value="1">Oui</option>
                              </select>
                              <div class="error_field o_handicapeError"></div>
                          </div>
                          <div class="form-group col-md-4">
                              <label for="o_nationality">Nationalité</label>
                              <select class="form-control" name="nationality_id" id="o_nationality">
                                  <?php foreach($nationalities as $nationality) : ?>
                                      <option value="<?= $nationality->id;?>"><?= $this->lang->line('nationality_'.$nationality->id);?></option>
                                  <?php endforeach;?>
                              </select>
                              <div class="error_field o_nationality_idError"></div>
                          </div>
                      </div>
                      <div class="form-row cin-container">
                        <div class="form-group col-md-4">
                            <label for="o_cin_personne_info">Numéro CIN</label>
                            <input type="text" maxlength="15" placeholder="000 000 000 000" class="form-control cin o_cin_personne" name="cin_personne" id="o_cin_personne_info"/>
                            <div class="error_field o_cin_personneError"></div>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="o_date_delivrance_cin">Date CIN</label>
                            <input type="date" class="form-control date_type" placeholder="jj/mm/aaaa" name="date_delivrance_cin" id="o_date_delivrance_cin"/>
                            <div class="error_field o_date_delivrance_cinError"></div>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="o_lieu_delivrance_cin">Lieu CIN</label>
                            <input type="text" class="form-control" name="lieu_delivrance_cin" id="o_lieu_delivrance_cin"/>
                            <div class="error_field o_lieu_delivrance_cinError"></div>
                        </div>
                      </div>
                      <div class="form-row passport-container"  style="display:none;">
                        <div class="form-group col-md-4">
                          <label for="o_passport">Numéro CIN/Passeport/Carte de résident</label>
                          <input type="text" class="form-control" maxlenght="20" placeholder="xxxxxxxxxxxxxxxxxxxx" name="passport" id="o_passport"/>
                          <div class="error_field o_passportError"></div>
                        </div>
                        <div class="form-group col-md-4">
                          <label for="o_passport_date">Date CIN/Passeport/Carte de résident</label>
                          <input type="date" class="form-control date_type" placeholder="jj/mm/aaaa" name="passport_date" id="o_passport_date"/>
                          <div class="error_field o_passport_dateError"></div>
                        </div>
                        <div class="form-group col-md-4">
                          <label for="o_passport_place">Lieu CIN/Passeport/Carte de résident</label>
                          <input type="text" class="form-control" placeholder="..." name="passport_place" id="o_passport_place"/>
                          <div class="error_field o_passport_placeError"></div>
                        </div>
                      </div>
                      <div class="form-row">
                          <div class="form-group col-md-4">
                              <label for="o_father">Père</label>
                              <input type="text" class="form-control father" name="father" id="o_father"/>
                              <div class="error_field o_fatherError"></div>
                          </div>
                          <div class="form-group col-md-2">
                              <label for="o_father_status">Mention</label>
                              <select name="father_status"  class="form-control" id="o_father_status">
                                  <option value="2"></option>
                                  <option value="0">Vivant</option>
                                  <option value="1">Mort</option>
                              </select>
                              <div class="error_field o_father_statusError"></div>
                          </div>
                          <div class="form-group col-md-4">
                              <label for="o_mother">Mère</label>
                              <input type="text" class="form-control" name="mother" id="o_mother"/>
                              <div class="error_field o_motherError"></div>
                          </div>
                          <div class="form-group col-md-2">
                              <label for="o_mother_status">Mention</label>
                              <select name="mother_status"  class="form-control" id="o_mother_status">
                                  <option value="2"></option>
                                  <option value="0">Vivante</option>
                                  <option value="1">Morte</option>
                              </select>
                              <div class="error_field o_mother_statusError"></div>
                          </div>
                      </div>
                      <div class="form-row">
                          <div class="form-group col-md-6">
                              <label for="o_phone">Téléphone(s)</label>
                              <input type="text" placeholder="032 00 000 00; 033 00 000 00; 034 00 000 00" class="form-control" name="phone" id="o_phone"/>
                              <div class="error_field o_phoneError"></div>
                          </div>
                      </div>
                      <div class="form-row">
                          <div class="form-group col-md-6">
                              <label for="o_job">Profession</label>
                              <select id="o_job" class="form-control job" name="job_id">      
                                <?php foreach($jobs as $job) : ?>
                                    <option value="<?= $job->id;?>"><?= $this->lang->line('job_'.$job->id);?></option>
                                <?php endforeach;?>
                              </select>
                              <input type="text" name="job_other" id="o_otherJob" placeholder="Préciser la profession" style="display: none; margin-top: 3px;" class="form-control" />
                              <div class="error_field o_job_idError"></div>
                          </div>
                          <div class="form-group col-md-6">
                              <label for="o_job_status">Situation actuelle dans l'emploi</label>
                              <input type="text" class="form-control" name="job_status" id="o_job_status"/>
                              <div class="error_field o_job_statusError"></div>
                          </div>
                      </div>
                      <div class="form-row">
                          <div class="form-group col-md-12">
                              <label for="o_observation">Observations</label>
                              <textarea class="form-control" name="observation" id="o_observation"></textarea>
                              <div class="error_field o_observationError"></div>
                          </div>
                      </div>
                    </form>
                  </div>
                  <div class="col-lg-5">
                    <h6>Cliquez sur le bouton ci-dessous pour rajouter le citoyen dans un ménage existant dans votre Fokontany</h6>
                    <div class="btn-migration">
                        <button id="migrationCitizenToHousehold" class="btn btn-color-8 mb-1 mr-1"><span class="iconify" data-icon="mdi:file-move-outline" data-inline="false"></span> Rajouter le citoyen dans un ménage existant</button>
                    </div>                  
                    <h6>Cliquez sur le bouton ci-dessous pour rajouter le citoyen dans votre Fokontany</h6>
                    <div class="btn-migration">
                        <button id="migrateCitizen" class="btn btn-color-5 mb-1 mr-1"><span class="iconify" data-icon="mdi:file-move-outline" data-inline="false"></span> Rajouter le citoyen dans un nouveau ménage</button>
                    </div>                   
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
        <!-- END Other Citizen details -->
        <!-- Insight Certificate -->
        <div class="modal fade" id="insightCertificate" tabindex="-1" role="dialog" aria-labelledby="insightCertificateTitle" aria-hidden="true">
          <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="insightCertificateTitle">
                  Nombre d'opérations de ce mois
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <div class="row">
                  <div class="col-lg-12">
                      <div class="container-bloc-link">
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
                          <span class="count"><?= $nbr_certificate[3];?></span> Vie Individuel
                        </a>
                        <a href="#" class="bloc-link color-7">
                          <span class="count"><?= $nbr_certificate[4];?></span> Prise en charge/garde
                        </a>
                        <a href="#" class="bloc-link color-7">
                          <span class="count"><?=  $nbr_certificate[5];?></span> Bonne conduite
                        </a>
                        <a href="#" class="bloc-link color-6"><span class="count"><?= $nbr_total;?></span> Nombre total</a>
                      </div>
                  </div>
                </div>
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
        <!-- END Insight Certificate -->
      </div>
    </div>
  </div>

	<script src="<?= js('jquery.min');?>"></script>
  <script src="<?= plugin('bootstrap', 'js', 'bootstrap.bundle.min.js');?>"></script>
  <script src="<?= plugin('phone', 'js', 'jquery-input-mask-phone-number.js');?>"></script>
	<script src="<?= plugin('tabulator', 'js', 'tabulator.min.js');?>"></script>
	<script src="<?= plugin('modules', 'common', 'index.js');?>"></script>
	<script src="<?= plugin('modules', 'citizen', 'speed_access.js');?>"></script>
<div id="appVersion"> Loharano Fokontany, version <?= APP_VERSION;?> &copy; <a href="https://digital.gov.mg" target="_blank">e-Gouvernance Madagascar</a> - <?= date("Y");?></div>
</body>
</html>
