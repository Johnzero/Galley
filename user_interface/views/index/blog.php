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
                            <?php if (isset($news)): ?>
                            <?php foreach ($news as $new): ?>
                            <article class="blog-post span8">
                                <div class="block-grey">
                                    <div class="block-light">
                                        <?php if ($new['image']) : ?>
                                        <div class="wrapper-img">
                                            <a href="<?php echo site_url("index/single/{$new['id']}"); ?>"><img src="/static/admin/news/<?php echo $new['image'];?>" alt="photo" /></a>
                                        </div>
                                        <?php endif; ?>
                                        <div class="wrapper">
                                            <h2 class="post-title">
                                                <a href="<?php echo site_url("index/single/{$new['id']}"); ?>"><?php echo $new['title']?></a>
                                                <a href="<?php echo site_url("index/single/{$new['id']}#comments"); ?>" class="single-comments" style="float: right;color:#777777">3</a>
                                            </h2>
                                            <p>
                                                <?php echo $new['introduce'];?>
                                                <a href="<?php echo site_url("index/single/{$new['id']}"); ?>" class="read-more">[...]</a>
                                            </p>
                                            <div class="widget-content">
                                                <p class="tags">
                                                    标签: <a><?php echo $new['addperson']?></a>,
                                                    <?php if( $new['typename'] ) {?> <a><?php echo $new['typename'];?></a>, <?php } ?> 
                                                    <?php if( $new['fromname'] ) {?> <a><?php echo $new['fromname'];?></a>, <?php } ?> 
                                                    <?php if( $new['keysword'] ) {?> <a><?php echo $new['keysword'];?></a><?php } ?> 
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </article>
                            <?php endforeach; ?>
                            <?php endif; ?>
                        </div>

                        <?php echo $this->pagination->create_links(); ?>

                    </section>

                    <?php $this->load->view('index/sidebar'); ?>

                </div>
            </div>
        </div>
    </div>
</section>

<?php $this->load->view('index/footer'); ?>