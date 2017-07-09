<?php

/**
 * Class E404Controller
 */
Class error404_controller extends Controller
{
    /**
     * Extends our primary controller class for page 404 error
     */
    function index_action()
    {
        $this->view->generate_view('view_not_found.php', 'template.php');
    }
}
