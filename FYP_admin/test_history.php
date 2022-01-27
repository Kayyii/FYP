<?php
SESSION_START();
require_once("include/output_functions.php");
require_once("include/validation.php");
check_logout();

html_header("Testing History");

$month = date('m');
$day = date('d');
$year = date('Y');

$today = $year . '-' . $month . '-' . $day;
?>
<body>
<?php   nav_bar("TESTING HISTORY");    ?>

<div class="container mt-4">
    <form action="" method="POST" class="needs-validation mt-5" novalidate>
        <div class="row align-items-end">
            <div class="col-md">
                <div class="form-group">
                    <label for="test_type">Type</label>
                    <select class="form-control" name="test_type" id="test_type">
                        <option value="1" selected>Age & Gender Detection</option>
                        <option value="2">Celebrity Recognition</option>
                    </select>
                </div>
            </div>
            <div class="col-md">
                <div class="form-group">
                    <label for="start_date">Start Date</label>
                    <input type="date" class="form-control" name="start_date" id="start_date" value="<?php echo $today; ?>" max="<?php echo $today; ?>">
                </div>
            </div>
            <div class="col-md">
                <div class="form-group">
                    <label for="end_date">End Date</label>
                    <input type="date" class="form-control" name="end_date" id="end_date" value="<?php echo $today; ?>" max="<?php echo $today; ?>">
                </div>
            </div>
            <div class="col-md">
                <div class="form-group">
                    <button type="submit" id="btnsearch" class="btn btn-submit btn-outline-main pl-4 pr-4">Search</button>
                </div>
            </div>
        </div>
    </form>
    <div id="result_table" class="mt-5 d-none">
    <!-- <hr>
        <div class="table-responsive">
            <table class="table table-hover table-sm text-center table-bordered">
                <caption id="total_records">Total 2 data</caption>
                <thead class="thead-light">
                    <tr>
                    <th class="align-middle" scope="col">#</th>
                    <th class="align-middle" scope="col">Testing Item</th>
                    <th class="align-middle" scope="col">Testing Result<br><small>(AGE | GENDER)</small></th>
                    <th class="align-middle" scope="col">Testing Date</th>
                    <th class="align-middle" scope="col">Tested By</th>
                    </tr>
                </thead>
                <tbody id="search_results">
                    <tr>
                        <th scope="row">1</th>
                        <td>testing_img01.jpg</td>
                        <td class="text-info font-weight-bold">21 | FEMALE</td>
                        <td>2021-07-30 14:25:35</td>
                        <td>admin</td>
                    </tr>
                    <tr>
                        <th scope="row">2</th>
                        <td>testing_img02.jpg</td>
                        <td class="text-info font-weight-bold">30 | MALE</td>
                        <td>2021-07-30 14:40:35</td>
                        <td>admin</td>
                    </tr>
                </tbody>
            </table>
            <div id="pagination_link"></div>
        </div> -->
    </div>
</div>
<div class="modal"></div>
    
<script>
    $body = $("body");

    $(document).on({
        ajaxStart: function() { $body.addClass("loading");    },
        ajaxStop: function() { $body.removeClass("loading"); }    
    });

    $(document).ready(function() {

        $('#btnsearch').click(function(e) {
            e.preventDefault();

            load_data(1);

            
        });

        $(document).on('click', '.page-link', function() {
            var page = $(this).data('page_number');
            load_data(page);
        });
    });

    function load_data(page_number = 1) {
        var pageNum = page_number;
        var ttype = $('#test_type').find(":selected").val();
        var tstart = $('#start_date').val();
        tstart += " 00:00:00";
        var tend = $('#end_date').val();
        tend += " 23:59:59";
        
        $.ajax({
            url:"db_test.php",
            method: "POST",
            data: {
                testType: ttype,
                testStart: tstart,
                testEnd: tend,
                page: pageNum
            },
            dataType: "html",
            success:function(data) {
                $('#result_table').removeClass("d-none");
                $('#result_table').html(data);
            }, 
            error: function(response, data) {
                $('#result_table').removeClass("d-none");
                // $('#total_records').text("-- Total 0 data --");
                $('#result_table').html('<tr><td colspan="5">No Data Found</td></tr>');
            }
        }); 
    }
</script>
</body>
</html>
