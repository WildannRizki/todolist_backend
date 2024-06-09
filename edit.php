<?php
include 'database.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];

if (isset($_GET['id'])) {
    $task_id = $_GET['id'];

    $query = "SELECT * FROM tasks WHERE taskid = '$task_id' AND user_id = '$user_id'";
    $result = mysqli_query($conn, $query);
    $task = mysqli_fetch_assoc($result);

    if (!$task) {
        header('Location: index.php');
        exit;
    }
}

if (isset($_POST['update'])) {
    $task = mysqli_real_escape_string($conn, $_POST['task']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $due_date = mysqli_real_escape_string($conn, $_POST['due_date']);
    $due_time = mysqli_real_escape_string($conn, $_POST['due_time']);

    $query = "UPDATE tasks SET tasklabel = '$task', description = '$description', due_date = '$due_date', due_time = '$due_time' WHERE taskid = '$task_id' AND user_id = '$user_id'";
    $run_query = mysqli_query($conn, $query);

    if ($run_query) {
        header('Location: index.php');
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Task</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style type="text/css">
        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700;800&family=Poppins:ital,wght@0,500;0,600;0,700;1,400&family=Roboto:wght@400;500;700&display=swap');
        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
        }
        body {
            font-family: "Roboto", sans-serif;
            background: #F4F4F9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: linear-gradient(to right, #8e2de2, #4a00e0);
        }
        .container {
            width: 500px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 15px 25px rgba(0, 0, 0, 0.1);
            padding: 30px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .header .title {
            font-size: 24px;
            font-weight: 700;
            color: #4a00e0;
        }
        .header .description {
            font-size: 14px;
            color: #999;
        }
        .card {
            margin-bottom: 15px;
            background: #f4f4f9;
            padding: 15px;
            border-radius: 5px;
        }
        .input-control {
            width: 100%;
            display: block;
            padding: 0.5rem;
            font-size: 1rem;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .text-right {
            text-align: right;
        }
        button {
            padding: 0.5rem 1rem;
            font-size: 1rem;
            cursor: pointer;
            background: #4a00e0;
            color: #fff;
            border: none;
            border-radius: 5px;
            transition: background 0.3s;
        }
        button:hover {
            background: #6a00e0;
        }
    </style>

</head>
<body>
<div class="container">

<div class="header">
    <div class="title">
        <a href="index.php"><i class='bx bx-chevron-left'></i></a>
        <span>Back</span>
    </div>
    <div class="description">
        <?= date("l, d M Y") ?>
    </div>
</div>

<div class="content">
    <div class="card">

            <form method="post" action="">
                <input type="text" name="task" class="input-control" value="<?= htmlspecialchars($task['tasklabel']) ?>" required>
                <textarea name="description" class="input-control" required><?= htmlspecialchars($task['description']) ?></textarea>
                <input type="date" name="due_date" class="input-control" value="<?= $task['due_date'] ?>" required>
                <input type="time" name="due_time" class="input-control" value="<?= $task['due_time'] ?>" required>
                <div class="text-right">
                    <button type="submit" name="update">Update</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
