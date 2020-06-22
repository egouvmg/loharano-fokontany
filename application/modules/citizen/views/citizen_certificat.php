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
  <style>
  </style>
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
              Fokontany
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
      <ul class="main-menu">
          <li>
            <a href="gestion_citoyens"><span class="iconify" data-icon="bi:people-fill" data-inline="false"></span> <?=$this->lang->line('citizens');?></a>
            <ul class="sub-main-menu" style="display:none;">
              <li><a href="recherche_menage"><?=$this->lang->line('add_citizen');?></a></li>
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
            <a href="#"><span class="iconify" data-icon="carbon:certificate" data-inline="false"></span> <?=$this->lang->line('certificates');?></a>
            <ul class="sub-main-menu" style="display:none;">
              <li><a href="residence">Résidence</a></li>
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
        <div class="row">
            <div class="col-lg-12">
                <div id="users"></div>
                <button type="button" class="btn btn-primary" id="pdf"> Générer pdf</button>
          </div>
        </div>
        <div class="container-fluid" id="content">
        <div >          
          <!--REPOBLIKAN'I MADAGASIKARA-->
          <div class="row">
            <div class="col-sm-4" style="background-color:white;"></div>
            <div class="col-sm-4 text-center" style="background-color:white;">
              <span class="">REPOBLIKAN'I MADAGASIKARA</span><br>
              <span class="">Fitiavana - Tanindrazana - Fandrosona</span>
            </div>
            <div class="col-sm-4" style="background-color:white;"></div>
          </div>
          <!--MINISTERANY ATITANY-->
          <div class="row">
            <div class="col-sm-4 text-center" style="background-color:white;">
              <span class="">MINISTERAN'NY ATITANY SY NY FITSINJARAM-PAHEFANA</span><br>
              <hr>
              <span class="">PREFECTIORAN'NY POLISIN'ANTANANARIVO</span><br>
              <hr class="font-weight-bold">
              <span class="font-weight-bold">DISTRIKAN'ANTANANARIVO II</span>
            </div>
            <div class="col-sm-4" style="background-color:white;">
            </div>
            <div class="col-sm-4 text-center" style="background-color:white;">
            <span class="font-weight-bold"><h2>FANAMARINAM-PONENANA</h2></span>
            <span class="font-weight-bold"><h1>CERTIFICAT DE RESIDENCE</h1></span>
            </div>
          </div>
          <!--FOKONTANY-->
          <div class="row"><!-- https://codepen.io/pen/ style="background-color:lavender;"-->
            <div class="col-sm-8"  style="background-color:white;">
              <div class="form-group row" style="margin-bottom: 0px;">
               <label for="fokontany" class="col-sm-2 col-form-label font-weight-bold">FOKONTANY :</label>
               <div class="col-sm-10">
                 <input type="text" class="form-control border-0" style="margin-left:-50px;" id="fokontany" value=<?= "'".addslashes($citizen_data[0]->libelle_fokontany)."'" ?>> 
                </div>
              </div>

              <div class="form-group row" style="margin-bottom: 0px;">
               <label for="Lf" class="col-sm-2 col-form-label font-weight-bold">Lf :</label>
               <div class="col-sm-10">
                 <input type="text" class="form-control border-0" style="margin-left:-50px;" id="Lf" value=<?= "'".addslashes($citizen_data[0]->lf_residence)."'" ?>> 
                </div>
              </div>
            </div>
            <div class="col-sm-4 text-center" style="background-color:white;">
            <span class="font-weight-bold"><h5>NY SEFO FOKONTANY DIA MANAMARINA FA :</h5></span>
            <span class="font-weight-bold"><h5>LE CHEF FOKONTANY CERTIFIE QUE :</h5></span>
            </div>
          </div>

          <!--CONTENUS-->
          <div class="row">
            <div class="col-sm-12" style="background-color:white;">
             <div class="row">
                <div class="col-sm-5">
                  <div class="form-group row" style="margin-bottom: 0px;">
                    <div class="col-sm-3 col-form-label">
                      <label for="Atoa" class="font-weight-bold" style="margin-bottom: 0px;">Atoa/Rtoa :</label>
                      <p class="font-italic">M./Mme/Mlle</p>
                    </div>
                    <div class="col-sm-9">
                      <input type="text" class="form-control border-0" style="margin-left:-50px;padding-bottom: 2px;" id="Atoa" value=<?= "'".$citizen_data[0]->nom." ".$citizen_data[0]->prenoms."'" ?>> 
                    </div>
                  </div>
                </div>

                <div class="col-sm-4"></div>
                  <div class="col-sm-3"> 
                    <div class="form-group row" style="margin-bottom: 0px;">
                      <div class="col-sm-4 col-form-label">
                        <label for="Asa" class="font-weight-bold" style="margin-bottom: 0px;">Asa :</label>
                        <p class="font-italic">Profession</p>
                      </div>
                      <div class="col-sm-8">
                        <input type="text" class="form-control border-0" style="margin-left:-75px;padding-bottom: 2px;" id="Asa" value=<?= "'".$citizen_data[0]->job."'" ?>> 
                      </div>
                    </div>
                  </div>

              </div>

             <div class="row">
                <div class="col-sm-4">
                  <div class="form-group row" style="margin-bottom: 0px;">
                    <div class="col-sm-5 col-form-label">
                      <label for="Teraka" class="font-weight-bold" style="margin-bottom: 0px;">Teraka tamin'ny :</label>
                      <p class="font-italic">Né(e) le </p>
                    </div>
                    <div class="col-sm-7">
                      <input type="text" class="form-control border-0" style="margin-left:-50px;padding-bottom: 2px;" id="Teraka" value=<?= "'".$citizen_data[0]->date_de_naissance."'" ?>> 
                    </div>
                  </div>
                </div>

                <div class="col-sm-4">
                  <div class="form-group row" style="margin-bottom: 0px;">
                    <div class="col-sm-5 col-form-label">
                      <label for="tao" class="font-weight-bold" style="margin-bottom: 0px;">tao :</label>
                      <p class="font-italic">à</p>
                    </div>
                    <div class="col-sm-7">
                      <input type="text" class="form-control border-0" style="margin-left:-150px;padding-bottom: 2px;" id="tao" value=<?= "'".$citizen_data[0]->lieu_de_naissance."'" ?>> 
                    </div>
                  </div>
                </div>

                  <div class="col-sm-4">
                    <div class="form-group row" style="margin-bottom: 0px;">
                      <div class="col-sm-5 col-form-label">
                        <label for="Zom" class="font-weight-bold" style="margin-bottom: 0px;">Zom-pirenena :</label>
                        <p class="font-italic">Nationalité</p>
                      </div>
                      <div class="col-sm-7">
                        <input type="text" class="form-control border-0" style="margin-left:-78px;padding-bottom: 2px;" id="Zom" value=<?= "'".$citizen_data[0]->nationalite."'" ?>> 
                      </div>
                    </div>
                  </div> 
             </div>

             <div class="row">
                <div class="col-sm-6">
                  <div class="form-group row" style="margin-bottom: 0px;">
                    <div class="col-sm-5 col-form-label">
                      <label for="Zanak" class="font-weight-bold" style="margin-bottom: 0px;">Zanak'i :</label>
                      <p class="font-italic">Fils ou fille de </p>
                    </div>
                    <div class="col-sm-7">
                      <input type="text" class="form-control border-0" style="margin-left:-200px;padding-bottom: 2px;" id="Zanak" value=<?= "'".$citizen_data[0]->father."'" ?>> 
                    </div>
                  </div>
                </div>

                <div class="col-sm-6">
                  <div class="form-group row" style="margin-bottom: 0px;">
                      <div class="col-sm-5 col-form-label">
                        <label for="sy" class="font-weight-bold" style="margin-bottom: 0px;">sy :</label>
                        <p class="font-italic">et de</p>
                      </div>
                      <div class="col-sm-7">
                        <input type="text" class="form-control border-0" style="margin-left:-240px;padding-bottom: 2px;" id="sy" value=<?= "'".$citizen_data[0]->mother."'" ?>> 
                      </div>
                  </div>
                </div>
              </div>

             <div class="row">
                <div class="col-sm-12">
                    <div class="form-group row" style="margin-bottom: 0px;">
                        <div class="col-sm-5 col-form-label">
                          <label for="Monina" class="font-weight-bold" style="margin-bottom: 0px;">Dia monina ao amin'ny :</label>
                          <p class="font-italic">Réside au</p>
                        </div>
                        <div class="col-sm-7">
                          <input type="text" class="form-control border-0" style="margin-left:-350px;padding-bottom: 2px;" id="Monina" value=<?= "'".$citizen_data[0]->adresse_actuelle."'" ?>> 
                        </div>
                    </div>
                </div>
             </div>

             <div class="row">
                <div class="col-sm-12">


                <div class="form-group row" style="margin-bottom: 0px;">
                        <div class="col-sm-5 col-form-label">
                          <label for="sy" style="margin-bottom: 0px;"><span class="font-weight-bold">Antony ilàna azy</span> (<span class="font-italic">Motif d'usage</span>): </label>
                        </div>
                        <div class="col-sm-7">
                          <input type="text" class="form-control border-0" style="margin-left:-300px;padding-bottom: 2px;" id="sy" value="" placeholder="Antony ilàna azy" autofocus> 
                        </div>
                    </div>
                </div>
             </div>

             <div class="row">
                <div class="col-sm-12">
                  <span class="font-weight-bold">Noho izany, dia nomena azy ity fanamarinana ity, mba hampiasainy sy hanan-kery amin'izay rehetra mety ilàna: azy.</span>
                  <p class="font-italic">En foi de quoi, le présent certificat lui est délivré pour servir et valoir ce que de droit.</p>
                </div>
             </div>
          </div>
          </div>
          <!--FOOTER-->
          <div class="row">
            <div class="col-sm-4" style="background-color:white;">
              <div class="form-group row" style="margin-bottom: 0px;">
                <label for="Lf" class="col-sm-7 col-form-label font-weight-bold">Fanisam-bahoaka lf :</label>
                <div class="col-sm-5">
                  <input type="text" class="form-control border-0" style="margin-left:-50px;" id="Lf" value=<?= "'".addslashes($citizen_data[0]->lf_residence)."'" ?>> 
                </div>
              </div>

              <div class="form-group row" style="margin-bottom: 0px;">
                <label for="Lf" class="col-sm-7 col-form-label font-weight-bold">CIN-Passeport N°:</label>
                <div class="col-sm-5">
                  <input type="text" class="form-control border-0" style="margin-left:-50px;" id="Lf" value=<?= "'".addslashes($citizen_data[0]->cin_personne)."'" ?>> 
                </div>
              </div>

              <div class="form-group row" style="margin-bottom: 0px;">
                <label for="Lf" class="col-sm-7 col-form-label font-weight-bold">du:</label>
                <div class="col-sm-5">
                  <input type="text" class="form-control border-0" style="margin-left:-50px;" id="Lf" value=<?= " ".$citizen_data[0]->date_delivrance_cin. " " ?>> 
                  
                </div>
                <label for="Lf" class="col-sm-7 col-form-label font-weight-bold">à</label>
                <div class="col-sm-5">
                  <input type="text" class="form-control border-0" style="margin-left:-50px;" id="Lf" value=<?= " ".$citizen_data[0]->lieu_delivrance_cin. " " ?>> 

                </div>
              </div>

              <div class="form-group row" style="margin-bottom: 0px;">
                <label for="Lf" class="col-sm-7 col-form-label font-weight-bold">N°:</label>
                <div class="col-sm-5">
                  <input type="text" class="form-control border-0" style="margin-left:-50px;" id="Lf" value=<?= "'".addslashes($citizen_data[0]->cin_personne)."'" ?>> 
                </div>
              </div>

            </div>

            <!--Ecusson-->
            <div class="col-sm-2" style="background-color:white;">
              <img src="<?= img('ecussons/cua.png');?>">
            </div>
            <div class="col-sm-6" style="background-color:white;">
            <div class="row">
                <div class="col-sm-6">
                  <div class="form-group row" style="margin-bottom: 0px;">
                    <div class="col-sm-5 col-form-label">
                      <label for="Zanak" class="font-weight-bold" style="margin-bottom: 0px;">Natao teto :</label>
                      <p class="font-italic">Fait à </p>
                    </div>
                    <div class="col-sm-7">
                      <input type="text" class="form-control border-0" style="margin-left:-30px;padding-bottom: 2px;" id="Zanak" value=<?= "'".$citizen_data[0]->libelle_fokontany."'" ?>> 
                    </div>
                  </div>
                </div>

                <div class="col-sm-6">
                  <div class="form-group row" style="margin-bottom: 0px;">
                      <div class="col-sm-6 col-form-label">
                        <label for="sy" class="font-weight-bold" style="margin-bottom: 0px;">androany faha</label>
                        <p class="font-italic">le</p>
                      </div>
                      <div class="col-sm-6">
                        <input type="text" class="form-control border-0" style="margin-left: -40px;padding-bottom: 2px;" id="sy" value=<?= "'".date('d-m-Y')."'" ?>> 
                      </div>
                  </div>
                </div>
              </div>           
            </div>
          </div>

          <div class="row">
            <div class="col-sm-4" style="background-color:white;">
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
	<div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-body text-center">
					<span class="icon-check">
					<span class="iconify" data-inline="false" data-icon="uil:check" style="font-size: 32px;"></span>
					</span>
					<p id="confirmResponse"></p>
					<a href="ajout_utilisateur"><button type="button" class="btn btn-primary btn-lg">Ok</button></a>
				</div>
			</div>
		</div>
  	</div>
  <!-- Modal END -->
	<script src="<?= js('jquery.min');?>"></script>
  <script src="<?= plugin('bootstrap', 'js', 'bootstrap.bundle.min.js');?>"></script>
	<script src="<?= plugin('tabulator', 'js', 'tabulator.min.js');?>"></script>
	<script src="<?= plugin('modules', 'common', 'index.js');?>"></script>
	<script src="<?= plugin('modules', 'common', 'location.js');?>"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.js"></script>
  <script src="<?= plugin('modules', 'common', 'jspdf.min.js');?>"></script>
	<script src="<?= plugin('modules', 'superadmin', 'citizen_certificate.js');?>"></script>
</body>
</html>
