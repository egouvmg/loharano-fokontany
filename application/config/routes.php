<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'auth/auth/index';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['se_connecter'] = 'auth/login';
$route['se_deconnecter'] = 'auth/logout';

// Main App
$route['changer_langue'] = 'auth/change_language';

//Superadmin
$route['la_liste_citoyens'] = 'superadmin/list_citizen';
$route['recuperer_liste_citoyen'] = 'superadmin/citizens_list';
$route['les_membres_menage'] = 'superadmin/list_citizen_by_carnet_id';
$route['gerener_certificat'] = 'superadmin/load_citizen_certificate';
$route['8165461654ssdsdq498z'] = 'superadmin/f45644548';

//User
$route['tableau_de_bords'] = 'user/index';
$route['ajout_utilisateur'] = 'user/add_user';
$route['ajout_de_chef'] = 'user/add_chief';
$route['liste_utilisateur'] = 'user/list_user';
$route['liste_des_chefs'] = 'user/list_chief';
$route['enregistrer_operateur'] = 'user/save_user';
$route['changer_operateur'] = 'user/edit_user';
$route['enregistrer_chef'] = 'user/save_chief';

//Chief
$route['tableau_de_bord_chef'] = 'chief/index';
$route['ajout_utilisateur_fokontany'] = 'chief/add_user';
$route['enregistrer_utilisateur_fokontany'] = 'chief/save_user';
$route['liste_utilisateur_fokontany'] = 'chief/list_users';
$route['chef_liste_menage'] = 'chief/list_households';
$route['chef_liste_citoyen'] = 'chief/list_citizens';

//Admin
$route['create_account'] = 'admin/save_operateur_sefo_account';

//Location
$route['enfant_province'] = 'territory/procince_get_childs';
$route['enfant_region'] = 'territory/region_get_childs';
$route['enfant_district'] = 'territory/district_get_childs';
$route['enfant_commune'] = 'territory/common_get_childs';
$route['enfant_arrondissement'] = 'territory/borough_get_childs';
$route['enfant_commune_avaliable'] = 'territory/common_get_avaliable_childs';

//Citizen
$route['insertion_citoyen'] = 'citizen/insert_citizen';
$route['gestion_citoyens'] = 'citizen/index';
$route['ajout_citoyen'] = 'citizen/add_citizen';
$route['liste_citoyen'] = 'citizen/list_citizen';
$route['enregistrement_citoyen'] = 'citizen/save_citizen';
$route['liste_citoyens'] = 'citizen/list_citizens';
$route['membres_menage'] = 'citizen/list_citizen_by_carnet_id';
$route['recherche_menage'] = 'citizen/search_household';
$route['menage_fokontany'] = 'citizen/fokontany_household';
$route['recherche_menage_fokontany'] = 'citizen/search_household_in_list';
$route['nouveau_menage_fokontany'] = 'citizen/new_household';
$route['liste_menage_fokontany'] = 'citizen/list_households';
$route['residence'] = 'citizen/certificate_residence';
$route['certificat_residence'] = 'citizen/generate_residence';

//Aid
$route['aide_menage'] = 'aid/index';

/*
 * AJAX
 */
//User
$route['les_utilisateurs'] = 'user/a_users';
$route['les_utilisateurs_fokontany'] = 'user/a_users_fokontany';
$route['les_chefs_arrondissement'] = 'user/a_chiefs_borough';

//Menage
$route['list_menage'] = 'menage/list_menage';
$route['menages_fokontany'] = 'menage/menages_fokontany';

//Chief
$route['utilisateurs_fokontany'] = 'chief/get_users';
$route['chef_liste_menages'] = 'chief/households_list';
$route['citoyens_liste'] = 'chief/citizens_list';
$route['chef_membres_menage'] = 'chief/list_citizen_by_carnet_id';

//Citizen
$route['recherche_rapide'] = 'citizen/speed_search';
$route['verifier_localite_menage'] = 'citizen/check_household';
$route['liste_menages_fokontany'] = 'citizen/households_list';
$route['citoyen_carnet_fokontany'] = 'citizen/get_notebook';
$route['insertion_citoyen_dans_menage'] = 'citizen/insert_in_household';
$route['modifier_citoyen'] = 'citizen/edit_citizen';
$route['citoyens_list'] = 'citizen/citizens_list';
$route['save_citizen_from_certificat'] = 'citizen/save_citizen_from_certificat';

//Certificat
$route['certificate'] = 'citizen/load_citizen_certificate';
$route['certificate_life'] = 'citizen/certificate_life';
$route['certificate_supported'] = 'citizen/certificate_supported';
$route['certificate_move'] = 'citizen/certificate_move';
$route['certificate_celibat'] = 'citizen/certificate_celibat';
$route['certificate_behavior'] = 'citizen/certificate_behavior';
$route['verifier_personnne'] = "citizen/check_fields";

//Aid
$route['aide_par_menage'] = 'aid/aid_by_household';
$route['ajout_aide'] = 'aid/add_household_aid';