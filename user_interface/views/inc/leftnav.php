<div class="left-nav">
    <div id="side-nav">
        <ul id="nav">
            <!-- <li>
                <form action="<?php echo site_url('home/quick_search'); ?>" method="POST" class="navbar-form pull-right" id="search-form">
                    <input id="keyword" type="hidden" name="keyword" >
                    <input type="search" placeholder="..." class="search-query" id="search-input">
                </form>
            </li> -->
            <li <?php if ($url == "home" )  echo 'class="current"';?> >
                <a href="<?php echo site_url('home'); ?>">
                    <i class="icon-home" style="font-size: 19px;">
                    </i>
                    全部
                </a>
            </li>
            <?php foreach ($cats as $key => $value): ?>
                <li>
                    <a href="#">
                        <?php echo $value['ico'];?>
                        <?php echo $value['typename'];?> 
                        <i class="arrow icon-angle-left"></i>
                    </a>
                    <ul class="sub-menu" >
                        <?php foreach ($value["sub_cat"] as $k => $v) : ?>
                            <li <?php if ($url == $v['id'] )  echo 'class="current"'; ?> >
                                <a href="<?php echo site_url("home/cat/$v[id]"); ?>">
                                    <i class="icon-angle-right">
                                    </i>
                                    <?php echo $v['typename'];?>
                                    <!-- <span class="label label-info pull-right">
                                        7
                                    </span> -->
                                </a>
                            </li>
                        <?php endforeach ?>
                    </ul>
                </li>
            <?php endforeach ?>
        </ul>
    </div>
</div>
<script type="text/javascript">
$(document).ready(function () {
    $("#search-form").submit( function () {
        $("#keyword").val( $("#search-input").val() );
    })
    $(".current").parent(".sub-menu").addClass("opened");
})
</script>