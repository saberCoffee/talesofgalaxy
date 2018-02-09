$(function() {
    var textarea = $('.messagebox')[0];

    var bbcodeWrapper = document.createElement('div');
    bbcodeWrapper.className = 'bbcodeWrapper';
    textarea.before(bbcodeWrapper);

    var colorBlock = document.createElement('div');
    colorBlock.id  = 'colorBlock';
    bbcodeWrapper.append(colorBlock);

    var colorPalette = createColorPalette();
    colorBlock.append(colorPalette.el);

    var bbcodeList =  [
        {
            name: 'b',
            value: 'b'
        },
        {
            name: 'i',
            value: 'i'
        },
        {
            name: 'img',
            value: 'img'
        },
        {
            name: 'quote',
            value: 'quote'
        },
        {
            name: 'url',
            value: 'url'
        },
        {
            value: 'size',
            options: [
                {
                    name: 'Minuscule',
                    value: 50
                },
                {
                    name: 'Petite',
                    value: 85
                },
                {
                    name: 'Normale',
                    value: 100,
                    default: true
                },
                {
                    name: 'Grande',
                    value: 150
                },
                {
                    name: 'Énorme',
                    value: 200
                }
            ]
        },
        {
            name: 'Couleur de la police',
            value: 'color'
        }
    ];

    var bbcodecount = bbcodeList.length;

    for (var i = 0; i < bbcodecount; i++) {
        (function(i) {
            var bbcode = bbcodeList[i];

            var input = document.createElement('span');
            if (!bbcode.options) {
                input.innerHTML = bbcode.name;
            } else {
                input.className = 'options';
            }
            bbcodeWrapper.append(input);

            switch (bbcode.value)
            {
                case 'b':
                    input.style.fontWeight = 'bold';
                    break;
                case 'i':
                    input.style.fontStyle = 'italic';
                    break;
            }

            if (bbcode.options) {
                var options = bbcode.options;

                var select = document.createElement('select');
                input.append(select);

                options.forEach(function( v,i ) {
                    var option = document.createElement('option');
                    option.value     = options[i].value;
                    option.innerHTML = options[i].name;
                    if (options[i].default) {
                        option.selected = 'selected';
                    }
                    select.append(option);
                });

                $(select).on('change', function() {
                    var openTag  = '[' + bbcode.value + '="' + $(this)[0].value + '"]';
                    var closeTag = '[/' + bbcode.value + ']';

                    insertBBcode(bbcode.value, openTag, closeTag);
                });
            } else {
                if (bbcode.value === 'color') {
                    $(input).on('click', function() {
                        $(colorBlock).toggle();
                        $(this).toggleClass('active');
                    });

                    $(colorPalette.input).on('click', function() {
                        var openTag  = '[' + bbcode.value + '="#' + $('.colorpicker_hex input')[0].value + '"]';
                        var closeTag = '[/' + bbcode.value + ']';

                        insertBBcode(bbcode.value, openTag, closeTag);
                    })
                } else {
                    $(input).on('click', function() {
                        var openTag  = '[' + bbcode.value + ']';
                        var closeTag = '[/' + bbcode.value + ']';

                        insertBBcode(bbcode.value, openTag, closeTag);
                    });
                }
            }
        }(i));
    }

    function insertBBcode(bbcode, openTag, closeTag)
    {
        var len   = textarea.value.length;
        var start = textarea.selectionStart;
        var end   = textarea.selectionEnd;

        var selectedText = textarea.value.substring(start, end);
        var replacement  = openTag + selectedText + closeTag;
        textarea.value = textarea.value.substring(0, start) + replacement + textarea.value.substring(end, len);

        textarea.selectionStart = start + openTag.length;
        textarea.selectionEnd   = end + openTag.length;
        textarea.focus();
    }

    function createColorPalette()
    {
        var el = document.createElement('div');
        el.id  = 'colorpickerHolder';

        var input = document.createElement('span');
        input.className = 'glyphicon glyphicon-share-alt';
        el.append(input);

        $(el).ColorPicker({
            flat: true,
        });

        return {
            el,
            input
        };
    }
});
