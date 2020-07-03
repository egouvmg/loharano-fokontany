<?php
    if(isset($index)) :
        $active = ($index == 1) ? 'active show' : 'fade';
?>
<div class="tab-pane <?= $active;?>" id="pills-<?= $index;?>" role="tabpanel" aria-labelledby="pills-<?= $index;?>-tab">
    <div class="row">   
        <div class="col-lg-3">
            <div class="form-row">
                <div class="form-group col-md-12 orange">
                    <?=$this->lang->line('info_citizen');?>
                </div>
                <div class="form-group col-md-12">
                    <label for="last_name<?= $index;?>"><?=$this->lang->line('last_name');?> *</label>
                    <input type="text" class="form-control last_name" id="last_name<?= $index;?>" name="last_name[]" placeholder="...">
                    <span class="error_field error_last_name<?= $index;?>"></span>
                </div>
                <div class="form-group col-md-12">
                    <label for="first_name<?= $index;?>"><?=$this->lang->line('first_name');?></label>
                    <input type="text" class="form-control first_name" id="first_name<?= $index;?>" name="first_name[]" placeholder="...">
                    <span class="error_field error_first_name<?= $index;?>"></span>
                </div>
                <div class="form-group col-md-12">
                    <label for="birth<?= $index;?>"><?=$this->lang->line('birth');?> *</label>
                    <input type="date" class="form-control" id="birth<?= $index;?>" name="birth[]" placeholder="jj/mm/aaaa">
                    <span class="error_field error_birth<?= $index;?>"></span>
                </div>
                <div class="form-group col-md-12">
                    <label for="birth_place<?= $index;?>"><?=$this->lang->line('birth_place');?> *</label>
                    <input type="text" class="form-control" id="birth_place<?= $index;?>" name="birth_place[]" placeholder="...">
                    <span class="error_field error_birth_place<?= $index;?>"></span>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="form-row">
                <div class="form-group col-md-12">.
                </div>
                <div class="form-group col-md-12">
                    <label for="sexe<?= $index;?>"><?=$this->lang->line('sexe');?> *</label>
                    <select name="sexe[]" id="sexe<?= $index;?>" class="form-control">
                        <option value="1"><?=$this->lang->line('sexe_male');?></option>
                        <option value="2"><?=$this->lang->line('sexe_female');?></option>
                    </select>
                    <span class="error_field error_sexe<?= $index;?>"></span>
                </div>
                <div class="form-group col-md-12">
                    <label for="marital_status<?= $index;?>"><?=$this->lang->line('marital_status');?></label>
                    <select name="marital_status[]" id="marital_status<?= $index;?>" class="form-control">
                        <option value="5">...</option>
                        <option value="1"><?=$this->lang->line('single');?></option>
                        <option value="2"><?=$this->lang->line('married');?></option>
                        <option value="3"><?=$this->lang->line('widower');?></option>
                        <option value="4"><?=$this->lang->line('divorced');?></option>
                    </select>
                    <span class="error_field error_marital_status<?= $index;?>"></span>
                </div>
                <div class="form-group col-md-12">
                    <label for="handicape<?= $index;?>"><?=$this->lang->line('handicapped');?> *</label>
                    <select  id="handicape<?= $index;?>" name="handicape[]"  class="form-control">
                        <option value="0"><?=$this->lang->line('no');?></option>
                        <option value="1"><?=$this->lang->line('yes');?></option>
                    </select>
                    <span class="error_field error_handicape<?= $index;?>"></span>
                </div>
                <div class="form-group col-md-12">
                    <label for="phone<?= $index;?>"><?=$this->lang->line('phone');?></label>
                    <input type="text" class="form-control phone_number" id="phone<?= $index;?>" name="phone[]" placeholder="...">
                    <span class="error_field error_phone<?= $index;?>"></span>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="form-row">
                <div class="form-group col-md-12 orange">
                    <?=$this->lang->line('info_parent');?>
                </div>
                <div class="form-group col-md-12">
                    <label for="father<?= $index;?>"><?=$this->lang->line('father');?></label>
                    <input type="text" class="form-control" id="father<?= $index;?>" name="father[]" placeholder="...">
                    <span class="error_field error_father<?= $index;?>"></span>
                </div>
                <div class="form-group col-md-12">
                    <label for="father_status<?= $index;?>"><?=$this->lang->line('father_status');?></label>
                    <select name="father_status[]" id="father_status<?= $index;?>" class="form-control">
                        <option value="1"><?=$this->lang->line('alive');?></option>
                        <option value="2"><?=$this->lang->line('dead');?></option>
                    </select>
                    <span class="error_field error_father_status<?= $index;?>"></span>
                </div>
                <div class="form-group col-md-12">
                    <label for="mother"><?=$this->lang->line('mother');?></label>
                    <input type="text" class="form-control" id="mother" name="mother[]" placeholder="...">
                    <span class="error_field error_mother"></span>
                </div>
                <div class="form-group col-md-12">
                    <label for="mother_status<?= $index;?>"><?=$this->lang->line('mother_status');?></label>
                    <select name="mother_status[]" id="mother_status<?= $index;?>" class="form-control">
                        <option value="1"><?=$this->lang->line('alive');?></option>
                        <option value="2"><?=$this->lang->line('dead');?></option>
                    </select>
                    <span class="error_field error_mother_status"></span>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="form-row">
                <div class="form-group col-md-12 orange">
                    <?=$this->lang->line('info_job');?>
                </div>
                <div class="form-group col-md-12">
                    <label for="job<?= $index;?>"><?=$this->lang->line('job');?></label>
                    <select name="job_id[]" class="form-control" id="job<?= $index;?>">
                    <option value="">...</option>
                    <?php foreach($jobs as $job) : ?>
                        <option value="<?= $job->id;?>"><?= $this->lang->line('job_'.$job->id);?></option>
                    <?php endforeach;?>
                    </select>
                    <input type="text" style="margin-top: 20px;display:none;" class="form-control" id="job_other" name="job_other[]" placeholder="<?= $this->lang->line('job_other');?>">
                    <span class="error_field error_job_id<?= $index;?>"></span>
                </div>
                <div class="form-group col-md-12">
                    <label for="job_status<?= $index;?>"><?=$this->lang->line('job_description');?></label>
                    <textarea class="form-control" id="job_status<?= $index;?>" name="job_status[]" placeholder="..."></textarea>
                    <span class="error_field error_job_status<?= $index;?>"></span>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="form-row">
            <div class="form-group col-md-12 orange">
                <?=$this->lang->line('info_cin');?> / <?=$this->lang->line('info_passport');?>
            </div>
            </div> 
        </div>
    </div>
    <div class="row">
        <div class="col-lg-3">
            <div class="form-row">
                <div class="form-group col-md-12">
                <label for="nationality<?= $index;?>"><?=$this->lang->line('nationality');?> *</label>
                    <select name="nationality_id[]" class="form-control nationality" id="nationality<?= $index;?>">
                    <?php foreach($nationalities as $nationality) : ?>
                        <option value="<?= $nationality->id;?>"><?= $this->lang->line('nationality_'.$nationality->id);?></option>
                    <?php endforeach;?>
                    </select>
                </div>
            </div>
        </div>
        <!-- CIN -->
        <div class="col-lg-3 cin-section">
            <div class="form-row">
                <div class="form-group col-md-12">
                <label for="cin<?= $index;?>"><?=$this->lang->line('cin');?> *</label>
                <input type="text" maxlenght="15" class="form-control cin" id="cin<?= $index;?>" name="cin[]" placeholder="000 000 000 000">
                <span class="error_field error_cin<?= $index;?>"></span>
                </div>
            </div>
        </div>
        <div class="col-lg-3 cin-section">
            <div class="form-row">
                <div class="form-group col-md-12">
                <label for="cin_date<?= $index;?>"><?=$this->lang->line('cin_date');?> *</label>
                <input type="date" class="form-control" id="cin_date<?= $index;?>" name="cin_date[]">
                <span class="error_field error_cin_date<?= $index;?>"></span>
                </div>
            </div>
        </div>
        <div class="col-lg-3 cin-section">
            <div class="form-row">
                <div class="form-group col-md-12">
                <label for="cin_place<?= $index;?>"><?=$this->lang->line('cin_place');?> *</label>
                <input type="text" class="form-control" id="cin_place<?= $index;?>" name="cin_place[]" placeholder="...">
                <span class="error_field error_cin_place<?= $index;?>"></span>
                </div>
            </div>
        </div>
        <!-- END CIN -->
        <!-- Passport -->
        <div class="col-lg-3 passport-section">
            <div class="form-row">
                <div class="form-group col-md-12">
                <label for="passport<?= $index;?>"><?=$this->lang->line('passport');?> *</label>
                <input type="text" class="form-control" id="passport<?= $index;?>" name="passport[]" placeholder="...">
                <span class="error_field error_passport<?= $index;?>"></span>
                </div>
            </div>
        </div>
        <div class="col-lg-3 passport-section">
            <div class="form-row">
                <div class="form-group col-md-12">
                <label for="passport_date<?= $index;?>"><?=$this->lang->line('passport_date');?> *</label>
                <input type="date" class="form-control" id="passport_date<?= $index;?>" name="passport_date[]">
                <span class="error_field error_passport_date<?= $index;?>"></span>
                </div>
            </div>
        </div>
        <div class="col-lg-3 passport-section">
            <div class="form-row">
                <div class="form-group col-md-12">
                <label for="passport_place<?= $index;?>"><?=$this->lang->line('passport_place');?> *</label>
                <input type="text" class="form-control" id="passport_place<?= $index;?>" name="passport_place[]" placeholder="...">
                <span class="error_field error_passport_place<?= $index;?>"></span>
                </div>
            </div>
        </div>
        <!-- END Passport -->
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="form-row">
            <div class="form-group col-md-12 orange">
                Observations
            </div>
            </div> 
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="form-row">
            <div class="form-group col-md-12">
                <textarea name="observation[]" class="form-control" id="observation<?= $index;?>" cols="30" rows="2"></textarea>
            </div>
            </div> 
        </div>
    </div>
</div>
<?php
    endif;
?>