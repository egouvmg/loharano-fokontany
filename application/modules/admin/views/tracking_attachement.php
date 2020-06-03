
<!-- Register infos -->
<div class="firm-register-infos">
    <div class="firm-register-infos-head">
    <div class="register-mark">
        <span class="iconify" data-icon="uil:dashboard" data-inline="false" style="font-size: 32px; color: #F26122;"></span>
    </div>
    <div class="register-separator"></div>
    <div class="register-infos">
        <h6>Suivi des saisies en cours</h6>
    </div>
    </div>
    <ul class="register-survey">
        <li>
        <span class="number big"><?= parcent_number(($done_company->nbr_register/$start_company->nbr_register)*100);?> %</span>
        <span class="text">Taux d'enregistrement</span>
        </li>
        <li>
        <span class="number big"><?= $done_company->nbr_register;?></span>
        <span class="text">Registres enregistrés</span>
        </li>
        <?php if(empty($avg_company)) : ?>
        <li>
        <span class="number">0</span>
        <span class="text">jours de saisies</span>
        </li>
        <li>
        <span class="number">0</span>
        <span class="text">Fokontany traités par jour</span>
        </li>
        <li>
        <span class="number">0</span>
        <span class="text">Registres traités en moyenne par jour</span>
        </li>
        <li>
        <span class="number">0</span>
        <span class="text">Personnes traitées en moyenne par jour</span>
        </li>
        <?php else : ?>
            <li>
        <span class="number"><?= format_number($avg_company->nbr_day);?></span>
        <span class="text">jours de saisies</span>
        </li>
        <li>
        <span class="number"><?= format_number($avg_company->avg_fokontany);?></span>
        <span class="text">Fokontany traités par jour</span>
        </li>
        <li>
        <span class="number"><?= format_number($avg_company->avg_register);?></span>
        <span class="text">Registres traités en moyenne par jour</span>
        </li>
        <li>
        <span class="number"><?= format_number($avg_company->avg_person);?></span>
        <span class="text">Personnes traitées en moyenne par jour</span>
        </li>
        <?php endif;?>
    </ul>
</div>
<!-- end register infos -->