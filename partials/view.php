<div class="row">
    <div class="col-xs-12">
        <div class="pull-left">
            <a href="<?=APP_ROOT; ?>"><i class="fa fa-arrow-left fa-fw"></i> Return Home</a>
        </div>
    </div>
</div>
<h1><?=get_meta($path, "Title"); ?></h1>
<p>
    by <?=get_meta($path, "Author"); ?> on <?php if (get_meta($path, "Date") == false): ?><?=date("F j, Y", filemtime($path)); ?><?php else: ?><?=get_meta($path, "Date"); ?><?php endif; ?>
</p>
<div class="mt-2">
    <?php

    require APP_ROOT . "Parsedown.php";
    require APP_ROOT . "ParsedownExtra.php";
    $parser = new ParsedownExtra();
    echo $parser->text(get_content($path));

    ?>
</div>
<div id="disqus_thread"></div>
<script>

    /**
     *  RECOMMENDED CONFIGURATION VARIABLES: EDIT AND UNCOMMENT THE SECTION BELOW TO INSERT DYNAMIC VALUES FROM YOUR PLATFORM OR CMS.
     *  LEARN WHY DEFINING THESE VARIABLES IS IMPORTANT: https://disqus.com/admin/universalcode/#configuration-variables*/
    /*
    var disqus_config = function () {
    this.page.url = PAGE_URL;  // Replace PAGE_URL with your page's canonical URL variable
    this.page.identifier = PAGE_IDENTIFIER; // Replace PAGE_IDENTIFIER with your page's unique identifier variable
    };
    */
    (function() { // DON'T EDIT BELOW THIS LINE
        var d = document, s = d.createElement('script');
        s.src = 'https://liamdemafelix.disqus.com/embed.js';
        s.setAttribute('data-timestamp', +new Date());
        (d.head || d.body).appendChild(s);
    })();
</script>
<noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>

<hr>