<?php

include "./db-manipulation.php";

define("MAX_SUBJECT_NAME_LENGTH", 128, true);
define("MAX_LECTURE_NAME_LENGTH", 128, true);
define("MAX_DESCRIPTION_LENGTH", 1024, true);
define("MIN_DESCRIPTION_LENGTH", 10, true);

$fileName = "request-executor.php";
$dirname = basename($_SERVER['REQUEST_URI']);
if ($_POST) {
  if ($fileName == $dirname) {
    executePostRequest(null);
  }
}

function executePostRequest($electiveId)
{
  $subjectName = $_POST['subjectName'];
  $lecturerName = $_POST['lecturerName'];
  $description = $_POST['description'];
  validateElectiveFields($subjectName, $lecturerName, $description);
  echo("-----------");
  if (is_null($electiveId)) {
    createNewElective($subjectName, $lecturerName, $description);
  } else {
    echo("dasdasd2222");
    updateExistingElective($subjectName, $lecturerName, $description, $electiveId);
  }
}

function createNewElective($subjectName, $lecturerName, $description)
{
  addElactive($subjectName, $lecturerName, $description);
  echo ("Elective is added sucesfully!");
}

function updateExistingElective($subjectName, $lecturerName, $description, $electiveId)
{
  checkIfElectiveExsists($electiveId);
  updateElective($subjectName, $lecturerName, $description, $electiveId);
  echo ("Elective is updated sucesfully!");
}

function getElective($electiveId)
{
  checkIfElectiveExsists($electiveId);

  return getEletiveById($electiveId);
}

function checkIfElectiveExsists($electiveId)
{
  $elective = getEletiveById($electiveId);
  $isElectiveExists = $elective["title"];
  if (!$isElectiveExists) {
    die("The elective with the given id: $electiveId is not existing.");
  }
}

function validateElectiveFields($subjectName, $lecturerName, $description)
{
  $errors = array();
  validateSubjectName($subjectName, $errors);
  validateLectureName($lecturerName, $errors);
  validateDescriptionOfSubject($description, $errors);

  if (count($errors) == 0) {
    die();
  }
}

function validateSubjectName($subjectName, $errors)
{
  if (!$subjectName) {
    $errors['subjectName'] = 'Името на предмета е задължително поле.';
  } elseif (strlen($subjectName) > MAX_SUBJECT_NAME_LENGTH) {
    $errors['subjectName'] = 'Името на предмета трябва да е по-малко от 128 символа.';
  }

  if (array_key_exists('subjectName', $errors)) {
    echo $errors['subjectName'];
  }
}

function validateLectureName($lecturerName, $errors)
{
  if (!$lecturerName) {
    $errors['lecturerName'] = 'Името на лектора е задължително поле.';
  } elseif (strlen($lecturerName) > MAX_LECTURE_NAME_LENGTH) {
    $errors['lecturerName'] = 'Името на лектора трябва да е по-малко от 128 символа.';
  }

  if (array_key_exists('lecturerName', $errors)) {
    echo $errors['lecturerName'];
  }
}

function validateDescriptionOfSubject($description, $errors)
{
  if (!$description) {
    $errors['description'] = 'Описанието на предмета е задължително поле.';
  } elseif (strlen($description) < MIN_DESCRIPTION_LENGTH) {
    $errors['description'] = 'Описанието на предмета трябва да е по-голямо от 10 символа.';
  } elseif (strlen($description) > MAX_DESCRIPTION_LENGTH) {
    $errors['description'] = 'Описанието на предмета трябва да е по-малко от 1024 символа.';
  }

  if (array_key_exists('description', $errors)) {
    echo $errors['description'];
  }
}
