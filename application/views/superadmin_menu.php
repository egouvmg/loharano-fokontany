<?php
    $sub_main_menu = 0;

    if(!empty($menu_active)){
        switch($menu_active){
            case 'add_chief':
            case 'list_chief':
                $sub_main_menu = 1; break;
            case 'add_user':
            case 'list_user':
                $sub_main_menu = 2; break;
            case 'list_citizen':
                $sub_main_menu = 3; break;
            case 'list_menage':
                $sub_main_menu = 4; break;
            case 'manage_aid':
            case 'insight_aid':
                $sub_main_menu = 5; break;
        }
    }
?>
<ul class="main-menu">
    <li>
    <a href="#"><span class="iconify" data-icon="clarity:users-solid" data-inline="false"></span> <?=$this->lang->line('user_chief');?></a>
    <ul class="sub-main-menu" <?php if($sub_main_menu != 1) echo 'style="display:none;"';?>>
        <li><a href="ajout_de_chef" <?php if($menu_active == 'add_chief') echo 'class="active"';?>><?=$this->lang->line('add');?></a></li>
        <li><a href="liste_des_chefs" <?php if($menu_active == 'list_chief') echo 'class="active"';?>><?=$this->lang->line('list');?></a></li>
    </ul>
    </li>
    <li>
    <a href="#"><span class="iconify" data-icon="clarity:users-solid" data-inline="false"></span> <?=$this->lang->line('user_fokontany');?></a>
    <ul class="sub-main-menu" <?php if($sub_main_menu != 2) echo 'style="display:none;"';?>>
        <li><a href="ajout_utilisateur" <?php if($menu_active == 'add_user') echo 'class="active"';?>><?=$this->lang->line('add');?></a></li>
        <li><a href="liste_utilisateur" <?php if($menu_active == 'list_user') echo 'class="active"';?>><?=$this->lang->line('list');?></a></li>
    </ul>
    </li>
    <li>
    <a href="#"><span class="iconify" data-icon="bi:people-fill" data-inline="false"></span> Citoyens</a>
    <ul class="sub-main-menu" <?php if($sub_main_menu != 3) echo 'style="display:none;"';?>>              
        <li><a href="la_liste_citoyens" <?php if($menu_active == 'list_citizen') echo 'class="active"';?>><?=$this->lang->line('list');?></a></li>
    </ul>
    </li>
    <li>
    <a href="#"><span class="iconify" data-icon="ic:outline-family-restroom" data-inline="false"></span> Ménages</a>
    <ul class="sub-main-menu" <?php if($sub_main_menu != 4) echo 'style="display:none;"';?>>              
        <li><a href="liste_des_menages" <?php if($menu_active == 'list_menage') echo 'class="active"';?>><?=$this->lang->line('list');?></a></li>
    </ul>
    </li>
    <li>
    <a href="#"><span class="iconify" data-icon="fa-solid:hands-helping" data-inline="false"></span> Aides</a>
    <ul class="sub-main-menu" <?php if($sub_main_menu != 5) echo 'style="display:none;"';?>>              
        <li><a href="gestion_des_aides" <?php if($menu_active == 'manage_aid') echo 'class="active"';?>><?=$this->lang->line('list');?></a></li>
        <li><a href="statistique_des_aides" <?php if($menu_active == 'insight_aid') echo 'class="active"';?>>Statistique</a></li>
    </ul>
    </li>
</ul>