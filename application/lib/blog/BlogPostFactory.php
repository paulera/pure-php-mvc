<?php 
class BlogPostFactory
{

    public static function getPostFromPath($path)
    {
        $post = null;
        
        $post = new BlogPost();
        $post->permalink = DIR_ROOT . $path;
        
        $explodedPath = explode("/", $path);
        $post->year = $explodedPath[2];
        $post->month = $explodedPath[3];
        $post->day = $explodedPath[4];
        
        if (! ctype_digit($post->year) || ! ctype_digit($post->month) || ! ctype_digit($post->day)) {
            throw new Exception("What the flock is this post?");
        }
        
        $post->date = new DateTime();
        $post->date->setDate($post->year, $post->month, $post->day);
        $post->date->setTime(0, 0, 0);
        
        if (file_exists(DIR_ROOT . $path . '.json')) {
            $metadata = json_decode(file_get_contents(DIR_ROOT . $path . '.json'));
            $post->loadMetadata($metadata);
        }
        
        if (! isset($post->title)) {
            $title = preg_replace("/(-|_|\ )/", " ", $explodedPath[5]);
            $title = trim(ucfirst($title));
            $post->title = $title;
        }
        
        return $post;
    }
}