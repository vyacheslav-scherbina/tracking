function show_alert(message) {
    $(".alert").find("#alert_text").html(message);
    $(".alert").animate({'height':'toggle','opacity':'toggle'});
    window.setTimeout( function(){
        $(".alert").slideUp();
    }, 3000);
}

function add_project() {        
        if( (!$('#manager').val()) || (!$('#company').val()) || (!$('#project_name').val()) ) {
            show_alert("Не все поля заполнены!");
            return false;
        }
    
        $('#projectAddModal form').submit();
}

$(function() {    

     $('#changeListsModal').find(".modal-body").find("ul.sortable").sortable({
            connectWith: "ul.sortable",
            stop: function(event, ui) {
                var method;
                if($(ui.item).parent().attr('id') !== 'fulllist') {
                    method="add_person";
                } else {
                    method="delete_person";
                }

                var person = {
                    "id": ui.item.attr("id"),
                    "unit_id": ui.item.attr("unit_id"),
                    "project_id": ui.item.attr("project_id")
                };

                var who_method = ui.item.parent().parent().parent().attr('method');
                if(who_method == "employees")
                    var page_list=$('ul.person[project_id="'+person.project_id+'"][unit_id="'+person.unit_id+'"]'); 
                else {
                    var page_list=$('ul.contact[project_id="'+person.project_id+'"]');       
                }


                $.ajax({
                    url: "projectajax/"+method+".json",
                    type: 'post',
                    data: person,
                    success: function () {                     
                        var thislist = $('#thislist').find("li");
                        
                        page_list.empty();
                        thislist.clone().appendTo(page_list);
                        
                        if(who_method == "employees" && page_list.find('li').length == 0) {
                            $('#changeListsModal').on('hide.unitRemover', function () { 
                                page_list.parent().remove();
                                $('#changeListsModal').unbind('hide.unitRemover');
                            })
                        }
                    },
                    error: function () {
                        show_alert("Произошла ошибка!");
                        event.preventDefault(); //cancel move
                    }
                })
            }
        });

     function addUnit(unit, project_id) {
        var unitsCell = $('.row[project_id="'+project_id+'"] > .unitsCell');
        
        var unit_div = $('<div>', {'class': 'span2 well well-span', 'unit_id': unit.id})
            .append(
                $('<div>', {'class': 'well unit well-title'})
                    .html('<img src="image/show/avatar_'+unit.image_id+'_32x32.png">'+unit.name )
                    .append($('<a>', {
                        'data-toggle': 'modal',
                        'class': 'btn btn-success btn-circle btn-right personsModalButton',
                        'unit_id': unit.id,
                        html: '+',
                        click: personsModalButtonClick
                    })
                    )
            )
            .append($('<ul>', {
                    'class': 'sortable person',
                    'project_id': project_id,
                    'unit_id': unit.id
                })
                
             );
                
            unitsCell.append(unit_div);
            
     }

    $('.unitsDropdownButton').click(function() {
        var project_id = $(this).attr('project_id');
        var unitsCell = $('.row[project_id="'+project_id+'"] > .unitsCell');

         var unitsList = $(this).parent().find(".dropdown-units");
         unitsList.empty();
         
         var return_ = true;
        
         $.ajax({
            url: "projectajax/units.json",
            type: 'post',
            data: {
                'without': unitsCell.children().map(function(){
                   return $(this).attr('unit_id');
                }).get()
            },
            dataType : "json",
            
            success: function(data){
                $.each(data['units'], function(i, unit){
                        unitsList.append(
                            $('<li>')
                                .append($("<a>")
                                    .append('<img src="image/show/avatar_'+unit.image_id+'_32x32.png">')
                                    .append(unit.name)
                                    .click( function () {
                                        addUnit(unit, project_id)
                                    })
                                )
                        )
                    }
                );
            },
            error: function () {
                    return_ = false;
                    show_alert("Произошла ошибка!");
            }
        });
        
        return return_;
    });
    
    
    //add project modal
    $('.add').click(function() {      
        $.ajax({
            url: "projectajax/companies.json",
            dataType : "json",
            
            success: function(data){
                var combobox = $('#projectAddModal #companies_combobox');
                combobox.empty();
                
                $.each(data['companies'], function(i, company){
                        combobox.append($('<option value="'+company.id+'">'+company.name+'</option>'));
                    }
                );
                    
                    $.ajax({
                        url: "projectajax/managers.json",
                        dataType : "json",

                        success: function(data){
                            var combobox = $('#projectAddModal #managers_combobox');
                            combobox.empty();

                            $.each(data['managers'], function(i, manager){
                                    combobox.append($('<option value="'+manager.id+'">'+manager.name+'</option>'));
                                }
                            );

                        $('#projectAddModal').modal();

                        },
                        error: function () {
                                show_alert("Произошла ошибка!");
                        }
                    });

            },
            error: function () {
                    show_alert("Произошла ошибка!");
            }
        });
  
    });
    

    //show persons modal
    var personsModalButtonClick = function() {
        
        var thislist = $('#changeListsModal').find('#thislist');
        var fulllist = $('#changeListsModal').find('#fulllist');
        
        var this_li =$(this).parent().parent().find("li");
        var project_id =$(this).parent().parent().parent().attr('project_id'); //parentception [x]

        //clean
        thislist.empty();
        fulllist.empty();
         
        //clone 
        this_li.clone().appendTo(thislist);
            
        var unit_id;
        var method;

       if($(this).attr('unit_id') !== undefined) {
           unit_id=$(this).attr('unit_id');
           method="employees";
       } else {
           unit_id=$(this).attr('company_id');
           method="contacts";
       }

        $.ajax({
            url: "projectajax/"+method+".json",
            type: 'post',
            data: {
                'unitid':  unit_id,
                'without': this_li.map(function(){
                   return $(this).attr('id');
                }).get()
            },
            dataType : "json",
            
            success: function(data){
                fulllist.parent().parent().attr('method', method);
                
                $.each(data['persons'], function(i, empl){
                        fulllist
                            .append(
                                $('<li>')
                                    .attr('id', i)
                                    .attr('unit_id', unit_id)
                                    .attr('project_id', project_id)
                                        .append($('<img>')
                                            .attr('src', 'image/show/avatar_'+empl.image+'_32x32.png')
                                            .attr('title', empl.first_name+"  "+empl.last_name)
                                        )
                                        //.append(empl.first_name+"  "+empl.last_name)    
                            );
                    }
                );
                    
            $('#changeListsModal').modal();

            },
            error: function () {
                    show_alert("Произошла ошибка!");
            }
        });
    };
    
    $('.personsModalButton').click(personsModalButtonClick);

    $( "#companies_combobox" ).combobox();
    $( "#managers_combobox" ).combobox();

    $("div.row").mouseenter(function(){
        $("#b_" + $(this).attr('project_id')).css('visibility', 'visible');
    }).mouseleave(function(){
        $("#b_" + $(this).attr('project_id')).css('visibility', 'hidden');
    });
});

