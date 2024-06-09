<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

include 'database.php';

// Fetch the logged-in user's information
$user_id = $_SESSION['user_id'];
$query_user = "SELECT username FROM users WHERE id = '$user_id'";
$result_user = mysqli_query($conn, $query_user);
$user = mysqli_fetch_assoc($result_user);
$username = $user['username'];

// Proses insert data
if (isset($_POST['add'])) {
    $task = mysqli_real_escape_string($conn, $_POST['task']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $due_date = mysqli_real_escape_string($conn, $_POST['due_date']);
    $due_time = mysqli_real_escape_string($conn, $_POST['due_time']);
    
    $q_insert = "INSERT INTO tasks (tasklabel, taskstatus, description, due_date, due_time, user_id) VALUES ('$task', 'open', '$description', '$due_date', '$due_time', '$user_id')";
    $run_q_insert = mysqli_query($conn, $q_insert);

    if ($run_q_insert) {
        header('Location: index.php');
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

// Proses show data
$q_select = "SELECT * FROM tasks WHERE user_id = '$user_id' ORDER BY taskid DESC";
$run_q_select = mysqli_query($conn, $q_select);

if (!$run_q_select) {
    echo "Error: " . mysqli_error($conn);
}

// Proses delete data
if (isset($_GET['delete'])) {
    $q_delete = "DELETE FROM tasks WHERE taskid = '".$_GET['delete']."' AND user_id = '$user_id'";
    $run_q_delete = mysqli_query($conn, $q_delete);

    header('Location: index.php');
}

// Proses update data
if (isset($_GET['done'])) {
    $status = $_GET['status'] == 'open' ? 'close' : 'open';
    $q_update = "UPDATE tasks SET taskstatus = '".$status."' WHERE taskid = '".$_GET['done']."' AND user_id = '$user_id'";
    $run_q_update = mysqli_query($conn, $q_update);

    header('Location: index.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To Do List</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="title">
                <i class='bx bxs-sun'></i>
                To Do List
            </div>
            <div class="description">
                <?= date("l, d M Y") ?>
            </div>
            <div id="logout-container">
                <a href="logout.php" id="logout-button">Log out</a>
            </div>
            <div id="welcome-user-container">
                <span id="welcome-user">Selamat Datang, <?= htmlspecialchars($username) ?> !</span>
            </div>
        </div>

        <div class="columns">
            <div class="column">
                <h3>To Do</h3>
                <?php
                if (mysqli_num_rows($run_q_select) > 0) {
                    while ($r = mysqli_fetch_array($run_q_select)) {
                        if ($r['taskstatus'] == 'open') {
                ?>
                    <div class="task-item">
                        <div>
                            <input type="checkbox" onclick="window.location.href = '?done=<?= $r['taskid'] ?>&status=<?= $r['taskstatus'] ?>'">
                            <span><?= htmlspecialchars($r['tasklabel']) ?></span>
                            <p><?= htmlspecialchars($r['description']) ?></p>
                            <small>Due: <?= date('Y-m-d h:i A', strtotime($r['due_date'] . ' ' . $r['due_time'])) ?></small>
                        </div>
                        <div class="icons hidden-icons">
                            <a href="edit.php?id=<?= $r['taskid'] ?>" class="text-orange" title="Edit"><i class="bx bx-edit"></i></a>
                            <a href="?delete=<?= $r['taskid'] ?>" class="text-red" title="Remove" onclick="return confirm('Are you sure?')"><i class="bx bx-trash"></i></a>
                        </div>
                    </div>
                <?php 
                        }
                    } 
                } else { 
                ?>
                    <div class="card">No tasks available</div>
                <?php 
                } 
                ?>
            </div>

            <div class="column">
                <h3>Add Task</h3>
                <div class="card">
                    <form method="post" action="">
                        <input type="text" name="task" class="input-control" placeholder="Add task" required>
                        <textarea name="description" class="input-control" placeholder="Add description" required></textarea>
                        <input type="date" name="due_date" class="input-control" required>
                        <input type="time" name="due_time" class="input-control" required>
                        <div class="text-right">
                            <button type="submit" name="add">Add</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="column">
                <h3>Done</h3>
                <?php
                mysqli_data_seek($run_q_select, 0); // Reset pointer to start
                if (mysqli_num_rows($run_q_select) > 0) {
                    while ($r = mysqli_fetch_array($run_q_select)) {
                        if ($r['taskstatus'] == 'close') {
                ?>
                    <div class="task-item done">
                        <div>
                            <input type="checkbox" onclick="window.location.href = '?done=<?= $r['taskid'] ?>&status=<?= $r['taskstatus'] ?>'" checked>
                            <span><?= htmlspecialchars($r['tasklabel']) ?></span>
                            <p><?= htmlspecialchars($r['description']) ?></p>
                            <small>Due: <?= date('Y-m-d h:i A', strtotime($r['due_date'] . ' ' . $r['due_time'])) ?></small>
                        </div>
                        <div class="icons">
                            <a href="edit.php?id=<?= $r['taskid'] ?>" class="text-orange" title="Edit"><i class="bx bx-edit"></i></a>
                            <a href="?delete=<?= $r['taskid'] ?>" class="text-red" title="Remove" onclick="return confirm('Are you sure?')"><i class="bx bx-trash"></i></a>
                        </div>
                    </div>
                <?php 
                        }
                    } 
                } else { 
                ?>
                    <div class="card">No tasks available</div>
                <?php 
                } 
                ?>
            </div>
        </div>
    </div>
</body>
</html>
