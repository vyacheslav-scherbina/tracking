<?php echo Asset::js('contact/contact.js'); ?>
<?php echo Asset::css('contact/contact.css'); ?>
<div class = 'modal hide' id = 'modal_form'>
    <div class = 'modal-header'>
        <a class = 'close' data-dismiss = 'modal'>x</a>
        <h3>Add contact</h3>
    </div>
    <form action = '' enctype = 'multipart/form-data' method = 'post' class = 'form-horizontal' name = 'add_contact_form' id = 'add_contact_form'>
        <div class = 'modal-body'>
            <div class = 'control-group'>
                <label class = 'control-label' for = 'first_name'>First name</label>
                <div class = 'controls'>
                    <input type = 'text' name = 'first_name' class = 'input-medium'>
                </div>
            </div>
            <div class = 'control-group'>
                <label class = 'control-label' for = 'last_name'>Last name</label>
                <div class = 'controls'>
                    <input type = 'text' name = 'last_name' class = 'input-medium'>
                </div>
            </div>
            <div class = 'control-group'>
                <label class = 'control-label' for = 'email'>E-mail</label>
                <div class = 'controls'>
                    <input type = 'text' name = 'email' class = 'input-medium'>
                </div>
            </div>
            <div class = 'control-group'>
                <label class = 'control-label' for = 'password'>Password</label>
                <div class = 'controls'>
                    <input type = 'password' name = 'password' class = 'input-medium'>
                </div>
            </div>
            <div class = 'control-group'>
                <label class = 'control-label' for = 'skype'>Skype</label>
                <div class = 'controls'>
                    <input type = 'text' name = 'skype' class = 'input-medium'></textarea>
                </div>
            </div>
            <div class = 'control-group'>
                <label class = 'control-label' for = 'phone'>Phone</label>
                <div class = 'controls'>
                    <input type = 'text' name = 'phone' class = 'input-medium'></textarea>
                </div>
            </div>
            <div class = 'control-group'>
                <label class = 'control-label' for = 'image'>Picture</label>
                <div class = 'controls'>
                    <input type='file' name = 'image' class = 'input-file' />
                </div>
            </div>
            <div class = 'control-group'>
                <label class = 'control-label' for = 'company'>Company</label>
                <div class = 'controls'>
                    <select name = 'company_id'>
                        <option value = '0'>No company</option>
                        <?php foreach ($companies as $value):?>
                        <option value = "<?php echo $value['id'] ?>"><?php echo $value['name']; ?></option>
                        <?php endforeach; ?>                        
                    </select>
                </div>
            </div>
            <input name = 'id' type = hidden value = '' />
        </div>
        <div class = 'modal-footer'>
            <input type = submit class = 'btn btn-primary' value = 'Save' />
        </div>
    </form>
</div>

<div class = 'alert alert-success' id = 'ajax_alert'></div>

<table class = 'table table-bordered table-striped' class = 'span10' id = 'contacts_table'>
    <thead>
        <tr>
            <th class = 'span4'>Name</th>
            <th class = 'span2'>Email</th>
            <th class = 'span2'>Skype</th>
            <th class = 'span2'>Phone</th>
            <th class = 'span3'>Company</th>
            <th class = 'buttons'>Edit/Delete</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($table as $value): ?>
        <tr>
            <td class = 'name'>
                <?php echo Html::img('image/show/avatar_'.$value['image_id'].'_32x32.png'); ?>
                <span class = 'first_name'><?php echo $value['first_name'];?></span>
                <span class = 'last_name'><?php echo $value['last_name'];?></span>
            </td>
            <td class = 'email'><?php echo $value['username'];?></td>
            <td class = 'skype'><?php echo $value['skype'];?></td>
            <td class = 'phone'><?php echo $value['phone'];?></td>
            <td class = 'company'><?php echo $value['company']['name'];?></td>
            <td class = 'buttons'>
                <button class = 'btn edit' contact_id = "<?php echo $value['id']; ?>">Edit</button>
                <button class = 'btn delete' contact_id = "<?php echo $value['id']; ?>">Delete</button>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>