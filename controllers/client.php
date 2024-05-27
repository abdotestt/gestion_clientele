<?php
    class Client{
        protected $pdo;
        public function __construct(){
            $this->pdo = Database::getConnection();

        }
        public function get_all(){
            $sql = "SELECT id, name, email, phone,statut FROM clients";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        }
        public function get_client_by_id($client_id){
            return "$client_id";
        }
        public function add_client($client_data){
            $fields = ['titre', 'date', 'lieu', 'heure', 'image', 'description','prix'];
            $sanitized_data = [];
            foreach ($fields as $field) {
                if (isset($client_data[$field])) {
                    $sanitized_data[$field] = htmlspecialchars(trim($client_data[$field]), ENT_QUOTES, 'UTF-8');
                } else {
                    $sanitized_data[$field] = null;
                }
            }
            $sql = "INSERT INTO clients (titre, date, lieu, heure, image ,description,prix) 
                    VALUES (:titre, :date, :lieu, :heure, :image ,:description,:prix )";
            $stmt = $this->pdo->prepare($sql);
             $stmt->execute($sanitized_data);
             Header('Location: '.$_SERVER['PHP_SELF']);
                Exit();
                            // print_r($client_data);
        }
        
        public function update_client($client_id, $client_data){
            $fields = ['name', 'email', 'phone', 'statut'];
            $sanitized_data = [];
            foreach ($fields as $field) {
                if (isset($client_data[$field])) {
                    $sanitized_data[$field] = htmlspecialchars(trim($client_data[$field]), ENT_QUOTES, 'UTF-8');
                } else {
                    $sanitized_data[$field] = null;
                }
            }
            $sql = "UPDATE clients SET 
                        name = :name, 
                        email = :email, 
                        phone = :phone, 
                        statut = :statut 
                    WHERE id = $client_id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($sanitized_data);
            Header('Location: '.$_SERVER['PHP_SELF']);
                Exit();
        }
        
    
        public function delete_client($client_id){
            $sql = "DELETE FROM clients WHERE id = :id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(array(':id' => $client_id));
            Header('Location: '.$_SERVER['PHP_SELF']);
                Exit();
            
        }
    }
