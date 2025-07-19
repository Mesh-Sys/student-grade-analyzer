# Student Grade Analyzer

This repo consist of three main parts

`grade_analyzer.py` A student grade analyzer written in python.

`grade_analyzer.php` A student grade analyzer written in php.

`grade_analyzer_db.php` A student grade analyzer website written in php with database storage.

It allows you to enter students grade records so you can easy analyse the data efficiently

Features Include
  - Add new students
  - Get Average score of all the students
  - Get students who scored the highest
  - Get students who failed
  - Get students who passed
  - Show students from highest scoring to lowest
  - Save result list as a text file
  - Desktop and Web site available
  - Database storage for results (web version)

## Installation

## Clone the repo
```command
git clone https://github.com/Mesh-Sys/student-grade-analyzer.git
```

## grade_analyzer.py

To run this file you must have python installed on your device

To install python 
[Install on Windows](https://www.geeksforgeeks.org/python/how-to-install-python-on-windows/) 
[Install on Linux](https://www.geeksforgeeks.org/python/how-to-install-python-on-linux/)
[Install on Mac](https://www.geeksforgeeks.org/python/how-to-install-python-on-mac/)

If you have already installed python or have python installed

open your terminal (or command prompt on windows) 

in your cloned directory and execute 
```command
python grade_analyzer.py
```

## grade_analyzer.php

To run this file you must have php installed on your device

To install php
[Install on Windows](https://www.geeksforgeeks.org/php/how-to-install-php-in-windows-10/)
[Install on Linux](https://www.geeksforgeeks.org/php/how-to-install-php-on-linux/)
[Install on Mac](https://www.geeksforgeeks.org/installation-guide/how-to-install-php-on-macos/)

If you have already installed php or have php installed

open your terminal (or command prompt on windows) 

in your cloned directory and execute 
```command
php grade_analyzer.php
```

## grade_analyzer_db.php

To run this file if you would need a http webserver (e.g nginx, apache) with php installed and configure,

For Easy Setup i Recommend getting a webserver stack package (e.g xampp, ampp)
[xampp install](https://www.apachefriends.org/download.html)

you would also need a sql database server (in my case postgresql, 
mysql or mariadb would also work with a little modification to the data types)
### To create the database table for postgresql
```command
psql -f database.sql
```

Then copy the `grade_analyzer_db.php` to your webserver root, 
open your web brower and navigate to 
```url
http://localhost/grade_analyzer_db.php
```
If your get any `not found` error in the page and you have copied the file to your webserver root

most likely your webserver is running on different port than standard `http` port (port 80)

then you will need to add your webserver port to the url
```url
http://localhost:<YOUR_WEB_SERVER_PORT>/grade_analyzer_db.php
```

or if using `https` on port 443
```url
https://localhost/grade_analyzer_db.php
```

### Note

This could also mean php is not installed or configured properly.

A quick internet search should help you get it installed properly