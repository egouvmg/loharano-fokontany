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

  <div class="container-fluid">
    <div class=row>
      <div class="main-side-bar">
        <ul class="main-menu">
          <li>
            <a href="gestion_citoyens"><span class="iconify" data-icon="bi:people-fill" data-inline="false"></span> <?=$this->lang->line('citizens');?></a>
            <ul class="sub-main-menu">
              <li><a href="recherche_menage" class="active"><?=$this->lang->line('add_citizen');?></a></li>
              <li><a href="liste_citoyens"><?=$this->lang->line('list_citizen');?></a></li>
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
            <a href="#"><span class="iconify" data-icon="ant-design:setting-filled" data-inline="false"></span> <?=$this->lang->line('settings');?></a>
          </li>
        </ul>
      </div>
      <div class="main-container">
        <!-- Page title -->
        <p class="info-fokontany"><span>Province : </span><?= $info_fokontany->province_name;?> <span>Région : </span><?= $info_fokontany->region_name;?> <span>District : </span><?= $info_fokontany->district_name;?> <span>Commune : </span><?= $info_fokontany->common_name;?></p>
        
        <div class="container-fluid page-title">
          <h1><?= $title;?> - <?=$this->lang->line('step');?> 02</h1>
        </div>
        <!-- End Page title -->

        <!-- Page Content -->
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <p><?= $this->lang->line('searching_household');?></p>
                </div>
                <div class="col-lg-12">
                  <div class="row">
                    <div class="col-lg-3">
                      <div class="form-group col-md-12 orange">
                          <?=$this->lang->line('info_citizen');?>
                      </div>
                      <div class="form-group col-md-12">
                          <label for="last_name"><?=$this->lang->line('last_name');?> *</label>
                          <input type="text" class="form-control" id="last_name" name="last_name" placeholder="...">
                          <span class="error_field error_last_name"></span>
                      </div>
                      <div class="form-group col-md-12">
                          <label for="first_name"><?=$this->lang->line('first_name');?> *</label>
                          <input type="text" class="form-control" id="first_name" name="first_name" placeholder="...">
                          <span class="error_field error_first_name"></span>
                      </div>
                      <div class="form-group col-md-12">
                          <label for="birth"><?=$this->lang->line('birth');?> *</label>
                          <input type="date" class="form-control" id="birth" name="birth" placeholder="jj/mm/aaaa">
                          <span class="error_field error_birth"></span>
                      </div>
                      <div class="form-group col-md-12">
                          <label for="birth_place"><?=$this->lang->line('birth_place');?> *</label>
                          <input type="text" class="form-control" id="birth_place" name="birth_place" placeholder="...">
                          <span class="error_field error_birth_place"></span>
                      </div>
                      <div class="form-group col-md-12">
                          <label for="father"><?=$this->lang->line('father');?></label>
                          <input type="text" class="form-control" id="father" name="father" placeholder="...">
                          <span class="error_field error_father"></span>
                      </div>
                      <div class="form-group col-md-12">
                          <label for="mother"><?=$this->lang->line('mother');?></label>
                          <input type="text" class="form-control" id="mother" name="mother" placeholder="...">
                          <span class="error_field error_mother"></span>
                      </div>
                    </div>
                    <div class="col-lg-9">
                      <div class="form-group col-md-12 orange">
                          <?=$this->lang->line('household_matches');?>
                      </div>
                      <div class="form-group col-md-12">
                          <div id="households"></div>
                      </div>
                    </div>
                  </div>
                </div>
            </div>
        </div>
        <!-- End Page Content -->
        
        <!-- Modal -->
        <div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-body text-center">
                <p>Voulez-vous mettre le citoyen dans ce ménage?</p>
                <ul>
                  <li><strong class="orange">Numéro carnet</strong> : <span id="tmpNotebook"></span></li>
                  <li><strong class="orange">Adresse</strong> : <span id="tmpAddress"></span></li>
                  <li><strong class="orange">Chef de ménage</strong> : <span id="tmpHead"></span></li>
                </ul>
                <input type="hidden" id="notebook">
                <button type="button" id="addToHousehold" data-dismiss="modal" class="btn btn-primary btn-lg">Ok</button>
              </div>
            </div>
          </div>
        </div>
        <!-- Modal END -->
    </div>
    </div>

	<script src="<?= js('jquery.min');?>"></script>
  <script src="<?= plugin('bootstrap', 'js', 'bootstrap.bundle.min.js');?>"></script>
	<script src="<?= plugin('tabulator', 'js', 'tabulator.min.js');?>"></script>
	<script src="<?= plugin('modules', 'common', 'index.js');?>"></script>
	<script src="<?= plugin('modules', 'citizen', 'search_household_in_list.js');?>"></script>
<div id="appVersion"> Loharano Fokontany, version <?= APP_VERSION;?> &copy; <a href="https://digital.gov.mg" target="_blank">e-Gouvernance Madagascar</a> - <?= date("Y");?></div>
</body>
</html>
