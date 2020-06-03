<?php if (count($company_date)) : ?>
<?php foreach ($company_date as $key => $value): ?>
  <div class="register-item" data-index="<?= $value->company_id;?>" data-date="<?= $value->day_done;?>">
    <div class="register-mark">
      <span class="mark">
        <span class="iconify" data-inline="false" data-icon="uil:check" style="font-size: 16px;"></span>
      </span>
    </div>
    <div class="register-separator"></div>
    <div class="register-infos">
      <h6>Saisies du <?= date('d / m / Y', strtotime($value->day_done));?></h6>
      <p>
        <span><?= format_number($value->nbr_fokontany);?> Fokontany traités</span>
        <span><?= format_number($value->nbr_register);?> Registres enregistrés</span>
      </p>
    </div>
  </div>
<?php endforeach ?>
<?php else : ?>
  <p>Traitement encours.</p>
<?php endif; ?>