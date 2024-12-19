<?php 
  session_start();
  if(isset($_SESSION['unique_id'])){
    header("location: users.php");
  }
?>
<body>
  <div class="wrapper">
    <section class="form login">
      <header>Realtime Chatter App</header>
      <form action="#" method="POST" enctype="multipart/form-data" autocomplete="off">
        <div class="error-text"></div>
        <div class="field input">
          <label>Email Address</label>
          <input type="text" name="email" placeholder="Enter your email" required>
        </div>
        <div class="field input">
          <label>Password</label>
          <input type="password" name="password" placeholder="Enter your password" required>
          <i class="fas fa-eye"></i>
        </div>
        <div class="field button">
          <input type="submit" name="submit" value="Continue to Chat">
        </div>
      </form>
      <div class="link">Not yet signed up? <a href="index.php">Signup now</a></div>
    </section>
  </div>
  
  <script src="javascript/pass-show-hide.js"></script>
  <script src="javascript/login.js"></script>

</body>
</html>

<style>
/* Simple Futuristic background and form styling */
body {
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  background: linear-gradient(135deg, #e0f7fa, #81d4fa);
  height: 100vh;
  margin: 0;
  display: flex;
  justify-content: center;
  align-items: center;
}

.wrapper {
  width: 100%;
  max-width: 600px;
}

section.form.login {
  background: #ffffff;
  border-radius: 15px;
  padding: 40px;
  box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
  color: #333;
}

header {
  font-size: 2rem;
  font-weight: bold;
  text-align: center;
  margin-bottom: 30px;
  color: #00897b;
  letter-spacing: 1px;
}

.error-text {
  text-align: center;
  color: red;
  margin-bottom: 15px;
}

/* Field styles */
.field {
  margin-bottom: 20px;
}

.field input {
  width: 100%;
  padding: 12px;
  font-size: 16px;
  border: 2px solid #81d4fa;
  border-radius: 8px;
  background: rgba(255, 255, 255, 0.7);
  color: #333;
  transition: all 0.3s ease-in-out;
}

.field input:focus {
  border-color: #00897b;
  background: rgba(255, 255, 255, 0.9);
}

.field label {
  display: block;
  margin-bottom: 8px;
  font-size: 14px;
  font-weight: 600;
  color: #00796b;
}

/* Button styles */
.field.button input {
  background: linear-gradient(135deg, #00897b, #00796b);
  border: none;
  color: #fff;
  padding: 14px;
  font-size: 18px;
  width: 100%;
  border-radius: 10px;
  cursor: pointer;
  transition: transform 0.3s ease, background 0.3s ease;
}

.field.button input:hover {
  background: linear-gradient(135deg, #00796b, #00897b);
  transform: scale(1.05);
}

.link {
  text-align: center;
  margin-top: 20px;
}

.link a {
  color: #00897b;
  text-decoration: none;
  font-weight: 600;
}

.link a:hover {
  text-decoration: underline;
}

/* Transition effect for input focus */
input[type="text"], input[type="password"] {
  transition: all 0.3s ease;
}

i {
  position: absolute;
  right: 10px;
  top: 50%;
  transform: translateY(-50%);
  color: #00796b;
}

</style>
