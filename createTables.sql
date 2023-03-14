/* Intial tables */

DROP TABLE IF EXISTS taskCategory;
CREATE TABLE taskCategory (
category_id INT AUTO_INCREMENT,
category_name VARCHAR(50) NOT NULL,
PRIMARY KEY(category_id)
);


DROP TABLE IF EXISTS task;
CREATE TABLE task (
task_id INT AUTO_INCREMENT,
task_desp VARCHAR(500) NOt NULL,
due_date DATE NOT NULL,
task_category INT,
priority_level tinyint CHECK(priority_level > 0 AND priority_level < 5),
task_status ENUM("active", "completed") NOT NULL,
PRIMARY KEY(task_id),
FOREIGN KEY(task_category) REFERENCES taskCategory(category_id)
);
