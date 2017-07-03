<?php

class BlogController
{

    protected $layout = "layouts/master.php";

    protected $model = null;

    // post files are allowed to have only alphanumeric chars and the ones
    // listed in $postWhiteListChars
    private $postWhiteListChars = array(
        "-",
        "_",
        ".",
        " "
    );

    public function index()
    {
        $this->listPosts();
    }

    public function route()
    {
        $parts = Input::explodePath();
        $count = count($parts);
        
        $year = null;
        $month = null;
        $day = null;
        $post = null;
        
        if ($count > 1) {
            $year = $parts[1];
            if (! ctype_digit($year)) {
                throw new Exception("Invalid year.");
            }
        }
        if ($count > 2 && ctype_digit($parts[2])) {
            $month = $parts[2];
            if (! ctype_digit($month)) {
                throw new Exception("Invalid month.");
            }
        }
        if ($count > 3 && ctype_digit($parts[3])) {
            $day = $parts[3];
            if (! ctype_digit($day)) {
                throw new Exception("Invalid day.");
            }
        }
        if ($count > 4) {
            $post = $parts[4];
            if (! ctype_alnum(str_replace($this->postWhiteListChars, "", $post))) {
                throw new Exception("Invalid post.");
            }
        }
        
        if (isset($post)) {
            $contents = $this->showPost($year, $month, $day, $post);
        } else {
            $contents = $this->listPostsByDate($year, $month, $day);
        }
        
        $contents = View::render("layouts/master.php", array(
            "contents" => $contents
        ));
        
        die($contents);
    }

    private function showPost($year, $month, $day, $post)
    {
        $postDayPath = $this->blogPostsDirRelativeToRoot . $year . DS . $month . DS . $day . DS;
        $postRelativePathNoExt = $postDayPath . $post;
        
        $postFullPathNoExt = realpath(DIR_ROOT . DS . 'blog' . DS . $postDayPath) . DS . $post;
        
        // Try to load post metadata from JSON file
        $postMetaData = null;
        if (file_exists($postFullPathNoExt . ".json")) {
            $postMetaData = json_decode(file_get_contents($postFullPathNoExt . ".json"));
        }
        
        $postFile = null;
        if (isset($postMetaData) && isset($postMetadata->file)) {
            if (file_exists($postMetadata->file)) {
                // $fileExtension = strtolower(end(explode(".", $postMetadata->file)));
                // if (! in_array($this->supportedPostExtension, $fileExtension)) {
                // throw new Exception("Post format not supported");
                // }
                $postFile = $postMetadata->file;
            } else {
                throw new Exception("File not found");
            }
        }
        
        if ($postFile == null) {
            // No file defined in the json metadata, will try to guess using the filename
            // with supported extensions
            $blogModel = BlogModel::instance();
            $postFile = $blogModel->getPostFile($postFullPathNoExt);
        }
        
        if ($postFile == null) {
            View::error404();
            die();
        }
        
        $postType = trim(str_replace($postFullPathNoExt, '', $postFile), '.');
        
        // Handling the file that was found.
        $htmlContents = "";
        switch ($postType) {
            case 'php':
                $htmlContents = View::render($postRelativePathNoExt . ".php");
                break;
            
            case 'md':
                $mdContents = file_get_contents($postFile);
                $parsedown = new Parsedown();
                $htmlContents = $parsedown->text($mdContents);
                break;
            
            case 'md.php':
                $mdContents = View::render('blog' . DS . $postRelativePathNoExt . ".md.php");
                $parsedown = new Parsedown();
                $htmlContents = $parsedown->text($mdContents);
                break;
            
            case 'html':
            case 'htm':
                $htmlContents = file_get_contents($postFile);
                break;
            
            case 'txt':
                $htmlContents = file_get_contents($postFile);
                $htmlContents = htmlentities($htmlContents);
                break;
        }
        
        $date = new DateTime();
        $date->setDate($year, $month, $day);
        
        $postMetaData->date = $date;
        
        if (! isset($postMetaData->title)) {
            $title = preg_replace("/(-|_|\ )/", " ", $post);
            $title = trim(ucfirst($title));
            $postMetaData->title = $title;
        }
        
        if (! isset($postMetaData->uuid)) {
            $postMetaData->uuid = $postRelativePathNoExt;
        }
        
        $postMetaData->permalink = "/" . $postRelativePathNoExt;
        
        $contentsWithBlogSubLayout = View::render("blog/post.php", array(
            "contents" => $htmlContents,
            "postData" => $postMetaData
        ));
        
        return $contentsWithBlogSubLayout;
    }

    private function listPosts()
    {
        return $this->listPostsByDate(null, null, null);
    }

    private function listPostsByDate($year = null, $month = null, $day = null)
    {
        $path = "";
        if ($year > 0) {
            $path .= $year . DS;
        }
        
        if ($month > 0) {
            $path .= $month . DS;
        }
        
        if ($day > 0) {
            $path .= $day . DS;
        }
        
        $blogModel = BlogModel::instance();
        $posts = $blogModel->getPostsByPath($path);
        return View::render("blog/postlist.php", array(
            "posts" => $posts
        ));
    }
}

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