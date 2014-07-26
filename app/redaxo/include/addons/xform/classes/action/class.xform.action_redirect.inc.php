<?php

/**
 * XForm
 * @author jan.kristinus[at]redaxo[dot]org Jan Kristinus
 * @author <a href="http://www.yakamara.de">www.yakamara.de</a>
 */

class rex_xform_action_redirect extends rex_xform_action_abstract
{

    function execute()
    {

        // spezialfaelle - nur bei request oder label
        switch ($this->getElement(3)) {
            case 'request':
                if (!isset($_REQUEST[$this->getElement(4)])) {
                    return false;
                }
                break;
            case 'label':
                if (!isset($this->params['value_pool']['sql'][$this->getElement(4)])) {
                    return false;
                }
                break;
        }

        $u = $this->getElement(2);
        $u1 = (string) (int) $u;

        if ($u == $u1) {
            // id -> intern article
            $url = rex_getUrl($u, '', '', '&');
        } else {
            // extern link
            $url = $u;
        }

        // Emailkeys ersetzen. Somit auch Weiterleitungen mit neuer ID m�glich. "id=###ID###"
        foreach ($this->params['value_pool']['email'] as $search => $replace) {
            $url = str_replace('###' . $search . '###', $replace, $url);
        }

        if ($url != '') {
            ob_end_clean();
            header('Location: ' . $url);
            exit;
        }

    }

    function getDescription()
    {
        return 'action|redirect|Artikel-Id oder Externer Link|request/label|field';
    }

}
