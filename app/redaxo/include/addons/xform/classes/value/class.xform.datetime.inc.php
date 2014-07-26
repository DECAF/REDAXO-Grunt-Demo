<?php

/**
 * XForm
 * @author jan.kristinus[at]redaxo[dot]org Jan Kristinus
 * @author <a href="http://www.yakamara.de">www.yakamara.de</a>
 */

class rex_xform_datetime extends rex_xform_abstract
{


    function preValidateAction()
    {
        if (is_array($this->getValue())) {
            $a = $this->getValue();

            $year = (int) substr(@$a['year'], 0, 4);
            $month = (int) substr(@$a['month'], 0, 2);
            $day = (int) substr(@$a['day'], 0, 2);
            $hour = (int) substr(@$a['hour'], 0, 2);
            $min = (int) substr(@$a['min'], 0, 2);

            $r =
                str_pad($year, 4, '0', STR_PAD_LEFT) . '-' .
                str_pad($month, 2, '0', STR_PAD_LEFT) . '-' .
                str_pad($day, 2, '0', STR_PAD_LEFT) . ' ' .
                str_pad($hour, 2, '0', STR_PAD_LEFT) . ':' .
                str_pad($min, 2, '0', STR_PAD_LEFT) . ':00';

            $this->setValue($r);
        }
    }


    function enterObject()
    {

        $r = $this->getValue();

        $day = '00';
        $month = '00';
        $year = '0000';
        $hour = '00';
        $minute = '00';

        if ($r != '') {
            $year = (int) substr($this->getValue(), 0, 4);
            $month = (int) substr($this->getValue(), 5, 2);
            $day = (int) substr($this->getValue(), 8, 2);
            $hour = (int) substr($this->getValue(), 11, 2);
            $minute   = (int) substr($this->getValue(), 14, 2);
        }

        $year = str_pad($year, 4, '0', STR_PAD_LEFT);
        $month = str_pad($month, 2, '0', STR_PAD_LEFT);
        $day = str_pad($day, 2, '0', STR_PAD_LEFT);
        $hour = str_pad($hour, 2, '0', STR_PAD_LEFT);
        $minute = str_pad($minute, 2, '0', STR_PAD_LEFT);

        $isodatum = sprintf('%04d-%02d-%02d %02d:%02d:%02d', $year, $month, $day, $hour, $minute, 0);

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

        // ------------- hour

        $hours = array();
        for ($i = 0; $i < 24; $i++) {
            $hours[$i] = str_pad($i, 2, '0', STR_PAD_LEFT);
        }

        // ------------- min

        if ($this->getElement(5) != '') {
            $minutes = explode(',', trim($this->getElement(5)));
        } else {
            $minutes = array();
            for ($i = 0; $i < 60; $i++) {
                $minutes[$i] = str_pad($i, 2, '0', STR_PAD_LEFT);
            }
        }

        // -------------

        $format = $this->getElement(6);
        if ($format == '') {
            $format = '###Y###-###M###-###D### ###H###h ###I###m';
        }
        $format = preg_split('/(?<=###[YMDHI]###)(?=.)|(?<=.)(?=###[YMDHI]###)/', $format);

        $this->params['form_output'][$this->getId()] = $this->parse(
            'value.datetime.tpl.php',
            compact('format', 'yearStart', 'yearEnd', 'hours', 'minutes', 'year', 'month', 'day', 'hour', 'minute')
        );
    }


    function getDescription()
    {
        return 'datetime -> Beispiel: datetime|name|label|jahrstart|jahrsende|minutenformate 00,15,30,45|[Anzeigeformat###Y###-###M###-###D### ###H###h ###I###m]';
    }


    function getDefinitions()
    {
        return array(
            'type' => 'value',
            'name' => 'datetime',
            'values' => array(
                'name'       => array( 'type' => 'name', 'label' => 'Feld' ),
                'label'      => array( 'type' => 'text', 'label' => 'Bezeichnung'),
                'year_start' => array( 'type' => 'text', 'label' => 'Startjahr'),
                'year_end'   => array( 'type' => 'text', 'label' => 'Endjahr'),
                'minutes'    => array( 'type' => 'text', 'label' => '[Minutenformate]'),
                'format'     => array( 'type' => 'text', 'label' => '[Anzeigeformat###Y###-###M###-###D### ###H###h ###I###m]'),
            ),
            'description' => 'Datum & Uhrzeit Eingabe',
            'dbtype' => 'datetime'
        );
    }

    static function getListValue($params)
    {
        global $I18N;
        $format = $I18N->msg('xform_format_datetime');
        if (($d = DateTime::createFromFormat('Y-m-d H:i:s', $params['subject'])) && $d->format('Y-m-d H:i:s') == $params['subject']) {
            return $d->format($format);
        }
        return '[' . $params['subject'] . ']';
    }

}
