<?php

function paginate($total_rows,$per_page,$custom = null){

if (isset($_GET['pn'])) { // Get pn from URL vars if it is present
    $pn = preg_replace('#[^0-9]#i', '', $_GET['pn']); // filter everything but numbers for security(new)

} else { // If the pn URL variable is not present force it to be value of page number 1
    $pn = 1;
} 

$lastPage = ceil($total_rows / $per_page);

if ($pn < 1) { // If it is less than 1
    $pn = 1; // force if to be 1
} else if ($pn > $lastPage) { // if it is greater than $lastpage
    $pn = $lastPage; // force it to be $lastpage's value
} 
$centerPages = "";
$sub1 = $pn - 1;
$sub2 = $pn - 2;
$add1 = $pn + 1;
$add2 = $pn + 2;

if ($pn == 1) {
    $centerPages .= ' <li class="current"><a href="">' . $pn . '</a></li> ';
    $centerPages .= ' <li><a href="' . url('/') . '?pn=' . $add1 . '">' . $add1 . '</a></li> ';
} else if ($pn == $lastPage) {
    $centerPages .= ' <li><a href="' . url('/') . '?pn=' . $sub1 . '">' . $sub1 . '</a></li> ';
    $centerPages .= ' <li class="current"><a href="">' . $pn . '</a></li> ';
} else if ($pn > 2 && $pn < ($lastPage - 1)) {
    $centerPages .= ' <li><a href="' . url('/') . '?pn=' . $sub2 . '">' . $sub2 . '</a></li> ';
    $centerPages .= ' <li><a href="' . url('/') . '?pn=' . $sub1 . '">' . $sub1 . '</a></li> ';
    $centerPages .= ' <li class="current"><a href="">' . $pn . '</a></li> ';
    $centerPages .= ' <li><a href="' . url('/') . '?pn=' . $add1 . '">' . $add1 . '</a></li> ';
    $centerPages .= ' <li><a href="' . url('/') . '?pn=' . $add2 . '">' . $add2 . '</a></li> ';
} else if ($pn > 1 && $pn < $lastPage) {
    $centerPages .= ' <li><a href="' . url('/') . '?pn=' . $sub1 . '">' . $sub1 . '</a></li> ';
    $centerPages .= ' <li class="current"><a href="">' . $pn . '</a></li> ';
    $centerPages .= ' <li><a href="' . url('/') . '?pn=' . $add1 . '">' . $add1 . '</a></li> ';
}


$left = $pages = $right = $what_page = "";

// This code runs only if the last page variable is not equal to 1, if it is only 1 page we require no paginated links to display
if ($lastPage != "1"){
   
    $what_page .= ' <small>On page ' . $pn . ' of ' . $lastPage .'</small> ';

    // If not on 1st page show previous page button
    if ($pn != 1) {
        $previous = $pn - 1;
        $left =  '  <li class=""><a href="' . url('/') . '?pn=' . $previous . '"> &laquo;</a></li> ';
    } 
   
   
    // If not on last page show next page button
    if ($pn != $lastPage) {
        $nextPage = $pn + 1;
        $right =  ' <li class=""><a href="' . url('/') . '?pn=' . $nextPage . '"> &raquo;</a></li> ';
    } 
     $pages .= '<ul class="pagination">' .$left. $centerPages . $right . '</ul>';
}
$pagination = array();
$pagination['pages']= $pages;
$pagination['total_items'] = $total_rows;
$pagination['on_page'] = $what_page;
return $pagination;
}