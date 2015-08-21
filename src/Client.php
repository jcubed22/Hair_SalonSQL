<?php

    class Client
    {
        private $name;
        private $phone;
        private $id;
        private $stylist_id;

        function __construct($name, $phone, $id = null, $stylist_id)
        {
            $this->name = $name;
            $this->phone = $phone;
            $this->id = $id;
            $this->stylist_id = $stylist_id;
        }

        //Name setter and getter
        function setName($new_name)
        {
            $this->name = $new_name;
        }

        function getName()
        {
            return $this->name;
        }

        //Phone number setter and getter
        function setPhone($new_phone)
        {
            $this->phone = $new_phone;
        }

        function getPhone()
        {
            return $this->phone;
        }

        //ID getter
        function getId()
        {
            return $this->id;
        }

        //Stylist_ID setter and getter
        function setStylistId($new_stylist_id)
        {
            $this->stylist_id = $new_stylist_id;
        }

        function getStylistId()
        {
            return $this->stylist_id;
        }

        //Save function
        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO clients (name, phone, stylist_id) VALUES
                ('{$this->getName()}',
                '{$this->getPhone()}',
                {$this->getStylistId()})"
                );
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        //Get all clients
        static function getAll()
        {
            $returned_clients = $GLOBALS['DB']->query("SELECT * FROM clients ORDER BY name;");
            $clients = array();
            foreach($returned_clients as $client) {
                $name = $client['name'];
                $phone = $client['phone'];
                $stylist_id = $client['stylist_id'];
                $new_client = new Client($name, $phone, $id, $stylist_id);
                array_push($clients, $new_client);
            }
            return $clients;
        }

        //Delete all clients
        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM clients;");
        }

        //Find a client
        static function find($search_id)
        {
            $found_client = null;
            $clients = Client::getAll();
            foreach($clients as $client) {
                $client_id = $client->getId();
                if ($client_id == $search_id) {
                    $found_client = $client;
                }
            }
            return $found_client;
        }

        //Update the client
        function update_client($new_name, $new_phone, $id, $new_stylist_id)
        {
            $GLOBALS['DB']->exec("UPDATE clients SET name = '{$new_name}', phone = '{$new_phone}', stylist_id = {$new_stylist_id} WHERE id = $id;");
            $this->setName($new_name);
            $this->setPhone($new_phone);
            $this->setStylistId($new_stylist_id);
        }

        //Delete a client
        function delete_client()
        {
            $GLOBALS['DB']->exec("DELETE FROM clients WHERE id = {$this->getId()};");
        }
        


    }

?>
