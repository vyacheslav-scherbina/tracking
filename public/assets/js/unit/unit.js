var unit = {
    'save_changes': function (event, ui){
        ui.item.attr("unit_id", ui.item.parent().attr("unit_id"));
        ui.item.attr("is_unit_manager", ui.item.parent().attr("is_unit_manager"));

        var person = {
            "id": ui.item.attr("id"),
            "unit_id": ui.item.attr("unit_id"),
            "is_unit_manager": ui.item.attr("is_unit_manager")
        };

        $.ajax({
            type: 'post',
            url: "unitajax/save_changes.json",
            data: person,
            error: function(){
                alert("Error"); // временное решение
            }
        });
    }
};

$(document).ready(function(){
    
    $(".add").click(function(){
        $("#myModal").css('visibility', 'visible').modal();
        $("div.modal-header h2").html("New Unit");
        $(".modal-footer a").html('Add');
        $("#myModal form").attr('action', 'unit/create/');
        $("#input_unit_name").css('color', 'grey').val('Unit Name').click(function(){
            if (this.value == 'Unit Name'){
                this.value = '';
            }
            this.style.color = 'black';
        }).blur(function(){
            if (this.value == ''){
                this.value = 'Unit Name';
                this.style.color = 'grey'
            }
        });
    });
    
    $("h1.unit_name").dblclick(function(){
        $("#myModal").css('visibility', 'visible').modal();
        $("div.modal-header h2").html("Edit Unit");
        $("#input_unit_name").focus().val($(this).html());
        $("#myModal form").attr('action', 'unit/edit/' + $(this).attr('unit_id'));
        $(".modal-footer a").html('Edit');
    });
    
    $( "ul.sortable" ).sortable({
		connectWith: "ul.sortable",
		stop: function(event, ui) {
            unit.save_changes(event, ui);
        }
	});
    
    $( "ul.homeless" ).sortable({
		connectWith: "ul.sortable",
		stop: function(event, ui) {
            unit.save_changes(event, ui);
            
            if($(".homeless li").length == 0){
                $("li#homeless").remove();
            };
        }
	});
    
    $("li.unit").mouseenter(function(){
        $("#b_" + $(this).attr('id')).css('visibility', 'visible');
    }).mouseleave(function(){
        $("#b_" + $(this).attr('id')).css('visibility', 'hidden');
    });
    
});
