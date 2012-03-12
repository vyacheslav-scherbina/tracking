<?php
class Controller_Contact extends Controller_MyTemplate
{
    public $template = 'main';
    
    public function action_index()
    {
        $table = Model_Person::find('all', array(
            'where'=> array(
                'group' => 2
            ),
            'order_by' => 'last_name',
        ));
        $companies = Model_Company::find('all', array(
            'order_by' => 'name'
        ));
        
        $data = array('table' => $table, 'companies' => $companies);
        $this->template->title = 'Contacts';
        $this->template->search = View::forge('search');
        $this->template->content = View::forge('contact/index', $data);
    }
    
    public function action_add()
    {
        $this->template = null;
        
        //Image processing
        $config = array('ext_whitelist' => array('img', 'jpg', 'jpeg', 'gif', 'png'));
        Upload::process($config);
        if (Upload::is_valid())
        {
            $file = Input::file('image');
            $fp = fopen($file['tmp_name'], 'r');
            $image['content'] = fread($fp, $file['size']);
            fclose($fp);
            $image_check = Model_Image::forge($image)->save();
            if ($image_check == 1)
            {
                $image_id = Model_Image::find('last')->get('id');
            }
        }
        else
        {
            $image_id = 1;
            $image_check = 0;
        }
        
        //Person processing
        $table = Input::post();
        $table['username'] = $table['email'];
        unset($table['email']);
        $table['unit_id'] = $table['company_id'];
        unset($table['company_id']);
        $table['group'] = 2;
        $table['image_id'] = $image_id;
        $person_check = Auth::create_person($table);
        $contact_id = Model_Person::find('last')->get('id');
                
        echo '{"person":'.$person_check.', "image":'.$image_check.', "image_id":'.$image_id.', "contact_id":'.$contact_id.'}';
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
        }

        //Person processing
        $table = Input::post();
        $entry = Model_Person::find($table['id']);
        $entry->first_name = $table['first_name'];
        $entry->last_name = $table['last_name'];
        $entry->password = $table['password'];
        $entry->username = $table['email'];
        $entry->skype = $table['skype'];
        $entry->phone = $table['phone'];
        $entry->unit_id = $table['company_id'];
        if ($image_id)
        {
            $entry->image_id = $image_id;            
        }
        $person_check = $entry->save();
        
        echo '{"person":'.$person_check.', "image":'.$image_check.', "image_id":'.$image_id.'}';
    }
    
    public function action_delete()
    {
        $this->template = null;
        $id = Input::post('id');
        $entry = Model_Person::find($id);
        $entry->delete();
        $check = Model_Person::find($id);
        if (!$check){
            echo '1';
        }
        else echo '0';
    }

}
