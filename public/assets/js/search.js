function filter(query, selector){
    query = $.trim(query);
    //Uncomment this if you need space to be interpreted as OR
    //query = query.replace(/ /gi, '|');
    $(selector).each(function(){
        var check = 0;
        $(this).children().each(function(){
            if ($(this).attr('class') != 'buttons'){
                var result = $(this).text().search(new RegExp(query, 'i'));
                if (result >= 0){
                    check = 1;    
                }
            }
        });
        if (check == 1){
            $(this).show().addClass('visible');
        }
        else {
            $(this).hide().removeClass('visible');
        }
    });
}

$(document).ready(function(){
    // !!! SELECTOR HERE
    var selector = 'tbody tr';
    $(selector).addClass('visible');
    $('#search').keyup(function(event) {
        // if 'Escape' or null 
        if (event.keyCode == 27 || $(this).val() == '') {
            $(this).val('');
            $(selector).removeClass('visible').show().addClass('visible');
        }
        else {
            filter($(this).val(), selector);
        }
    });
});