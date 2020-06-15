<?php
    if(isset($index)) :
        $active = ($index == 1) ? 'active' : '';
?>
    <li class="nav-item">
        <a class="nav-link <?= $active;?>" id="pills-<?= $index;?>-tab" data-toggle="pill" href="#pills-<?= $index;?>" role="tab" aria-controls="pills-<?= $index;?>" aria-selected="true"><?= $this->lang->line('citizen');?> <?= $index;?></a>
    </li>
<?php
    endif;
?>