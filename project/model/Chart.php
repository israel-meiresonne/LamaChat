<?php

require_once 'framework/Model.php';

class Chart extends Model
{
    /**
     * @var string chart's title
     */
    private $title;

    /**
     * @var string the chart
     * + javascript code surounded of script tags
     */
    private $chart;

    /**
     * @var array holds the datas
     */
    private $tab;

    /**
     * @var string chart's x-axe title
     */
    private $xTitle;

    /**
     * @var string chart's y-axe title
     */
    private $yTitle;

    // public function __construct($id, $tab/*$colNames, $rows*/)
    public function __construct($id, $colNames, $rows)
    {
        $nbCol = count($colNames);
        $realNbCol = count($rows[0]);
        if ($nbCol != $realNbCol) {
            throw new Exception("$nbCol column(s) expected but found $realNbCol");
        }
        $this->id = $id;
        array_unshift($rows, $colNames);
        $this->tab = $rows;
    }

    /**
     * Setter for chart's title
     * @param string $title chart's title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }
    /**
     * Setter for chart's title
     * @param string $title chart's title
     */
    public function setXTitle($xTitle)
    {
        $this->xTitle = $xTitle;
    }
    
    /**
     * Setter for chart's title
     * @param string $title chart's title
     */
    public function setYTitle($yTitle)
    {
        $this->yTitle = $yTitle;
    }

    private function setChart()
    {
        $id = $this->id;
        $tab = $this->tab;
        $title = $this->title;
        $xTitle = $this->xTitle;
        $yTitle = $this->yTitle;
        ob_start();
        require 'view/Admin/chart.php';
        $this->chart = ob_get_clean();
    }

    public function  getChart()
    {
        (!isset($this->chart)) ? $this->setChart() : null;
        return $this->chart;
    }
}
