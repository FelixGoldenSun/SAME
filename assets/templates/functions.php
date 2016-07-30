<?php
/**
 * Created by PhpStorm.
 * User: benajminw5409
 * Date: 10/12/2015
 * Time: 10:21 AM
 */

function selectMenu($list, $selected){
  $menu = "<select name='product'>";
  foreach($list as $key => $value){
    $menu .= "\t<option value='$value'";
    if ($selected == $value){
      $menu .= " selected";
    }
    $menu .= ">$key</option>";
  }

  $menu .= "</select>";
  return $menu;
}

function miniCalendar($month, $year){
  $date = new DateTime();
  $current_year = $date->format('Y');
  $current_month = $date->format('m');
  $current_day = $date->format('d');

  if((int)$month <= 0 || (int)$month > 12){
    $month = $date->format('m');
  }

  if((int)$year <= 0 || (int)$year > 9999){
    $year = $date->format('Y');
  }

  $prev_month = $month - 1;
  $prev_year = $year;
  if($prev_month < 1){
    $prev_month = 12;
    $prev_year -= 1;
  }

  $next_month = (int)$month + 1;
  $next_year = (int)$year;
  if($next_month > 12){
    $next_month = 1;
    $next_year += 1;
  }

  $date->setDate($year, $month, 1);
  $prev_month_date = new DateTime();
  $prev_month_date->setDate($year, $prev_month, 1);
  $first_day = $date->format("w");
  $last_day = $date->format("t");
  $prev_month_last_day = $prev_month_date->format("t");
  $prev_month_last_day -= $first_day - 1;

  $calendar_string = "<div id='calendar_heading'>";
  $calendar_string .= "<a href='/calendar.php?month=$prev_month&year=$prev_year' class='calendar_link'>Prev</a>";
  $calendar_string .= "<a href='/calendar.php?month=$next_month&year=$next_year' class='calendar_link'>Next</a>\n";
  $calendar_string .= "<h2 id='calendar_h2'>" . $date->format("F") . ", " . $year . "</h2>\n";
  $calendar_string .= "</div>";
  $calendar_string .= "<table id='calendar_table'>\n";
  $calendar_string .= "\t<tr>\t<td>Su</td>\n\t<td>Mo</td>\n\t<td>Tu</td>\n\t<td>We</td>\n\t<td>Th</td>\n\t<td>Fr</td>\n\t<td>Sa</td>\n\t</tr>";
  $count = 0;
  $day = 1;
  $row = 0;
  $next_month_days = 1;

  while ($count < 42){ //Creates days
    if($count == $row){
      $calendar_string .= "<tr>\n";
      $row += 7;
    }

    if($count < $first_day){ //greyed out days of the previous month
      $calendar_string .= "\t<td class='other_days'>$prev_month_last_day</td>\n";
      $prev_month_last_day += 1;
    }
    elseif($first_day == 0){ //if a month has 0 first days (like september)
      $no_first_day_count = 0;
      $prev_month_last_day -= 7;

      while ($no_first_day_count < 7){
        $calendar_string .= "\t<td class='other_days'>$prev_month_last_day</td>\n";
        $no_first_day_count += 1;
        $prev_month_last_day += 1;
      }
      $first_day = 7;
      $count = 6;
    }
    elseif( $count >= $first_day && $count < (int) $last_day  + (int) $first_day){ //all the days of the month
      if($current_year == $year && $current_month == $month && $current_day == $day){
        $calendar_string .= "\t<td id='current_day'>$day</td>\n";
      }
      else{
        $calendar_string .= "\t<td>$day</td>\n";
      }
      $day += 1;
    }
    elseif($count > $last_day){ //grayed out days of the next month
      $calendar_string .= "\t<td class='other_days'>$next_month_days</td>\n";
      $next_month_days += 1;
    }

    $count += 1;

    if($count == $row){
      $calendar_string .= "</tr>\n";
    }
  }

  $calendar_string .= "</table>\n";
  return $calendar_string;
}

