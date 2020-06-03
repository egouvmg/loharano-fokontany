
<div class="firm-register-infos">
  <div class="firm-register-infos-head">
    <div class="register-mark">
      <span class="mark">
        <span class="iconify" data-inline="false" data-icon="uil:check" style="font-size: 16px;"></span>
      </span>
    </div>
    <div class="register-separator"></div>
    <div class="register-infos">
      <h6>Saisies du <?= date('d / m / Y', strtotime($fr_details->day_done));?></h6>
      <p>
        <span><?= format_number($fr_details->nbr_fokontany);?> Fokontany à traiter</span>
        <span><?= format_number($fr_details->nbr_register);?> Registres enregistrés</span>
      </p>
    </div>
  </div>
  <ul class="firm-register-infos-list">


    <?php foreach ($daily_register_fokontany as $key => $value): ?>
    <li class="firm-register-infos-item">
      <div class="register-row">
        <div class="register-col-full fkt-name">Fokontany : <span><?= $value->name;?></span></div>
      </div> 
      <div class="register-row">
        <div class="register-col-half rgt-text">
          <span><?= format_number($value->t_register);?> Registres à traiter</span>
        </div>
        <div class="register-col-half rgt-text">
          <span><?= format_number($value->nbr_register);?> Registres traités</span>
        </div>
        <div class="register-col-half rgt-text">
          <span><?= format_number(($value->t_register - $value->nbr_register));?> Registres restant à traiter</span>
        </div>
        <div class="register-col-half rgt-text">
          <span class="person-treaty" data-day="<?= $fr_details->day_done;?>"><?= format_number($value->nbr_people);?> Personnes traitées</span>
        </div>
      </div> 
    </li>
    <?php endforeach ?>
  </ul>
</div>