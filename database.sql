-- create table to store students and scores
-- this follows postgresql syntax
CREATE TABLE IF NOT EXISTS students (
	student_id SERIAL PRIMARY KEY,
	student_name VARCHAR(255) NOT NULL,
	score FLOAT8 NOT NULL,
	created_at TIMESTAMPTZ DEFAULT NOW(),
	session_id VARCHAR(40) NOT NULL
);

