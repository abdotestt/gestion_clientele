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
        public function get_event_by_id($event_id){
            return "$event_id";
        }
        public function add_event($event_data){
            $fields = ['titre', 'date', 'lieu', 'heure', 'image', 'description','prix'];
            $sanitized_data = [];
            foreach ($fields as $field) {
                if (isset($event_data[$field])) {
                    $sanitized_data[$field] = htmlspecialchars(trim($event_data[$field]), ENT_QUOTES, 'UTF-8');
                } else {
                    $sanitized_data[$field] = null;
                }
            }
            $sql = "INSERT INTO events (titre, date, lieu, heure, image ,description,prix) 
                    VALUES (:titre, :date, :lieu, :heure, :image ,:description,:prix )";
            $stmt = $this->pdo->prepare($sql);
             $stmt->execute($sanitized_data);
             Header('Location: '.$_SERVER['PHP_SELF']);
                Exit();
                            // print_r($event_data);
        }
        
        public function update_event($event_id, $event_data){
            $sql = "UPDATE events SET 
                        titre = :titre, 
                        date = :date, 
                        lieu = :lieu, 
                        heure = :heure, 
                        image = :image, 
                        description = :description,
                        prix = :prix
                      
                    WHERE id = :id";
            $event_data['id'] = $event_id;
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute($event_data);
        }
    
        public function delete_event($event_id){
            $sql = "DELETE FROM events WHERE id = :id";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute(array(':id' => $event_id));
        }
    }
