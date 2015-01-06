<?php $this->load->view('index/header'); ?>

<!-- container -->
<section id="container">
    <div class="container">
        <div class="row">
            <div class="span12">
                <div class="row">
                    <!-- page content -->
                    <section id="page-sidebar" class="alignleft span8">
                        <!-- slider -->
                        <div class="row">
                            <div class="span8">
                                <div id="mainslider" class="flexslider">
                                    <ul class="slides">
                                        <li>
                                            <img src="/static/index/example/slider1.jpg" alt="photo" />
                                            <h3><span>工业“活化石”，最后的蒸汽火车</span><a href="#">2014年12月13日，这是新疆哈密入冬以来气温最低的一天，零下十七度，我们前往哈密三道岭煤矿去拍蒸汽机车，据说这批工业活化石快要“退役”了，于是想保存他们工作的最后景象。</a></h3>
                                        </li>
                                        <li>
                                            <img src="/static/index/example/slider2.jpg" alt="photo" />
                                            <h3><span>创意手上绘画迎新年 </span><a href="#">创意手上绘画迎新年 dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.</a></h3>
                                        </li>
                                        <li>
                                            <img src="/static/index/example/slider3.jpg" alt="photo" />
                                            <h3><span>创意手上绘画迎新年</span><a href="#">创意手上绘画迎新年 dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.</a></h3>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- content -->
                        <div class="row index-page">
                            <div class="span8">
                                <div class="title-divider">
                                    <h3>精彩推荐</h3>
                                    <div class="divider-arrow"></div>
                                </div>
                            </div>
                            <?php if (isset($hot_news)): ?>
                            <?php foreach ($hot_news as $new): ?>
                            <article class="blog-post span4">
                                <div class="block-grey">
                                    <div class="block-light">
                                        <a href="<?php echo site_url("index/single/{$new->id}"); ?>"><img src="/static/admin/news/<?php echo $new->image;?>" alt="photo" /></a>
                                        <div class="wrapper">
                                            <h2 class="post-title"><a href="<?php echo site_url("index/single/{$new->id}"); ?>"><?php echo $new->title; ?></a></h2>
                                            <a href="<?php echo site_url("index/single/{$new->id}#comments"); ?>" class="blog-comments">3</a>
                                            <p>
                                                <?php echo $new->introduce;?>
                                                <a href="<?php echo site_url("index/single/{$new->id}"); ?>" class="read-more">[...]</a>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </article>
                            <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </section>
                    
                    <?php $this->load->view('index/sidebar'); ?>
                    
                    <div class="clearfix"></div>
                    <!-- portfolio slider -->
                    <div>
                        <div class="span12">
                            <div class="title-divider">
                                <h3>精彩图集</h3>
                                <div class="divider-arrow"></div>
                            </div>
                        </div>
                        <div class="span12">
                            <div class="block-grey our-portfolio">
                                <div class="block-light wrap10">
                                    <div id="latest-work" class="carousel btleft">
                                    <div class="carousel-wrapper">
                                        <ul class="da-thumbs-folio">
                                            <li>
                                                <img src="/static/index/example/latest1.jpg" />
                                                <h3>示例图</h3>
                                                <div>
                                                    <a href="/static/index/example/view.jpg" class="p-view" data-rel="prettyPhoto"></a>
                                                </div>
                                            </li>
                                            <li>
                                                <img src="/static/index/example/latest2.jpg" />
                                                <h3>示例图</h3>
                                                <div>
                                                    <a href="/static/index/example/view.jpg" class="p-view" data-rel="prettyPhoto"></a>
                                                </div>
                                            </li>
                                            <li>
                                                <img src="/static/index/example/latest3.jpg" />
                                                <h3>示例图</h3>
                                                <div>
                                                    <a href="/static/index/example/view.jpg" class="p-view" data-rel="prettyPhoto"></a>
                                                </div>
                                            </li>
                                            <li>
                                                <img src="/static/index/example/latest4.jpg" />
                                                <h3>示例图</h3>
                                                <div>
                                                    <a href="/static/index/example/view.jpg" class="p-view" data-rel="prettyPhoto"></a>
                                                </div>
                                            </li>
                                            <li>
                                                <img src="/static/index/example/latest5.jpg" />
                                                <h3>示例图</h3>
                                                <div>
                                                    <a href="/static/index/example/view.jpg" class="p-view" data-rel="prettyPhoto"></a>
                                                </div>
                                            </li>
                                            <li>
                                                <img src="/static/index/example/latest6.jpg" />
                                                <h3>示例图</h3>
                                                <div>
                                                    <a href="/static/index/example/view.jpg" class="p-view" data-rel="prettyPhoto"></a>
                                                </div>
                                            </li>
                                            <li>
                                                <img src="/static/index/example/latest5.jpg" />
                                                <h3>示例图</h3>
                                                <div>
                                                    <a href="/static/index/example/view.jpg" class="p-view" data-rel="prettyPhoto"></a>
                                                </div>
                                            </li>
                                            <li>
                                                <img src="/static/index/example/latest6.jpg" />
                                                <h3>示例图</h3>
                                                <div>
                                                    <a href="/static/index/example/view.jpg" class="p-view" data-rel="prettyPhoto"></a>
                                                </div>
                                            </li>
                                            <li>
                                                <img src="/static/index/example/latest5.jpg" />
                                                <h3>示例图</h3>
                                                <div>
                                                    <a href="/static/index/example/view.jpg" class="p-view" data-rel="prettyPhoto"></a>
                                                </div>
                                            </li>
                                            <li>
                                                <img src="/static/index/example/latest6.jpg" />
                                                <h3>示例图</h3>
                                                <div>
                                                    <a href="/static/index/example/view.jpg" class="p-view" data-rel="prettyPhoto"></a>
                                                </div>
                                            </li>
                                            <li>
                                                <img src="/static/index/example/latest5.jpg" />
                                                <h3>示例图</h3>
                                                <div>
                                                    <a href="/static/index/example/view.jpg" class="p-view" data-rel="prettyPhoto"></a>
                                                </div>
                                            </li>
                                            <li>
                                                <img src="/static/index/example/latest6.jpg" />
                                                <h3>示例图</h3>
                                                <div>
                                                    <a href="/static/index/example/view.jpg" class="p-view" data-rel="prettyPhoto"></a>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                    </div>
                                    <script type="text/javascript">
                                        $(document).ready(function(){
                                            $('#latest-work').elastislide({
                                                imageW  : 235,
                                                margin  : 10
                                            });
                                        });
                                    </script>
                                </div>

                                <div class="short-text">
                                    创意手上绘画迎新年 创意手上绘画迎新年创意手上绘画迎新年创意手上绘画迎新年创意手上绘画迎新年创意手上绘画迎新年创意手上绘画迎新年
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>

<?php $this->load->view('index/footer'); ?>