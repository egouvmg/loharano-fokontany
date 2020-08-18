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
              <?=$this->session->user_name;?>
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
            <ul class="sub-main-menu" style="display:none;">
              <li><a href="ajout_utilisateur_fokontany"><?=$this->lang->line('add_user');?></a></li>
              <li><a href="liste_utilisateur_fokontany"><?=$this->lang->line('list_users');?></a></li>
            </ul>
          </li>
          <li>
            <a href="#"><span class="iconify" data-icon="ic:outline-family-restroom" data-inline="false"></span> Ménage</a>
            <ul class="sub-main-menu" style="display:none;">              
              <li><a href="chef_liste_menage">Liste des Ménages</a></li>
            </ul>
          </li>
          <li>
            <a href="#"><span class="iconify" data-icon="bi:people-fill" data-inline="false"></span> Citoyens</a>
            <ul class="sub-main-menu" style="display:none;">              
              <li><a href="chef_liste_citoyen">Liste des Citoyens</a></li>
            </ul>
          </li>
        </ul>
      </div>
      <div class="main-container admin-container">
        <!-- Page title --> 
        <p class="info-fokontany"><span>Province : </span><?= $info_borough->province_name;?> <span>Région : </span><?= $info_borough->region_name;?> <span>District : </span><?= $info_borough->district_name;?> <span>Commune : </span><?= $info_borough->common_name;?> <span>Arrondissement : </span><?= $info_borough->borough_name;?></p>
        <div class="container-fluid page-title">
          <h1><?= $title;?></h1>
        </div>
        <!-- End Page title -->

        <!-- Page Content -->
        <div class="container-fluid">
          
    <div class="row">
      <div class="col-lg-12">
        <div class="row">
          <div class="col-lg-6">
            <div class="line-bloc">
              <h6>Rapport global</h6>
              <div class="container-bloc-link">
                <a href="#" class="bloc-link color-7">
                  <span class="count"><?= $household_count;?></span> Ménages
                </a>
                <a href="#" class="bloc-link color-7">
                  <span class="count"><?= $citizen_count;?></span> Citoyens
                </a>
              </div>
            </div>
          </div>
          <div class="col-lg-6">
            <div class="line-bloc">
              <h6>Indicateurs démographiques</h6>
              <div class="container-bloc-link">
                <a href="#" class="bloc-link color-6" data-toggle="tooltip" data-placement="bottom" data-html="true" title="<ul class='m-0'><li>Moyenne d'age des hommes : <strong><?=$male_avg_age;?></strong></li><li>Moyenne d'age des femmes : <strong><?=$female_avg_age;?></strong></li></ul>">
                  <span class="pourcent"><?= $male_ratio;?>% / <?= $female_ratio;?>%</span> Hommes/Femmes
                </a>
                <a href="#" class="bloc-link color-6" data-toggle="tooltip" data-placement="bottom" data-html="true" title="<ul class='m-0'><li><strong><?=$minor_male;?></strong> mineurs masculins</li><li><strong><?=$minor_female;?></strong> mineurs féminins</li><li><strong><?=$major_male;?></strong> majeurs masculins</li><li><strong><?=$major_female;?></strong> majeurs féminins</li></ul>">
                  <span class="pourcent"><?= $minor_ratio;?>% / <?= $major_ratio;?>%</span> Mineurs/Majeurs
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
        </div>
        <div class="container-fluid">
          <div class="line-bloc">
                <h6>Accès rapide</h6>
            <div class="container-bloc-link">
              <a href="ajout_utilisateur_fokontany" class="bloc-link color-1">
                <span class="iconify" data-icon="ant-design:user-add-outlined" data-inline="false"></span> <?=$this->lang->line('add_user');?>
              </a>
              <a href="liste_utilisateur_fokontany" class="bloc-link  color-2">
                <span class="iconify" data-icon="bi:card-list" data-inline="false"></span> <?=$this->lang->line('list_users');?>
              </a>
              <a href="chef_liste_citoyen" class="bloc-link color-3">
                <span class="iconify" data-icon="bi:card-list" data-inline="false"></span> Liste des Ménages
              </a>
              <a href="chef_liste_citoyen" class="bloc-link color-4">
                <span class="iconify" data-icon="bi:card-list" data-inline="false"></span> Liste des Citoyens
              </a>
            </div>
          </div>
        </div>
        <!-- End Page Content -->
      </div>
    </div>
  </div>

	<script src="<?= js('jquery.min');?>"></script>
  <script src="<?= plugin('bootstrap', 'js', 'bootstrap.bundle.min.js');?>"></script>
	<script src="<?= plugin('tabulator', 'js', 'tabulator.min.js');?>"></script>
	<script src="<?= plugin('modules', 'common', 'index.js');?>"></script>
  <script>
    $('.bloc-link').tooltip({ boundary: 'window' });
  </script>
<div id="appVersion"> Loharano Fokontany, version <?= APP_VERSION;?> &copy; <a href="https://digital.gov.mg" target="_blank">e-Gouvernance Madagascar</a> - <?= date("Y");?></div>
</body>
</html>
