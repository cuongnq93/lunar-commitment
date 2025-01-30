<?php

class HelloWorld
{
    public function __construct($request)
    {
        $template = $request['t'] ?? 'default';
        // read file html
        $file = file_get_contents("templates/$template.html");
        echo $file;
    }
}
