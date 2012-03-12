<?php
class Controller_Company extends Controller_MyTemplate
{
    public $template = 'main';
    
    public function action_index()
    {
        $table = Model_Company::find('all', array(
            'related' => array (
                'persons' => array (
                    'where' => array(
                        array('group', '=', '2')
                    ),
                    'order_by' => array('last_name')
                )
            ),
            'order_by' => 'name',
        ));
        if (!empty ($table['persons'])){
            foreach ($table['persons'] as $value) {
                unset($value['password']);
            }
        }
        $data = array('table' => $table);
        $this->template->title = 'Companies';
        $this->template->search = View::forge('search');
        $this->template->content = View::forge('company/index', $data);
    }
    
    public function action_add()
    {
        $this->template = null;
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
        $company_check = $new->save();
        $last = Model_Company::find('last');
        $id = $last->id;
        
        echo '{"company":'.$company_check.', "company_id":'.$id.', "image_id":'.$table['image_id'].'}';
    }
    
    public function action_edit()
    {
        $this->template = null;
        
        //Image processing
        $file = Input::file('image');
        if($file)
        {
            $fp = fopen($file['tmp_name'], 'r');
            $image['content'] = fread($fp, $file['size']);
            fclose($fp);
            $image_check = Model_Image::forge($image)->save();
            if ($image_check == 1)
            {
                $image_id = Model_Image::find('last')->get('id');
            }
            else {
                $image_check = 0;
            }
        }
        
        $table = Input::post();
        $entry = Model_Company::find($table['id']);
        $entry->name = $table['name'];
        $entry->country = $table['country'];
        $entry->details = $table['details'];
        if ($image_id) $entry->image_id = $image_id;
        $company_check = $entry->save();
        echo '{"company":'.$company_check.', "image":'.$image_check;
        if ($image_id) echo ', "image_id":'.$image_id.'}';
        else echo '}';
    }
    
    public function action_delete()
    {
        $this->template = null;
        $id = Input::post('id');
        $entry = Model_Company::find($id);
        $entry->delete();
        $check = Model_Company::find($id);
        if (!$check){
            echo '1';
        }
        else echo '0';
    }
}