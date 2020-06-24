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
              Fokontany <?= $user_fokontany;?>
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
              <li><a href="recherche_menage"><?=$this->lang->line('add_citizen');?></a></li>
              <li><a href="liste_citoyens" class="active"><?=$this->lang->line('list_citizen');?></a></li>
            </ul>
          </li>
          <li>
            <a href="#"><span class="iconify" data-icon="fa-solid:user" data-inline="false"></span> <?=$this->lang->line('households');?></a>
            <ul class="sub-main-menu" style="display:none;">
              <li><a href="liste_menage_fokontany">Liste des ménages</a></li>
              <li><a href="aide_menage">Liste des aides</a></li>
            </ul>
          </li>
          <li>
            <a href="#"><span class="iconify" data-icon="carbon:certificate" data-inline="false"></span> <?=$this->lang->line('certificates');?></a>
            <ul class="sub-main-menu">
              <li><a href="residence" class="active">Résidence</a></li>
            </ul>
          </li>
        </ul>
      </div>
      <div class="main-container">
        <!-- Page title --> 
        <div class="container-fluid page-title">
          <h1><?= $title;?></h1>
        </div>
        <!-- End Page title -->

        <!-- Page Content -->
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <p><?=$this->lang->line('certificats_introduction');?></p>
                </div>
            </div>
            <div class="row">
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

