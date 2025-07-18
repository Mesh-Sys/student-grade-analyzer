<?php
  session_start();

  $_SESSION['extra'] = null;
  $_SESSION['student_list'] = null;
  if(!isset($_SESSION['page'])){
    $_SESSION['page'] = "amount_of_entries";
  }

  function fetch_results($sql = "SELECT student_name, score FROM students WHERE session_id = ?"){
    try{
      $db_conn = new PDO(
        "pgsql:host=".$_SERVER["DB_SERVER_NAME"].";dbname=".$_SERVER["DB_NAME"], 
        $_SERVER["DB_USERNAME"], $_SERVER["DB_PASSWORD"]
      );
      $stat = $db_conn->prepare($sql);
      $stat->execute([session_id()]);
      return $stat->fetchAll();
    }catch(Exception $e){
      error_log("grade_analyzer_db - fetch_results - Error: ".$e->getMessage());
    }
  }

  function fetch_sorted_results(){
    return fetch_results("SELECT student_name, score FROM students WHERE session_id = ? ORDER BY score DESC"); 
  }

  function fetch_students_with_highest_score(){
    return fetch_results("SELECT student_name, score FROM students WHERE session_id = ? AND score = 100"); 
  }

  function fetch_students_who_passed(){
    return fetch_results("SELECT student_name, score FROM students WHERE session_id = ? AND score >= 50"); 
  }

  function fetch_students_who_failed(){
    return fetch_results("SELECT student_name, score FROM students WHERE session_id = ? AND score < 50"); 
  }

  function add_student($student_name, $score){
    try{
      $db_conn = new PDO(
        "pgsql:host=".$_SERVER["DB_SERVER_NAME"].";dbname=".$_SERVER["DB_NAME"], 
        $_SERVER["DB_USERNAME"], $_SERVER["DB_PASSWORD"]
      );
      $db_conn->prepare("INSERT INTO students (student_name, score, session_id) VALUES (?, ?, ?)")->execute([$student_name, $score, session_id()]);
    }catch(Exception $e){
      error_log("grade_analyzer_db - add_student - Error: ".$e->getMessage());
    }
  }

  function get_average_score(){
    $student_list = fetch_results();
    if(count($student_list) == 0){
      return 0;
    }
    $score_sum = 0.0;
    foreach($student_list as $student){
      $score_sum += $student["score"];
    }
    return ($score_sum / count($student_list));
  }

  function save_in_file(){
    $student_list = fetch_results();
    $result_file = fopen("results.txt", "w");
    fwrite($result_file, "Name".spacing(4)."Score\n");
    foreach($student_list as $student){
      fwrite(
        $result_file, 
        $student['name'].
        join("", array_fill(0, $left_spacing - strlen($student['name']), " ")).
        $student['score']."\n"
      );
    }
    fclose($result_file);
  }

  if(isset($_POST['number_of_entries'])){
    $_SESSION['added'] = 0;
    $_SESSION['to_add'] = $_POST['number_of_entries'];
    $_SESSION['page'] = "add_new_students";
  }

  if(isset($_POST['student_name']) && isset($_POST['student_score'])){
    if(empty($_POST['student_name'])){
      echo "Invalid Student Name, Reload And Try Again";
      exit;
    }
    if(empty($_POST['student_score'])){
      echo "Invalid Score, Reload And Try Again";
      exit;
    }
    if(isset($_SESSION['added']) && isset($_SESSION['to_add'])){
      add_student($_POST['student_name'], (float)$_POST['student_score']);
      $_SESSION['added']++;
      if($_SESSION['added'] == $_SESSION['to_add']){
        $_SESSION['added'] = 0;
        $_SESSION['to_add'] = 0;
        $_SESSION['page'] = "management_menu";
      }
    }
  }

  if(isset($_GET['action'])){
    switch($_GET['action']){
      case "show_average_score":
        $_SESSION["extra"] = "The Average Score Is: " . get_average_score();
        break;
      case "show_students_with_highest_score":
        $_SESSION["student_list"] = fetch_students_with_highest_score();
        break;
      case "show_students_who_passed":
        $_SESSION["student_list"] = fetch_students_who_passed();
        break;
      case "show_students_who_failed":
        $_SESSION["student_list"] = fetch_students_who_failed();
        break;
      case "show_sorted_list":
        $_SESSION["student_list"] = fetch_sorted_results();
        break;
      case "save_result_to_text_file":
        //handle with javascript
        //header("Location: ".$_SERVER['REQUEST_SCHEME']."://".$_SERVER['HTTP_HOST']."/results.txt");
        exit;
      case "add_new_entry":
        $_SESSION['page'] = "amount_of_entries";
        header("Location: ".$_SERVER['PHP_SELF']);
        break;
    }
  }
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Student Grade Analyzer</title>
    <style>
      table, th, td{border: 0.5px solid black;}
    </style>
  </head>
  <body>
    <h1>Student Grade Analyzer</h1>
    <?php if($_SESSION['page'] == "amount_of_entries"):?>
      <form method="POST" action="">
        How many students do you want to add: 
        <input type="number" name="number_of_entries" placeholder="1" style="width: 60px;">
        <button type="submit">Add Entries</button>
      </form>
    <?php elseif($_SESSION['page'] == "add_new_students"):?>
      <?php echo $_SESSION['added']."/".$_SESSION['to_add']?> Entries to add
      <form method="POST" action="">
        Enter student name: <input type="text" placeholder="James Brown" name="student_name"><br>
        <div style="margin-top: 5px;"></div>
        Enter student score: <input type="number" placeholder="70.5" name="student_score" step="any">
        <button type="submit">Add Student</button>
      </form>
    <?php else:?>
      <a href="?action=show_average_score" style="margin-left: 10px; font-size: 16px;">Show Average Score</a><br>
      <a href="?action=show_students_with_highest_score" style="margin-left: 10px; font-size: 16px;">Show Names Of Students With The Highest Score</a><br>
      <a href="?action=show_students_who_passed" style="margin-left: 10px; font-size: 16px;">Show the Number of Students Who Passed (Score >= 50)</a><br>
      <a href="?action=show_students_who_failed" style="margin-left: 10px; font-size: 16px;">Show the Number of Students Who Failed</a><br>
      <a href="?action=show_sorted_list" style="margin-left: 10px; font-size: 16px;">Show Sorted Result List</a><br>
      <a href="?action=save_result_to_text_file" style="margin-left: 10px; font-size: 16px;">Save Result to Text File</a><br>
      <a href="?action=add_new_entry" style="margin-left: 10px; font-size: 16px;">Add New Students</a><br>
      <?php if(!is_null($_SESSION["extra"])):?>
        <div><?php echo $_SESSION['extra'];?></div>
      <?php endif;?>
    <?php endif;?>

    <div style="margin-top: 30%;"></div>

    <?php $students = !is_null($_SESSION['student_list']) ? $_SESSION['student_list'] : fetch_results();?>
    <?php if(count($students) != 0):?>
      <table style="width: 40%; ">
        <tr>
          <th>Student Name</th>
          <th>Score</th>
        </tr>
        <?php foreach($students as $student):?>
          <tr>
            <td><?php echo $student["student_name"]?></td>
            <td><?php echo $student["score"]?></td>
          </tr>
        <?php endforeach;?>
      </table>
    <?php else:?>
      No Students Found
    <?php endif;?>
  <body>
</html>