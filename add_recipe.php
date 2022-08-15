<?php
// Add a recipe to table
$page_title = 'Add Recipe';
include('header.html');

if($_SERVER['REQUEST_METHOD'] == 'POST'){
  $errors = array(); //errors
  require('mysqli_connect.php'); //connect to the db

  if(empty($_POST['name'])){ //if name empty
    $errors[] = 'You forgot to enter a name!';
  } else{ //if name entered
    $name = mysqli_real_escape_string($dbc, trim($_POST['name']));
  }

  if(empty($_POST['instructions'])){ //if instructions empty
    $errors[] = 'You forgot to enter your recipe instructions!';
  } else{ //if instructioins entered
    $instructions = mysqli_real_escape_string($dbc, trim($_POST['instructions']));
  }

  if(empty($_POST['description'])){ //if description empty
    $errors[] = 'You forgot to enter a secription!';
  } else{ //if description entered
    $description = mysqli_real_escape_string($dbc, trim($_POST['description']));
  }

  if(empty($_POST['creator'])){ //if creator empty
    $errors[] = 'You forgot to your name!';
  } else{ //if description entered
    $creator = mysqli_real_escape_string($dbc, trim($_POST['creator']));
  }

  if(empty($errors)){ //if no errors

    //creating query
    $q = "INSERT INTO recipe (recipe_name, recipe_instructions, recipe_description, creator_name) VALUES ('$name', '$instructions', '$description', '$creator')";
    $run = @mysqli_query($dbc, $q); //running query

    if($run){ //if query worked
      echo '<h1>Recipe Added</h1>';
    } else{
      // Public message:
			echo '<h1>System Error</h1>
			<p class="error">You could not be registered due to a system error. We apologize for any inconvenience.</p>';
			// Debugging message:
			echo '<p>' . mysqli_error($dbc) . '<br /><br />Query: ' . $q . '</p>';
    }

  } else{ //if errors exist
    echo '<h1>Error!</h1>
    <p class="error">The following error(s) occurred:<br />';
    foreach ($errors as $msg) { // Print each error.
      echo " - $msg<br />\n";
    }
    echo '</p><p>Please try again.</p><p><br /></p>';
  }
}



?>
<div class="container">
  <form class="" action='add_recipe.php' method="post">
    <p>What is your name? <input class="form-control" type="text" name="creator" maxlength="50" value=""></p>
    <p>Recipe Name <input class="form-control" type="text" name="name" maxlength="20" value=""></p>
    <div class="row">
      <div class="col">
        <p>Please provide recipe instruction!</p><textarea class="form-control" name="instructions" rows="8" cols="80" maxlength="250"></textarea>
      </div>
      <div class="col">
        <p>Please describe your recipe!</p><textarea type="text" class="form-control" name="description" rows="8" cols="80" maxlength="250"></textarea>
      </div>
    </div>
    <br>
    <p><input class="btn btn-primary form-control" type="submit" name="submit" value="Add Recipe"></p>
  </form>
</div>


<?php include('footer.html'); ?>
