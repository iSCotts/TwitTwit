<?php



  /************************************************************\

  *

  *	  PHP Array Pagination 

  *   Dinson

  \************************************************************/



  class pagination

  {

    var $page = 1; // Current Page

    var $perPage = 10; // Items on each page, defaulted to 10

    var $showFirstAndLast = false; // if you would like the first and last page options.

    

    function generate($array, $perPage = 10)

    {

      // Assign the items per page variable

      if (!empty($perPage))

        $this->perPage = $perPage;

      

      // Assign the page variable

      if (!empty($_GET['page'])) {

        $this->page = $_GET['page']; // using the get method

      } else {

        $this->page = 1; // if we don't have a page number then assume we are on the first page

      }

      

      // Take the length of the array

      $this->length = count($array);

      

      // Get the number of pages

      $this->pages = ceil($this->length / $this->perPage);

      

      // Calculate the starting point 

      $this->start  = ceil(($this->page - 1) * $this->perPage);

      

      // Return the part of the array we have requested

      return array_slice($array, $this->start, $this->perPage);

    }

    

    function links()

    {

      // Initiate the links array

      $plinks = array();

      $links = array();

      $slinks = array();

      

      // Concatenate the get variables to add to the page numbering string

      if (count($_GET)) {

        $queryURL = '';

        foreach ($_GET as $key => $value) {

          if ($key != 'page') {

            $queryURL .= '&'.$key.'='.$value;

          }

        }

      }

      

      // If we have more then one pages

      if (($this->pages) > 1)

      {

        // Assign the 'previous page' link into the array if we are not on the first page

        if ($this->page != 1) {

          if ($this->showFirstAndLast) {

            $plinks[] = ' <a href="?page=1'.$queryURL.'">&laquo;&laquo; First </a> ';

          }

          $plinks[] = ' <a href="?page='.($this->page - 1).$queryURL.'">&laquo; Prev</a> ';

        }

        

        // Assign all the page numbers & links to the array

        //for ($j = 1; $j < ($this->pages + 1); $j++) {

			if(!intval($this->page)) $this->page =1;

			$start_limit = $this->page;

			$end_limit = $this->page+10;

			if($end_limit>($this->pages + 1)) 

			{

				if($start_limit>($end_limit - ($this->pages + 1)))
				$start_limit-= $end_limit - ($this->pages + 1);

				$end_limit = $this->pages + 1;

			}

			$dotPrev = $start_limit-5;

			if($dotPrev>0) 

			$links[] = ' <a href="?page='.$dotPrev.$queryURL.'">...</a> ';

			

        for ($j = $start_limit; $j < $end_limit; $j++) {

          if ($this->page == $j) {

            $links[] = ' <a class="selected">'.$j.'</a> '; // If we are on the same page as the current item

          } else {

            $links[] = ' <a href="?page='.$j.$queryURL.'">'.$j.'</a> '; // add the link to the array

          }

        }

		
				$dotNext = $end_limit+4;

				if($dotNext<$this->pages + 1) 

				$links[] = ' <a href="?page='.$dotNext.$queryURL.'">...</a> ';

  		

        // Assign the 'next page' if we are not on the last page

        if ($this->page < $this->pages) {

          $slinks[] = ' <a href="?page='.($this->page + 1).$queryURL.'"> Next &raquo; </a> ';

          if ($this->showFirstAndLast) {

            $slinks[] = ' <a href="?page='.($this->pages).$queryURL.'"> Last &raquo;&raquo; </a> ';

          }

        }

        

        // Push the array into a string using any some glue

        return implode(' ', $plinks).implode($this->implodeBy, $links).implode(' ', $slinks);

      }

      return;

    }

  }

?>

