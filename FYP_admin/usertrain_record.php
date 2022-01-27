<?php
SESSION_START();
require_once("include/output_functions.php");
require_once("include/validation.php");
check_logout();

html_header("User Training Record");

$month = date('m');
$day = date('d');
$year = date('Y');

$today = $year . '-' . $month . '-' . $day;

?>
<body>
<?php   nav_bar("USER TRAINING RECORD");    ?>

<div class="container mt-4">
    <form id="search_form" action="" method="POST" class="needs-validation mt-5" novalidate>
        <div class="row align-items-end">
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
                <caption id="total_records"></caption>
                <thead class="thead-light">
                    <tr>
                    <th scope="col">#</th>
                    <th scope="col">Image Path</th>
                    <th scope="col">Real Gender</th>
                    <th scope="col">Real Age</th>
                    <th scope="col">Predicted Gender</th>
                    <th scope="col">Predicted Age</th>
                    <th scope="col">Training Date</th>
                    </tr>
                </thead>
                <tbody id="search_results">
                    <tr>
                        <th scope="row">1</th>
                        <td>img.jpg</td>
                        <td class="text-success font-weight-bold">FEMALE</td>
                        <td class="text-success font-weight-bold">20</td>
                        <td class="text-info font-weight-bold">FEMALE</td>
                        <td class="text-info font-weight-bold">18</td>
                        <td>2021-07-30 16:30:35</td>
                    </tr>
                    <tr>
                        <th scope="row">2</th>
                        <td>img2.jpg</td>
                        <td class="text-success font-weight-bold">MALE</td>
                        <td class="text-success font-weight-bold">20</td>
                        <td class="text-info font-weight-bold">MALE</td>
                        <td class="text-info font-weight-bold">18</td>
                        <td>2021-07-30 17:30:35</td>
                    </tr>
                    <tr>
                        <th scope="row">3</th>
                        <td>image3.jpg</td>
                        <td class="text-success font-weight-bold">MALE</td>
                        <td class="text-success font-weight-bold">25</td>
                        <td class="text-info font-weight-bold">MALE</td>
                        <td class="text-info font-weight-bold">25</td>
                        <td>2021-08-02 10:25:00</td>
                    </tr>
                </tbody>
            </table>
            <div id="pagination_links"></div>
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

            load_data();
        });

        $(document).on('click', '.page-link', function() {
            var page = $(this).data('page_number');
            load_data(page);
        });
    });

    function load_data(page_number = 1) {
        var pageNum = page_number;
        var tstart = $('#start_date').val();
        tstart += " 00:00:00";
        var tend = $('#end_date').val();
        tend += " 23:59:59";
        
        $.ajax({
            url:"db_usertrain.php",
            method: "POST",
            data: {
                trainStart: tstart,
                trainEnd: tend,
                page: pageNum
            },
            dataType: "html",
            success:function(data) {
                $('#result_table').removeClass("d-none");
                $('#result_table').html(data);
            }, 
            error: function(response, data) {
                $('#result_table').removeClass("d-none");
                $('#result_table').html('<tr><td colspan="7">No Data Found</td></tr>');
            }
        });
    }
</script>
</body>
</html>
