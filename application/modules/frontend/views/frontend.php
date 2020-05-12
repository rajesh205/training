<html>
    <head>
        <title><?php echo $setting->title; ?></title>
        <link rel="stylesheet" href="<?php echo site_url('common/site/bootstrap4/css/bootstrap.min.css'); ?>">
        <link href="common/site/fontawesome/css/all.min.css" rel="stylesheet" />
        <link href="common/site/css/animate.css" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="<?php echo site_url('common/site/css/style.css'); ?>">
        <link href="https://fonts.googleapis.com/css?family=Exo:200,300,400,500,600&display=swap" rel="stylesheet">
        <style>
            
        </style>
    </head>
    <body>
        <section id="topheader">
            <div class="row">
                <div class="col-md-6">
                    <font style="">Call Us Today <?php echo $setting->phone; ?></font>
                </div>
                <div class="col-md-6">    
                    <div class="social float-right">
                        <a href="<?php if(!empty($website->facebook)){
                            echo $website->facebook;
                        } else {
                            echo '#';
                        }?>"><i class="fab fa-facebook-f mr-4"></i></a>
                        <a href="<?php if(!empty($website->twitter)){
                            echo $website->twitter;
                        } else {
                            echo '#';
                        }?>"><i class="fab fa-twitter mr-4"></i></a>
                        <a href="<?php if(!empty($website->tumblr)){
                            echo $website->tumblr;
                        } else {
                            echo '#';
                        }?>"><i class="fab fa-tumblr mr-4"></i></a>
                    </div>
                </div>
            </div>
        </section>
        <hr style="margin-top: 10px !important; margin-bottom: 0px !important;">
        <section id="header">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <a class="navbar-brand" href="<?php echo site_url('frontend'); ?>">
                    <img src="<?php echo $setting->login_logoo; ?>" height="60px">
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavDropdown">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item active">
                            <a class="nav-link" href="#home">Home <span class="sr-only">(current)</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#about">About Us</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#features">Features</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#contact">Contact</a>
                        </li>
                    </ul>
                </div>
            </nav>
        </section>
        <section id="home">
            <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                <ol class="carousel-indicators">
                    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                </ol>
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img id="clip" class="d-block w-100" src="<?php if(!empty($website->slider1)){
                            echo $website->slider1;
                        } else {
                            echo 'https://www.kmccgolf.com/images/Business-Meeting.jpg';
                        }?>" alt="First slide">
                    </div>
                    <div class="carousel-item">
                        <img id="clip" class="d-block w-100" src="<?php if(!empty($website->slider2)){
                            echo $website->slider2;
                        } else {
                            echo 'https://www.kmccgolf.com/images/Business-Meeting.jpg';
                        }?>" alt="Second slide">
                    </div>
                    <div class="carousel-item">
                        <img id="clip" class="d-block w-100" src="<?php if(!empty($website->slider3)){
                            echo $website->slider3;
                        } else {
                            echo 'https://www.kmccgolf.com/images/Business-Meeting.jpg';
                        }?>" alt="Third slide">
                    </div>
                </div>
                <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </section>
        <section id="info" style="">
            <div class="container">
                <div class="row">
                    <div class="col-md-3"></div>
                    <div class="col-md-6">
                        <center>
                            <h2 style=""><?php echo lang('wehave'); ?></h2>
                            <hr style="">
                        </center>
                    </div>
                    <div class="col-md-3"></div>
                    <div class="col-md-4">
                        <div class="ielements">
                            <center>
                                <i class="fa fa-book fa-2x" style="padding-bottom: 15px;"></i>
                                <h3><?php echo lang('noc'); ?></h3>
                                <h3>#<?php echo $this->db->get('course')->num_rows() ?></h3>
                            </center>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="ielements">
                            <center>
                                <i class="fa fa-chalkboard-teacher fa-2x" style="padding-bottom: 15px;"></i>
                                <h3><?php echo lang('noi'); ?></h3>
                                <h3>#<?php echo $this->db->get('instructor')->num_rows() ?></h3>
                            </center>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="ielements">
                            <center>
                                <i class="fas fa-user-graduate fa-2x" style="padding-bottom: 15px;"></i>
                                <h3><?php echo lang('nos'); ?></h3>
                                <h3>#<?php echo $this->db->get('student')->num_rows() ?></h3>
                            </center>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section id="about" style="">
            <div id="">
                <div class="space2"></div>
                <div class="container">
                    <div class="row">
                        <div class="space"></div>
                        <div class="col-md-3">
                            <h2 style=""><i class="fas fa-info-circle"></i> <?php echo lang('aboutus'); ?></h2>
                            <hr style="">
                        </div>
                        <div class="col-md-9">
                            <div class="tellSomething animated slideInRight">
                                <p style=""><?php echo $website->about; ?></p>
                            </div>
                        </div>
                        <div class="space"></div>
                    </div>
                </div>
            </div>
        </section>
        <section id="features">
            <div class="container">
                <div class="row">
                    <div class="col-md-3"></div>
                    <div class="col-md-6">
                        <center>
                            <h2 style=""><?php echo lang('featured') . " " . lang('courses'); ?></h2>
                            <hr style="">
                        </center>
                    </div>
                    <div class="col-md-3"></div>
                    <div class="space2"></div>
                    
                        <div class="col-md-4">
                        <div class="felements">
                            <center>
                                <i class="fas fa-book-reader" ></i>
                                <h3><?php echo $website->course1; ?></h3>
                                <p><?php echo $website->course1detail; ?></p>
                            </center>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="felements">
                            <center>
                                <i class="fas fa-book-reader"></i>
                                <h3><?php echo $website->course2; ?></h3>
                                <p><?php echo $website->course2detail; ?></p>
                            </center>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="felements">
                            <center>
                                <i class="fas fa-book-reader"></i>
                                <h3><?php echo $website->course3; ?></h3>
                                <p><?php echo $website->course3detail; ?></p>
                            </center>
                        </div>
                    </div>
                    

                </div>
            </div>
            <div class="space2"></div>
        </section>
        <section id="instructors" style="">
            <div>
                <div class="space2"></div>
                <div class="container">
                    <div class="row">
                        <div class="space"></div>
                        <div class="col-md-3"></div>
                        <div class="col-md-6">
                            <center>
                                <h2 style=""><i class="fas fa-chalkboard-teacher"></i> <?php echo lang('ourtopinstructor'); ?></h2>
                                <hr style="">
                            </center>
                        </div>
                        <div class="col-md-3"></div>
                        
                            <div class="container row tellSomething animated slideInRight">
                                <div class="col-sm-4">
                                    <div class="telements">
                                    <center>
                                        <i class="fa fa-chalkboard-teacher fa-2x" style="padding-bottom: 15px;"></i>
                                        <h3><?php echo $website->instructor1; ?></h3>
                                        <p><?php echo $website->instructor1detail; ?></p>
                                    </center>
                                        </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="telements">
                                    <center>
                                        <i class="fa fa-chalkboard-teacher fa-2x" style="padding-bottom: 15px;"></i>
                                        <h3><?php echo $website->instructor2; ?></h3>
                                        <p><?php echo $website->instructor2detail; ?></p>
                                    </center>
                                </div>
                                    </div>
                                <div class="col-sm-4">
                                    <div class="telements">
                                    <center>
                                        <i class="fa fa-chalkboard-teacher fa-2x" style="padding-bottom: 15px;"></i>
                                        <h3><?php echo $website->instructor3; ?></h3>
                                        <p><?php echo $website->instructor3detail; ?></p>
                                    </center>
                                        </div>
                                </div>
                            
                        </div>
                        <div class="space"></div>
                    </div>
                </div>
            </div>
        </section>
        <section id="footer">
            <div class="space2"></div>
            <div class="container">
                <div class="row">
                    <div class="col-md-3">
                        <img src="<?php echo $setting->login_logoo; ?>" height="70px;">
                        <h5 style=""><?php echo $setting->system_vendor; ?></h5>
                    </div>
                    <div class="col-md-5">
                        <h4 style=""><?php echo lang('stayconnected'); ?></h4>
                        <hr>
                        <a href="<?php if(!empty($website->facebook)){
                            echo $website->facebook;
                        } else {
                            echo '#';
                        }?>"><i class="fab fa-facebook-square fa-3x" style=""></i></a>

                        <a href="<?php if(!empty($website->twitter)){
                            echo $website->twitter;
                        } else {
                            echo '#';
                        }?>"><i class="fab fa-twitter-square fa-3x" style=""></i></a>

                        <a href="<?php if(!empty($website->tumblr)){
                            echo $website->tumblr;
                        } else {
                            echo '#';
                        }?>"><i class="fab fa-tumblr-square fa-3x" style=""></i></a>

                    </div>
                    <div class="col-md-4">
                        <h4 style="color: white; font-weight: lighter"><?php echo lang('contactus'); ?></h4>
                        <hr>
                        <font style=""><?php echo $setting->phone; ?></font><br>
                        <font style=""><?php echo $setting->address; ?></font>
                    </div>
                </div>
            </div>
            <div class="space2"></div>
        </section>
    </body>
    <script src="<?php echo site_url('common/site/js/jquery.min.js'); ?>"></script>
    <script src="<?php echo site_url('common/site/bootstrap4/js/bootstrap.min.js'); ?>"></script>
    <script src="common/site/fontawesome/js/all.min.js"></script>
    <script type="text/javascript" src="<?php echo site_url('common/site/js/style.js'); ?>"></script>
</html>

