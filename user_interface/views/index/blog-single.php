<?php $this->load->view('index/header'); ?>

<!-- header -->
<header id="header">
    <div class="container">
        <div class="row">
            <div class="span2 logo">
                <a href="<?php echo site_url('index'); ?>"><img src="/static/logo.png" alt="logo" /></a>
            </div>
            <div class="span10 hidden-phone pull-right" style="width: auto;">
                <nav id="menu">

                    <ul class="clearfix">

                        <li <?php if ($url == "index" )  echo 'class="current"';?> >
                            <a href="<?php echo site_url('index'); ?>" <?php if ($url == "index" )  echo 'class="current"';?> >
                                首页
                            </a>
                        </li>
                        <?php foreach ($cats as $key => $value): ?>
                            <li>
                                <a href="#">
                                    <?php echo $value['ico'];?>
                                    <?php echo $value['typename'];?> 
                                    <i class="arrow icon-angle-left"></i>
                                </a>
                            </li>
                        <?php endforeach ?>

                    </ul>

                </nav>
            </div>
        </div>
    </div>
</header>

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
                        <div class="row">
                            <div class="span8">
                                <div class="title-divider">
                                    <h3>精彩推荐</h3>
                                    <div class="divider-arrow"></div>
                                </div>
                            </div>
                            <article class="blog-post span4">
                                <div class="block-grey">
                                    <div class="block-light">
                                        <a href="#"><img src="/static/index/example/latest1.jpg" alt="photo" /></a>
                                        <div class="wrapper">
                                            <h2 class="post-title"><a href="#">绘画迎新年</a></h2>
                                            <a href="#" class="blog-comments">3</a>
                                            <p>
                                                创意手上绘画迎新年 dolor sit amet, consectetuer adipiscing elit,
                                                sed diam nonummy nibh euismod tdolore mag quam erat volutpat.
                                                <a href="#" class="read-more">[...]</a>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </article>
                            <article class="blog-post span4">
                                <div class="block-grey">
                                    <div class="block-light">
                                        <a href="#"><img src="/static/index/example/latest2.jpg" alt="photo" /></a>
                                        <div class="wrapper">
                                            <h2 class="post-title"><a href="#">创意手上绘画迎新年</a></h2>
                                            <a href="#" class="blog-comments">3</a>
                                            <p>
                                                创意手上绘画迎新年 dolor sit amet, consectetuer adipiscing elit,
                                                sed diam nonummy nibh euismod tdolore mag quam erat volutpat.
                                                <a href="#" class="read-more">[...]</a>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </article>
                            <article class="blog-post span4">
                                <div class="block-grey">
                                    <div class="block-light">
                                        <a href="#"><img src="/static/index/example/latest3.jpg" alt="photo" /></a>
                                        <div class="wrapper">
                                            <h2 class="post-title"><a href="#">创意手上绘画迎新年</a></h2>
                                            <a href="#" class="blog-comments">3</a>
                                            <p>
                                                创意手上绘画迎新年 dolor sit amet, consectetuer adipiscing elit,
                                                sed diam nonummy nibh euismod tdolore mag quam erat volutpat.
                                                <a href="#" class="read-more">[...]</a>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </article>
                            <article class="blog-post span4">
                                <div class="block-grey">
                                    <div class="block-light">
                                        <a href="#"><img src="/static/index/example/latest5.jpg" alt="photo" /></a>
                                        <div class="wrapper">
                                            <h2 class="post-title"><a href="#">创意手上绘画迎新年</a></h2>
                                            <a href="#" class="blog-comments">3</a>
                                            <p>
                                                创意手上绘画迎新年 dolor sit amet, consectetuer adipiscing elit,
                                                sed diam nonummy nibh euismod tdolore mag quam erat volutpat.
                                                <a href="#" class="read-more">[...]</a>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </article>
                        </div>

                        
                    </section>
                    <!-- sidebar -->
                    <aside id="sidebar" class="alignright span4">
                        <!-- Search -->
                        <section class="search clearfix">
                            <form id="search" class="input-append" />
                                <input class="" id="appendedInputButton" size="16" type="text" placeholder="搜索..." name="search site" onfocus="if(this.value=='Search...') this.value=''" onblur="if(this.value=='') this.value='Search...'" />
                                <input class="btn search-bt" type="submit" name="submit" value="" />
                            </form>
                        </section>

                        <!-- 公告 block -->
                        <div class="title-divider">
                            <h3>图片管理系统介绍</h3>
                            <div class="divider-arrow"></div>
                        </div>
                        <section class="block-dark">
                            <div class="video">
                                <span>光明图片（pic.cn）由光明日报社光明网承建，致力于为全球媒体及摄影爱好者提供丰富而优质的图片内容产品及专业服务。2012年1月开始运营，每天实时发布各类新闻图片、创意图片等。</span>
                                <span>光明图片（pic.cn）将秉承合作共赢的原则，为全球商业客户及摄影师提供更宽广的图片电子商务平台，共创中国图片传播事业的美好未来。</span>
                                <a href="<?php echo site_url("auth/reg"); ?>"><img src="/static/images/sq.jpg"></a>
                            </div>
                        </section>

                        <!-- Recent Posts -->
                        <div class="title-divider">
                            <h3>最新文章</h3>
                            <div class="divider-arrow"></div>
                        </div>
                        <section class="block-grey">
                            <!-- Tabs navigation -->
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#blog" data-toggle="tab">文章</a></li>
                                <li><a href="#comments" data-toggle="tab">评论</a></li>
                            </ul>
                            <!-- Tabs content -->
                            <div class="tab-content">
                                <div class="tab-pane active" id="blog">
                                    <section class="post-widget">
                                        <ul class="clearfix">
                                            <li>
                                                <div class="avatar">
                                                    <a href="#"><img src="/static/index/example/sidebar1.jpg" alt="photo" /></a>
                                                </div>
                                                <div class="description">
                                                    <p><a href="#">Etiam sagittis purus quis neque pharetra pretium tempor</a></p>
                                                    <span class="date"><em>12 Apr 2012, 3 comments</em></span>
                                                </div>
                                                <div class="clear"></div>
                                            </li>
                                            <li>
                                                <div class="avatar">
                                                    <a href="#"><img src="/static/index/example/sidebar2.jpg" alt="photo" /></a>
                                                </div>
                                                <div class="description">
                                                    <p><a href="#">Maecenas malesuada convallis varius. Duis nec luctus leo nam venenatis</a></p>
                                                    <span class="date"><em>12 Apr 2012, 3 comments</em></span>
                                                </div>
                                                <div class="clear"></div>
                                            </li>
                                            <li>
                                                <div class="avatar">
                                                    <a href="#"><img src="/static/index/example/sidebar3.jpg" alt="photo" /></a>
                                                </div>
                                                <div class="description">
                                                    <p><a href="#">Donec feugiat luctus sem malesuada sodales praesent rutrum enim eget</a></p>
                                                    <span class="date"><em>12 Apr 2012, 3 comments</em></span>
                                                </div>
                                                <div class="clear"></div>
                                            </li>
                                        </ul>
                                    </section>
                                </div>
                                <div class="tab-pane" id="comments">
                                    <section class="recent-comments">
                                        <ul class="clearfix">
                                            <li><a href="#">Admin</a> on <a href="#">创意手上绘画迎新年 dolor sit amet, consectetur adipiscing elit.</a></li>
                                            <li><a href="#">ShmitAcc</a> on <a href="#">创意手上绘画迎新年 Sed Ut</a></li>
                                            <li><a href="#">Admin</a> on <a href="#">创意手上绘画迎新年 Sed Ut</a></li>
                                            <li><a href="#">Admin</a> on <a href="#">创意手上绘画迎新年 dolor sit amet, consectetur adipiscing elit.</a></li>
                                            <li><a href="#">ShmitAcc</a> on <a href="#">创意手上绘画迎新年 Sed Ut</a></li>
                                        </ul>
                                    </section>
                                </div>
                            </div>
                        </section>

                        <!-- Advertisment -->
                        <div class="title-divider">
                            <h3>推广</h3>
                            <div class="divider-arrow"></div>
                        </div>
                        <section class="block-dark">
                            <img src="/static/index/images/adv.gif" alt="" />
                        </section>                  
                        
                    </aside>
                    
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