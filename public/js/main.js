$('.Popup-close').on('click', function(){
    $(this).parents('.Popup-Container').addClass('hidden');
});

$('.Popup-open').on('click', function(){
    var object = $(this);
    loadPopup($('#Users'), {
        id      : object.data('id'),
        title   : object.data('title'),
        action  : object.data('action'),
        inputs  : inputs
    });
});

var inputs;

function setInputs(inputs){
    self.inputs = inputs;
}

function loadPopup(popup, params){
    popup.removeClass('hidden');
    $('#Popup-title').text(params.title);

    if(params.action === 'create')
        printForm(params, null);
    else if(params.action === 'edit')
        $.post('/index.php', {handle : params.action, id : params.id }, function(values){
            values = JSON.parse(values);
            printForm(params, values);
        });
    else
        console.log(params);
}


function printForm(params, values) {
    var html =  '',
        form = $('#Popup-form'),
        submited = params.action === 'edit'
                 ? 'formUpdate-submitted'
                 : 'form-submitted';

    $.each(params.inputs, function(index, input){
        var value = values ? values[input.name] : '';
        html += '<div class="form-group">' +
                    '<label for="' + input.name + '">' + input.text + '</label>' +
                    '<input type="text" id="' + input.name + '" placeholder="' + input.text + '" class="form-control" value="'+ value + '">' +
                '</div>';
    });

    html += '<input type="hidden" name="' + submited + '" value="1" />' +
            '<button data-action="' + params.action + '" id="Popup-submit" type="submit" class="btn btn-default">' + params.title + '</button>';

    form.html(html);

    $('#Popup-submit').on('click', function(){
        var action = $(this).data('action') + 'Post';
        $.each($('#Popup-form input'), function (index, input) {
            params[input.id] = input.value;
        });

        $.post('/index.php', {
            handle : action,
            all : params
        }, function(){
            $('.Popup-close').trigger('click');
            window.location.reload();
        })
    });
}

    $(".form_datetime").datetimepicker({
        format: "yyyy-mm-dd",
        showMeridian: false,
        setStartDate : '2016-11-23',
        autoclose: true,
        todayBtn: true
    });

/*
* calendarStart
* calendarEnd
* calendarTitle
* calendarDescription
* calendarCreate
* */

function send(params, action){
    $.each($('#Popup-form input'), function (index, input) {
        params[input.id] = input.value;
    });
}

$('#calendarOpen').on('click', function(){
    loadPopup($('#Calendar'));
});

$('#calendarCreate').on('click', function(){
    var params = {
        title       : $('#calendarTitle').val(),
        description : $('#calendarDescription').val(),
        start       : $('#calendarStart').val(),
        end         : $('#calendarEnd').val()
    };

    $.post('/index.php', {
        handle : 'createCalendar',
        all : params
    }, function(data){
        $('.Popup-close').trigger('click');
        window.location.reload();
    })

});






