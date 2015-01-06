<?php $this->load->view('index/header'); ?>

<!-- container -->
<section id="container">
    <div class="container">
        <div class="row">
            <div class="span12">
                <div class="row">
                    <!-- page content -->
                    <section id="page-sidebar" class="alignleft span8">
                        <!-- content -->
                        <div class="row">
                            <div class="span8">
                                <div class="title-divider">
                                    <h3><?php echo $this_cat->typename; ?></h3>
                                    <div class="divider-arrow"></div>
                                </div>
                            </div>
                            <article class="blog-post span8">
                                <div class="block-grey">
                                    <div class="block-light">
                                        <div class="wrapper-img">
                                            <a href="./portfolio2.html"><img src="/static/index/example/blog1.jpg" alt="photo" /></a>
                                        </div>
                                        <div class="wrapper">
                                            <h2 class="post-title"><a href="#">Lorem ipsum</a></h2>
                                            <a href="#" class="blog-comments">3</a>
                                            <p>
                                                Lorem ipsum dolor sit amet, consectetuer adipiscing elit,
                                                sed diam nonummy nibh euismod tdolore mag quam erat volutpat.
                                                <a href="#" class="read-more">[...]</a>
                                            </p>
                                            <p class="tags">
                                                Tags: <a href="#">Science</a>, <a href="#">Technology</a>, <a href="#">News</a>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </article>
                            <article class="blog-post span8">
                                <div class="block-grey">
                                    <div class="block-light">
                                        <div class="wrapper-img">
                                            <a href="./portfolio2.html"><img src="/static/index/example/blog2.jpg" alt="photo" /></a>
                                        </div>
                                        <div class="wrapper">
                                            <h2 class="post-title"><a href="#">Lorem ipsum</a></h2>
                                            <a href="#" class="blog-comments">3</a>
                                            <p>
                                                Lorem ipsum dolor sit amet, consectetuer adipiscing elit,
                                                sed diam nonummy nibh euismod tdolore mag quam erat volutpat.
                                                <a href="#" class="read-more">[...]</a>
                                            </p>
                                            <p class="tags">
                                                Tags: <a href="#">Science</a>, <a href="#">Technology</a>, <a href="#">News</a>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </article>
                            <article class="blog-post span8">
                                <div class="block-grey">
                                    <div class="block-light">
                                        <div class="wrapper">
                                            <h2 class="post-title"><a href="#">Lorem ipsum</a></h2>
                                            <a href="#" class="blog-comments">3</a>
                                            <p>
                                                Lorem ipsum dolor sit amet, consectetuer adipiscing elit,
                                                sed diam nonummy nibh euismod tdolore mag quam erat volutpat.
                                                <a href="#" class="read-more">[...]</a>
                                            </p>
                                            <p class="tags">
                                                Tags: <a href="#">Science</a>, <a href="#">Technology</a>, <a href="#">News</a>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </article>
                        </div>

                    </section>

                    <?php $this->load->view('index/sidebar'); ?>
                    
                </div>
            </div>
        </div>
    </div>
</section>

<?php $this->load->view('index/footer'); ?>