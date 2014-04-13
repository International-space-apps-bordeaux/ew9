<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
    <title>GALLERY</title>
    <link rel="stylesheet" href="media/css/mediaBoxes.css">
</head>
<body class="afterMenu">
    <script src="media/js/rotate-patch.js"></script>
    <script src="media/js/waypoints.min.js"></script>
    <script src="media/js/mediaBoxes.min.js"></script>
    <script>
        $('document').ready(function () {
            //INITIALIZE THE PLUGIN
            $('#grid').mediaBoxes({
                theme: 'theme3',
                imagesToLoadStart: 10,
                imagesToLoad: 15,
            });
        });
    </script>
    <div class="content grid-container">
        <div id="grid">
            <?php

                 $name_img = explode(".", $BestPhotoOfMonth->filename);
                $name_img_min = join('_min.', $name_img);
                echo('   
            <div class="box pictureWinner" data-category="ISS" style="width: 400px;">
                <div class="box-image">
                    <div data-thumbnail="http://ew9.spaceappsbdx.org/files/iserv/'.$name_img_min.'"></div>
                    <div class="thumbnail-caption">
                        <div class="box-caption">
                            <div class="box-title" style="font-size: 25px;">Month Winner</div>
                            <div class="box-text">
                                Time: '.$BestPhotoOfMonth->acquisition_time.'<br/>
                                Latitude: '.$BestPhotoOfMonth->latitude.'<br/> 
                                Longitude : '.$BestPhotoOfMonth->longitude .'<br/> 
                            </div>
                            <div class="box-more"><a href="index.php?page=detail&id='.$BestPhotoOfMonth->id.'">Read More</a></div>
                        </div>
                    </div>
                </div>
            </div>
            ');
            ?>
            <?php
            foreach ($images as $image){
                $name_img = explode(".", $image->filename);
                $name_img_min = join('_min.', $name_img);
                echo('   
            <div class="box" data-category="Pays">
                <div class="box-image">
                    <div data-thumbnail="http://ew9.spaceappsbdx.org/files/iserv/'.$name_img_min.'"></div>
                    <div class="thumbnail-caption">
                        <div class="box-caption">
                            <div class="box-title"></div>
                            <div class="box-text">
                                Time: '.$image->acquisition_time.'<br/>
                                Latitude: '.$image->latitude.'<br/> 
                                Longitude : '.$image->longitude .'<br/> 
                            </div>
                            <div class="box-more"><a href="index.php?page=detail&id='.$image->id.'">Read More</a></div>
                        </div>
                    </div>
                </div>
            </div>
            ');
            }
            ?>
        </div>
    </div>
    <a class="topButton" href="#"><img src="media/img/top.png" /></a>
</body>
</html>
