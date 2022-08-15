<?php
// Add a recipe to table
$page_title = 'Delete Recipe';
include('header.html');

if(isset($_GET['id'])){ //making sure the page was accessed from table
  $id = $_GET['id'];
} elseif(isset($_POST['id'])){
  $id = $_POST['id'];
} else{
  echo '<h1>Error: Page accessed by error</h1>';
  include('footer.html');
  exit();
}

require('mysqli_connect.php'); //connecting database

$to_hide = ""; //hides form after submission
$q = "SELECT recipe_name FROM recipe WHERE recipe_id=$id";
$run = @mysqli_query($dbc, $q);

$recipe_name = mysqli_fetch_array($run, MYSQLI_ASSOC)['recipe_name'];

if($_SERVER['REQUEST_METHOD'] == 'POST'){
  $q = "DELETE FROM recipe WHERE recipe_id=$id";
  $run = @mysqli_query($dbc, $q);

  if($run){ //if query ran
    $to_hide = 'hide';
    echo "<h1>Recipe $recipe_name deleted</h1>";
    echo "<p><a href='view_all_recipies.php'>Back to all recipies</a></p>";
  } else{
    echo "<h1>Error! Could not delete recipe</h1>";
    echo '<p>' . mysqli_error($dbc) . '<br /><br />Query: ' . $q . '</p>';
  }
}
?>

<div class="container">
  <!-- i use php to add hiding class once the recipe is updated -->
  <form class="<?php echo $to_hide ?>" action="delete_recipe.php" method="post">
    <p>Are you sure you want to delete the following recipe? <b>'<?php echo $recipe_name ?>'.</b></p>
    <p> <input class="btn btn-primary" type="submit" name="submit" value="Delete"> <a href="view_all_recipies.php">Cancel</a> </p>
    <input type="hidden" name="id" value="<?php echo $id; ?>">
  </form>
</div>



<?php include('footer.html'); ?>
