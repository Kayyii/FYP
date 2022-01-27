<?php
SESSION_START();
require_once("include/output_functions.php");
require_once("include/validation.php");
check_logout();

check_access(4);

html_header("Settings");
?>
<body>
<?php   nav_bar("SETTINGS");    ?>


<div class="container mt-4">
    <br><br>
    <div class="m-5 p-1">
        <table class="table table-bordered text-center">
            <tbody>
                <tr>
                    <td class="align-middle"><b class="text-main f-125">SERVICE</b></td>
                    <td class="align-middle">
                        <a class="btn btn-outline-secondary btn-maintain">In Maintenance</a>
                        <a class="btn btn-info btn-service">In Service</a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<script>
    $(".btn-maintain").click(function() {
        alert("Apps In Maintenance");
        $(this).addClass("btn-info")
                .removeClass("btn-outline-secondary");

        $(".btn-service").addClass("btn-outline-secondary")
                        .removeClass("btn-info");
    });

    $(".btn-service").click(function() {
        alert("Apps In Service");
        $(this).addClass("btn-info")
                .removeClass("btn-outline-secondary");

        $(".btn-maintain").addClass("btn-outline-secondary")
                        .removeClass("btn-info");
    });
</script>
</body>
</html>
