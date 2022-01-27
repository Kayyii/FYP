<?php
SESSION_START();
require_once("include/output_functions.php");
require_once("include/validation.php");
require_once("include/db_functions.php");
check_logout();
$conn = db_connect();

check_access(3);

html_header("Admin");

$pages = array(
    array("training", "TRAINING"),
    array("testing", "TESTING"),
    array("dataana", "DATASET ANALYSIS"),
    array("admin", "ADMIN"),
    array("setting", "SETTINGS"),
);
?>
<body>
<?php   nav_bar("ADD ADMIN");    ?>

<div class="container mt-4">
    <h2>Add Admin</h2>
        <form action="addadmin_process.php" method="POST" class="pt-3 pb-3 needs-validation" novalidate>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="username">Username:</label>
                <div class="col-sm-10 align-self-center">
                    <input type="text" class="form-control" id="username" name="username" placeholder="Username" required>
                    <div class="invalid-feedback">
                        Please fill out this field correctly.
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="password">Password:</label>
                <div class="col-sm-10 align-self-center">
                    <div class="row">
                        <div class="col">
                            <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                            <div class="invalid-feedback">
                                Please fill out this field correctly.
                            </div>
                        </div>
                        <div class="col">
                            <input type="password" class="form-control" id="cpassword" name="cpassword" placeholder="Confirm Password" required>
                            <div class="invalid-feedback">
                                Please fill out this field correctly.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Access Pages:</label>
                <div class="col-sm-10 align-self-center">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" name="pages[]" id="training" value="0">
                        <label class="form-check-label" for="training">
                            Training
                        </label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" name="pages[]" id="testing" value="1">
                        <label class="form-check-label" for="testing">
                            Testing
                        </label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" name="pages[]" id="dataana" value="2">
                        <label class="form-check-label" for="dataana">
                            Dataset Analysis
                        </label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" name="pages[]" id="admin" value="3">
                        <label class="form-check-label" for="admin">
                            Admin
                        </label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" name="pages[]" id="setting" value="4">
                        <label class="form-check-label" for="setting">
                            Settings
                        </label>
                    </div>
                </div>
            </div>
            <br>
            <div class="form-group row">
                <div class="offset-sm-2 col-sm-10">
                    <button type="reset" class="btn btn-outline-secondary mb-2">Reset</button>
                    <button type="submit" class="btn btn-primary btn-submit mb-2">Save</button>
                </div>
            </div>
        </form>  
</div>
    
<script>
var pwd = '';
var cpwd = '';
$('input[name=password]').change(function() {
    pwd = $(this).val();
    if (pwd != cpwd) {
        $('input[name=cpassword]').css("color", "red");
    } else {
        $('input[name=cpassword]').css("color", "black");
    }
});
    
$('input[name=cpassword]').keyup(function() {
    cpwd = $(this).val();
    if (pwd != cpwd) {
        $(this).css("color", "red");
        $(this).css("border-color", "red");
    } else {
        $(this).css("color", "black");
        $(this).css("border-color", "#ced4da");
    }
});

(function() {
    'use strict';
    window.addEventListener('load', function() {
        // Get the forms we want to add validation styles to
        var forms = document.getElementsByClassName('needs-validation');
        // Loop over them and prevent submission
        var validation = Array.prototype.filter.call(forms, function(form) {
        form.addEventListener('submit', function(event) {
            if (form.checkValidity() === false) {
                event.preventDefault();
                event.stopPropagation();
                $('input.form-control:invalid').first().focus();
            } else if ($('input:checkbox').filter(':checked').length < 1) {
                event.preventDefault();
                event.stopPropagation();
                alert("At least one page needs to be selected");
            } else if (pwd != cpwd) {
                event.preventDefault();
                event.stopPropagation();
                $('input[name=cpassword]').focus();
                alert("Please enter correct confirm password.");
            } else {
                $('.btn-submit').prop("disabled", true)
                                .html("<span class=\"fa fa-spinner fa-spin\"></span>&nbsp;&nbsp; Loading...");
            }
            form.classList.add('was-validated');
        }, false);
        });
    }, false);
    })();
</script>
</body>
</html>
