<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Stylist.php";
    require_once "src/Client.php";

    $server = 'mysql:host=localhost;dbname=hair_salon_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class StylistTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Stylist::deleteAll();
            Client::getAll();
        }

        function test_setName()
        {
            //Arrange
            $name = "Brenda";
            $test_stylist = new Stylist($name);
            $new_name = "Moonbeam Starchild";

            //Act
            $test_stylist->setName($new_name);

            //Assert
            $this->assertEquals($test_stylist->getName(), $new_name);
        }

        function test_getName()
        {
            //Arrange
            $name = "Brenda";
            $test_stylist = new Stylist($name);

            //Act
            $result = $test_stylist->getName();

            //Assert
            $this->assertEquals($name, $result);
        }

        function test_getId()
        {
            //Arrange
            $name = "Brenda";
            $id = null;
            $test_stylist = new Stylist($name, $id);
            $test_stylist->save();

            //Act
            $result = $test_stylist->getId();

            //Assert
            $this->assertEquals(true, is_numeric($result));
        }

        function test_save()
        {
            $name = "Brenda";
            $test_stylist = new Stylist($name);
            $test_stylist->save();

            //Act
            $result = Stylist::getAll();

            //Assert
            $this->assertEquals($test_stylist, $result[0]);
        }

        function test_getAll()
        {
            //Arrange
            $name = "Brenda";
            $test_stylist = new Stylist($name);
            $test_stylist->save();
            $name2 = "Eduardo";
            $test_stylist2 = new Stylist($name);
            $test_stylist2->save();

            //Act
            $result = Stylist::getAll();

            //Assert
            $this->assertEquals([$test_stylist, $test_stylist2], $result);
        }

        function test_deleteAll()
        {
            //Arrange
            $name = "Brenda";
            $test_stylist = new Stylist($name);
            $test_stylist->save();
            $name2 = "Eduardo";
            $test_stylist2 = new Stylist($name);
            $test_stylist2->save();

            //Act
            Stylist::deleteAll();
            $result = Stylist::getAll();

            //Assert
            $this->assertEquals([], $result);
        }

        function test_find()
        {
            //Arrange
            $name = "Brenda";
            $test_stylist = new Stylist($name);
            $test_stylist->save();
            $name2 = "Eduardo";
            $test_stylist2 = new Stylist($name);
            $test_stylist2->save();

            //Act
            $result = Stylist::find($test_stylist->getId());

            //Assert
            $this->assertEquals($test_stylist, $result);
        }

        function test_update()
        {
            //Arrange
            $name = "Stephen";
            $id = null;
            $test_stylist = new Stylist($name, $id);
            $new_name = "Stephanie";

            //Act
            $test_stylist->update_stylist($new_name);

            //Assert
            $this->assertEquals($new_name, $test_stylist->getName());
        }

        function test_delete()
        {
            //Arrange
            $name = "Brenda";
            $test_stylist = new Stylist($name);
            $test_stylist->save();
            $name2 = "Eduardo";
            $test_stylist2 = new Stylist($name);
            $test_stylist2->save();

            //Act
            $test_stylist->delete_stylist();

            //Assert
            $this->assertEquals([$test_stylist2], Stylist::getAll());
        }

        function test_getClients()
        {
            //Arrange
            $name = "Sasha";
            $id = null;
            $test_stylist = new Stylist($name, $id);
            $test_stylist->save();

            $name2 = "Sandra";
            $test_stylist2 = new Stylist($name2, $id);
            $test_stylist2->save();

            $c_name = "Garry Gergich";
            $phone = "503-472-8959";
            $stylist_id = $test_stylist->getId();
            $test_client = new Client($c_name, $phone, $id, $stylist_id);
            $test_client->save();

            $c_name2 = "Jerry Gergich";
            $phone2 = "503-864-4444";
            $stylist_id2 = $test_stylist2->getId();
            $test_client2 = new Client($c_name2, $phone2, $id, $stylist_id2);
            $test_client2->save();

            $c_name3 = "Brock Samson";
            $phone3 = "555-555-5555";
            $stylist_id3 = $test_stylist->getId();
            $test_client3 = new Client($c_name3, $phone3, $id, $stylist_id3);
            $test_client3->save();

            //Act
            $result = $test_stylist->getClients();

            //Assert
            $this->assertEquals([$test_client3, $test_client], $result);

        }
    }

?>
