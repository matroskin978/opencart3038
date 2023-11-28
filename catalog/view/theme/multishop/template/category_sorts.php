<div class="col-sm-6">
    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <label class="input-group-text" for="sort-select"><?= $this->language->get('text_sort'); ?></label>
        </div>
        <select class="custom-select" id="input-sort" onchange="location = this.value;">
            <?php foreach ($data['sorts'] as $sorts): ?>
                <?php if ($sorts['value'] == "{$data['sort']}-{$data['order']}"): ?>
                    <option value="<?= $sorts['href']; ?>"
                            selected="selected"><?= $sorts['text']; ?></option>
                <?php else: ?>
                    <option value="<?= $sorts['href']; ?>"><?= $sorts['text']; ?></option>
                <?php endif; ?>
            <?php endforeach; ?>
        </select>
    </div>
</div>
