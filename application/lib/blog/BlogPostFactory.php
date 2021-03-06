<?php
defined('IS_APP') || die();

class BlogPostFactory
{

    public static function getPostFromPath($path)
    {
        $post = null;
        
        $post = new BlogPost();
        $post->permalink = DIR_ROOT . $path;
        
        $explodedPath = explode("/", $path);
        $post->year = $explodedPath[1];
        $post->month = $explodedPath[2];
        $post->day = $explodedPath[3];
        
        if (! is_numeric($post->year) || ! is_numeric($post->month) || ! is_numeric($post->day)) {
            throw new Exception("What the flock is this post?");
        }
        
        $post->date = new DateTime();
        $post->date->setDate($post->year, $post->month, $post->day);
        $post->date->setTime(0, 0, 0);
        
        if (file_exists(DIR_APP . '/' . $path . '.json')) {
            $data = json_decode(file_get_contents(DIR_APP . '/' . $path . '.json'));
            $post->loadData($data);
        }
        
        if (! isset($post->title)) {
            $title = preg_replace("/(-|_|\ )/", " ", $explodedPath[4]);
            $title = trim(ucfirst($title));
            $post->title = $title;
        }
        
        return $post;
    }
}
