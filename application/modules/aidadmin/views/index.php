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
        <?= $side_main_menu;?>
      </div>
      <div class="main-container admin-container">
        <!-- Page title --> 
        <div class="container-fluid page-title">
          <h1><?= $title;?></h1>
        </div>
        <!-- End Page title -->

        <!-- Page Content -->
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <form id="addAid">
                        <h6>Ajout d'une aide</h6>
                        <div class="form-row">
                            <div class="form-group col-lg-6">
                                <label for="name"><?= $this->lang->line('last_name');?>*</label>
                                <input type="text" class="form-control" name="name" id="name" placeholder="...">
                                <div class="error_field error_name"></div>
                            </div>
                            <div class="form-group col-lg-6">
                                <label for="type">Type*</label>
                                <select class="form-control" name="type" id="type" placeholder="...">
                                    <option value="1">Vivres</option>
                                    <option value="2">Cash</option>
                                </select>
                                <div class="error_field error_type"></div>
                            </div>
                            <div class="form-group col-lg-12">
                                <label for="description">Description*</label>
                                <textarea name="description" id="description" cols="30" class="form-control" rows="3"></textarea>
                                <div class="error_field error_description"></div>
                            </div>
                            <div class="form-group col-lg-12">
                                <button class="btn btn-info" id="validAid">Ajouter</button>
                                <div class="loadingSave" style="display:none;">
                                    <img class="loading" src="<?= img('pulse.gif');?>"/>
                                    Enregistrement ...
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-lg-12">
                    <h6>Liste des aides</h6>
                    <div id="aids"></div>
                </div>
            </div>
        </div>
        <!-- End Page Content -->
      </div>
    </div>
  </div>

  
  <!-- Modal -->
	<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="newRegisterTitle">Modification d'aide</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
				<div class="modal-body">
          <form id="editAid">
            <div class="form-row">
                <div class="form-group col-lg-6">
                    <label for="ename"><?= $this->lang->line('last_name');?>*</label>
                    <input type="text" class="form-control" name="name" id="ename" placeholder="...">
                    <div class="error_field error_ename"></div>
                </div>
                <div class="form-group col-lg-6">
                    <label for="etype">Type*</label>
                    <select class="form-control" name="type" id="etype" placeholder="...">
                        <option value="1">Vivres</option>
                        <option value="2">Cash</option>
                    </select>
                    <div class="error_field error_etype"></div>
                </div>
                <input type="hidden" name="id" id="aid_id"/>
                <div class="form-group col-lg-12">
                    <label for="edescription">Description*</label>
                    <textarea name="description" id="edescription" cols="30" class="form-control" rows="3"></textarea>
                    <div class="error_field error_edescription"></div>
                </div>
                <div class="form-group col-lg-12">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                  Fermer
                  <span class="iconify" data-icon="uil:times-circle" data-inline="false"></span>
                </button>
                    <button class="btn btn-info" id="validEditAid">Valider</button>
                    <div class="loadingSave" style="display:none;">
                        <img class="loading" src="<?= img('pulse.gif');?>"/>
                        Enregistrement ...
                    </div>
                </div>
            </div>
          </form>
        </div>
			</div>
		</div>
  </div>
  <!-- End Modad -->

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
    <script src="<?= plugin('modules', 'superadmin', 'aids.js');?>"></script>
<div id="appVersion"> Loharano Fokontany, version <?= APP_VERSION;?> &copy; <a href="https://digital.gov.mg" target="_blank">e-Gouvernance Madagascar</a> - <?= date("Y");?></div>
</body>
</html>
