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
              <?=$this->lang->line('administrator');?>
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
              <li><a class="active" href="ajout_chef_fokontany"><?=$this->lang->line('add_chief');?></a></li>
              <li><a href="liste_utilisateur"><?=$this->lang->line('list_users');?></a></li>
            </ul>
          </li>
          <li>
            <a href="#"><span class="iconify" data-icon="ic:round-place" data-inline="false"></span> Fokontany</a>
          </li>
          <li>
            <a href="#"><span class="iconify" data-icon="ic:outline-family-restroom" data-inline="false"></span> Ménage</a>
          </li>
          <li>
            <a href="#"><span class="iconify" data-icon="bi:people-fill" data-inline="false"></span> Citoyens</a>
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
          <form id="userForm">          
            <div class="row"><div class="col-lg-4">
                <div class="form-row">
                  <div class="form-group col-md-12">
                    Information du compte
                  </div>
                  <div class="form-group col-md-12">
                    <label for="first_name">Nom</label>
                    <input type="text" class="form-control" id="first_name" name="first_name" placeholder="...">
                    <span class="error_field error_first_name"></span>
                  </div>
                  <div class="form-group col-md-12">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="user@loharano.mg">
                    <span class="error_field error_email"></span>
                  </div>
                  <div class="form-group col-md-12">
                    <label for="password">Mot de passe</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="********">
                    <span class="error_field error_password"></span>
                  </div>
                  <div class="form-group col-md-12">
                    <label for="confirm_password">Confirmation mot de passe</label>
                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="********">
                    <span class="error_field error_confirm_pwd"></span>
                  </div>
                  <button type="submit" id="saveOperator" class="btn btn-primary">Enregistrer</button>
                  <span id="failedMsg" class="error_field"></span>
                  <div id="loadingSave" style="display:none;">
                    <img class="loading" src="<?= img('pulse.gif');?>"/>
                    Enregistrement ...
                  </div>
                </div>
              </div>
              <div class="col-lg-8">
                  <div class="form-row">
                    <div class="form-group col-md-12">
                      Choisissez le Fokontany où travail le Chef Fokontany
                    </div>
                    <div class="form-group col-md-6">
                      <label for="province">Province</label>
                      <select id="province" class="form-control">
                        <?php foreach ($provinces as $province): ?>
                          <option value="<?= $province->id;?>"><?= $province->name;?></option>
                        <?php endforeach ?>
                      </select>
                    </div>
                    <div class="form-group col-md-6">
                      <label for="region">Région</label>
                      <select id="region" class="form-control">
                        <?php foreach ($regions as $region): ?>
                          <option value="<?= $region->id;?>"><?= $region->name;?></option>
                        <?php endforeach ?>
                      </select>
                    </div>
                    <div class="form-group col-md-6">
                      <label for="district">District</label>
                      <select id="district" class="form-control">
                        <?php foreach ($districts as $district): ?>
                          <option value="<?= $district->id;?>"><?= $district->name;?></option>
                        <?php endforeach ?>
                      </select>
                    </div>
                    <div class="form-group col-md-6">
                      <label for="common">Commune</label>
                      <select id="common" class="form-control">
                        <?php foreach ($commons as $common): ?>
                            <option value="<?= $common->id;?>"><?= $common->name;?></option>
                          <?php endforeach ?>
                      </select>
                    </div>
                    <div class="form-group col-md-6">
                      <label for="borough">Arrondissement</label>
                      <select id="borough" class="form-control">
                        <?php foreach ($boroughs as $borough): ?>
                            <option value="<?= $borough->id;?>"><?= $borough->name;?></option>
                          <?php endforeach ?>
                      </select>
                    </div>
                    <div class="form-group col-md-6">
                      <label for="fokontany">Fokontany</label>
                      <select id="fokontany" name="fokontany" class="form-control">
                        <?php foreach ($fokontanies as $fokontany): ?>
                          <option value="<?= $fokontany->id;?>"><?= $fokontany->name;?></option>
                        <?php endforeach ?>
                      </select>
                    </div>
                    <input type="hidden" id="type_compte" name="type_compte" value="sefo_kontany">
                  </div>
                
              </div>
            </div>
          </form>
        </div>
        <!-- End Page Content -->
      </div>
    </div>
  </div>

  <!-- Modal -->
  <div class="modal fade" id="newFirm" tabindex="-1" role="dialog" aria-labelledby="newFirmTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="newFirmTitle">
            Nouveau compte société
          </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="accountCompanyOperator">
            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="n_company">Société</label>
                <input type="text" id="n_company" name="n_company" class="form-control">
                <div class="errorField" id="error_n_company"></div>
              </div>
              <div class="form-group col-md-6">
                <label for="n_email">Mail</label>
                <input type="text" id="n_email" name="n_email" class="form-control">
                <div class="errorField" id="error_n_email"></div>
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="n_password">Mot de passe</label>
                <input type="password" id="n_password" name="n_password" class="form-control">
                <div class="errorField" id="error_n_password"></div>
              </div>
              <div class="form-group col-md-6">
                <label for="n_confirm_pwd">Confirmation mot de passe</label>
                <input type="password" id="n_confirm_pwd" name="n_confirm_pwd" class="form-control">
                <div class="errorField" id="error_n_confirm_pwd"></div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <h5 class="modal-sub-title">Compte opérateur de saisie</h5>
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="no_operator">Opérateur</label>
                <input type="text" id="no_operator" name="no_operator" class="form-control">
                <div class="errorField" id="error_no_operator"></div>
              </div>
              <div class="form-group col-md-6">
                <label for="no_email">Mail</label>
                <input type="text" id="no_email" name="no_email" class="form-control">
                <div class="errorField" id="error_no_email"></div>
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="no_password">Mot de passe</label>
                <input type="password" id="no_password" name="no_password" class="form-control">
                <div class="errorField" id="error_no_password"></div>
              </div>
              <div class="form-group col-md-6">
                <label for="no_confirm_pwd">Confirmation mot de passe</label>
                <input type="password" id="no_confirm_pwd" name="no_confirm_pwd" class="form-control">
                <div class="errorField" id="error_no_confirm_pwd"></div>
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <div id="loadingDataCompany" style="display: none;">
            <center>
              <img src="<?= img('loading.gif');?>"> Chargement ...
            </center>
          </div>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">
            Annuler
            <span class="iconify" data-icon="uil:times-circle" data-inline="false"></span>
          </button>
          <button type="button" class="btn btn-primary" id="validCompanyAccount">
            Valider
            <span class="iconify" data-icon="uil:arrow-right" data-inline="false"></span>
          </button>
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
	<script src="<?= plugin('modules', 'superadmin', 'add_user.js');?>"></script>
</body>
</html>
