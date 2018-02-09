$(function() {
    function avatarUpload()
    {
        var avatarInput = $('#user_avatar');

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

                    $(temp_avatar).remove();

                    if (isValid) {
                        var reader = new FileReader();
                        reader.onload = function (e) {
                            $('.avatarbox img').attr('src', e.target.result);
                        }
                        reader.readAsDataURL(uploadedFile);

                        $('.avatarbox .label-glyph').attr({'class': 'glyphicon glyphicon-ok label-glyph'});
                    } else {
                        $('.avatarbox .label-glyph').attr({'class': 'glyphicon glyphicon-warning-sign label-glyph'});
                    }
                }
            }
        });
    }

    function init()
    {
        avatarUpload();
    }

    init();
});
