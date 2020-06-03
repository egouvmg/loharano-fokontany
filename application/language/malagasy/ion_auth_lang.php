<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Name:  Ion Auth Lang - Malagasy
 *
 * Created by PhpStorm.
 * User: ME
 *
 * Location: https://github.com/benedmunds/CodeIgniter-Ion-Auth
 *
 * Date: 13/04/2020
 * Time: 12:48
 *
 * Description:  Malagasy language file for Ion Auth messages and errors
 */

// Account Creation
$lang['account_creation_successful']            = 'Kaonty voaforona ampahombiazana';
$lang['account_creation_unsuccessful']          = 'Tsy afaka namorona kaonty';
$lang['account_creation_duplicate_email']       = 'Mailaka efa nampiasaina na tsy manankery';
$lang['account_creation_duplicate_identity']    = 'Anarana mpampiasa efa nampiasaina na tsy manankery';
$lang['account_creation_missing_default_group'] = 'Ny vondrona dia tsy namboarina';
$lang['account_creation_invalid_default_group'] = 'Tsy manankery ny anaran\'ny vondrona';


// Password
$lang['password_change_successful']   = 'Voaova tamim-pahobiazana ny teny miafina';
$lang['password_change_unsuccessful'] = 'Tsy afaka ovaina ny teny miafina';
$lang['forgot_password_successful']   = 'Efa lasa ny mailaka famerenana fandrafetana teny miafina';
$lang['forgot_password_unsuccessful'] = 'Tsy tanteraka ny famerenana fandrafetana teny miafina';

// Activation
$lang['activate_successful']           = 'Voasokatra ny kaonty';
$lang['activate_unsuccessful']         = 'Tsy tanteraka ny fanokafana kaonty';
$lang['deactivate_successful']         = 'Kaonty miato';
$lang['deactivate_unsuccessful']       = 'Tsy afaka ampiatoana ny kaonty';
$lang['activation_email_successful']   = 'Ny mailaka fanokafana dia lasa ampahombiazana';
$lang['activation_email_unsuccessful'] = 'Tsy afaka alefa ny mailaka fanokafana';

// Login / Logout
$lang['login_successful']              = 'Mifandray ampahombiazana';
$lang['login_unsuccessful']            = 'Handisoana mandritra ny fifandraisana';
$lang['login_unsuccessful_not_active'] = 'Tsy miasa ny kaonty';
$lang['login_timeout']                 = 'Voabahana vetivety ny kaonty noho ny fanandramana be loatra. Manandrama manandrana indray afaka kelikely azafady.';
$lang['logout_successful']             = 'Vita soa amantsara ny fivoahana';

// Account Changes
$lang['update_successful']   = 'Nahomby ny fanavaozana ny kaonty mpampiasa';
$lang['update_unsuccessful'] = 'Tsy afaka atao ny fanavaozana ny kaonty mpampiasa';
$lang['delete_successful']   = 'Mpampiasa voafafa';
$lang['delete_unsuccessful'] = 'Tsy afaka fafana ny mpampiasa';
$lang['deactivate_current_user_unsuccessful']= 'Tsy afaka manapaka ny fifandraisanao ianao.';

// Groups
$lang['group_creation_successful'] = 'Vondrona voavoatra ampahombiazana';
$lang['group_already_exists']      = 'Ny anaran\'ny vondrona efa misy mampiasa';
$lang['group_update_successful']   = 'Ny fampahalalana vondrona efa nohavaozina';
$lang['group_delete_successful']   = 'Vondrona voafafa';
$lang['group_delete_unsuccessful'] = 'Tsy afaka fafana ny vondrona';
$lang['group_delete_notallowed']    = 'Ny vondrona mpandrindra dia tsy afaka fafana';
$lang['group_name_required']       = 'Ny anaran\'ny vondrona dia tsy maintsy fenoina';
$lang['group_name_admin_not_alter'] = 'Ny anaran\'ny vondrona Mpandrindra dia tsy afaka ovaina';

// Activation Email
$lang['email_activation_subject']  = 'Fanavaozana ny kaonty';
$lang['email_activate_heading']    = 'Ampidiro ny kaonty %s';
$lang['email_activate_subheading'] = 'Azafady tsindrio ity rohy ity %s.';
$lang['email_activate_link']       = 'Hidiro ny kaontinao';

// Forgot Password Email
$lang['email_forgotten_password_subject'] = 'Adino ny teny miafina - Fanamarinana';
$lang['email_forgot_password_heading']    = 'Avereno amboarina ny teny miafina %s';
$lang['email_forgot_password_subheading'] = 'Azafady tsindrio ity rohy ity %s.';
$lang['email_forgot_password_link']       = 'Avereno amboarina ny teny miafinao';
