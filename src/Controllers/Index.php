<?php

namespace Controllers;

class Index extends PublicController
{
    public function run(): void
    {
        \Views\Renderer::render('index', []);
    }
}
