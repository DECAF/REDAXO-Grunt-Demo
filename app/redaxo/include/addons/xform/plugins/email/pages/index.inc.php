<?php

/**
 * XForm
 * @author jan.kristinus[at]redaxo[dot]org Jan Kristinus
 * @author <a href="http://www.yakamara.de">www.yakamara.de</a>
 */

rex_title('XForm', $REX['ADDON']['xform']['SUBPAGES']);

$SF = true;

$table = $REX['TABLE_PREFIX'] . 'xform_email_template';
$bezeichner = $I18N->msg('xform_email_template');
$csuchfelder = array('name', 'mail_from', 'mail_subject', 'body');

$func = rex_request('func', 'string', '');
$template_id = rex_request('template_id', 'int');

if ($func == 'add' || $func == 'edit') {

    echo rex_content_block('<a class="rex-back" href="index.php?page=' . $page . '&amp;subpage=' . $subpage . '">' . $I18N->msg('xform_back_to_overview') . '</a>');

    echo rex_content_block('<p>Durch folgende Markierungen <b>###field###</b> kann man die in den Formularen eingegebenen Felder hier im E-Mail Template verwenden. Weiterhin sind
    alle REDAXO Variablen wie $REX["SERVER"] als <b>###REX_SERVER###</b> verwendbar. Urlencoded, z.b. für Links, bekommt man diese Werte über <b>+++field+++</b></p>');

    echo '<div class="rex-addon-output">';

    $form = new rex_form($REX['TABLE_PREFIX'] . 'xform_email_template', 'Template', 'id=' . $template_id);
    if ($func == 'edit') {
        $form->addParam('template_id', $template_id);
    }

    $field = &$form->addTextField('name');
    $field->setLabel($I18N->msg('xform_email_key'));

    $field = &$form->addTextField('mail_from');
    $field->setLabel($I18N->msg('xform_email_from'));

    $field = &$form->addTextField('mail_from_name');
    $field->setLabel($I18N->msg('xform_email_from_name'));

    $field = &$form->addTextField('subject');
    $field->setLabel($I18N->msg('xform_email_subject'));

    $field = &$form->addTextareaField('body');
    $field->setLabel($I18N->msg('xform_email_body'));

    $field = &$form->addTextareaField('body_html');
    $field->setLabel($I18N->msg('xform_email_body_html'));

    $field = &$form->addMedialistField('attachments');
    $field->setLabel($I18N->msg('xform_email_attachments'));

    $form->show();

    echo '</div>';
}

if ($func == 'delete') {
    $query = "delete from $table where id='" . $template_id . "' ";
    $delsql = rex_sql::factory();
    $delsql->debugsql = 0;
    $delsql->setQuery($query);
    $func = '';

    echo rex_info($I18N->msg('xform_email_info_template_deleted'));
}

if ($func == '') {

    echo '<div class="rex-addon-output-v2">';
    /** Suche  **/
    $add_sql = ' ORDER BY name';
    $link  = '';

    $sql = "select * from $table " . $add_sql;

    $list = rex_list::factory($sql);
    $list->setCaption($I18N->msg('xform_email_header_template_caption'));
    $list->addTableAttribute('summary', $I18N->msg('xform_email_header_template_summary'));

    $list->addTableColumnGroup(array(40, 40, '*', 153, 153));

    $img = '<img src="media/template.gif" alt="###name###" title="###name###" />';
    $imgAdd = '<img src="media/template_plus.gif" alt="' . $I18N->msg('xform_create_template') . '" title="' . $I18N->msg('xform_email_create_template') . '" />';
    $imgHeader = '<a href="' . $list->getUrl(array('page' => $page, 'subpage' => $subpage, 'func' => 'add')) . '">' . $imgAdd . '</a>';
    $list->addColumn($imgHeader, $img, 0, array('<th class="rex-icon">###VALUE###</th>', '<td class="rex-icon">###VALUE###</td>'));
    $list->setColumnParams($imgHeader, array('page' => $page, 'subpage' => $subpage, 'func' => 'edit', 'template_id' => '###id###'));

    $list->setColumnLabel('id', 'ID');
    $list->setColumnLayout('id',  array('<th class="rex-small">###VALUE###</th>', '<td class="rex-small">###VALUE###</td>'));

    $list->setColumnLabel('name', $I18N->msg('xform_email_header_template_description'));
    $list->setColumnParams('name', array('page' => $page, 'subpage' => $subpage, 'func' => 'edit', 'template_id' => '###id###'));

    $list->setColumnLabel('mail_from', $I18N->msg('xform_email_header_template_mail_from'));
    $list->setColumnLabel('mail_from_name', $I18N->msg('xform_email_header_template_mail_from_name'));
    $list->setColumnLabel('subject', $I18N->msg('xform_email_header_template_subject'));

    $list->removeColumn('body');
    $list->removeColumn('body_html');
    $list->removeColumn('attachments');

    $list->addColumn($I18N->msg('delete'), $I18N->msg('delete'));
    $list->setColumnParams($I18N->msg('delete'), array('page' => $page, 'subpage' => $subpage, 'func' => 'delete', 'template_id' => '###id###'));
    $list->addLinkAttribute($I18N->msg('delete'), 'onclick', 'return confirm(\' id=###id### ' . $I18N->msg('delete') . ' ?\')');

    $list->setNoRowsMessage($I18N->msg('xform_email_templates_not_found'));

    $list->show();

    echo '</div>';
}
