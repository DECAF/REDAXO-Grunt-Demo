<?php

/**
 * XForm
 * @author jan.kristinus[at]redaxo[dot]org Jan Kristinus
 * @author <a href="http://www.yakamara.de">www.yakamara.de</a>
 */

class rex_xform_validate_empty extends rex_xform_validate_abstract
{

    function enterObject()
    {
        if ($this->params['send'] == '1' && is_array($this->obj_array)) {
            foreach ($this->obj_array as $Object) {
                if ($Object->getValue() == '') {
                    $this->params['warning'][$Object->getId()] = $this->params['error_class'];
                    $this->params['warning_messages'][$Object->getId()] = $this->getElement('message');
                }
            }
        }
    }

    function getDescription()
    {
        return 'empty -> prüft ob leer, beispiel: validate|empty|label|warning_message ';
    }

    function getDefinitions()
    {
        return array(
            'type' => 'validate',
            'name' => 'empty',
            'values' => array(
                'name'    => array( 'type' => 'select_name', 'label' => 'Name' ),
                'message' => array( 'type' => 'text',        'label' => 'Fehlermeldung'),
            ),
            'description' => 'Hiermit wird ein Label überprüft ob es gesetzt ist',
            'famous' => true
        );

    }
}
