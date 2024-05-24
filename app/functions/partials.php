<?php
 declare(strict_types=1);

function path(string $path, array $data = []) {
    extract($data);
    $file = 'public/views/partials/'.$path.'.php';
    if(file_exists($file)){
      return require $file;
    }else{
        return false;
    }
   
}
