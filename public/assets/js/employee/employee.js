function clear(selector){
    $(selector).find(':input').each(function(){
        if (this.type != 'submit'){
            $(this).val('');                        
        }
    });
}

function validateEmployee(selector, action){
    $(selector).validate({
        debug: false,
        rules: {
            first_name: "required",
            last_name: "required",
            email: {
                required: true,
                email: true
            },
            password: "required"
        },
        messages: {
            first_name: "Enter first name",
            last_name: "Enter last name",
            email: {
                required: "Enter e-mail",
                email: "Wrong e-mail"
            }
        },
        submitHandler: function(form) {
            action()
        }
    });
}

function add_employee(){
    var output = $('#add_employee_form').serialize();
    $.post("employee/add", $('#add_employee_form').serialize(), function(data){
        if (data == 1) {
            var field = "#add_employee_form :input";
            //Putting data to row
            var name = "<td class = 'name'><span class = 'first_name'>"+$(field + '[name = "first_name"]').val()+"</span><span class = 'last_name'>"+$(field + '[name = "last_name"]').val()+"</span></td>";
            var email = "<td class = 'email'>"+$(field + '[name = "email"]').val()+"</td>";
            var skype = "<td class = 'skype'>"+$(field + '[name = "skype"]').val()+"</td>";
            var phone = "<td class = 'phone'>"+$(field + '[name = "phone"]').val()+"</td>";
            var unit = "<td>"+$("#add_employee_form select[name = 'unit_id'] option:selected").html()+"</td>";
            var buttons = "<td class='buttons'><button class = 'btn edit' contact_id = '"+$(field + '[name = "id"]').val()+"'>Edit</button>\
                <button class = 'btn delete' contact_id = '"+$(field + '[name = "id"]').val()+"'>Delete</button></td></tr>";
            var tr = '<tr>'+name+email+skype+phone+unit+buttons+'</tr>';
            $('#employee_table tbody').prepend(tr);
        }
        $('#modal_form').modal('hide');
    });
}

function edit_employee(){
    $.post("employee/edit", $('#add_employee_form').serialize(), function(data){
        if (data == 1) {
            var field = "#add_employee_form input";
            var id = $(field+"[name = 'id']").val();
            var thisButton = "button[employee_id = "+id+"]";
            //Putting data to row
            $(thisButton).parent().siblings().each(function(){
                switch ($(this).attr('class')) {
                    case 'name':
                        $(this).children('.first_name').html($(field + "[name = 'first_name']").val());
                        $(this).children('.last_name').html($(field + "[name = 'last_name']").val());
                        break;
                    case 'company':
                        var company = $("#add_employee_form select option:selected").text();
                        if (company != 'No company') {
                            $(this).html(company);                            
                        }
                        else{
                            $(this).html('');
                        }
                        break;
                    default:
                        var key = $(this).attr('class');
                        $(this).html($(field + "[name = '"+key+"']").val());
                        break;
                }
            });
        }  
    });
    $("#add_employee_form input[name = 'password']").parent().parent().show();
    $('#modal_form').modal('hide');
}

$("ul.nav li:nth-child(1)").addClass("active");

$(document).ready(function(){
    $(document).on('click', 'a.add', function(event){
        clear('#modal_form');
        $('#modal_form .modal-header h3').html('Add employee');
        $('#modal_form').modal('show');
        validateEmployee('#add_employee_form', add_employee);
    });

    $(document).on('click', 'button.edit', function(event){
        //Getting data from the row
        var data = {};
        $(event.target).parent().siblings().each(function(){
            var key = $(this).attr('class');
            if (key == 'name'){
                var value = $(this).children('.first_name').html();
                data.first_name = value;
                value = $(this).children('.last_name').html();
                data.last_name = value;                                
            }
            else {
                var value = $(this).html();
                data[key] = value;
            }
        });
        //Putting data to form
        for (var key in data){
            if (key == 'company' && data[key] != '') {
                $("#add_employee_form select option:contains("+data[key]+")").attr('selected', 'selected');
            }
            else {
                var selector = '#add_employee_form :input[name = "'+key+'"]';
                $(selector).val(data[key]);
            }
        }
        $('#modal_form .modal-header h3').html('Edit employee');
        var id = $(event.target).attr('employee_id');
        $("#add_employee_form input[name = 'id']").val(id);
        $("#add_employee_form input[name = 'password']").parent().parent().hide();
        $('#modal_form').modal('show');
        validateEmployee('#add_employee_form', edit_employee);
    });

    $(document).on('click', 'button.delete', function(event){
        var id = $(event.target).attr('employee_id');
        $.post('employee/delete', "id="+id, function(data){
            if (data == 1){
                $("button[employee_id="+id+"]").parent().closest('tr').remove();
            }
        });
    });
});