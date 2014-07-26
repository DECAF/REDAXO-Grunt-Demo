<input type="hidden" name="<?php echo $this->getFieldName() ?>" value="<?php echo $this->getValue() ?>" />
<p class="<?php echo $this->getHTMLClass() ?> formlabel-<?php echo $this->getName() ?>" id="<?php echo $this->getHTMLId() ?>">
    <label class="text <?php echo $this->getWarningClass() ?>" for="<?php echo $this->getFieldId() ?>" >
        <?php echo $this->getLabel() ?>
        <?php if ($this->getValue()): ?>
            <br />Dateiname: <a href="files/<?php echo $this->getValue() ?>"><?php echo $this->getValue() ?></a><br />
            <?php if (in_array(substr(strtolower($this->getValue()), -4), array('.jpg', '.png', '.gif'))): ?>
                <br /><img src="?rex_img_type=profileimage&amp;rex_img_file=<?php echo $this->getValue() ?>" />
            <?php endif ?>
        <?php endif ?>
    </label>
    <?php if ($this->getValue()): ?>
        <span class="formmcheckbox" style="width:300px;clear:none;">
            <input id="<?php echo $this->getFieldId('delete') ?>" type="checkbox" name="<?php echo md5($this->getFieldName('delete')) ?>" value="1" />
            <label for="<?php echo $this->getFieldId('delete') ?>">Datei löschen</label>
        </span>
    <?php endif ?>
    <input class="uploadbox clickmedia <?php echo $this->getWarningClass() ?>" id="<?php echo $this->getFieldId() ?>" name="file_<?php echo md5($this->getFieldName('file')) ?>" type="file" />
</p>
