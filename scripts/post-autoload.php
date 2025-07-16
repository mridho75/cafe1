<?php

$dir = __DIR__ . '/../public/menu_images';
if (is_dir($dir)) {
    chmod($dir, 0775);
    echo "Permission set to 775 for public/menu_images\n";
} else {
    echo "Directory public/menu_images not found\n";
}
