<?php include 'includes/header.php'; ?>

<div class="breadcrumbs">
    <div class="container">
        <ul>
            <li><a href="index.php">Главная</a></li>
            <li><span class="separator">/</span></li>
            <li><span class="current">Как это работает</span></li>
        </ul>
    </div>
</div>

<!-- FILTERS -->
<section style="background-size:cover; background-position: center center;">
    <div class="container">
        <div class="filter-buttons text-center">
            <a href="mission.php" class="filter-item">Миссия</a>
            <a href="howitworks.php" class="filter-item active">Как это работает</a>
            <a href="about_teacher.php" class="filter-item">О преподавателе</a>
            <a href="reviews.php" class="filter-item">Отзывы</a>
        </div>
        <h4 class="text-center" style="color: red">В разработке...</h4>
    </div>
</section>

    <!-- START TEACHERS AND STUDENTS -->
<section class="teachersstudents section-padding" style="background-image: url(assets/img/bg/section-2.jpg);  background-size:cover; background-position: center center;">
<div class="container">
    <div class="row">
            <div class="col-lg-4 col-sm-6 col-xs-12 wow fadeInUp">
                <div class="single_ts student-card" data-animate="student">
                    <div class="single_ts_img">
                        <img src="assets/img/student1.svg" class="img-fluid" alt="student-image" />
                    </div>
                    <h4>Ученикам</h4>
                </div>
            </div><!-- END COL -->
            <div class="col-lg-4 col-sm-6 col-xs-12 wow fadeInUp">
                <div class="single_ts teacher-card" data-animate="teacher">
                    <div class="single_ts_img">
                        <img src="assets/img/teacher1.svg" class="img-fluid" alt="teacher-image" />
                    </div>
                    <h4>Учителям</h4>
                </div>
            </div><!-- END COL -->
        </div><!--- END ROW -->
</div><!--- END CONTAINER -->
</section>
<!-- END TEACHERS AND STUDENTS -->


<?php include 'includes/footer.php'; ?>
