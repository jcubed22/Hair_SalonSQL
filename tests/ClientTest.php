<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Client.php";
    require_once "src/Stylist.php";

    $server = 'mysql:host=localhost;dbname=hair_salon_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class ClientTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Client::deleteAll();
            Stylist::deleteAll();
        }

        function test_setName()
        {
            //Arrange
            $name = "Sasha";
            $id = null;
            $test_stylist = new Stylist($name, $id);
            $test_stylist->save();

            $c_name = "Garry Gergich";
            $phone = "503-472-8959";
            $stylist_id = $test_stylist->getId();
            $test_client = new Client($c_name, $phone, $id, $stylist_id);
            $new_c_name = "Jerry Gergich";

            //Act
            $test_client->setName($new_c_name);

            //Assert
            $this->assertEquals($test_client->getName(), $new_c_name);
        }

        function test_getName()
        {
            //Arrange
            $name = "Sasha";
            $id = null;
            $test_stylist = new Stylist($name, $id);
            $test_stylist->save();

            $c_name = "Garry Gergich";
            $phone = "503-472-8959";
            $stylist_id = $test_stylist->getId();
            $test_client = new Client($c_name, $phone, $id, $stylist_id);

            //Act
            $result = $test_client->getName();

            //Assert
            $this->assertEquals($c_name, $result);
        }

        function test_getId()
        {
            //Arrange
            $name = "Sasha";
            $id = 1;
            $test_stylist = new Stylist($name, $id);
            $test_stylist->save();

            $c_name = "Garry Gergich";
            $phone = "503-472-8959";
            $stylist_id = $test_stylist->getId();
            $test_client = new Client($c_name, $phone, $id, $stylist_id);

            //Act
            $result = $test_client->getId();

            //Assert
            $this->assertEquals(true, is_numeric($result));
        }

        function test_getPhone()
        {
            //Arrange
            $name = "Sasha";
            $id = null;
            $test_stylist = new Stylist($name, $id);
            $test_stylist->save();

            $c_name = "Garry Gergich";
            $phone = "503-472-8959";
            $stylist_id = $test_stylist->getId();
            $test_client = new Client($c_name, $phone, $id, $stylist_id);

            //Act
            $result = $test_client->getPhone();

            //Assert
            $this->assertEquals($phone, $result);
        }

        function test_setPhone()
        {
            //Arrange
            $name = "Sasha";
            $id = null;
            $test_stylist = new Stylist($name, $id);
            $test_stylist->save();

            $c_name = "Garry Gergich";
            $phone = "503-472-8959";
            $stylist_id = $test_stylist->getId();
            $test_client = new Client($c_name, $phone, $id, $stylist_id);
            $new_phone = "503-434-5549";

            //Act
            $test_client->setPhone($new_phone);

            //Assert
            $this->assertEquals($test_client->getPhone(), $new_phone);
        }

        function test_save()
        {
            //Arrange
            $name = "Sasha";
            $id = null;
            $test_stylist = new Stylist($name, $id);
            $test_stylist->save();

            $c_name = "Garry Gergich";
            $phone = "503-472-8959";
            $stylist_id = $test_stylist->getId();
            $test_client = new Client($c_name, $phone, $id, $stylist_id);
            $test_client->save();

            $c_name2 = "Jerry Gergich";
            $phone2 = "503-560-5060";
            $stylist_id2 = $test_stylist->getId();
            $test_client2 = new Client($c_name2, $phone2, $id, $stylist_id2);
            $test_client2->save();

            //Act
            $result = Client::getAll();

            //Assert
            $this->assertEquals([$test_client, $test_client2], $result);
        }




    }







?>
