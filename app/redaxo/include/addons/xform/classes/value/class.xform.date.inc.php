<?php

/**
 * XForm
 * @author jan.kristinus[at]redaxo[dot]org Jan Kristinus
 * @author <a href="http://www.yakamara.de">www.yakamara.de</a>
 */

class rex_xform_date extends rex_xform_abstract
{

    function preValidateAction()
    {

        if ($this->getElement(6) == 1 && $this->params['send'] == 0 && $this->params['main_id'] < 1) {
            $this->setValue(date('Y-m-d'));

        }

        if (is_array($this->getValue())) {
            $a = $this->getValue();

            $year = (int) substr(@$a['year'], 0, 4);
            $month = (int) substr(@$a['month'], 0, 2);
            $day = (int) substr(@$a['day'], 0, 2);

            $r =
                str_pad($year, 4, '0', STR_PAD_LEFT) . '-' .
                str_pad($month, 2, '0', STR_PAD_LEFT) . '-' .
                str_pad($day, 2, '0', STR_PAD_LEFT);

            $this->setValue($r);
        }
    }


    function enterObject()
    {

        $r = $this->getValue();

        $day = '00';
        $month = '00';
        $year = '0000';

        if ($r != '') {

            if (strlen($r) == 8) {

                // 20000101
                $year = (int) substr($this->getValue(), 0, 4);
                $month = (int) substr($this->getValue(), 4, 2);
                $day = (int) substr($this->getValue(), 6, 2);

            } else {

                // 2000-01-01
                $year = (int) substr($this->getValue(), 0, 4);
                $month = (int) substr($this->getValue(), 5, 2);
                $day = (int) substr($this->getValue(), 8, 2);

            }
        }

        $year = str_pad($year, 4, '0', STR_PAD_LEFT);
        $month = str_pad($month, 2, '0', STR_PAD_LEFT);
        $day = str_pad($day, 2, '0', STR_PAD_LEFT);

        $isodatum = sprintf('%04d-%02d-%02d', $year, $month, $day);

        $this->params['value_pool']['email'][$this->getName()] = $isodatum;
        $this->params['value_pool']['sql'][$this->getName()] = $isodatum;


        // ------------- year

        $yearStart = (int) $this->getElement(3);
        $yearEnd = (int) $this->getElement(4);
        if ($yearStart == 0) {
            $yearStart = 1980;
        }
        if ($yearEnd == 0) {
            $yearEnd = 2020;
        }
        if ($yearEnd < $yearStart) {
            $yearEnd = $yearStart;
        }

        $format = $this->getElement(5);
        if ($format == '') {
            $format = '###Y###-###M###-###D###';
        }
        $format = preg_split('/(?<=###[YMD]###)(?=.)|(?<=.)(?=###[YMD]###)/', $format);

        $this->params['form_output'][$this->getId()] = $this->parse(
            array('value.date.tpl.php', 'value.datetime.tpl.php'),
            compact('format', 'yearStart', 'yearEnd', 'year', 'month', 'day')
        );
    }


    function getDescription()
    {
        return 'date -> Beispiel: date|name|label|jahrstart|jahrsende|[Anzeigeformat###Y###-###M###-###D###]|[1/Aktuelles Datum voreingestellt]';
    }

    function getDefinitions()
    {
        return array(
            'type' => 'value',
            'name' => 'date',
            'values' => array(
                'name'         => array( 'type' => 'name', 'label' => 'Feld' ),
                'label'        => array( 'type' => 'text', 'label' => 'Bezeichnung'),
                'year_start'   => array( 'type' => 'text', 'label' => '[Startjahr]'),
                'year_end'     => array( 'type' => 'text', 'label' => '[Endjahr]'),
                'format'       => array( 'type' => 'text', 'label' => '[Anzeigeformat###Y###-###M###-###D###]]'),
                'current_date' => array( 'type' => 'boolean', 'label' => 'Aktuelles Datum voreingestellt'),
            ),
            'description' => 'Datums Eingabe',
            'dbtype' => 'date'
        );
    }

    static function getListValue($params)
    {
        global $I18N;
        $format = $I18N->msg('xform_format_date');
        if (($d = DateTime::createFromFormat('Y-m-d', $params['subject'])) && $d->format('Y-m-d') == $params['subject']) {
            return $d->format($format);
        }
        return '[' . $params['subject'] . ']';
    }

}
