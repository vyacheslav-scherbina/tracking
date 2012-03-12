function validateCompany(selector, action){
    $(selector).validate({
        debug: false,
        rules: {
            name: "required",
            country: "required"
        },
        messages: {
            name: "Enter name",
            country: "Enter country"
        },
        submitHandler: function(form) {action()}
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
        submitHandler: function(form) {action()}
    });
}

function add_company(){
    var options = {
        url: 'company/add',
        success: showResponse,
        dataType: 'json'
    };
    function showResponse(data){
        if (data.company == 1){
            //Putting data to row
            var input = '#add_company_form :input';
            var name = "<td class = 'name'><img src='image/show/company_"+data.image_id+"_32x32.png'><div class = 'name'>"+$(input + "[name = 'name']").val()+"</div></td>";
            var country = "<td class = 'country'>"+$(input+'[name = "country"]').val()+"</td>";
            var contacts = "<td class = 'contacts'><div class = 'contacts'><button class = 'btn add_contact_to_company' company_id = "+data.company_id+">+</button></div></td>";
            var details = "<td class = 'details'>"+$(input+'[name = "details"]').val()+"</td>";
            var buttons = "<td class = 'buttons'><button class = 'btn edit' company_id = "+data.company_id+">Edit</button><button class = 'btn delete' company_id = "+data.company_id+">Delete</button></td>";
            var tr = "<tr>"+name+country+contacts+details+buttons+"</tr>";
            $('#companies_table tbody').prepend(tr);
            $('#ajax_alert').html('Company successfully added');
            $('#ajax_alert').fadeIn('slow').delay(2000).fadeOut('slow');
        }
    }
    $('#add_company_form').ajaxSubmit(options);
    $('#modal_form').modal('hide');
}

function edit_company(){
    var options = {
        url: 'company/edit',
        success: showResponse,
        dataType: 'json'
    };
    function showResponse(data){
        if (data.company == 1){
            var id = $("#add_company_form input[name = 'id']").val();
            var thisButton = "button[company_id = "+id+"]";
            $(thisButton).parent().siblings().each(function(){
                var key = $(this).attr('class');
                if (key != 'contacts'){
                    var value = $("#add_company_form :input[name = '"+key+"']").val();
                    if (key == 'name'){
                        $(this).children('.name').html(value);
                    }
                    else {
                        $(this).html(value);
                    }
                }
                if (data.image == 1){
                    $(this).children('img').attr('src', 'image/show/company_'+data.image_id+'_32x32.png');
                }
            });
            //Input file field cleaning
            $('#add_company_form input[type = "file"]').html($('#add_company_form input[type = "file"]').clone());
        }
    }
    $('#add_company_form').ajaxSubmit(options);
    $('#modal_form').modal('hide');
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
            var field = "#add_contact_form input";
            var id = $(field + "[name = 'company_id']").val();
            var contacts = $("button.add_contact_to_company[company_id = "+id+"]").parent('.contacts');
            var first = "<span class = 'first_name'>"+$(field+"[name = 'first_name']").val()+"</span>";
            var last = "<span class = 'last_name'>"+$(field+"[name = 'last_name']").val()+"</span>";
            var contact = '';
            img = "<img src='image/show/avatar_"+data.image_id+"_32x32.png')/>";
            contact = "<div class = 'contact'>"+img+first+last+"</div>";
            contacts.prepend(contact);
            $(field + "[name = 'first_name']").val();
        }
        $('#modal_form_contact').modal('hide');
    }
    $('#add_contact_form').ajaxSubmit(options);
    return false;
}


function clear(selector){
    $(selector).find(':input').each(function(){
        if (this.type != 'submit'){
            $(this).val('');                        
        }
    });
}

$("ul.nav li:nth-child(4)").addClass("active");

$(document).ready(function(){

    $(document).on('click', 'button.edit', function(event){
        var data = {};
        $(event.target).parent().siblings().each(function(){
            var key = $(this).attr('class');
            if (key != 'contacts'){
                if (key == 'name'){
                    value = $(this).children('.name').html();
                }
                else {
                    value = $(this).html();
                }
                $('#add_company_form :input[name = "'+key+'"]').val(value);
            }
        });        
        var id = $(event.target).attr('company_id');
        $("#add_company_form input[name = 'id']").val(id);
        $('#modal_form .modal-header h3').html('Edit company');
        $('#modal_form').modal('show');
        validateCompany('#add_company_form', edit_company);
    });
    
    $(document).on('click', 'a.add', function(event){
        clear('#modal_form');
        $('#modal_form .modal-header h3').html('Add company');
        $('#modal_form').modal('show');
        validateCompany('#add_company_form', add_company);
    });
    
    $(document).on('click', 'button.delete', function(event){
        var id = $(event.target).attr('company_id');
        $.post('company/delete', "id="+id, function(data){
            if (data == 1){
                $("button[company_id="+id+"]").parent().closest('tr').remove();
            }
        });
    });
    
    $(document).on('click', 'button.add_contact_to_company', function(event){
        clear('#modal_form_contact');
        $('#modal_form_contact').modal('show');
        var company_id = $(event.target).attr('company_id');
        $("#add_contact_form input[name = 'company_id']").val(company_id);
        validateContact('#add_contact_form', add_contact);
    });
});


