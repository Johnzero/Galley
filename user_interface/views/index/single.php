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
                                    <h3><?php echo $single->title; ?></h3>
                                    <div class="divider-arrow"></div>
                                </div>
                            </div>
                            <article class="blog-post span8">
                                <div class="block-grey">
                                    <div class="block-light">
                                        <?php if ($single->image) : ?>
                                        <div class="wrapper-img" style="text-align:left">
                                            <p class="tags">
                                                标签: <a><?php echo $single->addperson?></a>,
                                                <?php if( $single->typename ) {?> <a><?php echo $single->typename;?></a>, <?php } ?> 
                                                <?php if( $single->fromname ) {?> <a><?php echo $single->fromname;?></a>, <?php } ?> 
                                                <?php if( $single->keysword ) {?> <a><?php echo $single->keysword;?></a><?php } ?> 
                                                &nbsp;&nbsp;&nbsp;&nbsp;<a href="#" class="single-comments">3</a>
                                            </p>
                                            <!-- <img src="/static/admin/news/<?php echo $single->image;?>" alt="photo" /> -->
                                        </div>
                                        <?php endif; ?>
                                        <div class="wrapper">
                                            <!-- <h2 class="post-title"><?php echo $single->title; ?></h2> -->
                                            <p>
                                                <?php echo html_entity_decode($single->content);?>
                                            </p>
                                            
                                            <hr />
                                            <!--comments-->
                                            <!-- <div class="title-divider">
                                                <h3>4 评论</h3>
                                                <div class="divider-arrow"></div>
                                            </div>
                                            <div class="comments">
                                                <ul class="comments-list">
                                                    <li>
                                                        <div><img src="/static/index/images/avatar.png" alt="avatar" class="avatar" /></div>
                                                        <div class="textarea last">
                                                            <p class="meta">May 16, 2012 Designmd says:</p>
                                                            <p>
                                                                scelerisque felis. Maecenas tincidunt ligula eu magna tincidunt eget imperdiet erat malesuada.
                                                                Ut in diam et metus facilisis venenatis sit amet vel enim.
                                                            </p>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                            <hr /> -->
                                            <!--commetns form-->
<!--                                             <div class="title-divider">
                                                <h3>留言</h3>
                                                <div class="divider-arrow"></div>
                                            </div>
                                            <form name="comment" method="post" action="" class="af-form" id="af-form" />
                                                <div class="af-outer af-required">
                                                    <div class="af-inner">
                                                        <label for="name" id="name_label">Your Name:</label>
                                                        <input type="text" name="name" id="name" size="30" value="" class="text-input input-xlarge" />
                                                        <label class="error" for="name" id="name_error">Name is required.</label>
                                                    </div>
                                                </div>
                                                <div class="af-outer af-required">
                                                    <div class="af-inner">
                                                        <label for="email" id="email_label">Your Email:</label>
                                                        <input type="text" name="email" id="email" size="30" value="" class="text-input input-xlarge" />
                                                        <label class="error" for="email" id="email_error">Email is required.</label>
                                                    </div>
                                                </div>
                                                <div class="af-outer af-required">
                                                    <div class="af-inner">
                                                        <label for="input-message" id="message_label">留言内容:</label>
                                                        <textarea name="message" id="input-message" cols="30" class="text-input"></textarea>
                                                        <label class="error" for="input-message" id="message_error">留言信息不能为空.</label>
                                                    </div>
                                                </div>
                                                <div class="af-outer af-required">
                                                    <div class="af-inner">
                                                        <input type="submit" name="submit" class="form-button btn btn-large" id="submit_btn" value="发布" />
                                                    </div>
                                                </div>
                                            </form> -->
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