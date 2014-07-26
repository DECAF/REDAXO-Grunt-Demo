<?php

/**
 * XForm
 * @author jan.kristinus[at]redaxo[dot]org Jan Kristinus
 * @author <a href="http://www.yakamara.de">www.yakamara.de</a>
 */

class rex_xform_hidden extends rex_xform_abstract
{

    public function setValue($value)
    {
        if ($this->getElement(3) == 'REQUEST' && isset($_REQUEST[$this->getName()])) {
            $this->value = stripslashes(rex_request($this->getName()));

        } else {
            $this->value = $this->getElement(2);

        }

    }

    public function enterObject()
    {
        $this->params['form_output'][$this->getId()] = $this->parse('value.hidden.tpl.php');

        $this->params['value_pool']['email'][$this->getName()] = $this->getValue();
        if ($this->getElement(4) != 'no_db') {
            $this->params['value_pool']['sql'][$this->getName()] = $this->getValue();
        }
    }

    public function getDescription()
    {
        return '
                hidden -> Beispiel: hidden|name|(default)value||[no_db]<br />  hidden -> Beispiel: hidden|job_id|my_id|REQUEST|[no_db]
        ';
    }

}
