<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Loharano - Registres par Fokontany</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

  <!-- Bootstrap core CSS -->
  <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@300;400;700&family=Roboto+Slab:wght@300;400;500&display=swap" rel="stylesheet">
	<link href="<?= plugin('bootstrap', 'css', 'bootstrap.min.css');?>" rel="stylesheet">
	<?= css('company_admin');?>

  <script src="https://code.iconify.design/1/1.0.4/iconify.min.js"></script>


</head>

<body class="loharano">

  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-light bg-light static-top">
      <div class="logo-container">
        <img src="<?= img('sautRep.png');?>">
        <div class="separator"></div>
        <a href="tableau_bord"><img src="<?= img('Logo-Loharano-mini.png');?>"></a>
      </div>
      <div class="menu">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" href="tableau_menage" title="Tableau de bord">Tableau de bord des ménages</a>
          </li>
          <li class="nav-item separator"></li>
          <li class="nav-item">
            <a class="nav-link" href="tableau_bord" title="Sociétés de saisies">Tableau de bord des saisies</a>
          </li>
          <li class="nav-item separator-white"></li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Administrateur
              <span class="iconify" data-icon="uil:ellipsis-v" data-inline="false"></span>
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="#">Registres par fokontany</a>
              <a class="dropdown-item" href="#">Mon compte</a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="se_deconnecter">Se déconnecter</a>
            </div>
          </li>
        </ul>
      </div>
  </nav>

  <!-- Page title -->
  <div class="container-fluid page-title">
    <h1>Gestion des registres par fokontany</h1>
    <button type="submit" class="btn btn-primary" data-toggle="modal" data-target="#newRegisterAdmin">
      Nouveaux registres
    </button>
  </div>

  <!-- Page Content -->
  <div class="container-fluid main-container" style="padding-top: 24px;">
    
    <!-- Table Filter-->
    <div class="form-row">
      <div class="form-group col-md-2">
        <label>Province</label>
        <select id="province" class="form-control">
          <?php foreach ($provinces as $province): ?>
          	<option value="<?= $province->id;?>"><?= $province->name;?></option>
          <?php endforeach ?>
        </select>
      </div>
      <div class="form-group col-md-2">
        <label>Région</label>
        <select id="region" class="form-control">
          <?php foreach ($regions as $region): ?>
          	<option value="<?= $region->id;?>"><?= $region->name;?></option>
          <?php endforeach ?>
        </select>
      </div>
      <div class="form-group col-md-2">
        <label>District</label>
        <select id="district" class="form-control">
          <?php foreach ($districts as $district): ?>
          	<option value="<?= $district->id;?>"><?= $district->name;?></option>
          <?php endforeach ?>
        </select>
      </div>
      <div class="form-group col-md-2">
        <label>Commune</label>
        <select id="common" class="form-control">
          <?php foreach ($commons as $common): ?>
          	<option value="<?= $common->id;?>"><?= $common->name;?></option>
          <?php endforeach ?>
        </select>
      </div>
    </div>

    <!-- Table -->
    <div class="table-container">
      <div id="loadingData" style="display: none;">
        <center>
          <img src="<?= img('loading.gif');?>"> Chargement ...
        </center>
      </div>
      <table class="table table-hover">
        <thead>
          <tr>
            <th scope="col">Fokontany</th>
            <th scope="col">Registres</th>
            <th scope="col">Personnes</th>
            <th></th>
          </tr>
        </thead>
        <tbody id="fokontanyList">
          <?php foreach ($fokontany as $f): ?>
            <tr>
              <td><?= $f->fokontany_name;?></td>
              <td><?= format_number($f->nbr_register);?></td>
              <td><?= format_number($f->people);?></td>
              <td>
                <div class="dropdown">
                  <button type="submit" class="btn btn-more dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="iconify" data-icon="uil:ellipsis-v" data-inline="false"></span>
                  </button>
                  <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item edit-fk" data-name="<?= $f->fokontany_name;?>" data-people="<?= $f->people;?>" data-register="<?= $f->nbr_register;?>" data-index="<?= $f->fokontany_id;?>" data-toggle="modal" data-target="#editRegisterAdmin">Editer</a>
                  </div>
                </div>
              </td>
            </tr>
          <?php endforeach ?>
        </tbody>
      </table>
    </div><!-- Table END -->
    
  </div><!-- End page Content -->


  <!-- Modal new register -->
  <div class="modal fade" id="newRegisterAdmin" tabindex="-1" role="dialog" aria-labelledby="newRegisterAdminTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="newRegisterAdminTitle">
            Nouveaux registres
          </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-row">
            <div class="form-group col-md-4">
              <label for="n_province">Province</label>
              <select id="n_province" class="form-control">
                <?php foreach ($provinces as $province): ?>
                  <option value="<?= $province->id;?>"><?= $province->name;?></option>
                <?php endforeach ?>
              </select>
            </div>
            <div class="form-group col-md-4">
              <label for="n_region">Région</label>
              <select id="n_region" class="form-control">
                <?php foreach ($regions as $region): ?>
                  <option value="<?= $region->id;?>"><?= $region->name;?></option>
                <?php endforeach ?>
              </select>
            </div>
            <div class="form-group col-md-4">
              <label for="n_district">District</label>
              <select id="n_district" class="form-control">
                <?php foreach ($districts as $district): ?>
                  <option value="<?= $district->id;?>"><?= $district->name;?></option>
                <?php endforeach ?>
              </select>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-4">
              <label for="n_common">Commune</label>
              <select id="n_common" class="form-control">
                <?php foreach ($commons as $common): ?>
                  <option value="<?= $common->id;?>"><?= $common->name;?></option>
                <?php endforeach ?>
              </select>
            </div>
            <div class="form-group col-md-4">
              <label for="n_fokontany">Fokontany</label>
              <select id="n_fokontany" class="form-control">
                <?php foreach ($fokontanies as $f): ?>
                  <option value="<?= $f->id;?>"><?= $f->name;?></option>
                <?php endforeach ?>
              </select>
            </div>
            <div class="form-group col-md-4">
              <label for="n_register">Registres</label>
              <input type="text" id="n_register" class="form-control input-number">
              <div id="errorRegister" class="errorField"></div>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-4">
              <label for="n_people">Personnes</label>
              <input type="text" id="n_people" class="form-control input-number">
              <div id="errorPeople" class="errorField"></div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">
            Annuler
            <span class="iconify" data-icon="uil:times-circle" data-inline="false"></span>
          </button>
          <button type="button" class="btn btn-primary" id="validRegister">
            Valider
            <span class="iconify" data-icon="uil:arrow-right" data-inline="false"></span>
          </button>
        </div>
      </div>
    </div>
  </div>
  <!-- Modal new register - END -->


  <!-- Modal edit register -->
  <div class="modal fade" id="editRegisterAdmin" tabindex="-1" role="dialog" aria-labelledby="editRegisterAdminTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editRegisterAdminTitle">
            Modification registre
          </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-row">
          <div class="form-row">
            <div class="form-group col-md-4">
              <label for="e_fokontany">Fokontany</label>
              <input type="text" id="e_fokontany" class="form-control" disabled />
              <input type="hidden" id="current_id">
            </div>
            <div class="form-group col-md-4">
              <label for="e_register">Registres</label>
              <input type="text" id="e_register" class="form-control input-number">
              <input type="hidden" id="current_register">
              <div id="errorRegister" class="errorField"></div>
            </div>

            <div class="form-group col-md-4">
              <label for="e_people">Personnes</label>
              <input type="text" id="e_people" class="form-control input-number">
              <input type="hidden" id="current_people">
              <div id="errorPeople" class="errorField"></div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">
            Annuler
            <span class="iconify" data-icon="uil:times-circle" data-inline="false"></span>
          </button>
          <button type="button" class="btn btn-primary" id="validEditRegister">
            Valider
            <span class="iconify" data-icon="uil:arrow-right" data-inline="false"></span>
          </button>
        </div>
      </div>
    </div>
  </div>
  <!-- Modal edit register - END -->


  <!-- Bootstrap core JavaScript -->
	<script src="<?= js('jquery.min');?>"></script>
  	<script src="<?= plugin('bootstrap', 'js', 'bootstrap.bundle.min.js');?>"></script>
	<script src="<?= plugin('modules', 'admin', 'fokontany_register.js');?>"></script>

<div id="appVersion"> Loharano Fokontany, version <?= APP_VERSION;?> &copy; <a href="https://digital.gov.mg" target="_blank">e-Gouvernance Madagascar</a> - <?= date("Y");?></div>
</body>

</html>
