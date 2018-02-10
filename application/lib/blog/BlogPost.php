<?php
defined('IS_APP') || die();

class BlogPost
{

    public $year;

    public $month;

    public $day;

    public $date;

    public $postName;

    public $title;

    public $description;

    public $permalink;

    public $metadata;

    public function loadMetadata($metadata)
    {
        // Try to load post metadata from JSON file
        if (file_exists($jsonFile)) {
            $this->metadata = json_decode(file_get_contents($jsonFile));
            
            if (isset($this->metadata->title)) {
                $this->title = $this->metadata->title;
            }
            
            if (isset($this->metadata->description)) {
                $this->description = $this->metadata->description;
            }
            
            if (isset($this->metadata->file)) {
                $this->file = $this->metadata->file;
            }
            
            return true;
        }
        return false;
    }
}