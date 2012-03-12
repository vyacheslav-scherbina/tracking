<?= Asset::css('unit/unit.css') ?>
<? if ($superuser): ?>
    <?= Asset::js('unit/unit.js') ?>
<? endif ?>
<?= Session::get_flash('error') ?>
<ul class="units">
    <? foreach ($units as $unit): ?>
        <li class="unit row well" id="<?= $unit->id ?>">
            <div class="unit_title cell">
                <? if ($superuser): ?>
                    <?= Html::anchor('unit/delete/'.$unit->id, '&#215;', array("id" => 'b_'.$unit->id, "class" => "close_btn", "onClick" => "return confirm('Are you sure?')")) ?>
                    <?= Html::img('image/show/avatar_'.$unit->image->id.'_32x32.png', array('class' => 'pull-left', 'style' => 'margin-right:10px')) ?>
                <? else: ?>
                    <?= Html::img('image/show/avatar_'.$unit->image->id.'_32x32.png', array('class' => 'pull-left', 'style' => 'margin:0 10px 0 10px')) ?>
                <? endif ?>
                <h1 class="unit_name" unit_id="<?= $unit->id ?>"><?= $unit->name ?></h1>
            </div>
            <div class="persons cell">
                    <ul class="sortable managers row well" unit_id="<?= $unit->id ?>" is_unit_manager="1">
                        <? foreach ($managers[$unit->id] as $manager): ?>
                            <li id="<?= $manager->id ?>" unit_id="<?= $unit->id ?>" class="manager">
                                <?= Html::img('assets/img/unit/user_icon.png').$manager->first_name.' '.$manager->last_name ?>
                            </li>
                        <? endforeach ?>
                    </ul>
                    <ul class="sortable employees row well" unit_id="<?= $unit->id ?>" is_unit_manager="0">
                        <? foreach ($employees[$unit->id] as $employee): ?>
                            <li id="<?= $employee->id ?>" unit_id="<?= $unit->id ?>" class="employee">
                                <?= Html::img('assets/img/unit/user_icon.png').$employee->first_name.' '.$employee->last_name ?>
                            </li>
                        <? endforeach ?>
                    </ul>
            </div>
        </li>
    <? endforeach ?>
    <? if ( ! empty($homeless_employees)): ?>
        <li class="unit row well" id="homeless">
            <div class="unit_title cell" style="padding: 0; vertical-align: middle">
                <?= Html::img('image/show/avatar_2_32x32.png', array('class' => 'pull-left', 'style' => 'margin:0 10px 0 10px')) ?>
                <h1>
                    Homeless
                </h1>
            </div>
            <div class="persons cell">
                <ul class="homeless employees row well">
                    <? foreach ($homeless_employees as $employee): ?>
                        <li id="<?= $employee->id ?>" class="employee">
                            <?= Html::img('assets/img/unit/user_icon.png').$employee->first_name.' '.$employee->last_name ?>
                        </li>
                    <? endforeach ?>
                </ul>
            </div>
        </li>
    <? endif ?>
</ul>
<div class="modal" id="myModal">
    <div class="modal-header">
        <a class="close" data-dismiss="modal">×</a>
        <h2></h2>
    </div>
    <?= Form::open(array('action' => '', 'method' => 'post', 'enctype' => 'multipart/form-data')) ?>
        <div class="modal-body">
            <div>
                <?= Form::input('name', null, array('id' => 'input_unit_name')) ?>
            </div>
            <div>
                <?= Form::file('image', array('id' => 'input_unit_image', 'accept' => 'image/*')) ?>
            </div>
        </div>
        <div class="modal-footer">
			<?= Html::anchor('#', '', array('class' => 'btn btn-primary', 'onClick' => "$('#myModal form').submit()")) ?>
        </div>
    <?= Form::close()?>
</div>
<script>
    $(document).ready(function(){
        $("ul.nav li:nth-child(2)").addClass("active");
    });
</script>









