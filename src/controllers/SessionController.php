<?php

require_once('./models/Database.class.php');
require_once('./models/UserManager.php');
require_once('./models/User.class.php');

#[Prefix('/user')]
class SessionController {

    private $_bdd;
    private $_userManager;

    public function __construct(){
        $this->_bdd = (new Database())->connectDb();
        $this->_userManager = new UserManager($this->_bdd);
    }

    #[Route('/register','POST','register')]
    public function register(){

        if (isset($_POST["firstname"]) && isset($_POST["lastname"]) && isset($_POST["email"]) && isset($_POST["pwd"])) {
            
            $firstname = $_POST["firstname"];
            $lastname = $_POST["lastname"];
            $email = $_POST["email"];
            $pwd = $_POST["pwd"];
            $user = new User(array("firstname" => $firstname, "lastname" => $lastname, "email" => $email, "pwd" => $pwd));
            
            if ($this->_userManager->noRegister($user)) {
                echo "noregistre";
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

    #[Route("/login", "GET", "login")]
    public function login(){

        if (isset($_POST['email']) and !empty($_POST['email']) and isset($_POST['pwd']) and !empty($_POST['pwd'])) {

            $email = htmlspecialchars($_POST['email']);
            $pwd = htmlspecialchars($_POST['pwd']);
            $new_user = new User(array('email' => $email));
            $isConnected = $this->_userManager->checkConnection($new_user, $pwd);

            if ($isConnected) {
                session_start();
                $_SESSION['email'] = $_POST['email'];
                
                header('Location: index.php?page=keywords');
                exit();
            }
        }
    }
}

?>