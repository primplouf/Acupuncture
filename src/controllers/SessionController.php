<?php

require_once('./models/Database.class.php');
require_once('./models/UserManager.php');
require_once('./models/User.class.php');

#[Prefix('/user')]
class SessionController {

    private $_userManager;

    public function __construct(){
        $_userManager = new UserManager((new Database())->connectDb());
    }

    #[Route('/register','POST','register')]
    public function register(){

        if (isset($_POST["surname"]) && isset($_POST["nom"]) && isset($_POST["email"]) && isset($_POST["mdp"])) {

            $firstname = $_POST["firstname"];
            $lastname = $_POST["lastname"];
            $email = $_POST["email"];
            $pwd = $_POST["pwd"];
            $hash = password_hash($pwd, PASSWORD_DEFAULT);
            $user = new User(array("firstname" => $firstname, "lastname" => $lastname, "email" => $email, "pwd" => $hash));

            if ($this->_userManager->noRegister($user)) {

                $res = $this->_userManager->addUser($user);
                if ($res){
                    echo '<p style="color:green;">Inscription effectué avec succès vous pouvez vous connecter</p>';
                } else {
                    echo "<p style=\"color:red;\">Erreur lors de la création de l'utilisateur</p>";
                }
            } else {
                echo '<p style="color:red;">Adresse mail déjà utilisé</p>';
            }
        }

    }
}

?>