<?php

function addElactive($subjectName, $lecturerName, $description)
{
  $insertStatment = "INSERT INTO electives (title, description, lecturer) 
              VALUES 
                (:title, :description, :teacher)";

  $connection = getConnectionWithDatabase();
  $statement = $connection->prepare($insertStatment);
  $statement->bindParam(':title', $subjectName);
  $statement->bindParam(':description', $description);
  $statement->bindParam(':teacher', $lecturerName);
  $statement->execute() or die("Failed to execute query to database!");
}

function updateElective($subjectName, $lecturerName, $description, $electiveId)
{
  $updateStatement = "UPDATE electives 
              SET 
                title = :titlePlaceholder, description = :descriptionPlaceholder, lecturer = :lecturerPlaceholder
              WHERE id=:electiveId;";

  $connection = getConnectionWithDatabase();
  $statement = $connection->prepare($updateStatement);
  $statement->bindParam(':titlePlaceholder', $subjectName);
  $statement->bindParam(':descriptionPlaceholder', $description);
  $statement->bindParam(':lecturerPlaceholder', $lecturerName);
  $statement->bindParam(':electiveId', $electiveId);
  $statement->execute() or die("Failed to execute query to database!");
}

function getEletiveById($electiveId)
{
  $selectStatment = "SELECT * FROM electives
              WHERE id=:electiveId";

  $connection = getConnectionWithDatabase();
  $statement = $connection->prepare($selectStatment);
  $statement->bindParam(':electiveId', $electiveId);
  $statement->execute() or die("Failed to execute query to database!");
  $elective = $statement->fetch(PDO::FETCH_ASSOC) or die("The elective is not found!");

  return $elective;
}
function getConnectionWithDatabase()
{
  $host = "localhost";
  $username = "root";
  $password = "";
  $dbname = "test";

  try{
    $connection = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    return $connection;
  }
  catch(PDOException $error) {
    die($error->getMessage());
  }
}
?>