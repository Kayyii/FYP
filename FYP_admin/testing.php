<?php
SESSION_START();
require_once("include/output_functions.php");
require_once("include/validation.php");
check_logout();

check_access(1);

html_header("Testing");
?>
<body>
<?php   nav_bar("TESTING");    ?>

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
            <h3 class="text-main"><strong>Select An Image For Testing</strong></h3>
            <form action="" id="ageform" method="POST" class="needs-validation" novalidate>
                <div class="row align-items-center">
                    <div class="col-sm-5">
                        <div class="form-group pt-3">
                            <input type="file" class="form-control-file" id="filepicker" accept="image/*">
                        </div>
                    </div>
                    <div class="col-sm-4 offset-sm-3" align="center">
                        <button type="button" class="btn btn-submit btn-main btn-dark p-4">START TESTING</button>
                    </div>
                    <input type="hidden" name="train_type" value="agegender">
                </div>
            </form>
            <div id="result" class="p-3 mt-5 mb-5 border border-secondary">
                <h4 class="p-1">Result:</h4>
                <div class="text-center">
                    <div class="p-1">
                        <img src="https://via.placeholder.com/300" id="image-previewer" class="img-thumbnail" alt="Tested Image" width="300">
                    </div>
                    <!-- <table id="table-result" class="table table-dark m-0 d-none" style="color:white;">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Predicted Age</th>
                            <th scope="col">Predicted Gender</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row">1</th>
                            <td>25</td>
                            <td>Male</td>
                        </tr>
                    </tbody>
                    </table> -->
                    <br><br>
                    <h4 id="resultage"></h4>
                    <h4 id="resultgender"></h4>
                </div>
            </div>
        </div>
        <!-- Celebrity -->
        <div class="tab-pane fade p-3" id="celebrity" role="tabpanel" aria-labelledby="celebrity-tab">
        <h3 class="text-main"><strong>Select An Image For Testing</strong></h3>
            <form action="" id="celebrityform" method="POST" class="needs-validation" novalidate>
                <div class="row align-items-center">
                    <div class="col-md-5">
                        <div class="form-group pt-3">
                            <input type="file" class="form-control-file" id="filepicker" accept="image/*">
                        </div>
                    </div>
                    <div class="col-md-4 offset-md-3" align="center">
                        <button type="button" class="btn btn-submit btn-main btn-dark p-4">START TESTING</button>
                    </div>
                    <input type="hidden" name="train_type" value="celebrity">
                </div>
            </form>
            <div id="result" class="p-3 mt-5 mb-5 border border-secondary">
                <h4 class="p-1">Result:</h4>
                <div class="text-center">
                    <div class="p-1">
                        <img src="https://via.placeholder.com/300" id="image-previewer" class="img-thumbnail" alt="Tested Image" width="300">
                    </div>
                    <!-- <table id="table-result" class="table table-dark m-0">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Predicted Name of Celebrity</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row">1</th>
                            <td id="resultname">NAMEEEE</td>
                        </tr>
                    </tbody>
                    </table> -->
                    <br><br>
                    <h4 id="resultname"></h4>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/@tensorflow/tfjs@2.0.0/dist/tf.min.js"></script>
<script>
<?php  verify_form();  ?>

// show selected image
$('#age #filepicker').imoViewer({
    'preview' :'#age #image-previewer',
});

$('#celebrity #filepicker').imoViewer({
    'preview' :'#celebrity #image-previewer',
});

$('#age .btn-submit').on('click', function() {
    // check fileinput
    if ($('#age #filepicker').get(0).files.length === 0) {
        alert("No Image Selected");
    } else {
        // run model
        // return result

        // show result
        $("#age #resultage").html("Predicted Age: <b>25</b>");
        $("#age #resultgender").html("Predicted Gender: <b>MALE</b>");
    }

});

$('#celebrity .btn-submit').on('click', function() {
    if ($('#celebrity #filepicker').get(0).files.length === 0) {
        alert("No Image Selected");
    } else {
        // run model
        // return result

        // show result
        $("#celebrity #resultname").html("Predicted: <b>Scarlett Johansson</b>");
    }
});

async function start() {
    const image = $('#celebrity #filepicker');
    const result = $('#celebrity #table-result');

    // Load the model.
    const tfliteModel = await  tfTask.NLClassification.CustomModel.TFLite.load({
        model: "models/celebrity.tflite"
    });
}
// start();
</script>
</body>
</html>
