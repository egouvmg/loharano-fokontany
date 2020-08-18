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
              <?= $this->lang->line('administrator');?>
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
            <a href="#"><span class="iconify" data-icon="clarity:users-solid" data-inline="false"></span> <?=$this->lang->line('users');?></a>
            <ul class="sub-main-menu">
              <li><a href="ajout_utilisateur"><?=$this->lang->line('add_user');?></a></li>
              <li><a href="liste_utilisateur"><?=$this->lang->line('list_users');?></a></li>
            </ul>
          </li>
          <li>
            <a href="#"><span class="iconify" data-icon="ic:outline-family-restroom" data-inline="false"></span> Ménage</a>
            <ul class="sub-main-menu" style="display:none;">
              <li><a href="liste_menage_fokontany">Liste des ménages</a></li>
              <li><a href="#">Créer nouveau menage</a></li>
            </ul>
          </li>
        </ul>
      </div>
      <div class="main-container admin-container">
        <!-- Page title --> 
        <div class="container-fluid page-title">
          <h1><?= $title;?></h1>
        </div>
        <!-- End Page title -->

        <!-- Page Content -->
        <div class="row">
            <div class="col-lg-12">
                <div id="users"></div>
                <button type="button" class="btn btn-primary" id="pdf"> Imprimer pdf</button>
          </div>
        </div>
        <div class="container-fluid" id="content">
        <div >          
          <!--REPOBLIKAN'I MADAGASIKARA-->
          <div class="row">
            <div class="col-sm-4" style="background-color:lavender;"></div>
            <div class="col-sm-4 text-center" style="background-color:lavender;">
              <span class="">REPOBLIKAN'I MADAGASIKARA</span><br>
              <span class="">Fitiavana - Tanindrazana - Fandrosona</span>
            </div>
            <div class="col-sm-4" style="background-color:lavender;"></div>
          </div>
          <!--MINISTERANY ATITANY-->
          <div class="row">
            <div class="col-sm-4 text-center" style="background-color:lavender;">
              <span class="">MINISTERAN'NY ATITANY SY NY FITSINJARAM-PAHEFANA</span><br>
              <hr>
              <span class="">PREFECTIORAN'NY POLISIN'ANTANANARIVO</span><br>
              <hr class="font-weight-bold">
              <span class="font-weight-bold">DISTRIKAN'ANTANANARIVO VI</span>
            </div>
            <div class="col-sm-2" style="background-color:lavender;">
            </div>
            <div class="col-sm-6 text-center" style="background-color:lavender;">
            <span class="font-weight-bold">FANAMARINAM-PONENANA</span><br>
            <span class="font-weight-bold">CERTIFICAT DE RESIDENCE</span>
            </div>
          </div>
          <!--FOKONTANY-->
          <div class="row"><!-- https://codepen.io/pen/ style="background-color:lavender;"-->
            <div class="col-sm-8"  style="background-color:lavender;">
              <span class="font-weight-bold">FOKONTANY :</span> <?= $citizen_data[0]->libelle_fokontany ?>          
            <p><span class="font-weight-bold">Lf :</span></p>
            </div>
            <div class="col-sm-4 text-center" style="background-color:lavender;">
            <span class="font-weight-bold">NY SEFO FOKONTANY DIA MANAMARINA FA :</span><br>
            <span class="font-weight-bold">LE CHEF FOKONTANY CERTIFIE QUE :</span>
            </div>
          </div>

          <!--CONTENUS-->
          <div class="row">
            <div class="col-sm-12" style="background-color:lavender;">
             <div class="row">
              <div class="col-sm-5">
               <span class="font-weight-bold">Atoa/Rtoa : </span> <?= $citizen_data[0]->nom." ".$citizen_data[0]->prenoms ?>
               <p class="font-italic">M./Mme/Mlle</p>
              </div>
              <div class="col-sm-4"></div>
              <div class="col-sm-3"> 
              <span class="font-weight-bold">Asa :</span>
              <p class="font-italic">Profession</p>
              </div>
            </div>
             
             <div class="row">
                <div class="col-sm-4">
                <span class="font-weight-bold">Teraka tamin'ny :</span> </span><?= $citizen_data[0]->date_de_naissance ?>
                <p class="font-italic">Né(e) le </p>
                </div>
                <div class="col-sm-4">
                <span class="font-weight-bold">tao :</span><?= $citizen_data[0]->lieu_de_naissance ?>
                <p class="font-italic">à</p>
                </div>
                <div class="col-sm-4">
                <span class="font-weight-bold">Zom-pirenena :</span><?= $citizen_data[0]->nationalite ?>
                <p class="font-italic">Nationalité</p>
                </div>                                                                 
             </div>
             <div class="row">
             <div class="col-sm-6">
             <span class="font-weight-bold">Zanak'i :</span>
             <p class="font-italic">Fils ou fille de </p>
             </div>
             <div class="col-sm-6">
              <span class="font-weight-bold">sy :</span>
              <p class="font-italic">et de</p>   
             </div>
             </div>
             <div class="row">
             <div class="col-sm-12">
            <span class="font-weight-bold"> Dia monina ao amin'ny :</span><?= $citizen_data[0]->nom." ".$citizen_data[0]->adresse_actuelle ?>    
             <p class="font-italic">Réside au</p>
             </div>
             </div>
             <div class="row">
              <div class="col-sm-12">
                <p><span class="font-weight-bold">Antony ilàna azy</span> (<span class="font-italic">Motif d'usage</span>): </p>
              </div>
             </div>
             <div class="row">
              <div class="col-sm-12">
              <span class="font-weight-bold">Noho izany, dia nomena azy ity fanamarinana ity, mba hampiasainy sy hanan-kery amin'izay rehetra mety ilàna: azy.</span>
             <p class="font-italic">En foi de quoi, le présent certificat lui est délivré pour servir et valoir ce que de droit.</p>
              </div>
             </div>
             </div>
         <!--Eto le div  -->
          </div>
          <!--FOOTER-->
          <div class="row">
            <div class="col-sm-4" style="background-color:lavender;">
            <p>Fanisam-bahoaka lf:...................................</p>
            <p>CIN-Passeport N°: <?= $citizen_data[0]->cin_personne ?></p>
            <p>du:....................à..............................</p>
            <p class="font-weight-bold"> N°                                                    </p>
            </div>

            <!--Ecusson-->
            <div class="col-sm-3" style="background-color:lavender;">
              <img src="<?= img('ecussons/cua.png');?>">
            </div>
            <div class="col-sm-5" style="background-color:lavender;">
             <div class="row">
              <div class="col-sm-6" style="background-color:lavender;">
              Natao teto:<br>
              <span class="font-italic">Fait à</span>
              </div>
              <div class="col-sm-6" style="background-color:lavender;">
              androany faha<br>
              <span class="font-italic">le</span>
              </div>
             </div>            
            </div>
          </div>

          <div class="row">
            <div class="col-sm-4" style="background-color:lavender;">
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
<div id="appVersion"> Loharano Fokontany, version <?= APP_VERSION;?> &copy; <a href="https://digital.gov.mg" target="_blank">e-Gouvernance Madagascar</a> - <?= date("Y");?></div>
</body>
</html>
