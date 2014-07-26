<?php

/**
 * XForm
 * @author jan.kristinus[at]redaxo[dot]org Jan Kristinus
 * @author <a href="http://www.yakamara.de">www.yakamara.de</a>
 */

class rex_xform_validate_size extends rex_xform_validate_abstract
{

    function enterObject()
    {
        if ($this->params['send'] == '1') {
            // Wenn leer, dann alles ok
            if ($this->obj_array[0]->getValue() == '') {
                return;
            }

            if (strlen($this->obj_array[0]->getValue()) != $this->getElement('size')) {
                $this->params['warning'][$this->obj_array[0]->getId()] = $this->params['error_class'];
                $this->params['warning_messages'][$this->obj_array[0]->getId()] = $this->getElement('message');
            }
        }
    }

    function getDescription()
    {
        return 'size -> Laenge der Eingabe muss gleich size sein, beispiel: validate|size|plz|6|warning_message';
    }

    function getDefinitions()
    {
        return array(
            'type' => 'validate',
            'name' => 'size',
            'values' => array(
                'name'    => array( 'type' => 'select_name', 'label' => 'Name' ),
                'size'    => array( 'type' => 'text', 'label' => 'Anzahl der Zeichen'),
                'message' => array( 'type' => 'text', 'label' => 'Fehlermeldung'),
            ),
            'description' => 'Hiermit wird ein Label überprüft ob es eine bestimmte Anzahl von Zeichen hat',
        );

    }

}
