<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Name:  Auth Lang - Malagasy
 *
 * Created by PhpStorm.
 * User: ME
 *
 * Location: https://github.com/benedmunds/CodeIgniter-Ion-Auth
 *
 * Date: 13/04/2020
 * Time: 12:48
 *
 * Description:  Malagasy language file for Ion Auth example views
 */

// Errors
$lang['error_csrf'] = 'Ny fankatoavana ity takelaka ity dia tsy tanteraka';

// Login
$lang['login_heading']         = 'Miditra';
$lang['login_subheading']      = 'Azafady miditra avy amin\'ny anaranao sy ny teny miafinao';
$lang['login_identity_label']  = 'Mailaka/Anaran\'ny mpampiasa :';
$lang['login_password_label']  = 'Teny miafina :';
$lang['login_remember_label']  = 'Mijanona ho mifandray foana :';
$lang['login_submit_btn']      = 'Hiditra';
$lang['login_forgot_password'] = 'Adino ny teny miafina ?';
$lang['login_save_me'] = 'Tadidio aho';

// Index
$lang['index_heading']           = 'Mpampiasa';
$lang['index_subheading']        = 'Ireo ambany ireo ny lisitry ny mpampiasa.';
$lang['index_fname_th']          = 'Fanampin\'anarana';
$lang['index_lname_th']          = 'Anarana';
$lang['index_email_th']          = 'Mailaka';
$lang['index_groups_th']         = 'Vondrona';
$lang['index_status_th']         = 'Sata';
$lang['index_action_th']         = 'Hetsika';
$lang['index_active_link']       = 'Alefa';
$lang['index_inactive_link']     = 'Tsy alefa';
$lang['index_create_user_link']  = 'Mamorona mpampiasa vaovao';
$lang['index_create_group_link'] = 'Mamorona vondrona vaovao';

// Deactivate User
$lang['deactivate_heading']                  = 'Mampiato mpampiasa';
$lang['deactivate_subheading']               = 'Azo antoka ve fa tianao ny hanafoanana ilay mpampiasa : %s';
$lang['deactivate_confirm_y_label']          = 'Eny :';
$lang['deactivate_confirm_n_label']          = 'Tsia :';
$lang['deactivate_submit_btn']               = 'Alefa';
$lang['deactivate_validation_confirm_label'] = 'Fanamafisana';
$lang['deactivate_validation_user_id_label'] = 'Fidirana';

// Create User
$lang['create_user_heading']                           = 'Mamorona mpampiasa';
$lang['create_user_subheading']                        = 'Azafady ampidiro ny fampahalalana eto ambany.';
$lang['create_user_fname_label']                       = 'Fanampin\'anarana :';
$lang['create_user_lname_label']                       = 'Anarana :';
$lang['create_user_identity_label']                    = 'Maha-izy :';
$lang['create_user_company_label']                     = 'Orinasa :';
$lang['create_user_email_label']                       = 'Mailaka :';
$lang['create_user_phone_label']                       = 'Finday :';
$lang['create_user_password_label']                    = 'Teny miafina :';
$lang['create_user_password_confirm_label']            = 'Hamarino ny teny miafina :';
$lang['create_user_submit_btn']                        = 'Mamorona mpampiasa';
$lang['create_user_validation_fname_label']            = 'Fanampin\'anarana';
$lang['create_user_validation_lname_label']            = 'Anarana';
$lang['create_user_validation_identity_label']         = 'Maha-izy :';
$lang['create_user_validation_email_label']            = 'Adiresy mailaka';
$lang['create_user_validation_phone_label']            = 'Finday';
$lang['create_user_validation_company_label']          = 'Orinasa';
$lang['create_user_validation_password_label']         = 'Teny miafina';
$lang['create_user_validation_password_confirm_label'] = 'Fanamarinana teny miafina';

// Edit User
$lang['edit_user_heading']                           = 'Hampiseho ny mpampiasa';
$lang['edit_user_subheading']                        = 'Azafady ampidiro eto ny angon-drakitra mpampiasa eto ambany.';
$lang['edit_user_fname_label']                       = 'Fanampin\'anarana :';
$lang['edit_user_lname_label']                       = 'Anarana :';
$lang['edit_user_company_label']                     = 'Orinasa :';
$lang['edit_user_email_label']                       = 'Mailaka :';
$lang['edit_user_phone_label']                       = 'Finday :';
$lang['edit_user_password_label']                    = 'Teny miafina (raha niova) :';
$lang['edit_user_password_confirm_label']            = 'Hamarino ny teny miafina :';
$lang['edit_user_groups_heading']                    = 'Mpikambana ao amin\'ny vondrona';
$lang['edit_user_submit_btn']                        = 'Tehirizo ny fanovana';
$lang['edit_user_validation_fname_label']            = 'Fanampin\'anarana';
$lang['edit_user_validation_lname_label']            = 'Anarana';
$lang['edit_user_validation_email_label']            = 'Mailaka';
$lang['edit_user_validation_phone_label']            = 'Finday';
$lang['edit_user_validation_company_label']          = 'Orinasa';
$lang['edit_user_validation_groups_label']           = 'Vondrona';
$lang['edit_user_validation_password_label']         = 'Teny miafina';
$lang['edit_user_validation_password_confirm_label'] = 'Fanamarinana ny teny miafina';

