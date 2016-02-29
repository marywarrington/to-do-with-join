<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Task.php";
    require_once "src/Category.php";

    $server = 'mysql:host=localhost;dbname=to_do_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);


    class TaskTest extends PHPUnit_Framework_TestCase
      {

          protected function tearDown()
          {
              Task::deleteAll();
              Category::deleteAll();
          }

          function test_getId()
          {
              //Arrange
              $name = "Home stuff";
              $id = null;
              $test_category = new Category($name, $id);
              $test_category->save();

              $description = "Wash the dog";
              $due_date = "2016-02-24";
              $test_task = new Task($description, $due_date, $id);
              $test_task->save();

              //Act
              $result = $test_task->getId();

              //Assert
              $this->assertEquals(true, is_numeric($result));
          }

          function test_getDueDate()
          {
                $name = "Home stuff";
                $id = null;
                $test_category = new Category($name, $id);
                $test_category->save();

                $description = "Wash the dog";
                $due_date = "2016-02-24";
                $test_task = new Task($description, $due_date, $id);
                $test_task->save();

                //Act
                $result = $test_task->getDueDate();

                //Assert
                $this->assertEquals("2016-02-24", $result);
          }

          function test_save()
          {
              //Arrange
            //   $name = "Home stuff";
            //   $id = null;
            //   $test_category = new Category($name, $id);
            //   $test_category->save();

              $description = "Wash the dog";
              $due_date = "2016-02-24";
              $id = null;
              $test_task = new Task($description, $due_date, $id);

              //Act
              $test_task->save();

              //Assert
              $result = Task::getAll();
              $this->assertEquals($test_task, $result[0]);
          }

          function test_getAll()
          {
              //Arrange
            //   $name = "Home stuff";
            //   $test_category = new Category($name, $id);
            //   $test_category->save();

              $id = null;
              $description = "Wash the dog";
              $due_date = "2016-02-24";
              $test_task = new Task($description, $due_date, $id);
              $test_task->save();


              $description2 = "Water the lawn";
              $due_date2 = "2016-02-24";
              $test_task2 = new Task($description2, $due_date2, $id);
              $test_task2->save();

              //Act
              $result = Task::getAll();

              //Assert
              $this->assertEquals([$test_task, $test_task2], $result);
          }

          function test_deleteAll()
          {
              //Arrange
            //   $name = "Home stuff";
            //   $id = null;
            //   $test_category = new Category($name, $id);
            //   $test_category->save();

              $description = "Wash the dog";
              $due_date = "2016-02-24";
              $id = null;
              $test_task = new Task($description, $due_date, $id);
              $test_task->save();

              $description2 = "Water the lawn";
              $due_date2 = "2016-02-24";
              $test_task2 = new Task($description2, $due_date2, $id);
              $test_task2->save();

              //Act
              Task::deleteAll();

              //Assert
              $result = Task::getAll();
              $this->assertEquals([], $result);
          }

          function test_find()
          {
              //Arrange
            //   $name = "Home stuff";
            //   $test_category = new Category($name, $id);
            //   $test_category->save();

              $id = null;
              $description = "Wash the dog";
              $due_date = "2016-02-24";
              $test_task = new Task($description, $due_date, $id);
              $test_task->save();

              $description2 = "Water the lawn";
              $due_date2 = "2016-02-24";
              $test_task2 = new Task($description2, $id, $due_date2);
              $test_task2->save();

              //Act
              $result = Task::find($test_task->getId());

              //Assert
              $this->assertEquals($test_task, $result);
          }

          function test_update()
          {
              $id = null;
              $description = "Wash the dog";
              $due_date = "2016-02-29";
              $test_task = new Task($description, $due_date, $id);
              $test_task->save();

              $new_description = "Walk the dog";
              $new_due_date = "2016-03-29";

              $result = $test_task->update($new_description, $new_due_date);

              $this->assertEquals($new_description, $test_task->getDescription());
              $this->assertEquals($new_due_date, $test_task->getDueDate());
          }

          function test_deleteOneTask()

          {
              $id = null;
              $description = "Wash the dog";
              $due_date = "2016-02-29";
              $test_task = new Task($description, $due_date, $id);
              $test_task->save();

              $description2 = "Water the lawn";
              $due_date2 = "2016-02-24";
              $test_task2 = new Task($description2, $due_date2, $id);
              $test_task2->save();

              $test_task->deleteOneTask();
              $result = Task::getAll();

              $this->assertEquals([$test_task2], $result);
          }

          function test_addCategory()
          {
              $name = "Work stuff";
              $id = null;
              $test_category = new Category($name, $id);
              $test_category->save();

              $description = "File reports";
              $due_date = "2017-01-01";
              $test_task = new Task($description, $due_date, $id);
              $test_task->save();

              $test_task->addCategory($test_category);

              $this->assertEquals($test_task->getCategories(), [$test_category]);

          }

          function test_getCategories()
          {
              $name = "Work stuff";
              $id = null;
              $test_category = new Category($name, $id);
              $test_category->save();

              $name2 = "Home stuff";
              $test_category2 = new Category($name2, $id);
              $test_category2->save();

              $description = "File reports";
              $due_date = "2017-01-01";
              $test_task = new Task($description, $due_date, $id);
              $test_task->save();

              $test_task->addCategory($test_category);
              $test_task->addCategory($test_category2);

              $this->assertEquals($test_task->getCategories(), [$test_category, $test_category2]);
          }

          function test_deleteFromJoin()
          {
              $name = "Work stuff";
              $id = null;
              $test_category = new Category($name, $id);
              $test_category->save();

              $description = "File reports";
              $due_date = "1999-01-01";
              $test_task = new Task($description, $due_date, $id);
              $test_task->save();

              $test_task->addCategory($test_category);
              $test_task->deleteOneTask();

              $this->assertEquals([], $test_category->getTasks());
          }


      }
 ?>
