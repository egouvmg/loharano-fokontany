
<?php foreach ($fokontany as $f): ?>
  <tr>
    <td><?= $f->fokontany_name;?></td>
    <td><?= format_number($f->nbr_register);?></td>
    <td><?= format_number($f->people);?></td>
    <td>
      <div class="dropdown">
        <button type="submit" class="btn btn-more dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <span class="iconify" data-icon="uil:ellipsis-v" data-inline="false"></span>
        </button>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
          <a class="dropdown-item edit-fk" data-name="<?= $f->fokontany_name;?>" data-people="<?= $f->people;?>" data-register="<?= $f->nbr_register;?>" data-index="<?= $f->fokontany_id;?>" data-toggle="modal" data-target="#editRegisterAdmin">Editer</a>
        </div>
      </div>
    </td>
  </tr>
<?php endforeach ?>