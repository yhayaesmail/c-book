<?php
class ErrorController
{
    public function notFound()
    {
        show404();
    }

    public function forbidden()
    {
        http_response_code(403);
        $title = 'Forbidden';
        require 'views/errors/403.php';
    }
}
