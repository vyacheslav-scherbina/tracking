<?php
class Controller_Companyajax extends Controller_Rest
{
    public function post_add()
    {
        $table = Input::post();
        
        //Image processing
        $config = array('ext_whitelist' => array('img', 'jpg', 'jpeg', 'gif', 'png'));
        Upload::process($config);
        if (Upload::is_valid())
        {
            $file = Input::file('image');
            $fp = fopen($file['tmp_name'], 'r');
            $image['content'] = fread($fp, $file['size']);
            fclose($fp);
            $new_image = Model_Image::forge($image);
            $image_check = $new_image->save();
            $table['image_id'] = $new_image->id;
        }
        else
        {
            $table['image_id'] = 3;
        }
                
        //Company processing
        $new = Model_Company::forge($table);
        $output['company'] = $new->save();
        $last = Model_Company::find('last');
        $output['company_id'] = $last->id;
        $output['image_id'] = $table['image_id'];
        $this->response($output);
        
    }
}