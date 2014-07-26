<?php

/**
 * XForm
 * @author jan.kristinus[at]redaxo[dot]org Jan Kristinus
 * @author <a href="http://www.yakamara.de">www.yakamara.de</a>
 */

class rex_xform_be_medialist extends rex_xform_abstract
{

    function enterObject()
    {
        static $counter = 0;
        $counter++;

        $medialist = array_filter(explode(',', $this->getValue()));

        // Medialist arguments
        $args = '';
        // Category ID
        $argvalue = intval($this->getElement(4));
        if ($argvalue > 0) {
            $args .= '&amp;rex_file_category=' . $argvalue;
        }

        // Types
        $argvalue = trim($this->getElement(5));
        if (!empty($argvalue)) {
            $argvalue = str_replace(',', '%2C', $argvalue);
            $args .= '&amp;args[types]=' . $argvalue;
        }

        $this->params['form_output'][$this->getId()] = $this->parse('value.be_medialist.tpl.php', compact('counter', 'args', 'medialist'));

        $this->params['value_pool']['email'][$this->getElement(1)] = stripslashes($this->getValue());
        if ($this->getElement(6) != 'no_db') {
            $this->params['value_pool']['sql'][$this->getElement(1)] = $this->getValue();
        }

    }

    function getDescription()
    {
        return 'be_medialist -> Beispiel: be_medialist|name|label|preview|category|types|no_db|';
    }

    function getDefinitions()
    {
        return array(
            'type' => 'value',
            'name' => 'be_medialist',
            'values' => array(
                'name'     => array( 'type' => 'name',   'label' => 'Name' ),
                'label'    => array( 'type' => 'text',   'label' => 'Bezeichnung'),
                'preview'  => array( 'type' => 'text',   'label' => 'Preview (0/1) (opt)'),
                'category' => array( 'type' => 'text',   'label' => 'Medienpool Kategorie (opt)'),
                'types'    => array( 'type' => 'text',   'label' => 'Types (opt)')
            ),
            'description' => 'Medialiste, welches Dateien aus dem Medienpool holt',
            'dbtype' => 'text'
        );
    }

    static function getListValue($params)
    {

        $return = $params['subject'];

        if ($return != '' && $returns = explode(',', $return)) {
            $return = array();
            foreach ($returns as $r) {
                if (strlen($r) > 16) {
                    $return[] = '<span style="white-space:nowrap;" title="' . htmlspecialchars($r) . '">' . substr($r, 0, 6) . ' ... ' . substr($r, -6) . '</span>';
                }
            }
            $return = implode('<br />', $return);
        }
        return $return;
    }
}
