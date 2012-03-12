<?php echo Asset::js('company/company.js'); ?>
<?php echo Asset::css('company/company.css'); ?>
<div class = 'modal hide' id = 'modal_form'>
    <div class = 'modal-header'>
        <a class = 'close' data-dismiss = 'modal'>x</a>
        <h3>Add company</h3>
    </div>
    <form action = '' method = 'post' class = 'form-horizontal' name = 'add_company_form' id = 'add_company_form'>
        <div class = 'modal-body'>
            <div class = 'control-group'>
                <label class = 'control-label' for = 'name'>Company name</label>
                <div class = 'controls'>
                    <input type = 'text' name = 'name' class = 'text-medium'>
                </div>
            </div>
            <div class = 'control-group'>
                <label class = 'control-label' for = 'country'>Country</label>
                <div class = 'controls'>
                    <input type = 'text' name = 'country' class = 'text-small'>
                </div>
            </div>
            <div class = 'control-group'>
                <label class = 'control-label' for = 'details'>Details</label>
                <div class = 'controls'>
                    <textarea name = 'details' id = 'details' class = 'input-xlarge'></textarea>
                </div>
            </div>
            <div class = 'control-group'>
                <label class = 'control-label' for = 'image'>Picture</label>
                <div class = 'controls'>
                    <input type='file' name = 'image' class = 'input-file' />
                </div>
            </div>
            <input name = 'id' type = hidden value = '' />
        </div>
        <div class = 'modal-footer'>
            <input type = submit class = 'btn btn-primary' value = 'Save' />
        </div>
    </form>
</div>

<div class = 'modal hide' id = 'modal_form_contact'>
    <div class = 'modal-header'>
        <a class = 'close' data-dismiss = 'modal'>x</a>
        <h3>Add contact</h3>
    </div>
    <form action = '' method = 'post' class = 'form-horizontal' name = 'add_contact_form' id = 'add_contact_form'>
        <div class = 'modal-body'>
            <div class = 'control-group'>
                <label class = 'control-label' for = 'first_name'>First name</label>
                <div class = 'controls'>
                    <input type = 'text' name = 'first_name' class = 'text-medium'>
                </div>
            </div>
            <div class = 'control-group'>
                <label class = 'control-label' for = 'last_name'>Last name</label>
                <div class = 'controls'>
                    <input type = 'text' name = 'last_name' class = 'text-medium'>
                </div>
            </div>
            <div class = 'control-group'>
                <label class = 'control-label' for = 'email'>E-mail</label>
                <div class = 'controls'>
                    <input type = 'text' name = 'email' class = 'text-medium'>
                </div>
            </div>
            <div class = 'control-group'>
                <label class = 'control-label' for = 'password'>Password</label>
                <div class = 'controls'>
                    <input type = 'password' name = 'password' class = 'text-medium'>
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
            <input name = 'company_id' type = hidden value = '' />
        </div>
        <div class = 'modal-footer'>
            <input type = submit class = 'btn btn-primary' value = 'Save' />
        </div>
    </form>
</div>

<div class = 'alert alert-success' id = 'ajax_alert'></div>

<table class = 'table table-bordered table-striped' id = 'companies_table'>
    <thead>
        <tr>
            <th class = 'span3'>Name</th>
            <th class = 'span1'>Country</th>
            <th class = 'span5'>Contacts</th>
            <th class = 'span3'>Details</th>
            <th class = 'buttons'>Edit/Delete</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($table as $value): ?>
        <tr>
            <td class = 'name'><?php echo Html::img('image/show/company_'.$value['image_id'].'_32x32.png'); ?><span class = 'name'><?php echo $value['name'];?></span></td>
            <td class = 'country'><?php echo $value['country'];?></td>
            <td class = 'contacts'>
                <div class = 'contacts'>
                <?php if ($value['persons']): ?>
                <?php foreach ($value['persons'] as $contact): ?>
                    <div class = 'contact'>
                        <?php echo Html::img('image/show/avatar_'.$contact['image_id'].'_32x32.png'); ?>
                        <span class = 'first_name'><?php echo $contact['first_name'];?></span>
                        <span class = 'last_name'><?php echo $contact['last_name'];?></span>
                    </div>
                <?php endforeach; ?>
                <?php endif; ?>
                <button class = 'btn add_contact_to_company' company_id = "<?php echo $value['id']; ?>">+</button>
                </div>
             </td>
            <td class = 'details'><?php echo $value['details'];?></td>
            <td class = 'buttons'>
                <button class = 'btn edit' company_id = "<?php echo $value['id']; ?>">Edit</button>
                <button class = 'btn delete' company_id = "<?php echo $value['id']; ?>">Delete</button>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

