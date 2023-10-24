<?php

require_once('./models/Database.class.php');
require_once('./models/UserManager.php');
require_once('./models/User.class.php');
require_once('./models/Twig.class.php');

#[Prefix('/user')]
class SessionController {

    private $_twig;
    private $_db;
    private $_userManager;

    public function __construct(){
        $this->_twig = (new Twig())->getTwig();
        $this->_db = (new Database())->connectDb();
        $this->_userManager = new UserManager($this->_db);
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

        echo $this->_twig->render('inscription.twig');
    }

    #[Route("/login", "GET", "login")]
    public function login(){

        $params = array();

        if (isset($_POST['email']) and !empty($_POST['email']) and isset($_POST['pwd']) and !empty($_POST['pwd'])) {

            $email = htmlspecialchars($_POST['email']);
            $pwd = htmlspecialchars($_POST['pwd']);
            $new_user = new User(array('email' => $email));
            $isConnected = $this->_userManager->checkConnection($new_user, $pwd);

            $params['verify'] = $isConnected;

            if ($isConnected) {
                session_start();
                $params['session'] = $_POST['email'];
                echo $this->_twig->render('keywords.twig', $params);
                exit();
            }
            
            
        }
        echo $this->_twig->render('connexion.twig', $params);
    }

    #[Route("/logout", "GET", "logout")]
    public function logout(){

        $params = array();

        session_start();
        session_unset();
        session_destroy();

        echo $this->_twig->render('accueil.twig', $params);
    }
}

?>