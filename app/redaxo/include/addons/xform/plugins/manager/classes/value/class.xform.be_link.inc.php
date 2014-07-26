<?php

/**
 * XForm
 * @author jan.kristinus[at]redaxo[dot]org Jan Kristinus
 * @author <a href="http://www.yakamara.de">www.yakamara.de</a>
 */

class rex_xform_be_link extends rex_xform_abstract
{

    function enterObject()
    {
        static $counter = 0;
        $counter++;

        if ($this->getValue() == '' && !$this->params['send']) {
            $this->setValue($this->getElement(3));
        }

        $linkName = '';
        if ($this->getValue() != '' && $a = OOArticle::getArticleById($this->getValue())) {
            $linkName = $a->getName();
        }

        $this->params['form_output'][$this->getId()] = $this->parse('value.be_link.tpl.php', compact('counter', 'linkName'));

        $this->params['value_pool']['email'][$this->getName()] = stripslashes($this->getValue());
        if ($this->getElement(4) != 'no_db') {
            $this->params['value_pool']['sql'][$this->getName()] = $this->getValue();
        }
    }


    function getDescription()
    {
        return 'be_link -> Beispiel: be_link|name|label|defaultwert|no_db';
    }


    function getDefinitions()
    {
        return array(
            'type' => 'value',
            'name' => 'be_link',
            'values' => array(
                'name' => array( 'type' => 'name',   'label' => 'Name' ),
                'label' => array( 'type' => 'text',   'label' => 'Bezeichnung'),
            ),
            'description' => 'Hiermit kann man einen Link zu einem REDAXO Artikel setzen.',
            'dbtype' => 'text'
        );
    }


    static function getListValue($params)
    {
        if (intval($params['value']) < 1) {
            return '-';
        }

        if (($art = new rex_article($params['value']))) {
            return $art->getValue('name');
        } else {
            return 'article ' . $params['value'] . ' not found';
        }
    }

}
