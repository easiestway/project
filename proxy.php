<?php
/**
 * Created by PhpStorm.
 * User: d.shokel
 * Date: 6/26/14
 * Time: 1:39 PM
 * To change this template use File | Settings | File Templates.
 */

if($_GET['url'])
{
  echo file_get_contents(rawurldecode($_GET['url']));
} else {
  echo "{}";
}

