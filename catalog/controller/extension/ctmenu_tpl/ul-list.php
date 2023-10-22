<li class="test">
    <a href="<?=$item['link'];?>"><?=$item['title'];?></a>
    <?php if(isset($item['children'])): ?>
        <ul>
            <?= $this->treeToHtml($item['children'], $tpl);?>
        </ul>
    <?php endif; ?>
</li>
