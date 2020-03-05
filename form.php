<!DOCTYPE html>
<html lang="bg">
    <head>
        <meta content="text/html; charset=UTF-8" http-equiv="Content-Type" />
        <title>Form</title>
    </head>
    <body>
        <form action="/form.php" method="post">
          <label for="sName">Име на предмет:</label>
          <br>
          <input type="text" id="sName" name="subjectName" require>
          <br>
          <label for="lname">Преподавател:</label>
          <br>
          <input type="text" id="lName" name="lecturerName" require>
          <br>
          <label for="descr">Описание:</label>
          <br>
          <input type="text" id="descr" name="description" require>
          <br>
          <label for="groups">Група:</label>
          <br>
          <select id="groups" name="groups">
            <option value="М">М</option>
            <option value="ПМ">ПМ</option>
            <option value="ОКН">ОКН</option>
            <option value="ЯКН">ЯКН</option>
          </select>
          <br>
          <label for="credits">Кредити:</label>
          <br>
          <input type="number" id="credits" name="credits" min="1" max="20">
          <br>
          <input type="submit" value="Submit">
        </form>
        <?php
            $valid = array();
            $errors = array();

            if ($_POST) {
                $subjectName = $_POST['subjectName'];
                if (!$subjectName) {
                  $errors['subjectName'] = 'Името на предмета е задължително поле.';
                } elseif (strlen($subjectName) > 150) {
                  $errors['subjectName'] = 'Името на предмета трябва да е по-малко от 150 символа.';
                } else {
                  $valid['subjectName'] = $subjectName;
                }

                $lecturerName = $_POST['lecturerName'];
                if (!$lecturerName) {
                  $errors['lecturerName'] = 'Името на лектора е задължително поле.';
                } elseif (strlen($lecturerName) > 200) {
                  $errors['lecturerName'] = 'Името на лектора трябва да е по-малко от 200 символа.';
                } else {
                  $valid['lecturerName'] = $lecturerName;
                }

                $description = $_POST['description'];
                if (!$description) {
                  $errors['description'] = 'Описанието на предмета е задължително поле.';
                } elseif (strlen($description) < 10) {
                  $errors['description'] = 'Описанието на предмета трябва да е по-голямо от 10 символа.';
                } else {
                  $valid['description'] = $description;
                }

                $groups = $_POST['groups'];
                if (!$groups) {
                  $errors['groups'] = 'Трябва да изберете поне една група.';
                } else {
                  $valid['groups'] = $groups;
                }

                $credits = $_POST['credits'];
                if (!$credits) {
                  $errors['credits'] = 'Кредит е задължително поле.';
                } elseif (strlen($credits) < 0) {
                  $errors['credits'] = 'Кредита трябва да е положително число.';
                } elseif (strlen($credits) > 20) {
                  $errors['credits'] = 'Кредита може да бъде най-много 20.';
                } else {
                  $valid['credits'] = $credits;
                }
                
                if (count($valid) == 5) {
                  $filename = 'data.txt';
                  file_put_contents($filename, "Име на предмет: ", FILE_APPEND | LOCK_EX);
                  file_put_contents($filename, $subjectName, FILE_APPEND | LOCK_EX);
                  file_put_contents($filename, "\n", FILE_APPEND | LOCK_EX);
                  file_put_contents($filename, "Име на преподавател: ", FILE_APPEND | LOCK_EX);
                  file_put_contents($filename, $lecturerName, FILE_APPEND | LOCK_EX);
                  file_put_contents($filename, "\n", FILE_APPEND | LOCK_EX);
                  file_put_contents($filename, "Описание на предмет: ", FILE_APPEND | LOCK_EX);
                  file_put_contents($filename, $description, FILE_APPEND | LOCK_EX);
                  file_put_contents($filename, "\n", FILE_APPEND | LOCK_EX);
                  file_put_contents($filename, "Група: ", FILE_APPEND | LOCK_EX);
                  file_put_contents($filename, $groups, FILE_APPEND | LOCK_EX);
                  file_put_contents($filename, "\n", FILE_APPEND | LOCK_EX);
                  file_put_contents($filename, "Кредити: ", FILE_APPEND | LOCK_EX);
                  file_put_contents($filename, $credits,FILE_APPEND | LOCK_EX);
                  file_put_contents($filename, "\n", FILE_APPEND | LOCK_EX);
                  file_put_contents($filename, "=====================================================", FILE_APPEND | LOCK_EX);
                  file_put_contents($filename, "\n", FILE_APPEND | LOCK_EX);
                }
            }
        ?>
    </body>
</html>