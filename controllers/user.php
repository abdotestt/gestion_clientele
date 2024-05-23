<?php
require_once 'database.php';
session_start();
class User {
    private $pdo;

    public function __construct() {
        $this->pdo = Database::getConnection();
    }

    public function register($email,$nom,$prenom,$password) {
        // $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $sql = "INSERT INTO users (email,nom,prenom,`password`) VALUES (:email,:nom,:prenom, :password)";
        $stmt = $this->pdo->prepare($sql);
        if( $stmt->execute(['email' => $email,'nom'=>$nom,'prenom'=>$prenom,'password' => $password])){
            // $this->pdo->commit();
            $_SESSION['email'] = $email;
            $_SESSION['firstname'] = $nom;  
            $_SESSION['lastname'] = $prenom;
            header("Location: index.php");
            exit();

        }else{
            return "error registration";
        }
    }

    public function verifyLogin($email, $password) {
        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch();
        if ($password == $user['password']) {
            session_start();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['firstname'] = $user['nom'];
            $_SESSION['lastname'] = $user['prenom'];
            $_SESSION['role'] = $user['role'];
            header('Location: index.php');
        } else {
            $message = 'Mauvais identifiants';
        }
    }
      
    
}
?>