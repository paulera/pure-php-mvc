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

    protected $blogPostsDirRelativeToRoot = "blog";

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
        
        $folder = DIR_ROOT . DS . $this->blogPostsDirRelativeToRoot . DS . $path;
        if (! file_exists($folder)) {
            return $posts;
        }
        
        $dirIterator = new RecursiveDirectoryIterator(DIR_ROOT . DS . $this->blogPostsDirRelativeToRoot . DS . $path);
        $objects = new RecursiveIteratorIterator($dirIterator, RecursiveIteratorIterator::SELF_FIRST);
        foreach ($objects as $name => $object) {
            if ($object->isFile()) {
                $fileBaseName = $object->getBaseName();
                $fileName = trim(str_replace(self::$supportedPostExtension, "", $object->getBaseName()), '.');
                
                if ($fileName == $fileBaseName) {
                    continue;
                }
                
                $permalink = '/blog/' . str_replace(DIR_ROOT . DS . $this->blogPostsDirRelativeToRoot . DS, "", $object->getPath()) . DS . $fileName;
                
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
            return $files[0];
        }
    }
}