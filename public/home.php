<?php

session_start();




?>

<!DOCTYPE html>
<html lang="en">

<?php include('public/includes/head.php'); ?>

<body>
  <?php include('public/includes/nav.php'); ?>
  <div class="main-content">
    <div class="home-wrapper">
      <section class="home-main-content">
        <div class="top-section">
          <div class="tagline">
            <h1>Taskify Is Now <span>Available</span> To Use!</h1>
            <h3>Make Your Life Less Complicated</h3>
            <div class="tagline-button-container">
              <a class="tour" href="index.php"><i class="fas fa-cogs"></i> Take Tour</a>
              <a class="signup" href="register.php"><i class="fas fa-user"></i> Sign Up</a>
            </div>
          </div>
          <div class="content-carousel">
            <div class="dots-container">
              <div data-id="0" class="dot dot-active"></div>
              <div data-id="1" class="dot"></div>
              <div data-id="2" class="dot"></div>
            </div>
            <div class="carousel-item c1 ">
              <h3>Lorem ipsum dolor sit amet consectetur</h3>
              <img src="public/images/home-1.jpg" alt="productivity" />
              <p>perspiciatis accusantium animi a nisi aliquam.</p>
            </div>
            <div class="carousel-item c2 hidden">
              <h3>Repellendus alias temporibus quam voluptas cupiditate</h3>
              <img src="public/images/home-2.jpg" alt="productivity" />
              <p>Nesciunt molestias amet id sit est, nisi cumque culpa.</p>
            </div>
            <div class="carousel-item c3 hidden">
              <h3>perspiciatis accusantium animi a nisi aliquam</h3>
              <img src="public/images/home-3.jpg" alt="productivity" />
              <p>Lorem ipsum dolor sit amet consectetur</p>
            </div>
          </div>
        </div>
        <div class="about-information">
          <div class="about-header">
            <h2>Taskify Can Help You In Many Ways</h2>
            <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Totam temporibus cumque placeat quia ab excepturi.</p>
          </div>
          <div class="pain-points">
            <div class="pain-point no-time hidden">
              <h3>Never Enough Time?</h3>
              <div class="paint-point-content">
                <i class="far fa-clock"></i>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Eum expedita fugiat nemo vitae aspernatur ratione suscipit. Aspernatur iusto aliquid minima, quo doloremque ea culpa, dolores porro velit inventore modi laboriosam.</p>
              </div>
            </div>
            <div class="pain-point productivity hidden">
              <h3>Get Things Done</h3>
              <div class="paint-point-content">
                <i class="far fa-list-alt"></i>
                <p>sunt vitae quos laboriosam ab beatae. Tenetur omnis asperiores saepe eos blanditiis assumenda. Lorem ipsum dolor, sit amet consectetur adipisicing elit. Iusto alias sequi quaerat quod dolorem veniam, magnam consequatur architecto exercitationem accusantium.</p>
              </div>
            </div>
            <div class="pain-point family hidden">
              <h3>Family Time Is Important</h3>
              <div class="paint-point-content">
                <i class="fas fa-users"></i>
                <p> deleniti vel iure dolorum dolores? Vel eius facere quas s expedita ab veritatis reiciendis praesentium repellat aut vitae mollitia quos eos a dolore at harum impedit quasi! Odit atque et veritatis corrupti ratione facilis alias itaque libero earum?</p>
              </div>
            </div>
          </div>
        </div>
        <h2 class="contact">Get In Touch</h2>
        <div class="social">
          <a href="#"><i class="fab fa-facebook"></i></a>
          <a href="#"><i class="fab fa-twitter"></i></a>
          <a href="#"><i class="fab fa-instagram"></i></a>
          <a href="#"><i class="far fa-envelope"></i></a>

        </div>
      </section>
    </div>
  </div>
  <?php include('public/includes/footer.php'); ?>
  <script src="public/js/index.js"></script>
</body>

</html>