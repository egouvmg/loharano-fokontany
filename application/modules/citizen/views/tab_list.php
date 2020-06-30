<?php
    if(isset($index)) :
        $active = ($index == 1) ? 'active' : '';
?>
    <li class="nav-item">
        <a class="nav-link <?= $active;?>" id="pills-<?= $index;?>-tab" data-index="<?= $index;?>" data-toggle="pill" href="#pills-<?= $index;?>" role="tab" aria-controls="pills-<?= $index;?>" aria-selected="true">
        <span class="iconify" data-icon="carbon:user-filled" data-inline="false"></span> <?= $this->lang->line('citizen');?> <?= $index;?>
        </a>
    </li>
<?php
    endif;
?>