<?php

class HomeController
{
    public function indexAction()
    {
        $html = View::renderWithLayout("layouts/master.php", "testview.php", array(
            "title" => "vai nesse texto truta"
        ));
        die($html);
    }

    public function abc()
    {}
}