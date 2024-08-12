<nav class="sidebar sidebar-offcanvas" id="sidebar">
  <ul class="nav">
    <li class="nav-item nav-profile">
      <a href="#" class="nav-link">
        <div class="profile-image">
          <img class="img-xs rounded-circle" src="images/faces/face8.jpg" alt="profile image">
          <div class="dot-indicator bg-success"></div>
        </div>
        <div class="text-wrapper">
          <?php
          $uid = $_SESSION['sturecmsuid'];
          $sql = "SELECT * from tblstudent where ID=:uid";

          $query = $dbh->prepare($sql);
          $query->bindParam(':uid', $uid, PDO::PARAM_STR);
          $query->execute();
          $results = $query->fetchAll(PDO::FETCH_OBJ);

          $cnt = 1;
          if ($query->rowCount() > 0) {
            foreach ($results as $row) {               ?>
              <p class="profile-name"><?php echo htmlentities($row->StudentName); ?></p>
              <p class="designation"><?php echo htmlentities($row->StudentEmail); ?></p><?php $cnt = $cnt + 1;
                                                                                      }
                                                                                    } ?>
        </div>

      </a>
    </li>
    <li class="nav-item nav-category">
      <span class="nav-link">Dashboard</span>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="dashboard.php">
        <span class="menu-title">Dashboard</span>
        <i class="icon-screen-desktop menu-icon"></i>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-toggle="collapse" href="#ui-basic2" aria-expanded="false" aria-controls="ui-basic2">
        <span class="menu-title">Assignments</span>
        <i class="icon-layers menu-icon"></i>
      </a>
      <div class="collapse" id="ui-basic2">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item"> <a class="nav-link" href="view-assignment.php">Assignments</a></li>
        </ul>
      </div>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-toggle="collapse" href="#ui-basic3" aria-expanded="false" aria-controls="ui-basic3">
        <span class="menu-title">Exams</span>
        <i class="icon-layers menu-icon"></i>
      </a>
      <div class="collapse" id="ui-basic3">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item"> <a class="nav-link" href="subject-mark.php">Exam Marks</a></li>
        </ul>
      </div>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="view-notice.php">
        <span class="menu-title">View Notice</span>
        <i class="icon-book-open menu-icon"></i>
      </a>
    </li>
     <li class="nav-item">
      <a class="nav-link" href="chat.php">
        <span class="menu-title">Group chat</span>
        <i class="icon-bubble menu-icon"></i>
      </a>
    </li>

  </ul>
</nav>