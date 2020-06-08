<div class="form-row">
<input type="hidden" name="e_admin_id" value="<?= $ca[0]->user_id?>"/>
<input type="hidden" name="e_operator_id" value="<?= $ca[1]->user_id?>"/>
<input type="hidden" name="e_company_id" value="<?= $ca[0]->company_id?>"/>
    <div class="form-group col-md-6">
    <label for="e_company">Société</label>
    <input type="text" id="e_company" name="e_company" class="form-control" value="<?= $ca[0]->first_name;?>">
    <div class="errorField" id="error_e_company"></div>
    </div>
    <div class="form-group col-md-6">
    <label for="e_email">Mail</label>
    <input type="text" id="e_email" name="e_email" readonly class="form-control" value="<?= $ca[0]->email;?>">
    <div class="errorField" id="error_e_email"></div>
    </div>
</div>
<div class="form-row">
    <div class="form-group col-md-6">
    <label for="e_password">Nouveau mot de passe</label>
    <input type="text" id="e_password" name="e_password" class="form-control" value="<?= $ca[0]->current_pwd;?>">
    <div class="errorField" id="error_e_password"></div>
    </div>
    <div class="form-group col-md-6">
    <label for="e_confirm_pwd">Confirmation mot de passe</label>
    <input type="text" id="e_confirm_pwd" name="e_confirm_pwd" class="form-control" value="<?= $ca[0]->current_pwd;?>">
    <div class="errorField" id="error_e_confirm_pwd"></div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
    <h5 class="modal-sub-title">Compte opérateur de saisie</h5>
    </div>
</div>
<div class="form-row">
    <div class="form-group col-md-6">
    <label for="eo_operator">Opérateur</label>
    <input type="text" id="eo_operator" name="eo_operator" class="form-control" value="<?= $ca[1]->first_name;?>">
    <div class="errorField" id="error_eo_operator"></div>
    </div>
    <div class="form-group col-md-6">
    <label for="eo_email">Mail</label>
    <input type="text" id="eo_email" name="eo_email" readonly class="form-control" value="<?= $ca[1]->email;?>">
    <div class="errorField" id="error_eo_email"></div>
    </div>
</div>
<div class="form-row">
    <div class="form-group col-md-6">
    <label for="eo_password">Nouveau mot de passe</label>
    <input type="text" id="eo_password" name="eo_password" class="form-control" value="<?= $ca[1]->current_pwd;?>">
    <div class="errorField" id="error_eo_password"></div>
    </div>
    <div class="form-group col-md-6">
    <label for="eo_confirm_pwd">Confirmation mot de passe</label>
    <input type="text" id="eo_confirm_pwd" name="eo_confirm_pwd" class="form-control" value="<?= $ca[1]->current_pwd;?>">
    <div class="errorField" id="error_eo_confirm_pwd"></div>
    </div>
</div>