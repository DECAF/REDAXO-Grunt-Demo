<?php $value = isset($value) ? $value : 1 ?>
<p class="formcheckbox formlabel-<?php echo $this->getName() ?>" id="<?php echo $this->getHTMLId() ?>">
    <input type="checkbox" class="checkbox<?php echo $this->getWarningClass() ?>" name="<?php echo $this->getFieldName() ?>" id="<?php echo $this->getFieldId() ?>" value="<?php echo $value ?>"<?php echo $this->getValue() == $value ? ' checked="checked"' : '' ?> />
    <label class="checkbox<?php echo $this->getWarningClass() ?>" for="<?php echo $this->getFieldId() ?>" ><?php echo $this->getLabel() ?></label>
</p>
