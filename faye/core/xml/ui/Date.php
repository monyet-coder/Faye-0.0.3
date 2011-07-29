<?php
namespace faye\core\xml\ui;

use faye\core\xml\html\option as HTMLOption;

class Date extends Fragment {
    protected
        $date  = null,
        $month = null,
        $year  = null,
        $yearRange = 20;

    public function __construct (\DOMDocument $doc, array $attributes = array(), array $children = array()) {
        $this->date = new ComboBox($doc, array('class' => 'ui-combo-date'));
        $this->month = new ComboBox($doc, array('class' => 'ui-combo-month'));
        $this->year = new ComboBox($doc, array('class' => 'ui-combo-year'));

        foreach (range(1, 31) as $d) {
            $this->date->appendChild(new HTMLOption($doc, array('value' => $d), array(new \DOMText($d))));
        }

        foreach (range(1, 12) as $m) {
            $this->month->appendChild(new HTMLOption($doc, array('value' => $m), array(new \DOMText(date('M', strtotime('1970-' . $m . '-01'))))));
        }

        foreach (range(($yrs = date('Y')) - 20, $yrs) as $y) {
            $this->year->appendChild(new HTMLOption($doc, array('value' => $y), array(new \DOMText($y))));
        }

        parent::__construct ($doc, $attributes, array($this->date, $this->month, $this->year));

        $this->addClass('ui ui-date');
    }

    protected function setAttributeValue ($date) {
        $time = is_string($date) ? strtotime($date) : $date;

        if(($date = $this('.ui-combo-date option[value="' . date('d', $time) . '"]')->get(0)) !== null) {
            $date->setAttribute('selected', 'selected');
        }
        
        if (($month = $this('.ui-combo-month option[value="' . date('n', $time) . '"]')->get(0)) !== null) {
            $month->setAttribute('selected', 'selected');
        }
            
        if (($year = $this('.ui-combo-year option[value="' . date('Y', $time) . '"]')->get(0)) !== null) {
            $year->setAttribute('selected', 'selected');
        }

        return false;
    }

    protected function setAttributeName ($name) {
        $this->date->setAttribute('name', $name . '[date]');
        $this->month->setAttribute('name', $name . '[month]');
        $this->year->setAttribute('name', $name . '[year]');

        return false;
    }
}