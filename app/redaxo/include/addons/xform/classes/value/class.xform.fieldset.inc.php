<?php

/**
 * XForm
 * @author jan.kristinus[at]redaxo[dot]org Jan Kristinus
 * @author <a href="http://www.yakamara.de">www.yakamara.de</a>
 */

class rex_xform_fieldset extends rex_xform_abstract
{

    function enterObject()
    {
        $output = '';

        $option = $this->getElement(4);
        $options = array('onlyclose', 'onlycloseall', 'onlyopen', 'closeandopen');
        if (!in_array($option, $options)) {
            $option = 'closeandopen';
        }

        switch ($option) {
            case 'closeandopen':
            case 'onlyclose':
                if ($this->params['fieldsets_opened'] > 0) {
                    $output .= $this->parse('value.fieldset.tpl.php', array('option' => 'close'));
                    $this->params['fieldsets_opened']--;
                }
                break;
            case 'onlycloseall':
                for ($i = 0; $i < $this->params['fieldsets_opened']; $i++) {
                    $output .= $this->parse('value.fieldset.tpl.php', array('option' => 'close'));
                }
                $this->params['fieldsets_opened'] = 0;
                break;
            case 'onlyopen':
                break;
        }

        switch ($option) {
            case 'closeandopen':
            case 'onlyopen':
                $this->params['fieldsets_opened']++;
                $output .= $this->parse('value.fieldset.tpl.php', array('option' => 'open'));
                break;
        }

        $this->params['form_output'][$this->getId()] = $output;

    }

    function getDescription()
    {
        return 'fieldset -> Beispiel: fieldset|name|label|[class]|[onlyclose/onlycloseall/onlyopen/closeandopen]';

    }

    function getDefinitions()
    {
        return array(
            'type' => 'value',
            'name' => 'fieldset',
            'values' => array(
                'name'  => array( 'type' => 'name',  'value' => '' ),
                'label' => array( 'type' => 'text',  'label' => 'Bezeichnung'),
            ),
            'description' => 'hiermit kann man Bereiche in der Verwaltung erstellen.',
            'dbtype' => 'text'
        );
    }

}