function product_form($form_type, $product_id, $name, $description, $price, $cost, $qty, $category)
{
  if ($form_type == "new"){
    $action = "/product_new.php";
    $button_value = "create new product";
  }elseif($form_type == "edit"){
    $action = "/product_edit.php?product_id=$product_id ";
    $button_value = "update product";
  }
  // language="HTML"
  $form = <<<END_OF_FORM
        <div id="error_explanation">
          <h2>Validation Errors</h2>
          <ul>
          </ul>
        </div>
        <form method="post" action="$action" id="data_form">
        <div>
            <label for="name">Product Name</label>
            <input id="name" name="name" type="text" value="$name" placeholder="Name">
        </div>
        <div>
            <label for="description">Description</label>
            <textarea name="description"  id="description" placeholder="Description">$description</textarea>
        </div>
        <div>
            <label for="price">Price </label>
            <input id="price" name="price" type="number" value="$price" step="0.01">
        </div>
        <div>
            <label for="cost">Cost </label>
            <input id="cost" name="cost" type="number" value="$cost" step="0.01">
        </div>
        <div>
            <label for="qty">Qty </label>
            <input id="qty" name="qty" type="number" value="$qty">
        </div>
        <div>
            <label for="category">Category</label>
            <input id="category" name="category" type="text" value="$category" placeholder="Category">
        </div>


        <input type="submit" name="submit" value="$button_value">

        </form>


END_OF_FORM;
  return $form;
}

function articles_form($form_type, $article_id, $title, $author, $article_text, $date_posted)
{
  if ($form_type == "new"){
    $action = "/article_new.php";
    $button_value = "Create new article";
  }elseif($form_type == "edit"){
    $action = "/article_edit.php?article_id=$article_id ";
    $button_value = "Update article";
  }

  // language="HTML"
  $form = <<<END_OF_FORM
        <div id="error_explanation">
          <h2>Validation Errors</h2>
          <ul>
          </ul>
        </div>
        <form method="post" action="$action" id="data_form">
        <div>
          <label for="title">Title</label>
          <input id="title" name="title" type="text" value="$title" placeholder="Title">
        </div>
        <div>
          <label for="author">Author</label>
          <input id="author" name="author" type="text" value="$author" placeholder="Author Name">
        </div>
        <div>
          <label for="article_text">Article Text</label><br>
          <textarea name="article_text" id="article_text" placeholder="Put text here">$article_text</textarea>
        </div>
        <div>
          <label for="date_posted">Date Posted</label><br>
          <input id="date_posted" name="date_posted" type="date" value="$date_posted" placeholder="yyyy-mm-dd"><br>
        </div>

        <input type="submit" name="form_submit" value="$button_value">

        </form>


END_OF_FORM;
  return $form;
}

function blog_form($form_type, $blog_id, $title, $author, $date_posted, $blog_text)
{
  if ($form_type == "new"){
    $action = "/blog_new.php";
    $button_value = "Create new blog entry";
  }elseif($form_type == "edit"){
    $action = "/blog_edit.php?blog_id=$blog_id";
    $button_value = "Update blog entry";
  }

  // language="HTML"
  $form = <<<END_OF_FORM
        <div id="error_explanation">
          <h2>Validation Errors</h2>
          <ul>
          </ul>
        </div>
        <form method="post" action="$action" id="data_form">
        <div>
          <label for="title">Title</label>
          <input id="title" name="title" type="text" value="$title" placeholder="Title">
        </div>
        <div>
          <label for="author">Author</label>
          <input id="author" name="author" type="text" value="$author" placeholder="Author Name">
        </div>
        <div>
          <label for="date_posted">Date Posted</label><br>
          <input id="date_posted" name="date_posted" type="date" value="$date_posted" placeholder="yyyy-mm-dd"><br>
        </div>
        <div>
          <label for="blog_text">Blog Text</label><br>
          <textarea name="blog_text" id="blog_text" placeholder="Put text here">$blog_text</textarea>
        </div>

        <input type="submit" name="form_submit" value="$button_value">

        </form>


END_OF_FORM;
  return $form;
}

function comments($id, $hidden_name, $action, $submit_value){

  // language="HTML"
  $comment_form =<<<END_OF_COMMENT_FORM
        <div id="error_explanation">
          <h2>Validation Errors</h2>
          <ul>
          </ul>
        </div>
         <form method="post" action="$action"  id="data_form">
         <input type="hidden" name="$hidden_name" value="$id">
         <div>
            <label for="author" class="comment_labels">Author</label>
            <input id="author" type="text" name="author" placeholder="Author">
         </div>
         <div>
            <label for="text" class="comment_labels">Content</label>
            <textarea id="text" name="text" placeholder="Content"></textarea>
         </div>
         <div>
            <select name="rating">
              <option>1</option>
              <option>2</option>
              <option>3</option>
              <option>4</option>
              <option>5</option>
            </select><br>
         </div>

            <input type="submit" name="post" value="$submit_value">

          </form>

END_OF_COMMENT_FORM;

  return $comment_form;

}




?>
 
 