<!-- Person details -->
<div class="modal fade" id="personDetails" tabindex="-1" role="dialog" aria-labelledby="newRegisterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="newRegisterTitle">
            Détails de   :  <span id="full_name"></span>
          </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
        <form id="formEditPerson">
        <input id="person_id" name="person_id" type="hidden"/>
        <div class="row">
          <!--Form at left side -->
          <div class=" col-md-9">
            <div class="form-row">
              <div class="form-group col-md-6">
                  <label for="address"><?= $this->lang->line('address');?><span class="text-red">*</span></label>
                  <input type="text" name="address" class="form-control address" id="address"/>
                  <div class="error_field addressError"></div>
              </div>
              <div class="form-group col-md-6">
                  <label for="address">Numero Carnet<span class="text-red">*</span></label>
                  <input type="text" name="address" class="form-control address" id="numero_carnet"/>
              </div>
            </div>

            <div class="form-row">
              <div class="form-group col-md-4">
                <label for="last_name">Nom<span class="text-red">*</span></label>
                <input type="text" name="last_name" class="form-control last_name" id="last_name"/>
                <div class="error_field last_nameError"></div>
              </div>

              <div class="form-group col-md-4">
                <label for="first_name">Prénom(s)</label>
                <input type="text" name="first_name" class="form-control first_name" id="first_name"/>
                <div class="error_field first_nameError"></div>
              </div>

              <div class="form-group col-md-4">
                <label for="marital_status">Situation matrimoniale</label>
                <select id="marital_status" class="form-control"  name="marital_status">
                    <option value="5"></option>
                    <option value="1">Célibataire</option>
                    <option value="2">Marié(e)</option>
                    <option value="3">Veuf/Veuve</option>
                    <option value="4">Divorcé(e)</option>
                </select>
                <div class="error_field marital_statusError"></div>
              </div>
            </div>

            <div class="form-row">
              <div class="form-group col-md-4">
                <label for="parent_link">Lien parenté</label>
                <select id="parent_link" onchange="controlFilsFille('#parent_link', '#sexe');" class="form-control parent_link" name="parent_link">
                  <option value="0"></option>
                    <option value="pere">Père</option>
                    <option value="mere">Mère</option>
                    <option value="fils">Fils</option>
                    <option value="fille">Fille</option>
                    <option value="autre">Autres</option>
                </select>
                <input type="text" name="other_pl" id="otherParentLink" placeholder="Préciser le lien de parenté" style="display: none; margin-top: 3px;" class="form-control" />
                <div class="error_field parent_linkError"></div>
              </div>
              <div class="form-group col-md-4">
                <label for="birth">Date naissance<span class="text-red">*</span></label>
                <input type="text" class="form-control date_type" placeholder="jj/mm/aaaa" name="birth" id="birth"/>
                <div class="error_field birthError"></div>
              </div>
              <div class="form-group col-md-4">
                <label for="birth_place">Lieu de naissance<span class="text-red">*</span></label>
                <input type="text" class="form-control" name="birth_place" id="birth_place"/>
                <div class="error_field birth_placeError"></div>
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
                <label for="handicapped">Handicapé(e)</label>
                <select id="handicapped" class="form-control" name="handicapped">
                    <option value="0">Non</option>
                    <option value="1">Oui</option>
                </select>
                <div class="error_field handicappedError"></div>
              </div>
              <div class="form-group col-md-4">
                <label for="nationality">Nationalité</label>
                <select class="form-control" name="nationality" id="nationality">
                    <option value="0"></option>
                    <option value="Malgache">Malgache</option>
                    <option value="Française">Française</option>
                    <option value="Americaine">Americaine</option>
                    <option value="Afghane">Afghane</option>
                    <option value="Albanaise">Albanaise</option>
                    <option value="Algerienne">Algerienne</option>
                    <option value="Allemande">Allemande</option>
                    <option value="Andorrane">Andorrane</option>
                    <option value="Angolaise">Angolaise</option>
                    <option value="Antiguaise et barbudienne">Antiguaise et barbudienne</option>
                    <option value="Argentine">Argentine</option>
                    <option value="Armenienne">Armenienne</option>
                    <option value="Australienne">Australienne</option>
                    <option value="Autrichienne">Autrichienne</option>
                    <option value="Azerbaïdjanaise">Azerbaïdjanaise</option>
                    <option value="Bahamienne">Bahamienne</option>
                    <option value="Bahreinienne">Bahreinienne</option>
                    <option value="Bangladaise">Bangladaise</option>
                    <option value="Barbadienne">Barbadienne</option>
                    <option value="Belge">Belge</option>
                    <option value="Belizienne">Belizienne</option>
                    <option value="Beninoise">Beninoise</option>
                    <option value="Bhoutanaise">Bhoutanaise</option>
                    <option value="Bielorusse">Bielorusse</option>
                    <option value="Birmane">Birmane</option>
                    <option value="Bissau-Guinéenne">Bissau-Guinéenne</option>
                    <option value="Bolivienne">Bolivienne</option>
                    <option value="Bosnienne">Bosnienne</option>
                    <option value="Botswanaise">Botswanaise</option>
                    <option value="Bresilienne">Bresilienne</option>
                    <option value="Britannique">Britannique</option>
                    <option value="Bruneienne">Bruneienne</option>
                    <option value="Bulgare">Bulgare</option>
                    <option value="Burkinabe">Burkinabe</option>
                    <option value="Burundaise">Burundaise</option>
                    <option value="Cambodgienne">Cambodgienne</option>
                    <option value="Camerounaise">Camerounaise</option>
                    <option value="Canadienne">Canadienne</option>
                    <option value="Cap-verdienne">Cap-verdienne</option>
                    <option value="Centrafricaine">Centrafricaine</option>
                    <option value="Chilienne">Chilienne</option>
                    <option value="Chinoise">Chinoise</option>
                    <option value="Chypriote">Chypriote</option>
                    <option value="Colombienne">Colombienne</option>
                    <option value="Comorienne">Comorienne</option>
                    <option value="Congolaise">Congolaise</option>
                    <option value="Costaricaine">Costaricaine</option>
                    <option value="Croate">Croate</option>
                    <option value="Cubaine">Cubaine</option>
                    <option value="Danoise">Danoise</option>
                    <option value="Djiboutienne">Djiboutienne</option>
                    <option value="Dominicaine">Dominicaine</option>
                    <option value="Dominiquaise">Dominiquaise</option>
                    <option value="Egyptienne">Egyptienne</option>
                    <option value="Emirienne">Emirienne</option>
                    <option value="Equato-guineenne">Equato-guineenne</option>
                    <option value="Equatorienne">Equatorienne</option>
                    <option value="Erythreenne">Erythreenne</option>
                    <option value="Espagnole">Espagnole</option>
                    <option value="Est-timoraise">Est-timoraise</option>
                    <option value="Estonienne">Estonienne</option>
                    <option value="Ethiopienne">Ethiopienne</option>
                    <option value="Fidjienne">Fidjienne</option>
                    <option value="Finlandaise">Finlandaise</option>
                    <option value="Gabonaise">Gabonaise</option>
                    <option value="Gambienne">Gambienne</option>
                    <option value="Georgienne">Georgienne</option>
                    <option value="Ghaneenne">Ghaneenne</option>
                    <option value="Grenadienne">Grenadienne</option>
                    <option value="Guatemalteque">Guatemalteque</option>
                    <option value="Guineenne">Guineenne</option>
                    <option value="Guyanienne">Guyanienne</option>
                    <option value="Haïtienne">Haïtienne</option>
                    <option value="Hellenique">Hellenique</option>
                    <option value="Hondurienne">Hondurienne</option>
                    <option value="Hongroise">Hongroise</option>
                    <option value="Indienne">Indienne</option>
                    <option value="Indonesienne">Indonesienne</option>
                    <option value="Irakienne">Irakienne</option>
                    <option value="Irlandaise">Irlandaise</option>
                    <option value="Islandaise">Islandaise</option>
                    <option value="Israélienne">Israélienne</option>
                    <option value="Italienne">Italienne</option>
                    <option value="Ivoirienne">Ivoirienne</option>
                    <option value="Jamaïcaine">Jamaïcaine</option>
                    <option value="Japonaise">Japonaise</option>
                    <option value="Jordanienne">Jordanienne</option>
                    <option value="Kazakhstanaise">Kazakhstanaise</option>
                    <option value="Kenyane">Kenyane</option>
                    <option value="Kirghize">Kirghize</option>
                    <option value="Kiribatienne">Kiribatienne</option>
                    <option value="Kittitienne-et-nevicienne">Kittitienne-et-nevicienne</option>
                    <option value="Kossovienne">Kossovienne</option>
                    <option value="Koweitienne">Koweitienne</option>
                    <option value="Laotienne">Laotienne</option>
                    <option value="Lesothane">Lesothane</option>
                    <option value="Lettone">Lettone</option>
                    <option value="Libanaise">Libanaise</option>
                    <option value="Liberienne">Liberienne</option>
                    <option value="Libyenne">Libyenne</option>
                    <option value="Liechtensteinoise">Liechtensteinoise</option>
                    <option value="Lituanienne">Lituanienne</option>
                    <option value="Luxembourgeoise">Luxembourgeoise</option>
                    <option value="Macedonienne">Macedonienne</option>
                    <option value="Malaisienne">Malaisienne</option>
                    <option value="Malawienne">Malawienne</option>
                    <option value="Maldivienne">Maldivienne</option>
                    <option value="Malienne">Malienne</option>
                    <option value="Maltaise">Maltaise</option>
                    <option value="Marocaine">Marocaine</option>
                    <option value="Marshallaise">Marshallaise</option>
                    <option value="Mauricienne">Mauricienne</option>
                    <option value="Mauritanienne">Mauritanienne</option>
                    <option value="Mexicaine">Mexicaine</option>
                    <option value="Micronesienne">Micronesienne</option>
                    <option value="Moldave">Moldave</option>
                    <option value="Monegasque">Monegasque</option>
                    <option value="Mongole">Mongole</option>
                    <option value="Montenegrine">Montenegrine</option>
                    <option value="Mozambicaine">Mozambicaine</option>
                    <option value="Namibienne">Namibienne</option>
                    <option value="Nauruane">Nauruane</option>
                    <option value="Neerlandaise">Neerlandaise</option>
                    <option value="Neo-zelandaise">Neo-zelandaise</option>
                    <option value="Nepalaise">Nepalaise</option>
                    <option value="Nicaraguayenne">Nicaraguayenne</option>
                    <option value="Nigeriane">Nigeriane</option>
                    <option value="Nigerienne">Nigerienne</option>
                    <option value="Nord-coréenne">Nord-coréenne</option>
                    <option value="Norvegienne">Norvegienne</option>
                    <option value="Omanaise">Omanaise</option>
                    <option value="Ougandaise">Ougandaise</option>
                    <option value="Ouzbeke">Ouzbeke</option>
                    <option value="Pakistanaise">Pakistanaise</option>
                    <option value="Palau">Palau</option>
                    <option value="Palestinienne">Palestinienne</option>
                    <option value="Panameenne">Panameenne</option>
                    <option value="Papouane-neoguineenne">Papouane-neoguineenne</option>
                    <option value="Paraguayenne">Paraguayenne</option>
                    <option value="Peruvienne">Peruvienne</option>
                    <option value="Philippine">Philippine</option>
                    <option value="Polonaise">Polonaise</option>
                    <option value="Portoricaine">Portoricaine</option>
                    <option value="Portugaise">Portugaise</option>
                    <option value="Qatarienne">Qatarienne</option>
                    <option value="Roumaine">Roumaine</option>
                    <option value="Russe">Russe</option>
                    <option value="Rwandaise">Rwandaise</option>
                    <option value="Saint-lucienne">Saint-lucienne</option>
                    <option value="Saint-marinaise">Saint-marinaise</option>
                    <option value="Saint-vincentaise-et-grenadine">Saint-vincentaise-et-grenadine</option>
                    <option value="Salomonaise">Salomonaise</option>
                    <option value="Salvadorienne">Salvadorienne</option>
                    <option value="Samoane">Samoane</option>
                    <option value="Santomeenne">Santomeenne</option>
                    <option value="Saoudienne">Saoudienne</option>
                    <option value="Senegalaise">Senegalaise</option>
                    <option value="Serbe">Serbe</option>
                    <option value="Seychelloise">Seychelloise</option>
                    <option value="Sierra-leonaise">Sierra-leonaise</option>
                    <option value="Singapourienne">Singapourienne</option>
                    <option value="Slovaque">Slovaque</option>
                    <option value="Slovene">Slovene</option>
                    <option value="Somalienne">Somalienne</option>
                    <option value="Soudanaise">Soudanaise</option>
                    <option value="Sri-lankaise">Sri-lankaise</option>
                    <option value="Sud-africaine">Sud-africaine</option>
                    <option value="Sud-coréenne">Sud-coréenne</option>
                    <option value="Suedoise">Suedoise</option>
                    <option value="Suisse">Suisse</option>
                    <option value="Surinamaise">Surinamaise</option>
                    <option value="Swazie">Swazie</option>
                    <option value="Syrienne">Syrienne</option>
                    <option value="Tadjike">Tadjike</option>
                    <option value="Taiwanaise">Taiwanaise</option>
                    <option value="Tanzanienne">Tanzanienne</option>
                    <option value="Tchadienne">Tchadienne</option>
                    <option value="Tcheque">Tcheque</option>
                    <option value="Thaïlandaise">Thaïlandaise</option>
                    <option value="Togolaise">Togolaise</option>
                    <option value="Tonguienne">Tonguienne</option>
                    <option value="Trinidadienne">Trinidadienne</option>
                    <option value="Tunisienne">Tunisienne</option>
                    <option value="Turkmene">Turkmene</option>
                    <option value="Turque">Turque</option>
                    <option value="Tuvaluane">Tuvaluane</option>
                    <option value="Ukrainienne">Ukrainienne</option>
                    <option value="Uruguayenne">Uruguayenne</option>
                    <option value="Vanuatuane">Vanuatuane</option>
                    <option value="Venezuelienne">Venezuelienne</option>
                    <option value="Vietnamienne">Vietnamienne</option>
                    <option value="Yemenite">Yemenite</option>
                    <option value="Zambienne">Zambienne</option>
                    <option value="Zimbabweenne">Zimbabweenne</option>
                </select>
                <div class="error_field nationalityError"></div>
              </div>
            </div>

            <div class="form-row cin-container">
              <div class="form-group col-md-4">
                <label for="cin">Numéro CIN</label>
                <input type="text" maxlength="15" placeholder="000 000 000 000" class="form-control cin" name="cin" id="cin"/>
                <div class="error_field cinError"></div>
              </div>
              <div class="form-group col-md-4">
                <label for="cin_date">Date CIN</label>
                <input type="text" class="form-control date_type" placeholder="jj/mm/aaaa" name="cin_date" id="cin_date"/>
                <div class="error_field cin_dateError"></div>
              </div>
              <div class="form-group col-md-4">
                <label for="cin_place">Lieu CIN</label>
                <input type="text" class="form-control" name="cin_place" id="cin_place"/>
                <div class="error_field cin_placeError"></div>
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
                <input type="text" class="form-control date_type" placeholder="jj/mm/aaaa" name="passport_date" id="passport_date"/>
                <div class="error_field passport_dateError"></div>
              </div>
              <div class="form-group col-md-4">
                <label for="passport_place">Lieu CIN/Passeport/Carte de résident</label>
                <input type="text" class="form-control" placeholder="..." name="passport_place" id="passport_place"/>
                <div class="error_field passport_placeError"></div>
              </div>
            </div>

            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="father">Père</label>
                <input type="text" class="form-control father" name="father" id="father"/>
                <div class="error_field fatherError"></div>
              </div>
              <div class="form-group col-md-6">
                <label for="father_status">Mention</label>
                <select name="father_status"  class="form-control" id="father_status">
                    <option value="2"></option>
                    <option value="0">Vivant</option>
                    <option value="1">Mort</option>
                </select>
                <div class="error_field father_statusError"></div>
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="mother">Mère</label>
                <input type="text" class="form-control" name="mother" id="mother"/>
                <div class="error_field motherError"></div>
              </div>
              <div class="form-group col-md-6">
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
        
              <div class="form-group col-md-6">
                <label for="job">Profession</label>
                <select id="job" class="form-control job" name="job">
                        <option value="-1"></option>
                    <?php foreach ($jobs as $key => $job): ?>
                      <option value="<?= $job->id;?>"><?= $job->id;?> - <?= $this->lang->line('mg_job_'.$job->id);?> - <?= $this->lang->line('fr_job_'.$job->id);?></option>
                    <?php endforeach ?>
                        <option value="0">Autres</option>
                </select>
                <input type="text" name="job_other" id="otherJob" placeholder="Préciser la profession" style="display: none; margin-top: 3px;" class="form-control" />
                <div class="error_field jobError"></div>
              </div>
              <div class="form-group col-md-5">
                <label for="job_status">Situation actuelle dans l'emploi</label>
                <input type="text" class="form-control" name="job_status" id="job_status"/>
                <div class="error_field job_statusError"></div>
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-12">
                <label for="observation">Observation</label>
                <textarea class="form-control" placeholer="..." name="observation" id="observation"></textarea>
                <div class="error_field observationError"></div>
              </div>
            </div>
          </div>
          <!--Form at Right side -->
          <div class=" col-md-3">                     
            <a class="btn btn-primary btn-block" id="residence" href="certificate?id_personne=" + id_personne target="_blank" role="button">Certificat de résidence</a><br>
            <a class="btn btn-primary btn-block" id="life" href="" + id_personne target="_blank" role="button">Certificat de vie indiviudel</a><br>
            <a class="btn btn-primary btn-block" id="support" href="" + id_personne target="_blank" role="button">Certificat de prise en charge et de garde</a><br>
            <a class="btn btn-primary btn-block" id="move" href="" + id_personne target="_blank" role="button">Certificat de déménagement</a><br>
            <a class="btn btn-primary btn-block" id="celibacy" href="" + id_personne target="_blank" role="button">Certificat de célibat</a><br>
            <a class="btn btn-primary btn-block" id="behavior" href="" + id_personne target="_blank" role="button">Certificat de bonne conduite - de bonne vie - moeurs</a><br>
          </div> 
          <!--End Form at Right side -->

        </div>
        </form>
        </div>
        <div class="modal-footer">
          <div id="loadingSaveData" style="display: none;">
            <center>
              <img style="width: 50px;" src="<?= img('loading.gif');?>"> Chargement ...
            </center>
          </div>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">
            Fermer
            <span class="iconify" data-icon="uil:times-circle" data-inline="false"></span>
          </button>
          <button type="button" class="btn btn-primary" id="validEditPerson">
            Valider
            <span class="iconify" data-icon="uil:arrow-right" data-inline="false"></span>
          </button>
        </div>
      </div>
          </div> 
          <!--End Form at left side -->
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
	<script src="<?= plugin('modules', 'citizen', 'residence.js');?>"></script>
</body>
</html>
