$('.Popup-close').on('click', function(){
    $(this).parents('.Popup-Container').addClass('hidden');
});

$('.Popup-open').on('click', function(){
    var object = $(this);
    loadPopup($('.Popup-Container'), {
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

    params.action !== 'edit'
        ? printForm(params, null)
        : $.post('/index.php', {handle : params.action, id : params.id }, function(values){
              values = JSON.parse(values);
              printForm(params, values);
          })
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