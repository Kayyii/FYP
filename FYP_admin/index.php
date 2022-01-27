<?php
require_once("include/output_functions.php");
html_header("Login");
?>
<body>
<div class="container text-center p-5">
  <h1><strong>Admin Portal</strong></h1>
  <div class="login-form">
      <form action="login_process.php" method="POST" class="needs-validation" novalidate>
          <h2 class="text-center">Admin Login</h2>
          <div class="mt-3 mb-4">
              <div class="input-group mb-2">
                  <input type="text" name="username" class="form-control text-center" placeholder="Username" required>
                  <div class="invalid-feedback">Please fill out this field.</div>
              </div>
              <div class="input-group mb-2">
                  <input type="password" name="password" class="form-control text-center" placeholder="Password" required>
                  <div class="invalid-feedback">Please fill out this field.</div>
              </div>
          </div>
          <div class="form-group">
              <button type="submit" name="submit" class="btn btn-submit btn-outline-main pl-4 pr-4">LOGIN</button>
          </div>
      </form>
  </div>
</div>

<script>
<?php
verify_form();
?>
</script>
</body>

</html>