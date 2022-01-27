<?php
SESSION_START();
require_once("include/output_functions.php");
require_once("include/validation.php");
check_logout();

check_access(0);

html_header("Training");
?>
<body>
<?php   nav_bar("TRAINING");    ?>

<div class="container mt-4">
    <form action="" method="POST" class="needs-validation mt-5" novalidate>
        <div class="row">
            <div class="col-md-5">
                <div class="form-group">
                    <h4 class="text-main"><strong>Select Training Type</strong></h4>
                    <select class="form-control form-control-lg" name="train_type" id="train_type">
                        <option value="agegenderdet">Age & Gender Detection</option>
                        <option value="celebrityrec">Celebrity Recognition</option>
                    </select>
                </div>
                <div class="form-group">
                    <h5 class="text-main"><strong>Select Images folder or CSV file</strong></h5>
                    <select class="form-control form-control" name="train_method" id="train_method">
                        <option value="csv">CSV File</option>
                        <option value="folder">Images Folder</option>
                    </select>
                </div>
                <div class="form-group">
                    <input type="file" class="form-control-file" id="filepicker" accept=".csv">
                </div>
            </div>
            <div class="col-md-4 offset-md-3" align="center">
                <button type="submit" class="btn btn-submit btn-main btn-dark p-4">START TRAINING</button>
            </div>
            <input type="hidden" name="train_type" value="agegender">
        </div>
        <div class="row">
            <div id="listing_panel" class="col m-2 alert alert-info overflow-auto d-none">
                <ul id="listing" class="p-2"></ul>
            </div>
        </div>
    </form>
    <div id="result1" style="margin-top: 7em; margin-bottom: 7em">
        <div class="progress">
            <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 75%">75%</div>
        </div>
        <p class="text-main text-center"><span id="result_text">Training... </span><span id="result_percent" class="font-italic">75%</span></p>
        <div class="progress">
            <div class="progress-bar progress-bar-striped" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">100%</div>
        </div>
        <p class="text-main text-center"><span id="result_text">Train Success </span><span id="result_percent" class="font-italic">100%</span></p>
    </div>
</div>
    
<script>
    var select = "";
    select = $("#train_method").find(":selected").val();

    $('[id="train_method"]').change(function() {
        select = $(this).find(":selected").val();

        var input = $("#filepicker");
        input.val("");
        if (select == "csv") {
            resetListing();
            input.attr("accept", ".csv");
            input.prop("webkitdirectory", false);
            input.prop("multiple", false);
        } else if (select == "folder") {
            input.removeAttr("accept");
            input.prop("webkitdirectory", true);
            input.prop("multiple", true);
        }
    });

    <?php  verify_form();  ?>
    
    document.getElementById("filepicker").addEventListener("change", function(event) {
        resetListing();
        console.log("change");
        if (select == "folder") {
            $("#listing_panel").addClass("d-block");
            $("#listing_panel").removeClass("d-none");

            let output = document.getElementById("listing");
            let files = event.target.files;
            let fileslength = files.length;

            if (fileslength > 0) {
                for (let i=0; i<5; i++) {
                    let item = document.createElement("li");
                    item.innerHTML = files[i].webkitRelativePath;
                    output.appendChild(item);
                };
                let morefile = fileslength - 5;
                if (morefile > 0) {
                    let item = document.createElement("li");
                    item.innerHTML = "And " + morefile + " more files...";
                    output.appendChild(item);
                }
            } else {
                $("#listing_panel").addClass("d-none");
                $("#listing_panel").removeClass("d-block");
            }
        }
    }, false);

    function resetListing() {
        $("#listing_panel").addClass("d-none");
        $("#listing_panel").removeClass("d-block");
        $("#listing li").remove();
    }
</script>
</body>
</html>
