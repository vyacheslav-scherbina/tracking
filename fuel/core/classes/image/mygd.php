<?php

/**
 * Part of the Fuel framework.
 *
 * Image manipulation class.
 *
 * @package		Fuel
 * @version		1.0
 * @license		MIT License
 * @copyright	2010 - 2011 Fuel Development Team
 * @link		http://fuelphp.com
 */

namespace Fuel\Core;

class Image_Mygd extends \Image_Gd
{
    public function load_from_string($data)
    {
        $finfo = finfo_open();
        $tmp = finfo_buffer($finfo, $data, FILEINFO_MIME_TYPE);
        $tmp= explode('/', $tmp);
        $image_extension = $tmp[1];
        $filename = md5($data.date('y:m:d:h:s'));
        File::create('assets/tmp_img/', $filename.'.'.$image_extension, $data);
        $this->load('assets/tmp_img/'.$filename.'.'.$image_extension);
        File::delete('assets/tmp_img/'.$filename.'.'.$image_extension);
        return $this;
    }
}
