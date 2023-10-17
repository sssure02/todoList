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
date_created DATE NOT NULL,
due_date DATE NOT NULL,
task_category INT,
priority_level tinyint CHECK(priority_level > 0 AND priority_level < 5),
task_status ENUM("active", "completed") NOT NULL,
PRIMARY KEY(task_id),
FOREIGN KEY(task_category) REFERENCES taskCategory(category_id)
);

/* Dummy Data */

INSERT INTO taskCategory(category_name) VALUES ("Worksheet");
INSERT INTO taskCategory(category_name) VALUES ("HW");
INSERT INTO taskCategory(category_name) VALUES ("Assignment");
INSERT INTO taskCategory(category_name) VALUES ("Quiz");

INSERT INTO task (task_desp, due_date, task_category, priority_level, task_status)
VALUES ('Complete Math Wk', '2023-03-30', 1, 3, 'active'),
       ('Finish English Assignment', '2023-03-20', 3, 2, 'active'),
       ('HW 3 for CSC 4710', '2023-03-25', 2, 1, 'completed'),
       ('Finish quiz on Canvas', '2023-04-10', 4, 4, 'active'),
       ('Finish econ wk', '2023-03-22', 1, 2, 'completed');
