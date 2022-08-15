<?php
// View all recipies
$page_title = 'View Recipies'; //title
include('header.html');
require('mysqli_connect.php');

//determining how to sort results
if(isset($_GET['order_by'])){
  $sort = $_GET['order_by'];
} else{
  $sort = 'date_added';
}

//defining limits
$display = 3; //the number of results to display
$q = "SELECT COUNT(recipe_id) FROM recipe"; //counting records
$run = @mysqli_query ($dbc, $q);
$row = @mysqli_fetch_array ($run, MYSQLI_NUM);
$records = $row[0];

// calculate number of pages
if ($records > $display) {
	$pages = ceil ($records/$display);
} else {
	$pages = 1;
}

// determining current page
if(isset($_GET['s'])) {
	$start = $_GET['s'];
} else {
	$start = 0;
}

//selecting recipes
$q = "SELECT recipe_id, recipe_name, recipe_instructions, recipe_description, creator_name, date_added FROM recipe ORDER BY $sort LIMIT $start, $display";
$run = @mysqli_query($dbc, $q); //running Query

if ($run) { // If query works

  echo '<div class="text-center"><p>Click on a column to sort!</p></div>'; //informing the user about sorting
  //(I use an escape for creator's name)
	echo '<table class="table">
	<tr>
    <td align="left"><b><a href="?order_by=recipe_name">Recipe Name</a></b></td>
    <td align="left"><b><a href="?order_by=recipe_instructions">Recipe Instructions</a></b></td>
    <td align="left"><b><a href="?order_by=recipe_description">Recipe Description</a></b></td>
    <td align="left"><b><a href="?order_by=creator_name">Creator\'s name</a></b></td>
    <td align="left"><b><a href="?order_by=date_added">Date Added</a></b></td>
    <td align="left"><b>Edit</b></td>
    <td align="left"><b>Delete</b></td>
  </tr>';

	// displaying records in table
	while ($row = mysqli_fetch_array($run, MYSQLI_ASSOC)) {
		echo '<tr>
      <td align="left">'.$row['recipe_name'].'</td>
      <td align="left">'.$row['recipe_instructions'].'</td>
      <td align="left">'.$row['recipe_description'].'</td>
      <td align="left">'.$row['creator_name'].'</td>
      <td align="left">'.$row['date_added'].'</td>
      <td align="left"><a href="edit_recipe.php?id='.$row['recipe_id'].'">Edit</a></td>
      <td align="left"><a href="delete_recipe.php?id='.$row['recipe_id'].'">Delete</a></td>
    </tr>';
	}

	echo '</table>'; // Close the table

	mysqli_free_result ($run); // Free up the resources

} else { // if did not run

	// Public message:
	echo '<p class="error">The current users could not be retrieved. We apologize for any inconvenience.</p>';
	// Debugging message:
	echo '<p>' . mysqli_error($dbc) . '<br /><br />Query: ' . $q . '</p>';

}

if ($pages > 1) { //if more than 1 page
	$current_page = ($start/$display) + 1; //the current page
  echo '<br/><div class="container"><ul class="pagination">';
	if ($current_page != 1) { //displaying previos link if not page 1
		echo '<li class="page-item"><a class="page-link" href="?s='.($start - $display).'">Previous</a></li>';
	}

	for ($i = 1; $i <= $pages; $i++) { //diaplaying links to all pages
		if ($i != $current_page) {
			echo '<li class="page-item"><a class="page-link" href="?s=' . ($display * ($i - 1)) .'">' . $i . '</a></li>';
		} else {
			echo '<li class="page-item disabled"><a class="page-link">'.$i.'</a></li>';
		}
	}

	if ($current_page != $pages) { //displaying next link if not last page
		echo '<li class="page-item"><a class="page-link" href="?s=' . ($start + $display) . '&p=' . $pages . '">Next</a></li>';
	}
  echo '</ul></div>';
}

include('footer.html'); ?>
