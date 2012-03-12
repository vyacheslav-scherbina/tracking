function clear(selector){
    $(selector).find(':input').each(function(){
        if (this.type != 'submit'){
            $(this).val('');                        
        }
    });
}

function validateContact(selector, action){
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

function add_contact(){
    var options = {
        url: 'contact/add',
        success: showResponse,
        dataType: 'json'
    };
    function showResponse(data){
        if (data.person == 1) {
            //Putting data to row
            var field = "#add_contact_form :input";
            var name = "<td class = 'name'><img alt='avatar_"+data.image_id+"_32x32' src='image/show/avatar_"+data.image_id+"_32x32.png') /><span class = 'first_name'>"+$(field + '[name = "first_name"]').val()+"</span><span class = 'last_name'>"+$(field + '[name = "last_name"]').val()+"</span></td>";
            var email = "<td class = 'email'>"+$(field + '[name = "email"]').val()+"</td>";
            var skype = "<td class = 'skype'>"+$(field + '[name = "skype"]').val()+"</td>";
            var phone = "<td class = 'phone'>"+$(field + '[name = "phone"]').val()+"</td>";
            var company = "<td>"+$("#add_contact_form select[name = 'company_id'] option:selected").html()+"</td>";
            var buttons = "<td class='buttons'><button class = 'btn edit' contact_id = '"+data.contact_id+"'>Edit</button>\
                <button class = 'btn delete' contact_id = '"+data.contact_id+"'>Delete</button></td></tr>";
            var tr = '<tr>'+name+email+skype+phone+company+buttons+'</tr>';
            $('#contacts_table tbody').prepend(tr);
        }
        $('#modal_form').modal('hide');
    }
    $('#add_contact_form').ajaxSubmit(options);
    return false;
}

function edit_contact(){
    var options = {
        url: 'contact/edit',
        success: showResponse,
        dataType: 'json'
    };
    function showResponse(data){
        if (data.person == 1){
            var field = "#add_contact_form input";
            var id = $(field+"[name = 'id']").val();
            var thisButton = "button[contact_id = "+id+"]";
            //Putting data to row
            $(thisButton).parent().siblings().each(function(){
                switch ($(this).attr('class')) {
                    case 'name':
                        if (data.image == 1){
                            $(this).children('img').attr('src', 'image/show/avatar_'+data.image_id+'_32x32.png');
                        }
                        $(this).children('.first_name').html($(field + "[name = 'first_name']").val());
                        $(this).children('.last_name').html($(field + "[name = 'last_name']").val());
                        break;
                    case 'company':
                        var company = $("#add_contact_form select option:selected").text();
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
    }
    $('#add_contact_form').ajaxSubmit(options);
    $("#add_contact_form input[name = 'password']").parent().parent().show();
    $('#modal_form').modal('hide');
}

$("ul.nav li:nth-child(5)").addClass("active");

$(document).ready(function(){
    $(document).on('click', 'a.add', function(event){
        clear('#modal_form');
        $('#modal_form .modal-header h3').html('Add contact');
        $('#modal_form').modal('show');
        validateContact('#add_contact_form', add_contact);
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
                $("#add_contact_form select option:contains("+data[key]+")").attr('selected', 'selected');
            }
            else {
                var selector = '#add_contact_form :input[name = "'+key+'"]';
                $(selector).val(data[key]);
            }
        }
        $('#modal_form .modal-header h3').html('Edit contact');
        var id = $(event.target).attr('contact_id');
        $("#add_contact_form input[name = 'id']").val(id);
        $("#add_contact_form input[name = 'password']").parent().parent().hide();
        $('#modal_form').modal('show');
        validateContact('#add_contact_form', edit_contact);
    });

    $(document).on('click', 'button.delete', function(event){
        var id = $(event.target).attr('contact_id');
        $.post('contact/delete', "id="+id, function(data){
            if (data == 1){
                $("button[contact_id="+id+"]").parent().closest('tr').remove();
            }
        });
    });
});