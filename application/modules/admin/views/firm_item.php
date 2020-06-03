<?php if (!empty($companies)): ?>
<li class="firm-item active" data-index="<?=$companies[0]->company_id;?>" data-name="<?=$companies[0]->company_name;?>">
  <div class="firm-item-info">
    <div class="text">
      <h5><?= $companies[0]->company_name;?></h5>
      <p>
        <span><?= format_number($companies[0]->nbr_fokontany);?> Fokontany</span>
        <span>-</span>
        <span><?= format_number($companies[0]->nbr_register);?> Registres</span>
      </p>
    </div>
  </div>
  <div class="chevron">
    <span class="iconify" data-icon="uil:angle-right" data-inline="false"></span>
  </div>
</li>
<?php for ($i=1; $i < count($companies); $i++) :?>
  <li class="firm-item"  data-index="<?=$companies[$i]->company_id;?>" data-name="<?=$companies[$i]->company_name;?>">
  <div class="firm-item-info">
    <div class="text">
      <h5><?= $companies[$i]->company_name;?></h5>
      <p>
        <span><?= format_number($companies[$i]->nbr_fokontany);?> Fokontany</span>
        <span>-</span>
        <span><?= format_number($companies[$i]->nbr_register);?> Registres</span>
      </p>
    </div>
  </div>
  <div class="chevron">
    <span class="iconify" data-icon="uil:angle-right" data-inline="false"></span>
  </div>
</li>
<?php endfor;?>
<?php endif ?>