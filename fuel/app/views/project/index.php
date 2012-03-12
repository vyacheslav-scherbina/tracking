<?php echo Asset::js('project/combobox_widget.js') ?>
<?php echo Asset::css('jquery-ui.css') ?>

<? if ($superuser): ?>
    <?php echo Asset::js('project/project.js') ?>
<? endif ?>

<?php echo Asset::css('project/project.css') ?>

<? foreach ($projects as $project_id => $project): ?>

<div class="row well" style="margin-left: 0px;" project_id="<?=$project_id?>">
    
        <div class="cell projectCell">
            
         <div class="span3" style="height: 115px; margin-left: 0px;"><?= Html::anchor('project/delete/'.$project_id, '&#215;', array("id" => "b_$project_id" ,"class" => "close-btn", "onClick" => "return confirm('Are you sure?')")) ?>
             <div class="btn-group btn-circle btn-right ">
            <? if ($superuser): ?>
                <a  data-toggle="dropdown" href="#" class="btn btn-success dropdown-toggle btn-circle btn-right unitsDropdownButton"  project_id="<?=$project_id?>">+</a>
            <? endif ?>
            <ul class="dropdown-menu dropdown-units">
                   <!-- data -->
              </ul>

            </div>
            
            
            <h2><?=$project->name?></h2>
           <p class="person">
               <? if(isset($project->manager->first_name)): ?>
                    <?=Html::img('image/show/avatar_'.$project->manager->image_id.'_32x32.png').$project->manager->first_name.' '.$project->manager->last_name ?>
               <? else: ?>
                        Unknown Manager(maybe deleted)
               <? endif ?>
           </p>
         </div>
        </div>
        
        <div class="cell unitsCell" project_id="<?=$project_id?>">
         <div class="span2 well well-span">
              <div class="well company well-title">
             
                 <? if (isset($project->company->name)): ?>
                    <?= Html::img('assets/img/unit/unit_icon.png').$project->company->name ?>
                    <? if ($superuser): ?>
                        <a data-toggle="modal" href="#" class="btn btn-success btn-circle btn-right personsModalButton" company_id="<?=$project->company->id?>">+</a>
                    <? endif ?>
                  <? else: ?>
                        Unknown Company (maybe deleted)
                  <? endif ?>
              </div>
            
           <ul class="sortable contact" project_id="<?=$project_id?>">
               <? if(isset($contacts[$project_id]['persons'])) foreach ($contacts[$project_id]['persons'] as $contact): ?>
                    <li id="<?=$contact->id?>" project_id="<?=$project_id?>"><?=Html::img('image/show/avatar_'.$contact->image_id.'_32x32.png', array('title ' => $contact->first_name.' '.$contact->last_name)) ?></li>
                <? endforeach; ?>
            </ul>
         </div>   

        <? if(isset($units[$project_id]['units']))  foreach ($units[$project_id]['units'] as $unit): ?>    
         <div class="span2 well well-span" unit_id="<?=$unit->id?>">
              <div class="well unit well-title">
                  <?=Html::img('image/show/avatar_'.$unit->image_id.'_32x32.png').$unit->name ?>
                  <? if ($superuser): ?>
                    <a data-toggle="modal" class="btn btn-success btn-circle btn-right personsModalButton" unit_id="<?=$unit->id?>">+</a>
                  <? endif ?>
              </div>
            
                      <ul class="sortable person"  project_id="<?=$project_id?>" unit_id="<?=$unit->id?>">
                        <? foreach ($units[$project_id]['persons'][$unit->id] as $person): ?>
                            <li id="<?=$person->id?>" project_id="<?=$project_id?>" unit_id="<?=$unit->id?>"><?=Html::img('image/show/avatar_'.$person->image_id.'_32x32.png', array('title ' => $person->first_name.' '.$person->last_name)) ?></li>
                        <? endforeach; ?>
                    </ul>
         </div>  
        <? endforeach; ?>
        
        </div>  
      </div>

<? endforeach; ?>


<div id="changeListsModal" class="modal hide">
            <div class="modal-header">
              <a class="close" data-dismiss="modal">×</a>
              <h3>Edit Persons</h3>
            </div>
            <div class="modal-body">
                <div class="modal_c">
                <div class="span3 modal-span3 well">
                        <ul class="sortable person" id="thislist">
                            <!-- data -->
                        </ul>
                </div> 
                <div class="span3 modal-span3 well">
                         <ul class="sortable person" id="fulllist">
                             <!-- data -->
                        </ul>
                </div> 
                </div>
            </div>
            <div class="modal-footer">
              <a href="#" class="btn" data-dismiss="modal">Close</a>
            </div>
</div>

<div class="alert alert-error hide fade in">
  <!-- <a class="close" data-dismiss="alert">×</a> -->
  <h4 class="alert-heading">Warning!</h4>
  <div id="alert_text"><!-- data --></div>
</div>

<div class="modal hide" id="projectAddModal">
    <div class="modal-header">
        <a class="close" data-dismiss="modal">×</a>
        <h2>New Project</h2>
    </div>

        <div class="modal-body">
    <?= Form::open('project/create', array('method' => 'post')) ?>

                <?= Form::label('Name:'); ?>
                <?= Form::input('name', null, array('id' => 'project_name')) ?>
          
                <?= Form::label('Project manager:'); ?>

                <select id="managers_combobox" name="manager">
                    <!-- data -->
                </select>
            
                <?= Form::label('Company:'); ?>

                <select id="companies_combobox" name="company">
                    <!-- data -->
                </select>
            
        </div>  
                <div class="modal-footer">
                    <a href="#" class="btn btn-primary" onClick="add_project()">Add</a>
                    <a href="#" class="btn" data-dismiss="modal">Close</a>
            </div>
      <?= Form::close()?>
</div>

<script>
    $(document).ready(function(){
        $("ul.nav li:nth-child(3)").addClass("active");
    });
</script>
