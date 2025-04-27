<?php
session_start();
if (!isset($_SESSION['last_name'])) {
  header("Location: signin.html");
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>RoamReady - Account</title>
  <link rel="stylesheet" href="Accountstyle.css" />
  <link href="https://cdn.jsdelivr.net/npm/remixicon@3.2.0/fonts/remixicon.css" rel="stylesheet" />
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
  <a href="#main-content" class="skip-link">Skip to main content</a>
  
  <nav class="section_container nav__container">
    <div class="nav__logo">
      <img src="placeholderlogo.png" alt="RoamReady Logo">
      <span>RoamReady</span>
    </div>
    <ul class="nav__links">
      <li class="link"><a href="index.html">Home</a></li>
      <li class="link"><a href="account.php">Itineraries</a></li>
      <li class="link"><a href="places.html">Destinations</a></li>
      <li class="link"><a href="signin.html">Log In</a></li>
      <li class="link"><a href="logout.php">Logout</a></li>
    </ul>
  </nav>

  <header class="section_container" id="main-content">
    <h1>Welcome to Your Itinerary Dashboard</h1>
    <p>Manage your saved trips, plan future adventures, and explore recommendations.</p>
      
    <div class="id__card">
        <img src="human.jpg" alt="user profile picture">
        <div class="id__card_text">
        <h1 id="user-name"><?php echo htmlspecialchars($_SESSION['last_name']); ?></h1>
        <h4>Length of Stay:</h4>
        <p id="trip-duration">14 days</p>
        <h4>Number of Guests:</h4>
        <p id="trip-guests">4</p>
        </div>
    </div>
  </header>

  <!-- Trip Customization Form -->
  <section class="section__container trip-form__container">
    <h2 class="section__title">Plan Your Trip</h2>
    <form id="trip-form" class="trip-form">
      <div class="form-group">
        <label for="trip-title">Trip Title:</label>
        <input type="text" id="trip-title" required aria-required="true">
      </div>
      <div class="form-group">
        <label for="destination">Destination:</label>
        <input type="text" id="destination" required aria-required="true">
      </div>
      <div class="form-row">
        <div class="form-group">
          <label for="start-date">Start Date:</label>
          <input type="date" id="start-date" required aria-required="true">
        </div>
        <div class="form-group">
          <label for="end-date">End Date:</label>
          <input type="date" id="end-date" required aria-required="true">
        </div>
      </div>
      <div class="form-group">
        <label for="guests">Number of Guests:</label>
        <input type="number" id="guests" min="1" value="1" aria-label="Number of guests">
      </div>
      <button type="submit" class="btn">Save Trip Details</button>
    </form>
  </section>

  <!-- Actual Itinerary -->
  <div class="itinerary-destinations-container">
    <section class="section__container places__container">
      <h2 class="section__title">Your Itinerary</h2>
      
      <div class="add-destination">
        <div class="form-group">
          <label for="newDestination" class="sr-only">Activity name</label>
          <input type="text" id="newDestination" placeholder="Activity name" required aria-required="true">
        </div>
        <div class="form-group">
          <label for="destinationLink" class="sr-only">Booking URL</label>
          <input type="text" id="destinationLink" placeholder="Booking URL (optional)">
        </div>
        <div class="form-group">
          <label for="activity-date" class="sr-only">Activity date</label>
          <input type="date" id="activity-date" aria-label="Activity date">
        </div>
        <div class="form-group">
          <label for="activity-time" class="sr-only">Activity time</label>
          <input type="time" id="activity-time" aria-label="Activity time">
        </div>
        <button id="add-activity-btn" class="btn">Add Activity</button>
      </div>
      
      <ul class="places__list" id="itinerary-list">
        <!-- Default items remain -->
        <li><a href="https://www.tripadvisor.com/AttractionProductReview-g612474-d15140529-Icacos_Island_All_Inclusive_Snorkel_and_Boat_Tour-Fajardo_Puerto_Rico.html" target="_blank">
          <i class="ri-sailboat-fill"></i>Icacos Island All-Inclusive Snorkel and Boat Tour</a>
          <button type="button" class="remove-activity" data-id="123">Remove</button>
          <button type="button" class="edit-activity" data-id="123">Edit</button>
        </li>
        <li><a href="https://www.tripadvisor.com/AttractionProductReview-g1675690-d11482564-Mixology_Class_at_Casa_BacardI_in_Puerto_Rico-Catano_Puerto_Rico.html" target="_blank">
          <i class="ri-roadster-fill"></i>Mixology Class at Casa Bacardi (21+)</a>
         <button type="button" class="remove-activity" data-id="123">Remove</button>
          <button type="button" class="edit-activity" data-id="123">Edit</button>
        </li>
      </ul>
    </section>

    <section class="section__container holiday__container">
      <h2 class="section__title">Popular Destinations</h2>

      <div class="slideshow__container">
        <div class="mySlides fade">
          <div class="numbertext">1 / 3</div>
          <a href="https://www.tripadvisor.com/AttractionProductReview-g612474-d17418672-Half_Day_El_Yunque_Rainforest_and_Waterslide_Guided_Tour-Fajardo_Puerto_Rico.html">
            <img src="puertoricoimage.jpg" alt="El Yunque Rainforest" style="width:100%">
            <div class="text">El Yunque Rainforest</div>
          </a>
        </div>
    
        <div class="mySlides fade">
          <div class="numbertext">2 / 3</div>
          <a href="https://www.tripadvisor.com/AttractionProductReview-g612474-d11450364-Icacos_Deserted_Island_Catamaran_Snorkel_and_Picnic_Cruise-Fajardo_Puerto_Rico.html">
            <img src="bahamasimage.jpg" alt="Icacos Deserted Island" style="width:100%">
            <div class="text">Icacos Deserted Island</div>
          </a>
        </div>

        <div class="mySlides fade">
          <div class="numbertext">3 / 3</div>
          <a href="https://www.tripadvisor.com/AttractionProductReview-g612474-d17418672-Half_Day_El_Yunque_Rainforest_and_Waterslide_Guided_Tour-Fajardo_Puerto_Rico.html">
            <img src="thailandimage.jpg" alt="Bio Bay" style="width:100%">
            <div class="text">Bio Bay</div>
          </a>
        </div>

        <a class="prev" onclick="plusSlides(-1)" aria-label="Previous slide">❮</a>
        <a class="next" onclick="plusSlides(1)" aria-label="Next slide">❯</a>
      </div>

      <div style="text-align:center">
        <span class="dot" onclick="currentSlide(1)" aria-label="Go to slide 1"></span> 
        <span class="dot" onclick="currentSlide(2)" aria-label="Go to slide 2"></span> 
        <span class="dot" onclick="currentSlide(3)" aria-label="Go to slide 3"></span> 
      </div>
    </section>
  </div>

  <!-- Recommendations Section -->
  <section class="section__container recommendations__container">
    <h2 class="section__title">Recommended For You</h2>
    <div id="recommendations" class="recommendations-grid">
      <!-- Recommendations will be loaded here -->
      <div class="recommendation-card">
        <img src="puertoricoimage.jpg" alt="El Yunque Rainforest">
        <h3>El Yunque Rainforest</h3>
        <p>Explore the only tropical rainforest in the U.S. National Forest System</p>
        <a href="https://www.tripadvisor.com/AttractionProductReview-g612474-d17418672-Half_Day_El_Yunque_Rainforest_and_Waterslide_Guided_Tour-Fajardo_Puerto_Rico.html" class="btn">Learn More</a>
      </div>
      <div class="recommendation-card">
        <img src="bahamasimage.jpg" alt="Icacos Island">
        <h3>Icacos Island</h3>
        <p>Enjoy a day of snorkeling and relaxation on this deserted island</p>
        <a href="https://www.tripadvisor.com/AttractionProductReview-g612474-d11450364-Icacos_Deserted_Island_Catamaran_Snorkel_and_Picnic_Cruise-Fajardo_Puerto_Rico.html" class="btn">Learn More</a>
      </div>
    </div>
  </section>

  <footer class="section_container footer__container">
    <p class="section__header">Our Team</p>
    <h2 class="section__title">Contact Us</h2>
    <div class="socialmedia">
      <span><i class="ri-facebook-box-fill" aria-label="Facebook"></i></span>
      <span><i class="ri-twitter-fill" aria-label="Twitter"></i></span>
      <span><i class="ri-instagram-fill" aria-label="Instagram"></i></span>
      <span><i class="ri-linkedin-box-fill" aria-label="LinkedIn"></i></span>
      <span><i class="ri-youtube-fill" aria-label="YouTube"></i></span>
    </div>
    <p class="description">Here to help with all your travel and buddy needs.</p>
  </footer>

  <script src="itinerary.js"></script>
  <script src="slidingimages.js"></script>
</body>
</html>