// Create Group
$lang['create_group_title']                  = 'Mamorona Vondrona';
$lang['create_group_heading']                = 'Mamorona Vondrona';
$lang['create_group_subheading']             = 'Azafady ampidiro eto ny fampahalalana vondrona.';
$lang['create_group_name_label']             = 'Anaran\'ny vondrona :';
$lang['create_group_desc_label']             = 'Famaritana :';
$lang['create_group_submit_btn']             = 'Mamorona ny Vondrona';
$lang['create_group_validation_name_label']  = 'Anaran\'ny Vondrona';
$lang['create_group_validation_desc_label']  = 'Famaritana';

// Edit Group
$lang['edit_group_title']                  = 'Hampiseho ny Vondrona';
$lang['edit_group_saved']                  = 'Vondrona voatahiry';
$lang['edit_group_heading']                = 'Hampiseho ny Vondrona';
$lang['edit_group_subheading']             = 'Azafady ampidiro eto ambany ny fampahalalana vondrona.';
$lang['edit_group_name_label']             = 'Anaran\'ny Vondrona :';
$lang['edit_group_desc_label']             = 'Famaritana :';
$lang['edit_group_submit_btn']             = 'Tehirizo ireo fanovana';
$lang['edit_group_validation_name_label']  = 'Anaran\'ny Vondrona';
$lang['edit_group_validation_desc_label']  = 'Famaritana';

// Change Password
$lang['change_password_heading']                               = 'Hanova ny teny miafina';
$lang['change_password_old_password_label']                    = 'Teny miafina taloha :';
$lang['change_password_new_password_label']                    = 'Teny miafina vaovao (Tsy maintsy misy %s litera farafahakeliny) :';
$lang['change_password_new_password_confirm_label']            = 'Hamarino ny teny miafina vaovao :';
$lang['change_password_submit_btn']                            = 'Tehirizo';
$lang['change_password_validation_old_password_label']         = 'Teny miafina taloha';
$lang['change_password_validation_new_password_label']         = 'Teny miafina vaovao';
$lang['change_password_validation_new_password_confirm_label'] = 'Hamarino ny teny miafina vaovao';

// Forgot Password
$lang['forgot_password_heading']                 = 'Adino ny teny miafina';
$lang['forgot_password_subheading']              = 'Azafady ampidiro ny %s mba hahafahanay mandefa anao ny teny miafina vaovao.';
$lang['forgot_password_email_label']             = '%s :';
$lang['forgot_password_submit_btn']              = 'Alefa';
$lang['forgot_password_validation_email_label']  = 'Adiresy mailaka';
$lang['forgot_password_username_identity_label'] = 'Anaran\'ny mpampiasa';
$lang['forgot_password_email_identity_label']    = 'Mailaka';
$lang['forgot_password_email_not_found']         = 'Ity adiresy mailaka ity dia tsy voarakitra ato aminay.';
$lang['forgot_password_identity_not_found']      = 'Ity anaran\'ny mpampiasa ity dia tsy voarakitra ato aminay.';

// Reset Password
$lang['reset_password_heading']                               = 'Hanova teny miafina';
$lang['reset_password_new_password_label']                    = 'Teny miafina vaovao (Tsy maintsy misy %s litera farafahakeliny) :';
$lang['reset_password_new_password_confirm_label']            = 'Hamarino ny teny miafina vaovao :';
$lang['reset_password_submit_btn']                            = 'Tehirizo';
$lang['reset_password_validation_new_password_label']         = 'Teny miafina vaovao';
$lang['reset_password_validation_new_password_confirm_label'] = 'Hamarino ny teny miafina vaovao';

// Activation Email
$lang['email_activate_heading']    = 'Vahao ny kaonty %s';
$lang['email_activate_subheading'] = 'Tsindrio eo amin\'ny rohy ny %s';
$lang['email_activate_link']       = 'Vahao ny kaontinao';

// Forgot Password Email
$lang['email_forgot_password_heading']    = 'Ovao ny teny miafina %s';
$lang['email_forgot_password_subheading'] = 'Tsindrio eo amin\'ny rohy ny %s';
$lang['email_forgot_password_link']       = 'Ovao ny teny miafinao';
