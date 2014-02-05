<?php // Google Image Search API: https://developers.google.com/image-search/v1/jsondevguide

  $query = $_REQUEST['query'];

  $cache_file = 'gimage/'.md5($query).'.jpg';

  if (!is_dir('gimage')) mkdir('gimage');

  if (file_exists($cache_file))
  {
        Header('Location:/'.$cache_file);
        die(0);
  }
  else
  {
      $body = file_get_contents('http://ajax.googleapis.com/ajax/services/search/images?v=1.0&imgsz=xxlarge&as_filetype=jpg&q='.urlencode('"'.$query.'"'));
      if ($body)
      {
      $json = json_decode($body);
        foreach ($json->responseData->results as $result) {
            if ($image = file_get_contents($result->unescapedUrl))
            {
                file_put_contents($cache_file, $image);
                header("Content-Type: image/jpeg");
                die($image);
            }
       }
      }
  }

Header('Location:/gimage/noimage.jpg');
die(0);
