<?php

/**
 * XForm
 * @author jan.kristinus[at]redaxo[dot]org Jan Kristinus
 * @author <a href="http://www.yakamara.de">www.yakamara.de</a>
 */

class rex_xform_action_fulltext_value extends rex_xform_action_abstract
{

    function execute()
    {
        $label = $this->getElement(2);
        $labels = ' ,' . $this->getElement(3) . ',';

        $vt = '';
        foreach ($this->params['value_pool']['sql'] as $key => $value) {
            if (strpos($labels, ",$key,") > 0) {
                $this->params['value_pool']['sql'][$label] .= ' ' . $value;
            }
        }

        return;
    }

    function getDescription()
    {
        return 'action|fulltext_value|label|fulltextlabels with ,';
    }

}
