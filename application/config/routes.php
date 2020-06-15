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

//User
$route['tableau_de_bords'] = 'user/index';
$route['ajout_utilisateur'] = 'user/add_user';
$route['ajout_chef_fokontany'] = 'user/add_chief';
$route['liste_utilisateur'] = 'user/list_user';
$route['enregistrer_operateur'] = 'user/save_user';
$route['enregistrer_chef'] = 'user/save_chief';

//Admin
$route['create_account'] = 'admin/save_operateur_sefo_account';

//Location
$route['enfant_province'] = 'territory/procince_get_childs';
$route['enfant_region'] = 'territory/region_get_childs';
$route['enfant_district'] = 'territory/district_get_childs';
$route['enfant_commune'] = 'territory/common_get_childs';
$route['enfant_commune_avaliable'] = 'territory/common_get_avaliable_childs';

//Citizen
$route['gestion_citoyens'] = 'citizen/index';
$route['ajout_citoyen'] = 'citizen/add_citizen';
$route['liste_citoyen'] = 'citizen/list_citizen';
$route['enregistrement_citoyen'] = 'citizen/save_citizen';
$route['citoyens_list'] = 'citizen/citizens_list';
$route['certificate'] = 'citizen/load_citizen_certificate';
$route['liste_citoyens'] = 'citizen/list_citizens';
$route['membres_menage'] = 'citizen/list_citizen_by_carnet_id';

/*
 * AJAX
 */
//User
$route['les_utilisateurs'] = 'user/a_users';
$route['les_utilisateurs_fokontany'] = 'user/a_users_fokontany';

//Menage
$route['list_menage'] = 'menage/list_menage';
$route['menages_fokontany'] = 'menage/menages_fokontany';
