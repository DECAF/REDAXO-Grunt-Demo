
<?php if ($this->relation['relation_type'] < 2): ?>

    <p class="<?php echo $this->getHTMLClass() ?> formlabel-<?php echo $this->getName() ?>" id="<?php echo $this->getHTMLId() ?>">
        <label class="select <?php echo $this->getWarningClass() ?>" for="<?php echo $this->getFieldId() ?>" ><?php echo $this->getLabelStyle($this->relation['label']) ?></label>
        <select class="select" id="<?php echo $this->getFieldId() ?>" <?php echo $this->relation['relation_type'] == 1 ? 'name="' . $this->getFieldName() . '[]" multiple="multiple" size="' . $this->relation['size'] . '"' : 'name="' . $this->getFieldName() . '" size="1"', $this->relation['disabled'] ? ' disabled="disabled"' : '' ?>>
            <?php foreach ($options as $key => $value): ?>
                <option value="<?php echo $key ?>"<?php echo in_array($key, $this->getValue()) ? ' selected="selected"' : '' ?>><?php echo $value ?></option>
            <?php endforeach ?>
        </select>
    </p>

<?php else: ?>

    <div class="xform-element <?php echo $this->getHTMLClass() ?> formlabel-<?php echo $this->getName() ?>" id="<?php echo $this->getHTMLId() ?>">
        <label class="select <?php echo $this->getWarningClass() ?>" for="<?php echo $this->getFieldId() ?>" ><?php echo $this->getLabelStyle($this->relation['label']) ?></label>
        <div class="rex-widget">
        
            <?php if ($this->relation['relation_type'] == 4) { ?>

                <div class="rex-widget-data">
                    <p class="rex-widget-field">
                        <input type="hidden" name="<?php echo $this->getFieldName() ?>" id="XFORM_MANAGER_DATA_<?php echo $this->getId() ?>" value="<?php echo implode(',', $this->getValue()) ?>" />
                        <?php 
                        
                        if ($this->params["main_id"] > 0) {
                            ?><a href="javascript:void(0);" onclick="newLinkMapWindow('<?php echo $link ?>');return false;"><?php echo $I18N->msg('xform_relation_edit_relations'); ?></a>
                            <?php
                        } else {
                            echo $I18N->msg('xform_relation_first_create_data');
                        
                        }
                        
                        ?>
                        
                    </p>
                </div>

            <?php } else if ($this->relation['relation_type'] == 2) { ?>

                <div class="rex-widget-data">

                    <p class="rex-widget-field">
                        <input type="hidden" name="<?php echo $this->getFieldName() ?>" id="XFORM_MANAGER_DATA_<?php echo $this->getId() ?>" value="<?php echo implode(',', $this->getValue()) ?>" />
                        <input type="text" size="30" name="XFORM_MANAGER_DATANAME[<?php echo $this->getId() ?>]" value="<?php echo htmlspecialchars($valueName) ?>" id="XFORM_MANAGER_DATANAME_<?php echo $this->getId() ?>" readonly="readonly" class="text" />
                    </p>
                    <p class="rex-widget-icons rex-widget-1col">
                    <span class="rex-widget-column rex-widget-column-first">
                        <a href="javascript:void(0);" class="rex-icon-file-open" onclick="xform_manager_openDatalist(<?php echo $this->getId() ?>, '<?php echo $this->relation['target_field'] ?>', '<?php echo $link ?>','0');return false;" title="<?php echo $I18N->msg('xform_relation_choose_entry') ?>"></a>
                        <a href="javascript:void(0);" class="rex-icon-file-delete" onclick="xform_manager_deleteDatalist(<?php echo $this->getId() ?>,'0');return false;" title="<?php echo $I18N->msg('xform_relation_delete_entry') ?>"></a>
                    </span>
                    </p>
                </div>

            <?php } else { ?>

                <div class="rex-widget-xform-manager-datalist">
                    <input type="hidden" name="<?php echo $this->getFieldName() ?>" id="XFORM_MANAGER_DATALIST_<?php echo $this->getId() ?>" value="<?php echo implode(',', $this->getValue()) ?>" />
                    <p class="rex-widget-field">
                        <select name="XFORM_MANAGER_DATALIST_SELECT[<?php echo $this->getId() ?>]" id="XFORM_MANAGER_DATALIST_SELECT_<?php echo $this->getId() ?>" size="<?php echo $this->relation['size'] ?>">';
                            <?php foreach ($options as $key => $value): ?>
                                <option value="<?php echo $key ?>"><?php echo $value ?></option>
                            <?php endforeach ?>
                        </select>
                    </p>
                    <p class="rex-widget-icons rex-widget-2col">
                        <span class="rex-widget-column rex-widget-column-first">
                            <a href="javascript:void(0);" class="rex-icon-file-top" onclick="xform_manager_moveDatalist(<?php echo $this->getId() ?>,'top');return false;" title="<?php echo $I18N->msg('xform_relation_move_first_data') ?>"></a>
                            <a href="javascript:void(0);" class="rex-icon-file-up" onclick="xform_manager_moveDatalist(<?php echo $this->getId() ?>,'up');return false;" title="<?php echo $I18N->msg('xform_relation_move_up_data') ?>"></a>
                            <a href="javascript:void(0);" class="rex-icon-file-down" onclick="xform_manager_moveDatalist(<?php echo $this->getId() ?>,'down');return false;" title="<?php echo $I18N->msg('xform_relation_down_first_data') ?>"></a>
                            <a href="javascript:void(0);" class="rex-icon-file-bottom" onclick="xform_manager_moveDatalist(<?php echo $this->getId() ?>,'bottom');return false;" title="<?php echo $I18N->msg('xform_relation_move_last_data') ?>"></a>
                        </span>
                        <span class="rex-widget-column">
                            <a href="javascript:void(0);" class="rex-icon-file-open" onclick="xform_manager_openDatalist(<?php echo $this->getId() ?>, '<?php echo $this->relation['target_field'] ?>', '<?php echo $link ?>','1');return false;" title="<?php echo $I18N->msg('xform_relation_choose_entry') ?>"></a>
                            <a href="javascript:void(0);" class="rex-icon-file-delete" onclick="xform_manager_deleteDatalist(<?php echo $this->getId() ?>,'1');return false;" title="<?php echo $I18N->msg('xform_relation_delete_entry') ?>"></a>
                        </span>
                    </p>
                </div>

            <?php } ?>

        </div>
        <div class="rex-clearer"></div>
    </div>

<?php endif ?>
