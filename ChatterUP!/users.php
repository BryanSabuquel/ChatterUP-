<?php 
  session_start();
  include_once "php/config.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messenger-Like Chat UI</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* Reset and Global Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            display: flex;
            height: 100vh;
            background-color: #f0f2f5;
            overflow: hidden;
        }

        /* Sidebar (Chat List) */
        .sidebar {
            width: 25%;
            background-color: #ffffff;
            border-right: 1px solid #ddd;
            display: flex;
            flex-direction: column;
        }

        .sidebar h2 {
            padding: 15px;
            font-size: 1.2em;
            border-bottom: 1px solid #ddd;
        }

        .search-bar {
            padding: 10px;
        }

        .search-bar input {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .chat-list {
            list-style: none;
            overflow-y: auto;
            flex-grow: 1; /* Allows the chat list to grow and take remaining space */
        }

        .chat-item {
            display: flex;
            align-items: center;
            padding: 10px;
            cursor: pointer;
            border-bottom: 1px solid #f0f2f5;
        }

        .chat-item:hover {
            background-color: #f9f9f9;
        }

        .chat-item img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 10px;
        }

        .chat-item .chat-info {
            flex-grow: 1;
        }

        .chat-info h4 {
            margin: 0;
            font-size: 1em;
        }

        .chat-info p {
            margin: 2px 0;
            font-size: 0.9em;
            color: #777;
        }

        /* Logout Footer */
        .logout-footer {
            padding: 10px;
            background-color: #f8f9fa;
            border-top: 1px solid #ddd;
            text-align: center;
        }

        .logout-footer button {
            background-color: #ff4d4d;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1em;
        }

        .logout-footer button:hover {
            background-color: #e04343;
        }

        /* Chat Area */
        .chat-area {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            background-color: #ffffff;
        }

        .chat-header {
            padding: 15px;
            border-bottom: 1px solid #ddd;
            display: flex;
            align-items: center;
        }

        .chat-header img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 10px;
        }

        .chat-header h3 {
            margin: 0;
        }

        .chat-body {
            flex-grow: 1;
            padding: 15px;
            overflow-y: auto;
            background-color: #f0f2f5;
        }

        .message {
            margin: 10px 0;
        }

        .message.sent {
            text-align: right;
        }

        .message p {
            display: inline-block;
            padding: 10px;
            border-radius: 10px;
            max-width: 70%;
        }

        .message.sent p {
            background-color: #0b93f6;
            color: #ffffff;
        }

        .message.received p {
            background-color: #e4e6eb;
            color: #000;
        }

        /* Chat Footer */
        .chat-footer {
            padding: 10px;
            border-top: 1px solid #ddd;
            display: flex;
            align-items: center;
        }

        .chat-footer input {
            flex-grow: 1;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 20px;
            outline: none;
            margin-right: 10px;
        }

        .chat-footer button {
            background-color: #0b93f6;
            color: #ffffff;
            border: none;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            font-size: 1em;
            cursor: pointer;
        }

        .chat-footer button:hover {
            background-color: #0078e0;
        }
    </style>
</head>
<body>
    <!-- Sidebar (Chat List) -->
    <div class="sidebar">
        <h2>Chats</h2>
        <div class="search-bar">
            <input type="text" placeholder="Search Messenger...">
        </div>
        <ul class="chat-list">
        <?php
            include_once "php/config.php";
            $outgoing_id = $_SESSION['unique_id'];
            $sql = "SELECT * FROM users WHERE NOT unique_id = {$outgoing_id} ORDER BY user_id DESC";
            $query = mysqli_query($conn, $sql);
            $output = "";
            if(mysqli_num_rows($query) == 0){
                $output .= "No users are available to chat";
            }elseif(mysqli_num_rows($query) > 0){
                include_once "php/data.php";
            }
            echo $output;
        ?>
        </ul>
        <div class="logout-footer">
            <button onclick="logout()">Logout</button>
        </div>
    </div>

    
    <!-- Chat Area -->
    <div class="chat-area">
        <div class="chat-header">
        </div>
        <div class="chat-body">
        <p>Select A User to View and Start Conversation</p>
        </div>
        <div class="chat-footer">

        </div>
    </div>
</body>

<script>
const searchBar = document.querySelector(".search-bar input"),
      usersList = document.querySelector(".chat-list");

searchBar.onkeyup = () => {
  let searchTerm = searchBar.value.trim();
  if (searchTerm !== "") {
    // Perform search query via AJAX
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "php/search.php", true);
    xhr.onload = () => {
      if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
        let data = xhr.response;
        usersList.innerHTML = data; // Update the user list with the search results
      }
    };
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send("searchTerm=" + searchTerm); // Send the search term to the backend
  } else {
    // If search bar is empty, reload the full list (or any default behavior)
    let xhr = new XMLHttpRequest();
    xhr.open("GET", "php/users.php", true);
    xhr.onload = () => {
      if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
        let data = xhr.response;
        usersList.innerHTML = data; // Reset the user list
      }
    };
    xhr.send();
  }
};


function logout() {
    window.location.href = "php/logout.php"; // Redirects to logout.php
}

</script>
</html>


