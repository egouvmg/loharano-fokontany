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
    <div class=row  style="background-color:white;">
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
                <span class="">PREFECTIORAN'NY POLISIN'ANTANANARIVO</span><br>
                <hr class="font-weight-bold">
                <span class="font-weight-bold">DISTRIKAN'<?=$district_name?></span>
              </div>
              <div class="col-sm-3" style="background-color:white;">
            </div>
            <div class="col-sm-5 text-center" style="background-color:white;">
            <!--<span class="font-weight-bold"><h2>FANAMARINAM-PONENANA</h2></span>-->
            <span class="font-weight-bold"><h1>CERTIFICAT DE PRISE EN CHARGE ET DE GARDE</h1></span>
            </div>
          </div>
          
          <div class="row">
            <div class="col-sm-8" style="background-color:white;">
              <span class="font-weight-bold" style="background-color:white;">Le président du fokontany <?= " ".$citizen_data[0]->libelle_fokontany."" ?>, Commune Urbaine 
              d'Antananarivo, Arrondissement <?= " ".$this->data["info_fokontany"]->borough_name?>, selon la déclaration de l'intéressé(e), confirmé par deux témoins
              soussignés :
              </span>
            </div>
            <div class="col-sm-4" style="background-color:white;">
            <br><br><br><br>
            </div>
          </div>
          
          

          <!--CONTENUS-->
          <div class="row">
            <div class="col-sm-12" style="background-color:white;">
             <div class="row">
                <div class="col-sm-5" style="background-color:white;">
                  <span class="font-weight-bold" style="margin-bottom: 0px;">Le déclarant(e) :</span><span id="name"><?= " ".$citizen_data[0]->nom." ".$citizen_data[0]->prenoms."" ?></span>
                </div>

                <div class="col-sm-1" style="background-color:white;"></div>
                  <div class="col-sm-6" style="background-color:white;">
                    <span class="font-weight-bold" style="margin-bottom: 0px;">CIN N° :</span><?= " ".$citizen_data[0]->cin_personne."" ?>
                  </div>
                </div>

             <div class="row">
                <div class="col-sm-6">
                  <span class="font-weight-bold" style="margin-bottom: 0px;">délivré à :</span><?= " ".$citizen_data[0]->lieu_delivrance_cin."" ?>
                </div>
             </div>
             
             <div class="row">
                <div class="col-sm-6">
                  <span class="font-weight-bold" style="margin-bottom: 0px;">Né(e) le :</span><?= " ".$citizen_data[0]->date_de_naissance."" ?>
                </div>

                <div class="col-sm-6">
                  <span class="font-weight-bold" style="margin-bottom: 0px;">à :</span><?= " ".$citizen_data[0]->lieu_de_naissance."" ?>
                </div>
             </div>

             <div class="row">
                <div class="col-sm-6">
                  <span class="font-weight-bold" style="margin-bottom: 0px;">Fils ou fille de :</span><?= " ".$citizen_data[0]->father."" ?>
                </div>

                <div class="col-sm-6">
                  <span class="font-weight-bold" style="margin-bottom: 0px;">et de :</span><?= " ".$citizen_data[0]->mother."" ?>
                </div>
              </div>

             <div class="row">
                <div class="col-sm-4">
                  <span class="font-weight-bold" style="margin-bottom: 0px;">CIN N° :</span><?= " ".$citizen_data[0]->cin_personne."" ?>
                </div>

                <div class="col-sm-4">
                  <span class="font-weight-bold" style="margin-bottom: 0px;">délivrée le :</span><?= " ".$citizen_data[0]->date_delivrance_cin."" ?>
                </div>

                <div class="col-sm-4">
                  <span class="font-weight-bold" style="margin-bottom: 0px;">à :</span><?= " ".$citizen_data[0]->lieu_delivrance_cin."" ?>
                </div>
              </div>

             <div class="row">
                <div class="col-sm-4">
                  <span class="font-weight-bold" style="margin-bottom: 0px;">demeurant à :</span><?= " ".$citizen_data[0]->libelle_fokontany."" ?>
                </div>

                <div class="col-sm-4">
                  <span class="font-weight-bold" style="margin-bottom: 0px;">Lot :</span><?= " ".$citizen_data[0]->adresse_actuelle."" ?>
                </div>

                <div class="col-sm-4">
                  <span class="font-weight-bold" style="margin-bottom: 0px;">depuis :</span><?= " ".$citizen_data[0]->date_arrivee."" ?>
                </div>
              </div>

             <div class="row">
                <div class="col-sm-6">
                  <div class="form-group row" style="margin-bottom: 0px;">
                    <div class="col-sm-4 col-form-label">
                      <label for="Zanak" class="font-weight-bold" style="margin-bottom: 0px;">Témoin 1 :</label>
                    </div>
                    <div class="col-sm-8">
                      <input type="text" class="form-control border-0" style="margin-left:-120px;padding-bottom: 2px;" id="Zanak" placeholder="Nom du Témoin 1" value=""> 
                    </div>
                  </div>
                </div>

                <div class="col-sm-6">
                  <div class="form-group row" style="margin-bottom: 0px;">
                      <div class="col-sm-4 col-form-label">
                        <label for="sy" class="" style="margin-bottom: 0px;">CIN N°</label>
                      </div>
                      <div class="col-sm-8">
                        <input type="text" maxlength="15" class="form-control border-0 cin_personne" style="margin-left:-140px;padding-bottom: 2px;" id="sy" placeholder="000 000 000 000" value=""> 
                      </div>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group row" style="margin-bottom: 0px;">
                    <div class="col-sm-3 col-form-label">
                      <label for="Teraka" class="" style="margin-bottom: 0px;">délivré à</label>
                    </div>
                    <div class="col-sm-9">
                      <input type="text" class="form-control border-0" style="margin-left:-80px;padding-bottom: 2px;" id="Teraka" placeholder="Lieu obtention CIN du Témoin 1" value=""> 
                    </div>
                  </div>
                </div>

                <div class="col-sm-6">
                  <div class="form-group row" style="margin-bottom: 0px;">
                    <div class="col-sm-4 col-form-label">
                      <label for="tao" class="" style="margin-bottom: 0px;">le</label>
                    </div>
                    <div class="col-sm-8">
                      <input type="text" class="form-control border-0 date_type" style="margin-left:-170px;padding-bottom: 2px;" id="tao" placeholder="jj/mm/aaaa" value=""> 
                    </div>
                  </div>
                </div>
             </div>

             <div class="row">
                <div class="col-sm-6">
                  <div class="form-group row" style="margin-bottom: 0px;">
                    <div class="col-sm-4 col-form-label">
                      <label for="Zanak" class="font-weight-bold" style="margin-bottom: 0px;">Témoin 2 :</label>
                    </div>
                    <div class="col-sm-8">
                      <input type="text" class="form-control border-0" style="margin-left:-120px;padding-bottom: 2px;" id="Zanak" placeholder="Nom du Témoin 2" value=""> 
                    </div>
                  </div>
                </div>

                <div class="col-sm-6">
                  <div class="form-group row" style="margin-bottom: 0px;">
                      <div class="col-sm-4 col-form-label">
                        <label for="sy" class="" style="margin-bottom: 0px;">CIN N°</label>
                      </div>
                      <div class="col-sm-8">
                        <input type="text" maxlength="15" class="form-control border-0 cin_personne" style="margin-left:-140px;padding-bottom: 2px;" id="sy" placeholder="000 000 000 000" value=""> 
                      </div>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group row" style="margin-bottom: 0px;">
                    <div class="col-sm-3 col-form-label">
                      <label for="Teraka" class="" style="margin-bottom: 0px;">délivré à</label>
                    </div>
                    <div class="col-sm-9">
                      <input type="text" class="form-control border-0" style="margin-left:-80px;padding-bottom: 2px;" id="Teraka" placeholder="Lieu obtention CIN du Témoin 2" value=""> 
                    </div>
                  </div>
                </div>

                <div class="col-sm-6">
                  <div class="form-group row" style="margin-bottom: 0px;">
                    <div class="col-sm-4 col-form-label">
                      <label for="tao" class="" style="margin-bottom: 0px;">le</label>
                    </div>
                    <div class="col-sm-8">
                      <input type="text" class="form-control border-0 date_type" style="margin-left:-170px;padding-bottom: 2px;" id="tao" placeholder="jj/mm/aaaa" value=""> 
                    </div>
                  </div>
                </div>
             </div>


             <div class="row">
                <div class="col-sm-6">
                    <div class="form-group row" style="margin-bottom: 0px;">
                    <div class="col-sm-3 col-form-label">
                      <label for="tao" class="" style="margin-bottom: 0px;">Certifie que :</label>
                    </div>
                    <div class="col-sm-9">
                      <input type="text" class="form-control border-0" style="margin-left:-60px;padding-bottom: 2px;" id="tao" placeholder="Nom de la personne prise en charge" value=""> 
                    </div>
                  </div>
                </div>
                  <div class="col-sm-6">
                  <span>est pris en charge </span>
                  </div>
             </div>

             <div class="row">
                <div class="col-sm-12">
                    <span>déclarant, ainsi que les deux témoins sont des ressortissants de Fokontany 
                    <?= " ".$citizen_data[0]->libelle_fokontany."" ?>.</span>
                  </div>
             </div>

             <div class="row">
              <div class="col-sm-10">
                  <div class="form-group row" style="margin-bottom: 0px;">
                        <div class="col-sm-5 col-form-label">
                          <label for="tao" class="" style="margin-bottom: 0px;">Le présent certificat est établi et délivré à</label>
                        </div>
                        <div class="col-sm-7">
                          <input type="text" class="form-control border-0" style="margin-left:-120px;padding-bottom: 2px;" id="tao" placeholder="Nom à remplir" value=""> 
                        </div>
                  </div>
                </div>
                  <div class="col-sm-2">
                      <span>pour</span>
                  </div>
              </div>

             <div class="row">
              <div class="col-sm-10">
                  <div class="form-group row" style="margin-bottom: 0px;">
                        <div class="col-sm-7 col-form-label">
                          <label for="tao" class="" style="margin-bottom: 0px;">servir et valoir ce que de 
                          droit en particulier et uniquement pour 
                          </label>
                        </div>
                        <div class="col-sm-5">
                          <input type="text" class="form-control border-0" style="margin-left:-120px;padding-bottom: 2px;" id="tao" placeholder="Nom à remplir" value=""> 
                        </div>
                  </div>
                </div>
                  <div class="col-sm-2">
                      <span></span>
                  </div>
              </div>

             <div class="row" style="background-color:white;">
                <div class="col-sm-4" style="background-color:white;">
                  <span class="font-weight-bold">Témoin 1</span>  
                </div>
                <div class="col-sm-4" style="background-color:white;">
                  <span class="font-weight-bold">Témoin 2</span>  
                </div>
                <div class="col-sm-4" style="background-color:white;">
                  <span class="font-weight-bold">Le déclarant(e)</span>  
                </div>
             </div>

          </div>
          </div>
          <!--FOOTER-->
          <div class="row">
            <div class="col-sm-12" style="background-color:white;">
                  <br>  <br> <br>  <br> 
            </div>
          </div>

          <div class="row">
            <div class="col-sm-6" style="background-color:white;"></div>
            <div class="col-sm-6" style="background-color:white;">

            <div class="form-group row" style="margin-bottom: 0px;">
                        <div class="col-sm-7 col-form-label">
                          <label for="tao" class="" style="margin-bottom: 0px;"><?= "".$citizen_data[0]->libelle_fokontany."" ?>, le</label>
                        </div>
                        <div class="col-sm-5">
                          <input type="text" class="form-control border-0" style="margin-left:-150px;padding-bottom: 2px;" id="tao" value=<?= "'".date('d-m-Y')."'" ?>> 
                        </div>
                  </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-6" style="background-color:white;">
              <span class="font-weight-bold" style="margin-bottom: 0px;">N° :</span><?= " ".addslashes($reference).'  ./'.date('y')."" ?>
            </div>
            <div class="col-sm-6" style="background-color:white;">
              <u>LE CHEF DU FOKONTANY </u>
            </div>
          </div>

          <div class="row">
            <div class="col-sm-12" style="background-color:white;">
                  <br>  <br> <br>  <br> 
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
  <script src="<?= plugin('modules', 'superadmin', 'html2canvas.js');?>"></script>
  <!-- <script src="https://unpkg.com/jspdf@latest/dist/jspdf.min.js"></script> -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.debug.js"></script>
	<script src="<?= plugin('modules', 'superadmin', 'citizen_certificate.js');?>"></script>
<div id="appVersion"> Loharano Fokontany, version <?= APP_VERSION;?> &copy; <a href="https://digital.gov.mg" target="_blank">e-Gouvernance Madagascar</a> - <?= date("Y");?></div>
</body>
</html>
