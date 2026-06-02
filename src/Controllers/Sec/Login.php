<?php

namespace Controllers\Sec;

class Login extends \Controllers\PublicController
{
    public function run(): void
    {
        $error = '';

        if ($this->isPostBack()) {
            $email  = trim($_POST['email']  ?? '');
            $passwd = trim($_POST['passwd'] ?? '');

            // -------------------------------------------------------
            // TODO: replace this stub with a real Dao lookup, e.g.:
            //   $user = \Dao\Security::getUserByEmail($email);
            //   if ($user && password_verify($passwd, $user['passwd_hash'])) { ... }
            // -------------------------------------------------------
            if ($email !== '' && $passwd !== '') {
                \Utilities\Security::login(1, 'Demo User', $email);
                $redirTo = urldecode(\Utilities\Context::getContextByKey('redirto') ?: 'index.php');
                \Utilities\Site::redirectTo($redirTo);
            } else {
                $error = 'Please enter your email and password.';
            }
        }

        \Views\Renderer::render('security/login', ['error' => $error]);
    }
}
