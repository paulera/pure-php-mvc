<?php
defined('IS_APP') || die();

class BlogModel
{

    private static $__instance = null;

    public static function instance()
    {
        if (! isset(self::$__instance)) {
            self::$__instance = new BlogModel();
        }
        return self::$__instance;
    }

    // Keep from creating new instances of this class
    private function __construct()
    {}

    protected $blogDir = "blog";

    protected static $supportedPostExtension = array(
        "md.php",
        "md",
        "html",
        "php",
        "txt"
    );

    public function getPostsByPath($path)
    {
        $posts = array();
        
        $folder = DIR_APP . DS . $this->blogDir . DS . $path;
        if (! file_exists($folder)) {
            return $posts;
        }
        
        $dirIterator = new RecursiveDirectoryIterator(DIR_APP . DS . $this->blogDir . DS . $path);
        $objects = new RecursiveIteratorIterator($dirIterator, RecursiveIteratorIterator::SELF_FIRST);
        foreach ($objects as $name => $object) {
            if ($object->isFile()) {
                
                // With extension
                $fileBaseName = $object->getBaseName();
                
                // Without extension
                $fileName = trim(str_replace(View::getSupportedExtensions(), "", $object->getBaseName()), '.');
                
                if ($fileName == $fileBaseName) {
                    // Can't extract a known file extension for views, so it is 
                    // not a post.
                    continue;
                }
                
                $permalink = 'blog/' . str_replace(DIR_APP . DS . $this->blogDir . DS, "", $object->getPath()) . DS . $fileName;
                
                if (isset($posts[$permalink])) {
                    continue;
                }
                
                $postObject = BlogPostFactory::getPostFromPath($permalink);
                
                $posts[$permalink] = $postObject;
            }
        }
        
        $posts = array_reverse($posts);
        return $posts;
    }

    public static function getPostFile($pathNoExtension)
    {
        $files = glob($pathNoExtension . '.{' . implode(',', self::$supportedPostExtension) . '}', GLOB_BRACE);
        if (count($files) > 0) {
            // found!
            $filename = $files[0];
            $fileRelativePath = str_replace(DIR_APP . DS, '', $filename);
            return $fileRelativePath;
        }
    }
}