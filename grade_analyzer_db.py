logo_text = r"""
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
"""

student_list = [
	{"name": "John Aboyi", "score": 61.2},
	{"name": "Tobi Aje", "score": 99.5},
	{"name": "Sasha Elize", "score": 20.5},
	{"name": "Kehinde Awe", "score": 61.2},
	{"name": "Ogbogu Johua", "score": 74.3},
	{"name": "Wisdom Onyeso", "score": 10.1}
]
left_spacing = 16

def spacing(offset):
	return ''.join([' ' for x in range(left_spacing - offset)])

def get_average_score():
	score_sum = 0.0
	for student in student_list:
		score_sum += student["score"]
	return score_sum / len(student_list)

def show_student_with_highest_sore():
	highest_students = []
	for student in student_list:
		if student["score"] == 100:
			highest_students.append(f"{student['name']}{spacing(len(student['name']))}{student['score']}")
	if len(highest_students) == 0:
		print("\nNo student scored the highest score!!")
	elif len(highest_students) == len(student_list):
		print("\nAll students got the highest score!!")
	else:
		print(f"\nName{spacing(4)}Score")
		print(f"{'\n'.join(highest_students)}")

def show_student_who_passed():
	passed_students = []
	for student in student_list:
		if student["score"] >= 50:
			passed_students.append(f"{student['name']}{spacing(len(student['name']))}{student['score']}")
	if len(passed_students) == 0:
		print("\nUnfortunately no student passed!!")
	elif len(passed_students) == len(student_list):
		print("\nAll students passed!!")
	else:
		print(f"\nName{spacing(4)}Score")
		print(f"{'\n'.join(passed_students)}")

def show_student_who_failed():
	failed_students = []
	for student in student_list:
		if student["score"] < 50:
			failed_students.append(f"{student['name']}{spacing(len(student['name']))}{student['score']}")
	if len(failed_students) == 0:
		print("\nNo student failed!!")
	elif len(failed_students) == len(student_list):
		print("\nAll students failed!!")
	else:
		print(f"\nName{spacing(4)}Score")
		print(f"{'\n'.join(failed_students)}")

def show_sorted_result():
	def ret_score(student):
		return student["score"]
	sorted_student_list = student_list.copy()
	sorted_student_list.sort(key=ret_score)
	sorted_student_list.reverse()
	print(f"\nName{spacing(4)}Score")
	for student in sorted_student_list:
		print(f"{student['name']}{spacing(len(student['name']))}{student['score']}")

def save_in_file():
	print("\n1. Enter filename")
	print("2. Save as results.txt")
	filename = ""

	choice = int(input("\nEnter a choice: "))
	if choice == 1:
		filename = str(input("\nEnter filename: "))
		if len(filename) == 0 or filename.isspace():
			filename = "results.txt"
			print("Invalid filename saving as results.txt")
	elif choice == 2:
		filename = "results.txt"

	with open(filename, "w") as result_file:
		result_file.write(f"Name{spacing(4)}Score\n")
		for student in student_list:
			result_file.write(f"{student['name']}{spacing(len(student['name']))}{student['score']}\n")

	print(f"Saved results in {filename}")

def management_menu():
	while True:
		print("\n1. Show the average score")
		print("2. Show the name(s) of the student(s) with the highest score")
		print("3. Show the number of students who passed (score >= 50)")
		print("4. Show the number of students who failed")
		print("5. Show sorted result list")
		print("6. Save result in a text file")
		print("0. Exit")
		choice = int(input("\nEnter a choice: "))
		if choice == 1:
			print(f"\nThe Average Score Is: {get_average_score()}")
		elif choice == 2:
			show_student_with_highest_sore()
		elif choice == 3:
			show_student_who_passed()
		elif choice == 4:
			show_student_who_failed()
		elif choice == 5:
			show_sorted_result()
		elif choice == 6:
			save_in_file()
		elif choice == 0:
			print("\nExiting...")
			return
		else:
			print("Invalid option Try again\n")

def enter_students():
	total_students = int(input("\nHow many students do you want to enter: "))
	if total_students == 0:
		print("Invalid entry, Cannot enter 0 amout of students")
		enter_students()
		return
	for student in range(total_students):
		while True:
			student_name = str(input("\nEnter student name: "))
			if len(student_name) == 0 or student_name.isspace():
				print("Invalid student name")
				continue
			score = float(input("Enter student score: "))
			if score > 100:
				print("Invalid score")
				continue
			student_list.append({"name": student_name, "score": score})
			break

	print("\nDone!!!")
	management_menu()

def main():
	print(logo_text)
	print("\nWelcome!!!\n")

	while True:
		print("1. Enter Students")
		print("0. Exit")
	
		choice = int(input("\nEnter a choice: "))
		if choice == 1:
			enter_students()
			return
		elif choice == 0:
			print("\nExiting...")
			return
		else:
			print("Invalid option Try again\n")

if __name__ == "__main__":
	main()