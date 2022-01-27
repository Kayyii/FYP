<?php
require_once("include/db_functions.php");

$conn = db_connect();

$query = '';

if (isset($_POST['trainType']) && isset($_POST['trainStart']) && isset($_POST['trainEnd'])) {
    $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
    
    $ttype = $_POST['trainType'];
    $tstart = $_POST['trainStart'];
    $tend = $_POST['trainEnd'];
    
    $limit = 10;
    $page = 1;
    if ($_POST['page'] > 1) {
        $start = (($_POST['page'] - 1) * $limit);
        $page = $_POST['page'];
    } else {
        $start = 0;
    }

    // $query = "SELECT * FROM training_record WHERE training_type='{$ttype}' AND START >= '{$tstart}' AND END <= '{$tend}'";    
    $query = "SELECT a.*, b.username FROM training_record AS a LEFT JOIN admin AS b ON a.train_by = b.id WHERE training_type='{$ttype}' AND train_date BETWEEN '{$tstart}' AND '{$tend}' ORDER BY train_date DESC";

    $filter_array = $query . ' LIMIT ' . $start . ', ' . $limit . '';

    $result = $conn->query($query);

    $total_data = mysqli_num_rows($result);

    $result = $conn->query($filter_array);

    $html = '
    <hr>
    <div class="table-responsive">
    <table class="table table-hover table-sm text-center table-bordered">
        <caption id="total_records">-- Total '.$total_data.' data --</caption>
        <thead class="thead-light">
            <tr>
            <th scope="col">#</th>
            <th scope="col">Dataset Path</th>
            <th scope="col">Image Amount</th>
            <th scope="col">Training Date</th>
            <th scope="col">Trained By</th>
            <th scope="col">Result</th>
            </tr>
        </thead>
        <tbody id="search_results">
    ';

    if ($total_data > 0) {
        $cnt = $start+1;
        while ($row = $result->fetch_assoc()) {
            $html .= '
            <tr>
                <th scope="row">'.$cnt++.'</th>
                <td>'.$row['dataset_path'].'</td>
                <td>'.$row['img_amount'].'</td>
                <td>'.$row['train_date'].'</td>
                <td>'.$row['username'].'</td>
                ';
            if ($row['train_result'] == '1') {
                $html .= '<td class="text-success">SUCCESS</td>';
            } else if ($row['train_result'] == '2') {
                $html .= '<td class="text-danger">FAIL</td>';
            } else {
                $html .= '<td>NULL</td>';
            }
            $html .= '</tr>';
        }
    } else {
        $html .= '<tr><td colspan="6">No Data Found</td></tr>';
    }
    $html .= '</tbody>
            </table>
            <div align ="center">
                <ul class="pagination">';

    $total_links = ceil($total_data/$limit);
    $previous_link = '';
    $next_link = '';
    $page_link = '';
    $page_array = array();

    if ($total_links > 4) {
        if ($page < 5) {
            for ($i=1; $i <= 5; $i++) { 
                $page_array[] = $count;
            }
            $page_array[] = '...';
            $page_array[] = $total_links;
        } else {
            $end_limit = $total_links -5;

            if ($page > $end_limit) {
                $page_array[] = 1;
                $page_array[] = '...';

                for ($i=$end_limit; $i <= $total_links; $i++) { 
                    $page_array[] = $i;
                }
            } else {
                $page_array[] = 1;
                $page_array[] = '...';
                for ($i=$page-1; $i <= $page +1; $i++) { 
                    $page_array[] = $i;
                }
                $page_array[] = '...';
                $page_array[] = $total_links;
            }
        }
    } else {
        for ($count=1; $count <= $total_links; $count++) { 
            $page_array[] = $count;
        }
    }

    for ($i=0; $i < count($page_array); $i++) { 
        if ($page == $page_array[$i]) {
            $page_link .= '
            <li class="page-item active">
                <a class="page-link" href="#">'.$page_array[$i].'
                    <span class="sr-only">(current)</span>
                </a>
            </li>
            ';

            $previous_id = $page_array[$i] - 1;
            
            if ($previous_id > 0) {
                $previous_link = '
                <li class="page-item">
                    <a class="page-link" href="javascript:void(0)" data-page_number="'.$previous_id.'">Previous</a>
                </li> ';
            } else {
                $previous_link = '
                <li class="page-item disabled">
                    <a class="page-link" href="#">Previous</a>
                </li>';
            }

            $next_id = $page_array[$i] + 1;
            if ($next_id > $total_links) {
                $next_link = '
                <li class="page-item disabled">
                    <a class="page-link" href="#">Next</a>
                </li>';
            } else {
                $next_link = '
                <li class="page-item">
                    <a class="page-link" href="javascript:void(0)" data-page_number="'.$next_id.'">Next</a>
                </li>';
            }
        } else {
            if ($page_array[$i] == '...') {
                $page_link .= '
                <li class="page-item disabled">
                    <a class="page-link" href="#">...</a>
                </li>';
            } else {
                $page_link .= '
                <li class="page-item">
                    <a class="page-link" href="javascript:void(0)" data-page_number="'.$page_array[$i].'">'.$page_array[$i].'</a>
                </li>';
            }
        }
    }
    $html .= $previous_link . $page_link . $next_link;
    $html .= '</ul></div></div>';

    echo $html;
    // echo json_encode($output);
}

// if (isset($_GET)) {
//     $ttype = $_GET['train_type'];
//     if ($ttype == "agegender") {
//         $ttype = 1;
//     } else if ($ttype == "celebrityrec") {
//         $ttype = 2;
//     }
//     $tstart = $_GET['start_date'];
//     $tend = $_GET['end_date'];

//     $query = "SELECT * FROM training_record WHERE training_type=$ttype AND START >= '$tstart' AND END <= '$tend'";    
// } else {
//     $query = "SELECT * FROM training_record ORDER BY train_date DESC";    
// }

// echo $query;

// $stmt = $conn->prepare($query);

// $stmt->execute();
// $result = $stmt->get_result();

?>