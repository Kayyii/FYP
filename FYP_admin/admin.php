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

if (isset($_GET['del'])) {
    if (is_numeric($_GET['del'])) {
        $id = $_GET['del'];
        $sql = "DELETE FROM admin WHERE id=$id LIMIT 1";
        $result = $conn->query($sql);
        if ($result) {
            echo '<script>alert("Delete Success.")</script>';
            echo "<script>window.location.assign('admin.php');</script>";
        }
    } else {
        echo '<script>alert("Iccorrect ID");</script>';
    }
}
?>
<body>
<?php   nav_bar("ADMIN");    ?>

<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <a href="addadmin.php" class="btn btn-lg btn-primary">
                <i class="fa fa-edit"></i> Add Admin
            </a>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-12">
            <h2>Admin List</h2>
            <div class="table-responsive">
                <table id="datatable-buttons" class="table table-striped table-bordered jambo_table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Access Pages</th>
                            <th width="300">Action</th>
                        </tr>
                    </thead>
                    <form action="member-list.php" method="POST">
                    <tbody>
                        <?php
                            $level = $_SESSION['access_level'];
                            $sql = "SELECT * FROM admin WHERE level > $level";
                            $run = $conn->query($sql);

                            if($run->num_rows>0){
                                while($row = $run->fetch_assoc()){
                        ?>
                        <tr>
                            <td><?php echo $row['username']; ?></td>
                            <td><?php
                            $access = $row['access'];
                            if($access != "all") {
                                $access = explode(",", trim($access));
                            }
                            $access_page = array();
                            if ($access == "all") {
                                for ($i=0; $i < count($pages); $i++) { 
                                    $access_page[] = $pages[$i][1];
                                }
                            } else {
                                for ($i=0; $i < count($access); $i++) { 
                                    $access_page[] = $pages[$access[$i]][1];
                                }
                            }
                            echo implode(", ",$access_page);
                            ?></td>
                            <td>
                                <a href="editadmin.php?edit=<?php echo $row['id']; ?>" class="btn btn-sm btn-info">
                                    Edit</a>
                                <a href="admin.php?del=<?php echo $row['id'];?>" class="btn btn-sm btn-danger"  onClick="javascript: return confirm('Please confirm deletion');">
                                    Delete</a>

                            </td>
                        </tr>
                        <?php
                                        }
                            } else {
                                echo '<tr class="text-center"><td colspan="3">No Data Found</td></tr>';
                            }
                        ?>
                    </tbody>
                    </form>
                </table>
            </div>
        </div>
    </div>
</div>
    
<script>
<?php  verify_form();  ?>
</script>
</body>
</html>
