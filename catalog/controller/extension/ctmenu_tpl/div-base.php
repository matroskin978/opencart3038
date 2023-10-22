<?php if(!isset($item['children'])): ?>
    <?php $classes = $dropdown_classes ?: 'nav-item nav-link' ?>
    <a href="<?=$item['link'];?>" class="<?= $classes; ?>"><?=$item['title'];?></a>
<?php else: ?>
    <div class="nav-item dropdown">
        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><?=$item['title'];?>
            <i class="fa fa-angle-down mt-1"></i>
        </a>
        <div class="dropdown-menu bg-primary rounded-0 border-0 m-0">
            <?= $this->treeToHtml($item['children'], $tpl, 'dropdown-item');?>
        </div>
    </div>
<?php endif; ?>
