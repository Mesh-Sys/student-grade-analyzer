<?php
$logo_text = "
 ___| |_ _   _  __| | ___ _ __ | |_    __ _ _ __ __ _  __| | ___ 
/ __| __| | | |/ _` |/ _ \ '_ \| __|  / _` | '__/ _` |/ _` |/ _ \
\__ \ |_| |_| | (_| |  __/ | | | |_  | (_| | | | (_| | (_| |  __/
|___/\__|\__,_|\__,_|\___|_| |_|\__|  \__, |_|  \__,_|\__,_|\___|
                                      |___/                      
                   _                    
  __ _ _ __   __ _| |_   _ _______ _ __ 
 / _` | '_ \ / _` | | | | |_  / _ \ '__|
| (_| | | | | (_| | | |_| |/ /  __/ |   
 \__,_|_| |_|\__,_|_|\__, /___\___|_|   
                     |___/ 
";

$student_list = [
	0 => [
		"name" => "John Aboyi",
		"score" => 61.2
	],
	1 => [
		"name" => "Tobi Aje",
		"score" => 99.5
	],
	2 => [
		"name" => "Sasha Elize",
		"score" => 20.5
	],
	3 => [
		"name" => "Kehinde Awe",
		"score" => 61.2
	],
	4 => [
		"name" => "Ogbogu Johua",
		"score" => 74.3
	],
	5 => [
		"name" => "Wisdom Onyeso",
		"score" => 10.1
	],
];
$left_spacing = 16;

function spacing($offset){
	global $left_spacing;
	return join("", array_fill(0, $left_spacing - $offset, " "));
}

function show_student_with_highest_sore(){
	global $student_list;
	$highest_students = [];
	foreach($student_list as $student){
		if($student["score"] == 100){
			array_push($highest_students, $student['name'].spacing(strlen($student['name'])).$student['score']."\n");
		}
	}
	if(count($highest_students) == 0){
		echo "\n\nNo student scored the highest score!!";
	}elseif(count($highest_students) == count($student_list)){
		echo "\n\nAll students got the highest score!!";
	}else{
		echo "\nName".spacing(4)."Score\n";
		echo join("", $highest_students);
	}
}

function show_student_who_passed(){
	global $student_list;
	$passed_students = [];
	foreach($student_list as $student){
		if($student["score"] >= 50){
			array_push($passed_students, $student['name'].spacing(strlen($student['name'])).$student['score']."\n");
		}
	}
	if(count($passed_students) == 0){
		echo "\n\nUnfortunately no student passed!!";
	}elseif(count($passed_students) == count($student_list)){
		echo "\n\nAll students passed!!";
	}else{
		echo "\nName".spacing(4)."Score\n";
		echo join("", $passed_students);
	}
}

function show_student_who_failed(){
	global $student_list;
	$failed_students = [];
	foreach($student_list as $student){
		if($student["score"] < 50){
			array_push($failed_students, $student['name'].spacing(strlen($student['name'])).$student['score']."\n");
		}
	}
	if(count($failed_students) == 0){
		echo "\n\nNo student failed!!";
	}elseif(count($failed_students) == count($student_list)){
		echo "\n\nAll students failed!!";
	}else{
		echo "\nName".spacing(4)."Score\n";
		echo join("", $failed_students);
	}
}

function show_sorted_result(){
	global $student_list;
	function ret_score($x, $y){
		if($x["score"] == $y["score"]){return 0;}
		return ($x["score"] < $y["score"]) ? 1 : -1;
	}
	$sorted_student_list = $student_list;
	usort($sorted_student_list, "ret_score");
	echo "\nName".spacing(4)."Score\n";
	foreach($sorted_student_list as $student){
		echo $student['name'].spacing(strlen($student['name'])).$student['score']."\n";
	}
}

function save_in_file(){
	global $student_list;
	echo "\n1. Enter filename";
	echo "\n2. Save as results.txt";
	$filename = "";

	$choice = (int)readline("\nEnter a choice: ");
	switch($choice){
		case 1:
			$filename = readline("\nEnter filename: ");
			if (strlen($filename) == 0){
				$filename = "results.txt";
				echo "\nInvalid filename saving as results.txt";
			}
			break;
		case 2:
			$filename = "results.txt";
			break;
	}

	$result_file = fopen($filename, "w");
	fwrite($result_file, "Name".spacing(4)."Score\n");
	foreach($student_list as $student){
		fwrite($result_file, $student['name'].spacing(strlen($student['name'])).$student['score']."\n");
	}
	fclose($result_file);
	echo "\nSaved results in ".$filename;
}

function get_average_score(){
	global $student_list;
	$score_sum = 0.0;
	foreach($student_list as $student){
		$score_sum += $student["score"];
	}
	return ($score_sum / count($student_list));
}

function management_menu(){
	while(true){
		echo "\n\n1. Show the average score";
		echo "\n2. Show the name(s) of the student(s) with the highest score";
		echo "\n3. Show the number of students who passed (score >= 50)";
		echo "\n4. Show the number of students who failed";
		echo "\n5. Show sorted result list";
		echo "\n6. Save result in a text file";
		echo "\n0. Exit";
		$choice = (int)readline("\n\nEnter a choice: ");
		switch($choice){
			case 1:
				echo "\nThe Average Score Is: " . get_average_score();
				break;
			case 2:
				show_student_with_highest_sore();
				break;
			case 3:
				show_student_who_passed();
				break;
			case 4:
				show_student_who_failed();
				break;
			case 5:
				show_sorted_result();
				break;
			case 6:
				save_in_file();
				break;
			case 0:
				echo "\nExiting...";
				return;
				break;
			default:
				echo "\nInvalid option Try again\n";
				break;
		}	
	}
}

function enter_students(){
	global $student_list;
	$total_students = (int)readline("\nHow many students do you want to enter: ");
	if($total_students == 0){
		echo "\n\nInvalid entry, Cannot enter 0 amout of students";
		enter_students();
		return;
	}
	for($i = 0;$i < $total_students;$i++){
		while(true){
			$student_name = readline("\nEnter student name: ");
			if(strlen($student_name) == 0){
				echo "\n\nInvalid student name";
				continue;
			}
			$score = (float)readline("Enter student score: ");
			if($score > 100){
				echo "\n\nInvalid score";
				continue;
			}
			array_push($student_list, ["name" => $student_name, "score" => $score]);
			break;
		}
	}

	echo "\nDone!!!";
	management_menu();
}

function main(){
	global $logo_text;
	echo $logo_text;
	echo "\nWelcome!!!\n";

	while(true){
		echo "\n1. Enter Students\n";
		echo "0. Exit\n";

		$choice = (int)readline("\nEnter a choice: ");
		switch($choice){
			case 1:
				enter_students();
				return;
			case 0:
				echo "\nExiting...";
				return;
			default:
				echo "\nInvalid option Try again\n";
				return;
		}

	}
}

	main();
?>