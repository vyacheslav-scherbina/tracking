<?php
class Controller_Image extends Controller_MyTemplate
{
    public function before($data = null) 
    {
        parent::before();
        $this->auto_render = false;
    }
    
    public function action_show($file)
    {
        try
        {
            try
            {
                $this->response->set_header('Content-Type', 'image');
                File::read('assets/tmp_img/'.$file);
            }
            catch (InvalidPathException $e)
            {
                if (preg_match('/_(\d*)_(\d*)x(\d*)/', $file, $matches))
                {

                    $id = $matches[1];
                    $width = $matches[2];
                    $height = $matches[3];
                    //if ($width > 500 or $height > 500) throw new Exception('Too big size');
                    if ($img = Model_Image::find($id))
                        Image::load_from_string($img->content)->crop_resize($width, $height)->save('assets/tmp_img/'.$file)->output();
                    else
                        throw new Exception('Unknown id');
                }
                else
                {
                    throw new Exception('Preg_match failed');
                }
            }
        }
        catch (Exception $a)
        {
            echo "OLOLO";// TODO
        }
    }
}