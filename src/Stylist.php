<?php

    class Stylist
    {
        private $name;
        private $id;

        function __construct($name, $id=null)
        {
            $this->name = $name;
            $this->id = $id;
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

        //ID getter
        function getId()
        {
            return $this->id;
        }

        //Save to database
        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO stylists (name) VALUES ('{$this->getName()}')");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        //Get all stylists
        static function getAll()
        {
            $returned_stylists = $GLOBALS['DB']->query("SELECT * FROM stylists ORDER BY name;");
            $stylists = array();
            foreach($returned_stylists as $stylist) {
                $name = $stylist['name'];
                $id = $stylist['id'];
                $new_stylist = new Stylist($name, $id);
                array_push($stylists, $new_stylist);
            }
            return $stylists;
        }

        //Delete all function, **UPDATE WITH CLIENTS**
        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM stylists;");
            $GLOBALS['DB']->exec("DELETE FROM clients;");
        }

        //Find function
        static function find($search_id)
        {
            $found_stylist = null;
            $stylists = Stylist::getAll();
            foreach($stylists as $stylist) {
                $stylist_id = $stylist->getId();
                if ($stylist_id == $search_id) {
                    $found_stylist = $stylist;
                }
            }
            return $found_stylist;
        }

        //Update function
        function update_stylist($new_name)
        {
            $GLOBALS['DB']->exec("UPDATE stylists SET name = '{new_name}' WHERE id = {$this->getId()};");
            $this->setName($new_name);
        }

        //Delete a Stylist...dun dun DUNNNNN.
        function delete_stylist()
        {
            $GLOBALS['DB']->exec("DELETE FROM stylists WHERE id = {$this->getId()};");
            $GLOBALS['DB']->exec("DELETE FROM clients WHERE stylist_id = {$this->getId()};");
        }

        function getClients()
        {
            $clients = array();
            $returned_clients = $GLOBALS['DB']->query("SELECT * FROM clients WHERE stylist_id = {$this->getId()} ORDER BY c_name;");
            foreach($returned_clients as $client) {
                $c_name = $client['c_name'];
                $phone = $client['phone'];
                $id = $client['id'];
                $stylist_id = $client['stylist_id'];
                $new_client = new Client($c_name, $phone, $id, $stylist_id);
                array_push($clients, $new_client);
            }
            return $clients;
        }
    }

?>
