<?php
defined('IS_APP') || die();

class BlogPost
{

    public $year;

    public $month;

    public $day;

    public $date;

    public $title;

    public $description;

    public $permalink;

    public function loadData($data)
    {
        if (isset($data->title)) {
            $this->title = $data->title;
        }
        
        if (isset($data->description)) {
            $this->description = $data->description;
        }
        
        if (isset($data->file)) {
            $this->file = $data->file;
        }

    }
}