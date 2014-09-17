<?php
class Pagination {

    /*
    how many records in total
    @type int
    */
    public $total_rows;

    /*
    how many records/row to show per page
    @type int
    */
    public $per_page;

     /*
    html tag to use for
    container of page links
    @type string
    */
    public $list_tag = "ul";

    /*
    html tag to use for page link
    @type string
    */
    public $page_tag = "li";
    
    /*
    class name of current page
    */

    public $onpage_class = "current";
    /*
    page number
    @type int
    */
    public $page_num;

    /*
    last pate
    @type int
    */
    public $lastpage;

    /*
    used for having for than 1 get params
    to put in making href links
    */
    public $extra_query = null;

    public function initialize ()
    {
       
        $this->lastpage = ceil($this->total_rows / $this->per_page);
        if (isset($_GET['page_num'])) { // Get page_num from URL vars if it is present
            $this->page_num = preg_replace('#[^0-9]#i', '', $_GET['page_num']); // filter everything but numbers for security(new)
        } else { // If the page_num URL variable is not present force it to be value of page number 1
            $this->page_num = 1;
        } 
        if ($this->page_num < 1) { // If it is less than 1
            $this->page_num = 1; // force it to be 1
        } else if ($this->page_num > $this->lastpage) { // if it is greater than $this->lastpage
            $this->page_num = $this->lastpage; // force it to be $this->lastpage's value
        } 
    }

    //Builds the array containing the links and details
    public function pageIt ()
    {
        $this->initialize();
        $num_pages = "";
        $sub1 = $this->page_num - 1;
        $sub2 = $this->page_num - 2;
        $add1 = $this->page_num + 1;
        $add2 = $this->page_num + 2;
        $added_query = "?";
        foreach ((array)$this->extra_query as $eachquery) {
            $added_query .="{$eachquery}&";
        }
            if ($this->page_num == 1)
            {
                $num_pages .= '<li class="'.$this->onpage_class.'"><a href="">'.$this->page_num.'</a></li> ';
                $num_pages .= '<li><a href="'.$added_query.'page_num='.$add1.'">'.$add1.'</a></li> ';
            } else if ($this->page_num == $this->lastpage) {
                $num_pages .= '<li><a href="'.$added_query.'page_num='.$sub1.'">'.$sub1.'</a></li> ';
                $num_pages .= '<li class="'.$this->onpage_class.'"><a href="">'.$this->page_num. '</a></li> ';
            } else if ($this->page_num > 2 && $this->page_num < ($this->lastpage - 1)) {
                $num_pages .= '<li><a href="'.$added_query.'page_num='.$sub2.'">'.$sub2.'</a></li> ';
                $num_pages .= '<li><a href="'.$added_query.'page_num='.$sub1.'">'.$sub1.'</a></li> ';
                $num_pages .= '<li class="'.$this->onpage_class.'"><a href="">'.$this->page_num. '</a></li> ';
                $num_pages .= '<li><a href="'.$added_query.'page_num='.$add1.'">'.$add1.'</a></li> ';
                $num_pages .= '<li><a href="'.$added_query.$add2.'page_num='.'">'.$add2.'</a></li> ';
            } else if ($this->page_num > 1 && $this->page_num < $this->lastpage) {
                $num_pages .= '<li><a href="'.$added_query.'page_num='.$sub1.'">'.$sub1.'</a></li> ';
                $num_pages .= '<li class="'.$this->onpage_class.'"><a href="">'.$this->page_num. '</a></li> ';
                $num_pages .= '<li><a href="'.$added_query.'page_num='.$add1.'">'.$add1.'</a></li> ';
            }

        
        $left = $pages = $right = $what_page = "";

        // if last page = 1, no need to display links

        //if last page not = 1
        if ($this->lastpage != "1")
        {
           
            $what_page .= ' <small>On page '.$this->page_num. ' of '.$this->lastpage .'</small> ';

            // If not on 1st page show previous page button
            if ($this->page_num != 1) {
                $previous = $this->page_num - 1;
                $left =  '  <li class=""><a href="'.$added_query.'page_num='.$previous.'"> &laquo;</a></li> ';
            }     
            // If not on last page show next page button
            if ($this->page_num != $this->lastpage) {
                $nextPage = $this->page_num + 1;
                $right =  ' <li class=""><a href="'.$added_query.'page_num='.$nextPage.'"> &raquo;</a></li> ';
            } 
             $pages .= '<ul class="pagination">' .$left. $num_pages.$right.'</ul>';
        }

        $pagination = array();
        $pagination['pages']= $pages;
        $pagination['total_items'] = $this->total_rows;
        $pagination['on_page'] = $what_page;
        return $pagination;
    }

}