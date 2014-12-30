<?php $this->load->view('inc/header'); ?>

<link href="/static/home/css/thin-admin.css" rel="stylesheet" media="screen" />
<link rel="stylesheet" type="text/css" href="/static/home/css/component.css" />

<style type="text/css">
    .wrapper {
        margin: -20px -20px 0px -20px;
    }
    .bottom-nav {
        padding: 0;
        height: 50px;
        line-height: 50px;
        text-align: center;
    }
</style>

<div id="wrapper"  class="wrapper">
    <?php $this->load->view('inc/leftnav'); ?>
    <div class="page-content">
        <div class="content container">
            <div class="row">
                <section class="grid-wrap">
                    <ul class="grid swipe-right" id="grid">
                        <?php if (isset($images)): ?>
                        <?php foreach ($images as $image): ?>
                        <li>
                            <a class="album-images img-fancy thumbnail" href="<?php echo site_url("imagedata/{$image['uuid']}?type=large"); ?>" title="<?php echo $image['name']; ?>">
                                <img src="<?php echo site_url("imagedata/{$image['uuid']}"); ?>" data-link="<?php echo site_url("home/zip_load/{$image['uuid']}"); ?>">
                                
                                <h3 href="<?php echo site_url("home/detail/{$image['id']}"); ?>">
                                    <!-- <?php if ($image['author']) : ?>
                                    <span><?php echo $image['author']; ?> </span>
                                    <?php endif;?> -->
                                    <i class="icon-large icon-folder-close pull-right"></i>
                                    <?php if ($image['created_at']) : ?>
                                        <span class="pull-left">
                                            <?php if ($image['location']) : ?>
                                                <?php echo $image['location']; ?>&nbsp;&nbsp;
                                            <?php endif;?>
                                            <?php echo date(' Y 年 m 月 d', strtotime($image['created_at'])); ?>
                                        </span>
                                    <?php endif;?>
                                    &nbsp;
                                </h3>

                            </a>
                        </li>
                        <?php endforeach; ?>
                        <?php endif; ?>
                    </ul>
                </section>
                <?php echo $this->pagination->create_links(); ?>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready( function () { 
        new GridScrollFx( document.getElementById( 'grid' ), {
            viewportFactor : 0.4
        });
        $(".current").parent(".sub-menu").addClass("opened");
        $('a.img-fancy').fancybox();
        $(".grid li h3").click(function (event) {
            window.open($(this).attr('href'));
            return false;
        });
    });
</script>
<?php $this->load->view('inc/footer'); ?>



