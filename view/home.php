<?php include 'view/header.php'; ?>
<main>
  <img src='images/Kellett_application.jpg' alt='Filling out application' class='center' style='width: 95%;'>
  <div id='quote'>
    <div id='json_quote'></div>
    <div id='json_author'></div>
  </div>
  <div id="home_content">
    <section id='deadline'>
      <div id="sticky_note">
        <h2>Deadline</h2>
        <p>April 10th, 2022</p>
      </div>
    </section>
    <section id='scholarship_info'>
      <h2>About</h2>
      <p>The B. S. T. Smart Scholarship is offered every semester to eligible students (see 'Requirements' below). The committee for the scholarship is
         composed of three members and receives hundreds of applications from students at the end of each semester. The committee awards one scholarship at
         the end of each semester to reimburse tuition paid by the awardee at the beginning of that semester.</p>
      <p>Click the 'Apply' button below to apply now. The application for this semester will be closed after the deadline.</p>
      <br>
      <h2>Requirements</h2>
      <ul>
        <li>Have a 3.2 minimum cumulative GPA</li>
        <li>Taken at least 12 credit hours during the semester</li>
        <li>Must be at most 23 years old at the application date</li>
      </ul>
      <form action='controller.php' method='post'>
        <input type='hidden' name='action' value='show_application'>
        <input type='submit' id='apply_btn' value='Apply' class='center'>
      </form>
    </section>
  </div>
</main>
<?php include 'view/footer.php'; ?>
