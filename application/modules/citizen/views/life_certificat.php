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
   input[readonly] {background-color: white !important;}
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
      <input type="hidden" id="id_personne" name="id_personne" value="<?= $id_personne?>"/>
      <input type="hidden" id="origin_page" name="origin_page" value="<?= $origin_page?>"/>
      <input type="hidden" id="fokontany_id" name="fokontany_id" value="<?= $fokontany_id?>"/>
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
        </div>
        <!-- End Page title -->

        <!-- Page Content -->
        <div class="row">
            <div class="col-lg-12">
                <div id="users"></div>
                <button type="button" class="btn btn-primary" id="pdf"> Imprimer pdf</button>
          </div>
        </div>
        <div class="container" id="content">
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
              <span class="">PREFEKITORAN'NY POLISIN'ANTANANARIVO</span><br>
              <hr class="font-weight-bold">
              <span class="font-weight-bold">DISTRIKAN'ANTANANARIVO II</span>
            </div>
            <div class="col-sm-4" style="background-color:white;">
            </div>
            <div class="col-sm-4 text-center" style="background-color:white;">
            <span class="font-weight-bold"><h2>FANAMARINAM-PAHAVELOMANA</h2></span>
            <span class="font-weight-bold"><h1>CERTIFICAT DE VIE INDIVIDUEL</h1></span>
            </div>
          </div>
          <!--FOKONTANY-->
          <div class="row"><!-- https://codepen.io/pen/ style="background-color:lavender;"-->
            <div class="col-sm-8"  style="background-color:white;">
              <div class="form-group row" style="margin-bottom: 0px;">
                <div class="col-sm-12">
                  <span class="font-weight-bold" style="margin-bottom: 0px;">FOKONTANY :</span><?=" ".$citizen_data[0]->libelle_fokontany?>
                </div>
              </div>

              <div class="form-group row" style="margin-bottom: 0px;">
               <div class="col-sm-12">
                 <span class="font-weight-bold" style="margin-bottom: 0px;">Lf :</span><?= " ".addslashes($citizen_data[0]->lf_vie+1).' . '.date('y')."" ?>
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
                  <span class="font-weight-bold" style="margin-bottom: 0px;">Atoa/Rtoa :</span><span id="name"><?= " ".$citizen_data[0]->nom." ".$citizen_data[0]->prenoms."'" ?></span>
                  <p class="font-italic">M./Mme/Mlle</p>
                </div>

                <div class="col-sm-4"></div>
                  <div class="col-sm-3"> 
                    <span class="font-weight-bold" style="margin-bottom: 0px;">Asa :</span><?=$citizen_data[0]->job?>
                    <p class="font-italic">Profession</p>
                  </div>
                </div>

                <div class="row">
                  <div class="col-sm-4">
                    <span class="font-weight-bold" style="margin-bottom: 0px;">Teraka tamin'ny :</span><?=" ".$citizen_data[0]->date_de_naissance?>
                    <p class="font-italic">Né(e) le</p>
                  </div>

                <div class="col-sm-4">
                  <span class="font-weight-bold" style="margin-bottom: 0px;">tao :</span><?=" ".$citizen_data[0]->lieu_de_naissance?>
                  <p class="font-italic">à</p>
                </div>

                  <div class="col-sm-4">
                    <span class="font-weight-bold" style="margin-bottom: 0px;">Zom-pirenena :</span><?=" ".$citizen_data[0]->nationalite?>
                    <p class="font-italic">Nationalité</p>
                  </div> 
             </div>

             <div class="row">
                <div class="col-sm-6">
                  <span class="font-weight-bold" style="margin-bottom: 0px;">Zanak'i :</span><?=" ".$citizen_data[0]->father?>
                  <p class="font-italic">Fils ou fille de</p>
             </div>

                <div class="col-sm-6">
                  <span class="font-weight-bold" style="margin-bottom: 0px;">sy :</span><?=" ".$citizen_data[0]->mother?>
                  <p class="font-italic">et de</p>
                </div>
              </div>

              <div class="row">
                <div class="col-sm-4">
                  <span class="font-weight-bold" style="margin-bottom: 0px;">Kara-panondrom-pirenena lf (CNI) :</span><?=" ".$citizen_data[0]->cin_personne?>
              </div>

                <div class="col-sm-4">
                  <span class="font-weight-bold" style="margin-bottom: 0px;">nomena ny (du) :</span><?=" ".$citizen_data[0]->date_delivrance_cin?>
                </div>

                  <div class="col-sm-4">
                    <span class="font-weight-bold" style="margin-bottom: 0px;">tao (à) :</span><?=" ".$citizen_data[0]->lieu_delivrance_cin?>
                  </div> 
             </div>

             <div class="row">
                <div class="col-sm-12">
                    <span class="font-weight-bold" style="margin-bottom: 0px;">Monina ao amin'ny :</span><?=" ".$citizen_data[0]->adresse_actuelle?>
                    <p class="font-italic">Réside au</p>
                </div>
             </div>

             <div class="row">
                <div class="col-sm-3"></div>
                <div class="col-sm-6">
                  <span style="padding:50px;" class="font-weight-bold">DIA VELONA ARY NISEHO TETO ANATREHANAY ANDROANY.</span>
                  <p class="font-italic">EST BIEN VIVANTE ET S'EST PRESÉNTÉ(E) DEVANT NOUS AUJOURD'HUI MÊME.</p>
                </div>
                <div class="col-sm-3"></div>
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
              <div class="col-sm-7 col-form-label">
                <label for="Lf" class="font-weight-bold">Fanisam-bahoaka lf :</label>
                <p class="font-italic">Recensement n°</p>
              </div>
                
                <div class="col-sm-5">
                  <input type="text" class="form-control border-0" style="margin-left:-50px;" id="Lf" value="" placeholder="Fanisana..."> 
                </div>
              </div>

              <div class="form-group row" style="margin-bottom: 0px;">
                <div class="col-sm-12">
                  <span class="font-weight-bold">N° :</span><?= " ".addslashes($reference).'  ./'.date('y')."" ?>
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
                  <span class="font-weight-bold" style="margin-bottom: 0px;">Natao teto :</span><?=$citizen_data[0]->libelle_fokontany?>
                  <p class="font-italic">Fait à</p>
                </div>

                <div class="col-sm-6">
                  <span class="font-weight-bold" style="margin-bottom: 0px;">androany faha</span><?= " ".date('d-m-Y')."" ?>
                  <p class="font-italic">le</p>
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
  <script src="https://unpkg.com/jspdf@latest/dist/jspdf.min.js"></script>
	<script src="<?= plugin('modules', 'superadmin', 'citizen_certificate.js');?>"></script>
</body>
</html>
