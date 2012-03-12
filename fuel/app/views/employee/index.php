<?php echo Asset::js('employee/employee.js'); ?>
<?php echo Asset::css('employee/employee.css'); ?>
<div class = 'modal hide' id = 'modal_form'>
    <div class = 'modal-header'>
        <a class = 'close' data-dismiss = 'modal'>x</a>
        <h3>Add employee</h3>
    </div>
    <form action = '' method = 'post' class = 'form-horizontal' name = 'add_employee_form' id = 'add_employee_form'>
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
                    <input type = 'email' name = 'email' class = 'input-medium'>
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
                    <input type = 'text' name = 'skype' class = 'input-medium'>
                </div>
            </div>
            <div class = 'control-group'>
                <label class = 'control-label' for = 'phone'>Phone</label>
                <div class = 'controls'>
                    <input type = 'text' name = 'phone' class = 'input-medium'>
                </div>
            </div>
            <div class = 'control-group'>
                <label class = 'control-label' for = 'unit'>Unit</label>
                <div class = 'controls'>
                    <select name = 'unit_id'>
                        <option value = '0'></option>
						<? foreach($unit as $u):?>
							<?$ua[$u['id']]=$u['name'];?>
							<option value = '<?=$u['id']?>'><?=$u['name']?></option>
						<? endforeach;?>
                    </select>
                &nbsp;&nbsp;&nbsp;Manager?<input type='checkbox' name='is_unit_manager'>
				</div>
            </div>
            <input name = 'id' type = hidden value = '' />
        </div>
        <div class = 'modal-footer'>
            <input type = submit class = 'btn btn-primary' value = 'Save' />
        </div>
    </form>
</div>

<? if(is_array($table)):?>

	<table class="table table-striped table-bordered table-condensed" id="employee_table">
		<thead> 
	<tr>
<td class="span1" style="font-weight:bold">Photo</th>
<th class="span2">Name</th>
<th class="span2">Email</th>
<th class="span2">Skype</th>
<th class="span2">Phone</th>
<th class="span2">Unit</th>
<td class="span2" style="font-weight:bold">Edit/Delete</th>
	</tr>
		</thead> 
		<tbody> 

		<? foreach($table as $v):?>

	<tr>
<td><img src="http://img.ners.ru/design/userpic/default-userpic-50.jpg"></td>

<td class = 'name'>
<?=$v['first_name'].' '.$v['last_name']?></td>
<td><?=$v['username']?></td>
<td><?=$v['skype']?></td>
<td><?=$v['phone']?></td>
<td class = 'company'><span <?if($v['is_unit_manager']):?>style="font-weight:bold;"<?endif;?>><?=$ua[$v['unit_id']]?></span></td>
<td class = 'buttons'>
	<button class = 'btn edit' employee_id = "<?php echo $v['id']; ?>">Edit</button>
	<button class = 'btn delete' employee_id = "<?php echo $v['id']; ?>">Delete</button>
</td>
	</tr>
		<? endforeach;?>

		</tbody> 
	</table>

<? endif;?>