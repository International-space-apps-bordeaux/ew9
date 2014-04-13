<!DOCTYPE html>
<html>

<script>
    // function print 
    function makepage(src) {
        return "<html>\n" +
        "<head>\n" +
        "<title>Temporary Printing Window</title>\n" +
        "<script>\n" +
        "function step1() {\n" +
        " setTimeout('step2()', 10);\n" +
        "}\n" +
        "function step2() {\n" +
        " window.print();\n" +
        " window.close();\n" +
        "}\n" +
        "</scr" + "ipt>\n" +
        "</head>\n" +
        "<body onLoad='step1()'>\n" +
        "<img src='" + src + "'/>\n" +
        "</body>\n" +
        "</html>\n";
    }
    function printme(evt) {
        src = 'http://ew9.spaceappsbdx.org/files/iserv/<?php  echo $image->filename  ?>';
        link = "about:blank";
        var pw = window.open(link, "_new");
        pw.document.open();
        pw.document.write(makepage(src));
        pw.document.close();
    }

    function vote(id) {
        $.ajax({
            type: "POST",
            url: "src/controler/ajax.php",
            data: "vote=" + id,
            success: function () {
                location.reload();
            }
        });
        return false;
    };


</script>
<body>
    <section>
        <div class="row detail-image">
            <div class="col-xs-12 detail-image">
                <?php
                $name_img = explode(".", $image->filename);
                $name_img_min = join('_avg.', $name_img);
                echo('<img class="img-responsive" src="http://ew9.spaceappsbdx.org/files/iserv/'.$name_img_min.'" />');
                ?>
            </div>
        </div>
    </section>
    <section class="grey-section">
        <div class="row">
            <div class="col-xs-6 detail-share">
                <span>SHARE WITH</span>
                <img src="media/img/facebook_blue.png" />
                <img src="media/img/twitter_blue.png" />
                <img src="media/img/google_red.png" />
            </div>
            <div class="col-xs-6 detail-likes">
                <span class="count-like"><?php
                                         echo($image->note);
                ?></span>
                <img src="media/img/heart-white.png" />
                <?php
                echo('<img style="float:right;cursor:pointer;" onclick=vote('.$image->id.') src="media/img/+1heart.png" />');
                ?>
            </div>
        </div>
    </section>
    <section>
    </section>
    <section class="blue-section detail-underMap">
        <div class="row">
            <div class="col-sm-4">
                <img src="media/img/localisation_big.png" />
                <span>AMZONIA / MANAUS</span>
            </div>
            <div class="col-sm-4">
                <img src="media/img/timer.png" />
                <span>13 MARCH 2013 / 15H34</span>
            </div>
            <div class="col-sm-4">
                <img src="media/img/space.png" />
                <span>MISSION 38</span>
            </div>
        </div>
    </section>
    <section class="grey-section">
        <div class="row">
            <div class="col-xs-12">
                <img src="media/img/camera.png" />
                <span>RELATED PICTURES</span>
            </div>
        </div>
    </section>
    <div class="row">
        <?php
        for($i = 0; $i < count($related_pictures); $i++){
            $name_img = explode(".", $related_pictures[$i]->filename);
            $name_img_min = join('_avg.', $name_img);
            
            echo('<div class="col-xs-3">
                    <a href="index.php?page=detail&id='.$related_pictures[$i]->id.'"><img class="img-responsive" src="http://ew9.spaceappsbdx.org/files/iserv/'.$name_img_min.'"/></a>
                </div>');
        }
        ?>
    </div>
    <section>
    </section>
    <section class="grey-section">
        <div class="row">
            <div class="col-xs-12">
                <img src="media/img/discuss.png" />
                <span>DISCUSS IT</span>
            </div>
        </div>
    </section>
    <section class="chat-section ">
        <div class="row">
            <div class="col-xs-12">
                <div id="disqus_thread"></div>
                <script type="text/javascript">
                    /* * * CONFIGURATION VARIABLES: EDIT BEFORE PASTING INTO YOUR WEBPAGE * * */
                    var disqus_shortname = 'spacebreak'; // required: replace example with your forum shortname

                    /* * * DON'T EDIT BELOW THIS LINE * * */
                    (function () {
                        var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
                        dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
                        (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
                    })();
                </script>
                <noscript>Please enable JavaScript to view the <a href="http://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
                <a href="http://disqus.com" class="dsq-brlink">comments powered by <span class="logo-disqus">Disqus</span></a>
            </div>
        </div>
    </section>
</body>


</html>
