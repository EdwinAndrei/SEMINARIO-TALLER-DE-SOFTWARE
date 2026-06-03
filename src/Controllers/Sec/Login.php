<?php

namespace Controllers\Sec;

class Login extends \Controllers\PublicController
{
    private string $email = "";
    private string $error = "";

    public function run(): void
    {
   
    if ($this->isPostBack()) {

            $this->email = trim(
                $_POST["email"] ?? ""
            );

            $passwd = trim(
                $_POST["passwd"] ?? ""
            );

            if (
                empty($this->email) ||
                empty($passwd)
            ) {

                $this->error =
                    "Debe ingresar correo y contraseña.";

            } else {

                $usuario =
                    \Dao\UsuarioDAO::getUsuarioByEmail(
                        $this->email
                    );

                if (
                    $usuario &&
                    password_verify(
                        $passwd,
                        $usuario["password"]
                    )
                ) {

                    \Utilities\Security::login(
                        $usuario["id"],
                        $usuario["nombre"],
                        $usuario["email"],
                        $usuario["rol"]
                    );

                    $redirTo =
                        urldecode(
                            \Utilities\Context::getContextByKey(
                                "redirto"
                            ) ?: "index.php"
                        );

                    \Utilities\Site::redirectTo(
                        $redirTo
                    );

                } else {

                    $this->error =
                        "Correo o contraseña incorrectos.";
                }
            }
        }

        \Utilities\Site::addLink(
            "public/css/auth.css"
        );

        \Utilities\Site::addLink(
    "public/css/auth.css"
);

        \Views\Renderer::render(
            "security/login",
            get_object_vars($this)
        );
    }
}