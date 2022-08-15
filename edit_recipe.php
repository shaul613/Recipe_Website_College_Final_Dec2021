<?php
// Add a recipe to table
$page_title = 'Edit Recipe';
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

$q = "SELECT recipe_id FROM recipe"; //selecting all recipe ids
$run = @mysqli_query($dbc, $q);
$ids = array();
while($row = mysqli_fetch_array($run, MYSQLI_ASSOC)){ //adding all recipe ids to array
  $ids[] = $row['recipe_id'];
}
if(!in_array($id, $ids)){ //verifying that id in GET is valid
  echo "Don't mess with my wbsite";
  include('footer.html');
  exit();
}

$to_hide = ""; //used to hide form once submitted

$q = "SELECT creator_name, recipe_name, recipe_instructions, recipe_description FROM recipe WHERE recipe_id=$id";
$run = @mysqli_query($dbc, $q); //running Query
$row = mysqli_fetch_array($run, MYSQLI_NUM);

$changes_made = false; //determines if changes were made
$o_creator = mysqli_real_escape_string($dbc, $row[0]); //record before update
$o_name = mysqli_real_escape_string($dbc, $row[1]);
$o_inst = mysqli_real_escape_string($dbc, $row[2]);
$o_desc = mysqli_real_escape_string($dbc, $row[3]);;

if($_SERVER['REQUEST_METHOD'] == 'POST'){
  $errors = array(); //errors

  if(empty($_POST['name'])){ //if name empty
    $errors[] = 'You forgot to enter a name!';
  } else{ //if name entered
    $name = mysqli_real_escape_string($dbc, trim($_POST['name']));
    if($name != $o_name){ //if changes were made
      $changes_made = true;
      echo $o_name;
    }
  }

  if(empty($_POST['instructions'])){ //if instructions empty
    $errors[] = 'You forgot to enter your recipe instructions!';
  } else{ //if instructioins entered
    $instructions = mysqli_real_escape_string($dbc, trim($_POST['instructions']));
    if($instructions != $o_inst){ //if changes were made
      $changes_made = true;
    }
  }

  if(empty($_POST['description'])){ //if description empty
    $errors[] = 'You forgot to enter a secription!';
  } else{ //if description entered
    $description = mysqli_real_escape_string($dbc, trim($_POST['description']));
    if($description != $o_desc){ //if changes were made
      $changes_made = true;
    }
  }

  if(empty($_POST['creator'])){ //if creator empty
    $errors[] = 'You forgot to your name!';
  } else{ //if description entered
    $creator = mysqli_real_escape_string($dbc, trim($_POST['creator']));
    if($creator != $o_creator){ //if changes were made
      $changes_made = true;
    }
  }

  if(!$changes_made){ //adding error if no changes were made
    $errors[] = "No changes were made!";
  }

  if(empty($errors)){ //if no errors
    //creating query
    $q = "UPDATE recipe SET recipe_name='$name', recipe_instructions='$instructions', recipe_description='$description', creator_name='$creator' WHERE recipe_id=$id LIMIT 1";
    $run = @mysqli_query ($dbc, $q);

    if (mysqli_affected_rows($dbc) == 1) { //is query ran, hiding table with JS and dispaying message
      $to_hide = 'hide';
      echo '<p>Recipe Updated</p>';
      echo '<a href="view_all_recipies.php">Back to all recipies</a>';
    } else { //if did not run
      echo '<p class="error">The user could not be edited due to a system error. We apologize for any inconvenience.</p>'; // Public message.
      echo '<p>' . mysqli_error($dbc) . '<br />Query: ' . $q . '</p>';
    }

  } else{ //if fields empty
    echo '<h1>Error!</h1>
    <p class="error">The following error(s) occurred:<br />';
    foreach ($errors as $msg) {
      echo " - $msg<br />\n";
    }
    echo '</p><p>Please try again.</p><p><br /></p>';
  }
}

?>

<div class="container">
  <!-- i use php to add hiding class once the recipe is updated -->
  <form id="edit_record" class="<?php echo $to_hide ?>" action='edit_recipe.php' method="post">
    <p>What is your name? <input class="form-control" type="text" name="creator" maxlength="50" value="<?php echo $row[0]; ?>"></p>
    <p>Recipe Name <input class="form-control" type="text" name="name" maxlength="20" value="<?php echo $row[1]; ?>"></p>
    <div class="row">
      <div class="col">
          <p>Please provide recipe instruction!</p><textarea class="form-control" name="instructions" rows="8" cols="80" maxlength="250" value=""><?php echo $row[2]; ?></textarea>
      </div>
      <div class="col">
        <p>Please describe your recipe!</p><textarea class="form-control" name="description" rows="8" cols="80" maxlength="250" value=""><?php echo $row[3]; ?></textarea>
      </div>
    </div>
    <br>
    <p><input class="btn btn-primary form-control" type="submit" name="submit" value="Update Recipe"></p>
    <input type="hidden" name="id" value="<?php echo $id ?>" />
  </form>
</div>


<?php include('footer.html'); ?>
