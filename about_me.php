<?php
// Add a recipe to table
$page_title = 'About Me';
include('header.html');
?>

<div class="about_me container">
  <h1>About Me</h1>
  <p>This is Shaul Lifschitz</p>
  <p>Click button to view next image ----> <button onclick="nextImg()" type="button" name="button" class="btn btn-primary">Next</button></p>
  <figure id="my_photo_one" class="figure" style="display: block;">
    <img src="me.jpg" alt="me">
    <figcaption class="figure-caption">Studying at Hewlett Public Library on October 19, 2021.</figcaption>
  </figure>
  <figure id="my_photo_two" class="figure" style="display: none;">
    <img src="me2.jpg" alt="me">
    <figcaption class="figure-caption">Studying outdoors due to covid. Location: New York Public Library.</figcaption>
  </figure>
  <figure id="my_photo_three" class="figure" style="display: none;">
    <img src="me3.jpg" alt="me">
    <figcaption class="figure-caption">Shaul flashing his code.</figcaption>
  </figure>

</div>

<script type="text/javascript">
  function nextImg(){ //switching images when button clicked
    var one = document.getElementById("my_photo_one");
    var two = document.getElementById("my_photo_two");
    var three = document.getElementById("my_photo_three");
    if(one.style.display === "block"){
      one.style.display = "none";
      two.style.display = "block";
    } else if(two.style.display === "block"){
      two.style.display = "none";
      three.style.display = "block";
    } else{
      three.style.display = "none";
      one.style.display = "block";
    };
  };
</script>


<?php include('footer.html'); ?>
