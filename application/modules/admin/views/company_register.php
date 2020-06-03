<div class="col-md-12">
    <ul class="fkt">
    <?php 
        $tr = 0;
        $tp = 0;
        foreach ($company_fokontany as $cf):
        $tr += $cf->nbr_register;
        $tp += $cf->nbr_people;
    ?>
        <li class="fkt-item">
        <div class="text">
            <span class="fkt-name"><?= $cf->fokontany_name;?></span>
            <span class="fkt-nbr">Registres : <?= format_number($cf->nbr_register);?></span>
            <span class="fkt-nbr">Personnes : <?= format_number($cf->nbr_people);?></span>
        </div>
        <div class="delete-btn" data-index="<?= $cf->fokontany_id;?>">
            <span class="iconify" data-icon="uil:multiply" data-inline="false" class="fon-size:24px"></span>
        </div>
        </li>
    <?php endforeach ?>
    </ul>
</div>
<div class="col-md-12">
    <div class="fkt-total">
    <span class="nbr"><?= format_number($tr);?> registres</span>
    <span>-</span>
    <span class="nbr"><?= format_number($tp);?> personnes</span>
    </div>
</div>