<?php

/**
 * XForm
 * @author jan.kristinus[at]redaxo[dot]org Jan Kristinus
 * @author <a href="http://www.yakamara.de">www.yakamara.de</a>
 */

class rex_xform_be_mediapool extends rex_xform_abstract
{

    function enterObject()
    {
        static $counter = 0;
        $counter++;

        if ($this->getValue() == '' && !$this->params['send']) {
            $this->setValue($this->getElement(3));
        }

        $this->params['form_output'][$this->getId()] = $this->parse('value.be_mediapool.tpl.php', compact('counter'));

        $this->params['value_pool']['email'][$this->getElement(1)] = stripslashes($this->getValue());
        if ($this->getElement(4) != 'no_db') {
            $this->params['value_pool']['sql'][$this->getElement(1)] = $this->getValue();
        }
    }

    function getDescription()
    {
        return 'be_mediapool -> Beispiel: be_mediapool|name|label|defaultwert|no_db';
    }

    function getDefinitions()
    {
        return array(
            'type' => 'value',
            'name' => 'be_mediapool',
            'values' => array(
                'name' => array( 'type' => 'name',   'label' => 'Name' ),
                'label' => array( 'type' => 'text',    'label' => 'Bezeichnung'),
                'default' => array( 'type' => 'text',     'label' => 'Defaultwert'),
            ),
            'description' => 'Mediafeld, welches eine Datei aus dem Medienpool holt',
            'dbtype' => 'text'
        );
    }


    static function getListValue($params)
    {
        $return = $params['subject'];
        if (strlen($return) > 16) {
            $return = '<span style="white-space:nowrap;" title="' . htmlspecialchars($return) . '">' . substr($return, 0, 6) . ' ... ' . substr($return, -6) . '</span>';
        }
        return $return;

    }



}
