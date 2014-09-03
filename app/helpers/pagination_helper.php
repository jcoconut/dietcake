<?php
class Pagination{
    
    public $total_rows;
    public $per_page;
    public $custom;
    public $pn;
    public $lastpage;
    public $extra_query;

    public function __construct ($total_rows,$per_page,$extra_query = null,$custom = null)
    {
        $this->total_rows = $total_rows;
        $this->per_page = $per_page;
        $this->extra_query = $extra_query;
        $this->lastpage = ceil($this->total_rows / $this->per_page);
        if (isset($_GET['pn'])) { // Get pn from URL vars if it is present
            $this->pn = preg_replace('#[^0-9]#i', '', $_GET['pn']); // filter everything but numbers for security(new)
        } else { // If the pn URL variable is not present force it to be value of page number 1
            $this->pn = 1;
        } 
        if ($this->pn < 1) { // If it is less than 1
            $this->pn = 1; // force if to be 1
        } else if ($this->pn > $this->lastpage) { // if it is greater than $this->lastpage
            $this->pn = $this->lastpage; // force it to be $this->lastpage's value
        } 
    }

    //Builds the array containing the links and details
    public function pageIt ()
    {
        $centerPages = "";
        $sub1 = $this->pn - 1;
        $sub2 = $this->pn - 2;
        $add1 = $this->pn + 1;
        $add2 = $this->pn + 2;
        $added_query = "?";
        foreach ((array)$this->extra_query as $eachquery) {
          $added_query .="{$eachquery}&";
        }
            if ($this->pn == 1)
            {
                $centerPages .= ' <li class="current" style="background:#0266C8;"><a href="">' . $this->pn .  '</a></li> ';
                $centerPages .= ' <li><a href="'  . $added_query . 'pn=' . $add1 . '">' . $add1 . '</a></li> ';
            } else if ($this->pn == $this->lastpage) {
                $centerPages .= ' <li><a href="'  . $added_query . 'pn=' . $sub1 . '">' . $sub1 . '</a></li> ';
                $centerPages .= ' <li class="current"><a href="">' . $this->pn .  '</a></li> ';
            } else if ($this->pn > 2 && $this->pn < ($this->lastpage - 1)) {
                $centerPages .= ' <li><a href="'  . $added_query . 'pn=' . $sub2 . '">' . $sub2 . '</a></li> ';
                $centerPages .= ' <li><a href="'  . $added_query . 'pn=' . $sub1 . '">' . $sub1 . '</a></li> ';
                $centerPages .= ' <li class="current"><a href="">' . $this->pn .  '</a></li> ';
                $centerPages .= ' <li><a href="'  . $added_query . 'pn=' . $add1 . '">' . $add1 . '</a></li> ';
                $centerPages .= ' <li><a href="'  . $added_query . $add2 . 'pn=' . '">' . $add2 . '</a></li> ';
            } else if ($this->pn > 1 && $this->pn < $this->lastpage) {
                $centerPages .= ' <li><a href="'  . $added_query . 'pn=' . $sub1 . '">' . $sub1 . '</a></li> ';
                $centerPages .= ' <li class="current"><a href="">' . $this->pn .  '</a></li> ';
                $centerPages .= ' <li><a href="'  . $added_query . 'pn=' . $add1 . '">' . $add1 . '</a></li> ';
            }

        
        $left = $pages = $right = $what_page = "";

        // if last page = 1, no need to display links

        //if last page not = 1
        if ($this->lastpage != "1")
        {
           
            $what_page .= ' <small>On page ' . $this->pn .  ' of ' . $this->lastpage .'</small> ';

            // If not on 1st page show previous page button
            if ($this->pn != 1) {
                $previous = $this->pn - 1;
                $left =  '  <li class=""><a href="'  . '?pn=' . $previous . '"> &laquo;</a></li> ';
            }     
            // If not on last page show next page button
            if ($this->pn != $this->lastpage) {
                $nextPage = $this->pn + 1;
                $right =  ' <li class=""><a href="'  . '?pn=' . $nextPage . '"> &raquo;</a></li> ';
            } 
             $pages .= '<ul class="pagination">' .$left. $centerPages . $right . '</ul>';
        }
        $pagination = array();
        $pagination['pages']= $pages;
        $pagination['total_items'] = $this->total_rows;
        $pagination['on_page'] = $what_page;
        return $pagination;
    }

}