$(function() {
    function avatarUpload()
    {
        // Dans le cas où on édite le profil
        var avatarInput = $('#user_avatar');

        // Dans le cas où on édite un personnage
        if (!avatarInput.length) {
            avatarInput = $('#post_character_avatar');
        }

        $('.avatarbox .label-glyph').on('click', function(event) {
            $(avatarInput).trigger('click');
        });

        avatarInput.on('change', function(event) {
            if (this.files && this.files[0]) {
                var uploadedFile = this.files[0];
                var isValid      = false;

                var temp_avatar = new Image();
                $(temp_avatar).hide();
                $('.avatarbox').append(temp_avatar);

                var reader = new FileReader();
                reader.onload = function (e) {
                    $(temp_avatar).attr('src', e.target.result);
                }
                reader.readAsDataURL(uploadedFile);

                temp_avatar.onload = function (e) {
                    if ($(temp_avatar).width() === 150 && $(temp_avatar).height() === 150) {
                        isValid = true;
                    }

                    if (isValid) {
                        $(temp_avatar).remove();

                        var reader = new FileReader();
                        reader.onload = function (e) {
                            $('.avatarbox img').attr('src', e.target.result);
                        }
                        reader.readAsDataURL(uploadedFile);

                        $('.avatarbox .label-glyph').attr({'class': 'glyphicon glyphicon-ok label-glyph'});
                    } else {
                        $('.avatarbox .label-glyph').attr({'class': 'glyphicon glyphicon-warning-sign label-glyph'});

                        // jCrop to the rescue !
                        getJCrop(temp_avatar, avatarInput);
                    }
                }
            }
        });
    }

    function getJCrop(temp_avatar, avatarInput)
    {
        var cropBox = $('<div>');
        cropBox.addClass('cropbox');
        $('body').append(cropBox);

        $('body').on('click', function() {
            event.stopPropagation();
            cropBox.fadeOut();
        });

        cropBox.append(temp_avatar);
        $(temp_avatar).show();
        $(temp_avatar).Jcrop({
            aspectRatio: 1,
            minSize   : [150, 150],
            onSelect  : showCoords,
            onChange  : showCoords,
            boxWidth  : 600,
            boxHeight : 600,
            keySupport: false
        });

        var input_x = $('<input>');
        createInput($('#character-creation'), input_x, 'x');

        var input_y = $('<input>');
        createInput($('#character-creation'), input_y, 'y');

        var input_w  = $('<input>');
        createInput($('#character-creation'), input_w, 'w');

        var input_h  = $('<input>');
        createInput($('#character-creation'), input_h, 'h');

        var input_submit = $('<input>');
        input_submit.val('Trancher l\'image au sabre-laser');
        input_submit.prop('type', 'submit');
        input_submit.prop('id', 'uploadCroppedAvatar');
        $('.jcrop-holder').append(input_submit);

        input_submit.on('click', function() {
            var data = new FormData();

            data.append('avatar', avatarInput[0].files[0]);
            data.append('x', input_x.val());
            data.append('y', input_y.val());
            data.append('w', input_w.val());
            data.append('h', input_h.val());

            $.ajax({
                url: update_avatar_by_ajax_path,
                data: data,
                enctype: 'multipart/form-data',
                contentType: false,
                processData: false,
                cache: false,
                dataType: "json",
                type: 'POST',
                success: function(data) {
                    $('.avatarbox img').attr('src', character_avatar_path + data);
                    cropBox.fadeOut();
                },
                error: function(err) {
                    var errorDiv = $('<div>');
                    errorDiv.html(err.responseText);
                    errorDiv.css({position : 'absolute', 'top' : 0, 'left' : 0, 'z-index' : 62000})
                    $('body').append(errorDiv);
                    errorDiv.on('click', function() {
                        $(this).remove();
                    })
                },
            });
        });
    }

    function showCoords(c)
    {
        $('#x').val(c.x);
        $('#y').val(c.y);
        $('#w').val(c.w);
        $('#h').val(c.h);
    }

    function createInput(parent, input, name)
    {
        input.prop('type', 'hidden');
        input.prop('id', name);
        input.prop('name', name);
        parent.append(input);
    }

    function init()
    {
        avatarUpload();
    }

    init();
});
