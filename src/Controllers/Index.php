<?php
 
namespace Controllers;
 
class Index extends PublicController
{
    public function run(): void
    {
        $isLogged = \Utilities\Security::isLogged();
        $data = ['isLogged' => $isLogged];
 
        if ($isLogged) {
            $user = \Utilities\Security::getUser();
            $data['userName'] = $user['userName'] ?? '';
            $data['userRol']  = $user['userRol']  ?? '';
        }
 
        \Views\Renderer::render('index', $data);
    }
}
 