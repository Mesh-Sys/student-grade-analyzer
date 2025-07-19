# Student Grade Analyzer

This repo consist of three main parts

`grade_analyzer.py` A student grade analyzer written in python.

`grade_analyzer.php` A student grade analyzer written in php.

`grade_analyzer_db.php` A student grade analyzer website written in php with database storage.

## Clone the repo
```command
git clone https://github.com/Mesh-Sys/student-grade-analyzer.git
```

## grade_analyzer.py

To run this file if you have python installed open your terminal (or command prompt on windows) 

in your cloned directory and execute 
```command
python grade_analyzer.py
```

## grade_analyzer.php

To run this file if you have php installed open your terminal (or command prompt on windows) 

in your cloned directory and execute 
```command
php grade_analyzer.php
```

## grade_analyzer_db.php

To run this file if you would need a http webserver (e.g nginx, apache) with php installed and configure,

you would also need a sql database server (in this case postgresql)
### To create the database table
```command
psql -f database.sql
```

Then copy the `grade_analyzer_db.php` to your webserver root, 
open your web brower and navigate to 
```url
http://localhost/grade_analyzer_db.php
```
If your get any `not found` error in the page and you have copied the file to your webserver root

most likely your webserver is running on different port than standard http port (port 80)

then you will need to add your webserver port to the url
```url
http://localhost:<YOUR_WEB_SERVER_PORT>/grade_analyzer_db.php
```

### Note

This could also mean php is not installed or configured properly.

A quick internet search should help you get it installed properly

