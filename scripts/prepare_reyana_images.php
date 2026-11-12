<?php
// Offline derivation of downloaded reference images. Never contacts the source site.
$root=dirname(__DIR__).'/public/reyana/';
foreach(glob($root.'look-*.*') as $file) {
    if(str_contains(basename($file),'-small') || str_contains(basename($file),'-medium')) continue;
    $image=imagecreatefromstring(file_get_contents($file));
    if(!$image) continue;
    foreach(['small'=>400,'medium'=>750] as $suffix=>$width) {
        $height=(int)round(imagesy($image)*$width/imagesx($image));
        $resized=imagescale($image,$width,$height);
        imagewebp($resized,$root.pathinfo($file,PATHINFO_FILENAME).'-'.$suffix.'.webp',82);
        imagedestroy($resized);
    }
    imagedestroy($image);
}
