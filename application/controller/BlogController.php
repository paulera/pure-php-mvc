<?php

class BlogController
{

    protected $blogViewDir = "blog";

    protected $supportedPostExtension = array(
        "md.php",
        "md",
        "html",
        "php",
        "txt"
    );

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
        
        echo $contents;
        die();
    }

    private function listPosts()
    {
        return $this->listPostsByDate(null, null, null);
    }

    private function listPostsByDate($year = null, $month = null, $day = null)
    {
        // TODO: not implemented
    }

    private function showPost($year, $month, $day, $post)
    {
        $postRelativePathNoExt = $this->blogViewDir . DS . $year . DS . $month . DS . $day . DS . $post;
        $postFullPathNoExt = DIR_VIEW . DS . $postRelativePathNoExt;
        
        // Try to load post metadata from JSON file
        $postMetaData = null;
        if (file_exists($postFullPathNoExt . ".json")) {
            $jsonFile = $postFullPathNoExt . ".json";
            $postMetaData = json_decode(file_get_contents($jsonFile));
        }
        
        $postFile = null;
        $postType = null;
        if ($postMetaData) {
            // Will look for a file to get contents from
            if (isset($postMetadata->file)) {
                // File defined in the json file
                if (file_exists($postMetadata->file)) {
                    $fileExtension = strtolower(end(explode(".", $postMetadata->file)));
                    if (! in_array($this->supportedPostExtension, $fileExtension)) {
                        throw new Exception("Post format not supported");
                    }
                    $postFile = $postMetadata->file;
                    $postType = trim(str_replace($postFullPathNoExt, '', $postFile), '.');
                } else {
                    throw new Exception("Post not found");
                }
            }
        }
        
        if ($postFile == null) {
            // No file defined, will try to guess using the filename
            // with supported extensions
            $files = glob($postFullPathNoExt . '.{' . implode(',', $this->supportedPostExtension) . '}', GLOB_BRACE);
            if (count($files) > 0) {
                // found!
                $postFile = $files[0];
                $postType = trim(str_replace($postFullPathNoExt, '', $postFile), '.');
            }
        }
        
        // Can't find a suitable view by any means. 404.
        if ($postFile == null) {
            echo "404";
            die();
        }
        
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
                $mdContents = View::render($postRelativePathNoExt . ".md.php");
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
        
        if (!isset($postMetaData->title)) {
            $title = preg_replace( "/(-|_|\ )/", " ", $post);
            $title = trim(ucfirst($title));
            $postMetaData->title = $title;
        }
        
        if (!isset($postMetaData->uuid)) {
            $postMetaData->uuid = $postRelativePathNoExt;
        }
        
        $postMetaData->permalink = "/".$postRelativePathNoExt;
        
        $contentsWithBlogSubLayout = View::render("layouts/post.php", array(
            "contents" => $htmlContents,
            "postData" => $postMetaData
        ));
        
        return $contentsWithBlogSubLayout;
    }
}