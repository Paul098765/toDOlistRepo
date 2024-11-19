<?php
require 'db.php';

// Check if the ID is passed
if (isset($_GET['id'])) {
    $task_id = $_GET['id'];

    // Fetch the task details based on the task ID
    $stmt = $db->prepare("SELECT * FROM tasks WHERE id = :id");
    $stmt->execute(['id' => $task_id]);
    $task = $stmt->fetch();

    // If task doesn't exist, redirect to index page
    if (!$task) {
        header("Location: index.php");
        exit;
    }

    // Handle form submission for updating the task
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $updated_task = $_POST['task'];

        // Update the task in the database
        $stmt = $db->prepare("UPDATE tasks SET task = :task WHERE id = :id");
        $stmt->execute(['task' => $updated_task, 'id' => $task_id]);

        // Redirect to the index page after updating
        header("Location: index.php");
        exit;
    }
} else {
    // If ID is not passed, redirect to index
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Task</title>
</head>
<body>
    <h1>Edit Task</h1>
    <link rel="stylesheet" href="style.css">
    <form action="edit_task.php?id=<?= $task['id'] ?>" method="POST">
        <input type="text" name="task" value="<?= htmlspecialchars($task['task']) ?>" required>
        <button type="submit">Update Task</button>
    </form>
    <a href="index.php">Back to To-Do List</a>
</body>
</html>

*add this code in your style.css*
/* Reset some default styling */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

/* Body Styling */
body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    color: #333;
    line-height: 1.6;
}

/* Header Styling */
h1 {
    text-align: center;
    padding: 20px;
    background-color: #4CAF50;
    color: white;
}

/* Form Styling */
form {
    display: flex;
    justify-content: center;
    margin-top: 20px;
}

form input[type="text"] {
    padding: 10px;
    width: 60%;
    border: 1px solid #ddd;
    border-radius: 5px;
    font-size: 16px;
}

form button {
    padding: 10px 15px;
    margin-left: 10px;
    background-color: #4CAF50;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

form button:hover {
    background-color: #45a049;
}

/* Task List Styling */
ul {
    list-style-type: none;
    padding: 0;
    margin-top: 20px;
}

li {
    background-color: #fff;
    padding: 15px;
    margin-bottom: 10px;
    border-radius: 5px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

/* Link Styling */
a {
    color: #4CAF50;
    text-decoration: none;
    margin-left: 10px;
}

a:hover {
    text-decoration: underline;
}

/* Responsive Styling */
@media screen and (max-width: 600px) {
    form input[type="text"] {
        width: 70%;
    }

    form button {
        width: 30%;
        margin-left: 5px;
    }
}