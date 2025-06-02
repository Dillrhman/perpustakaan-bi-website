<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Register Staff</title>
  <link rel="stylesheet" href="css/register-staff.css" />
</head>
<body>
  <div class="container">
    <div class="left">
      <img src="css/reg-staf.jpg" alt="Register Staff Illustration" />
    </div>
    <div class="right">
      <h1>Register Staff</h1>
      <form>
        <label for="username">Username</label>
        <input type="text" id="username" name="username" required />

        <label for="email">Email</label>
        <input type="email" id="email" name="email" required />

        <label for="password">Password</label>
        <input type="password" id="password" name="password" required />

        <div class="buttons">
          <button type="submit" class="btn register">Login</button>
          <button type="button" class="btn signin">Sign In</button>
        </div>
      </form>
    </div>
  </div>
</body>
</html>
