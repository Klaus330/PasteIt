<?php


namespace app\core;


class DateFormatter
{
    protected \DateInterval $interval;

    public function __construct($interval)
    {
        $this->interval = $interval;
    }

    public function displayHumanFormat()
    {
        if($this->interval->y != 0){
            $nrOfYears = $this->interval->format("%y");
            return "$nrOfYears years";
        }else if($this->interval->m != 0){
            $nrOfYears = $this->interval->format("%m");
            return "$nrOfYears months";
        }else if($this->interval->d !=0){
            $nrOfYears = $this->interval->format("%d");
            return "$nrOfYears days";
        }else if($this->interval->h !=0){
            $nrOfYears = $this->interval->format("%h");
            return "$nrOfYears hours";
        }
        else if($this->interval->i !=0){
            $nrOfYears = $this->interval->format("%i");
            return "$nrOfYears min";
        }
        else if($this->interval->s !=0){
            $nrOfYears = $this->interval->format("%s");
            return "$nrOfYears sec";
        }
    }

    public function isInvert()
    {
        return ($this->interval->invert == 0);
    }

}