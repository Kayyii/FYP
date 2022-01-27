<?php
SESSION_START();
require_once("include/output_functions.php");
require_once("include/validation.php");
check_logout();

check_access(2);

html_header("Dataset Analysis");

$celebrity = array();
$myfile = fopen("models/labels.txt", "r") or die ("Unable to open file!");
while(!feof($myfile)) {
    // echo fgets($myfile) . "<br>";
    $celebrity[] = fgets($myfile);
}
fclose($myfile);

if (($key = array_search("Unknown Person", $celebrity)) !== false) {
    unset($celebrity[$key]);
}
?>
<body>
<?php   nav_bar("DATASET ANALYSIS");    ?>


<div class="container mt-4">
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="age-tab" data-toggle="tab" href="#age" role="tab" aria-controls="age" aria-selected="true">Age & Gender Detection</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="celebrity-tab" data-toggle="tab" href="#celebrity" role="tab" aria-controls="celebrity" aria-selected="false">Celebrity Recognition</a>
        </li>
    </ul>
    <div class="tab-content" id="myTabContent">
        <!-- Age & Gender Detection -->
        <div class="tab-pane fade show active p-3" id="age" role="tabpanel" aria-labelledby="age-tab">
            <!-- <h3>Age & Gender Detection</h3>
            <br> -->
            <h3 class="text-main"><strong>Age & Gender Dataset</strong></h3><br>
            <div class="row">
                <div class="col-md p-2 m-1 border">
                    <div class="row text-center">
                        <b class="col border-right my-auto">Total</b>
                        <div class="col h5 my-auto">100000</div>
                    </div>
                </div>
                <div class="col-md p-2 m-1 border">
                    <div class="row text-center">
                        <b class="col border-right my-auto">Male</b>
                        <div class="col h5 my-auto">48000</div>
                    </div>
                </div>
                <div class="col-md p-2 m-1 border">
                    <div class="row text-center">
                        <b class="col border-right my-auto">Female</b>
                        <div class="col h5 my-auto">52000</div>
                    </div>
                </div>
            </div>
            <div class="mt-5 row">
                <div class="col-md">
                    <h5>Age</h5>
                    <div class="graph bg-secondary p-5"></div>
                </div>
                <div class="col-md">
                    <h5>Gender</h5>
                    <div class="graph bg-secondary p-5"></div>
                </div>
            </div>
        </div>
        <!-- Celebrity -->
        <div class="tab-pane fade p-3" id="celebrity" role="tabpanel" aria-labelledby="celebrity-tab">
            <h3 class="text-main"><strong>Celebrity Dataset</strong></h3><br>
            <div class="row">
                <div class="col-md-6 p-2 m-1 border">
                    <div class="row text-center">
                        <b class="col border-right my-auto">Total Celebrity</b>
                        <div class="col h5 my-auto"><?php echo count($celebrity); ?></div>
                    </div>
                </div>
            </div>
            <div class="mt-5 row">
                <input type="text" id="myInput" class="form-control" onkeyup="searchCel()" placeholder="Search for names.." title="Type in a name">
                <table id="celTable" class="table table-striped table-hover mt-2">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Celebrity Name</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        for ($i=0; $i < count($celebrity); $i++) { 
                            echo '<tr>'.
                                    '<td scope="row">'.($i+1).'</td>'.
                                    '<td><b>'.($celebrity[$i]).'</b></td>'.
                                '</tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
function searchCel() {
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("celTable");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[1];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }       
  }
}
</script>
</body>
</html>
