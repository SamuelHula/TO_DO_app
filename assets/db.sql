CREATE DATABASE todo_app;

USE todo_app;

CREATE TABLE tasks (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    task_name VARCHAR(255) NOT NULL,
    task_description TEXT,
    is_completed TINYINT(1) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Insert some sample data
INSERT INTO tasks (task_name, task_description) VALUES 
('Learn PHP', 'Study PHP basics and advanced concepts'),
('Build Todo App', 'Create a functional todo list application'),
('Style with CSS', 'Make the application look beautiful');