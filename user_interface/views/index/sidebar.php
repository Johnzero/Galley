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
    <section class="block-grey sidebar">
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
                        <?php if (isset($hot_news)): ?>
                        <?php foreach ($hot_news as $key => $new): ?>
                            <li>
                                <div class="avatar">
                                    <a href="<?php echo site_url("index/single/{$new->id}"); ?>"><img src="/static/admin/news/<?php echo $new->image;?>" alt="photo" /></a>
                                </div>
                                <div class="description">
                                    <p><a href="<?php echo site_url("index/single/{$new->id}"); ?>"><?php echo $new->title; ?></a></p>
                                    <span class="date"><em><?php echo date(' Y 年 m 月 d', strtotime($new->create_date)); ?>，<?php echo $new->addperson;?></em></span>
                                </div>
                                <div class="clear"></div>
                            </li>
                            <?php if ($key>1) break;?>
                        <?php endforeach; ?>
                        <?php endif; ?>
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
        <h3>图片欣赏</h3>
        <div class="divider-arrow"></div>
    </div>
    <section class="block-grey">
        <div id="latestwork-sidebar" class="carousel slide">
            <div class="carousel-inner">
                <div class="active item"><img src="/static/index/example/latest3.jpg" alt="photo" /></div>
                <div class="item"><img src="/static/index/example/latest4.jpg" alt="photo" /></div>
                <div class="item"><img src="/static/index/example/latest5.jpg" alt="photo" /></div>
            </div>
            <a class="carousel-control left" href="#latestwork-sidebar" data-slide="prev"></a>
            <a class="carousel-control right" href="#latestwork-sidebar" data-slide="next"></a>
        </div>
        <script type="text/javascript">
            $(document).ready(function(){
                $('.carousel').carousel({
                    interval: 3000
                })
            });
        </script>
    </section>                 
    
</aside>
<div class="clearfix"></div>
