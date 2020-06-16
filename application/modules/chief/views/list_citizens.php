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
            <?=$this->session->user_name;?>
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
                <ul class="sub-main-menu">              
                <li><a href="chef_liste_citoyen" class="active">Liste des Citoyens</a></li>
                </ul>
            </li>
            </ul>
        </div>
      <div class="main-container">
        <!-- Page title --> 
        <div class="container-fluid">
            <p class="info-fokontany">
                <span><span class="iconify" data-icon="ic:baseline-place" data-inline="false"></span> Province : </span>
                <?= $info_borough->province_name;?>
                <span><span class="iconify" data-icon="ic:baseline-place" data-inline="false"></span> Région : </span>
                <?= $info_borough->region_name;?>
                <span><span class="iconify" data-icon="ic:baseline-place" data-inline="false"></span> District : </span>
                <?= $info_borough->district_name;?>
                <span><span class="iconify" data-icon="ic:baseline-place" data-inline="false"></span> Commune : </span>
                <?= $info_borough->common_name;?>
                <span><span class="iconify" data-icon="ic:baseline-place" data-inline="false"></span> Arrondissement : </span>
                <?= $info_borough->borough_name;?>
            </p>
        </div>
        <div class="container-fluid page-title">
            <h1><?= $title;?></h1>
        </div>
        <!-- End Page title -->

        <!-- Page Content -->
        <div class="container-fluid">
            <div id="citizens"></div>
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
    </div>
    </div>

	<script src="<?= js('jquery.min');?>"></script>
  <script src="<?= plugin('bootstrap', 'js', 'bootstrap.bundle.min.js');?>"></script>
	<script src="<?= plugin('tabulator', 'js', 'tabulator.min.js');?>"></script>
	<script src="<?= plugin('modules', 'common', 'index.js');?>"></script>
	<script src="<?= plugin('modules', 'chief', 'list_citizens.js');?>"></script>
</body>
</html>
