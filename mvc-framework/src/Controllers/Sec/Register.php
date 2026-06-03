<?php

namespace Controllers\Sec;

class Register extends \Controllers\PublicController
{
    private string $nombre = "";
    private string $email = "";
    private string $error = "";

    public function run(): void
    {
        if ($this->isPostBack()) {

            $this->nombre =
                trim($_POST["nombre"] ?? "");

            $this->email =
                trim($_POST["email"] ?? "");

            $passwd =
                trim($_POST["passwd"] ?? "");

            if (
                empty($this->nombre) ||
                empty($this->email) ||
                empty($passwd)
            ) {

                $this->error =
                    "Todos los campos son obligatorios.";

            } else {

                $existe =
                    \Dao\UsuarioDAO::getUsuarioByEmail(
                        $this->email
                    );

                if ($existe) {

                    $this->error =
                        "Ya existe una cuenta con ese correo.";

                } else {

                    \Dao\UsuarioDAO::crearUsuario(
                        $this->nombre,
                        $this->email,
                        $passwd
                    );

                    \Utilities\Site::redirectTo(
                        "index.php?page=Sec.Login"
                    );
                }
            }
        }

        \Utilities\Site::addLink(
            "public/css/auth.css"
        );

        \Views\Renderer::render(
            "security/register",
            get_object_vars($this)
        );
    }
}