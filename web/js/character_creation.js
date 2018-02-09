$(function() {
    var selectedGroup;

    var characterGroupSelect  = $('#post_character_group');
    characterGroupSelect.hide();

    var json = characterGroupSelect.data('value');

    var characterGroupOptions = characterGroupSelect.children('option');

    var groupSelection = $('<div>');
    groupSelection.addClass('groupSelection');
    characterGroupSelect.before(groupSelection);

    var highlighted = $('<div>');
    highlighted.addClass('highlighted');
    groupSelection.append(highlighted);

    var description = $('<div>');
    description.addClass('description');
    highlighted.append(description);

    var gallery = $('<div>');
    gallery.addClass('gallery');
    groupSelection.append(gallery);

    characterGroupOptions.each(function() {
        var groupValue  = $(this).val();
        if (!groupValue) {
            return;
        }
        var groupName   = $(this).text();
        var groupColour = json[groupValue].colour;
        var groupAbrv   = json[groupValue].abreviation;

        var groupDiv = $('<div>');
        groupDiv.addClass('group');
        gallery.append(groupDiv);

        var name = $('<span>');
        name.addClass('faction-' + groupAbrv);
        name.text(groupName);
        groupDiv.append(name);

        var groupMask = $('<img>');
        groupMask.addClass('mask');
        groupMask.attr({'src' : character_creation_path + 'group_mask.png'});
        groupDiv.append(groupMask);

        var groupImg = $('<img>');
        groupImg.addClass('group-illu');
        groupImg.attr({
            'data-value' : groupValue,
            'src'        : character_creation_path + 'group_' + groupValue + '.jpg',
            'alt'        : groupName,
            'border'     : '1px solid #' + groupColour
        });
        groupDiv.append(groupImg);

        groupDiv
        .on('click', function() {
            $(this).toggleClass('selected');
            highlighted.css({height : 'auto'});

            if ($(this).hasClass('selected')) {
                selectedGroup = groupValue;
                characterGroupSelect.val(selectedGroup);

                var previousHighlight = highlighted.children('.group');

                if (previousHighlight.length) { // S'il y a déjà un highlight, on l'inverse avec le nouveau
                    $(this).before(previousHighlight);
                    previousHighlight.toggleClass('selected'),
                    description.before($(this));
                } else { // Sinon, on append celui-là
                    description.before($(this));
                }

                var html = '<blockquote class="bbcode-blockquote"><span class="quoteTitle faction-' + groupAbrv + '">' + groupName + '</span><div><p><strong class="faction-' + groupAbrv + '">Capitale</strong> : ...<br><strong class="faction-' + groupAbrv + '">Chef de faction</strong> : ...<br><strong class="faction-' + groupAbrv + '">Régime en place</strong> : ...</p><p><strong class="faction-' + groupAbrv + '">Diplomatie</strong> : ...</p><p><strong class="faction-' + groupAbrv + '">Situation actuelle</strong> : ...</p><p><strong class="faction-' + groupAbrv + '">Rôles</strong> : ...</p><p><strong class="faction-' + groupAbrv + '">Histoire</strong> : ...</p></div></blockquote>';
                description.html(html);
            }
        })
        .on('mouseover', function() {
            groupImg.css({'box-shadow' : '0 0 7px 1px #' + groupColour});
        })
        .on('mouseleave', function() {
            if (!$(this).hasClass('selected')) {
                groupImg.css({'box-shadow' : 'none'});
            }
        });
    });

    var birthdate = $('#post_character_birthdate');

    birthdate.on('input', function() {
        var age = 220 - $(this).val();

        $(this).prev('label').text('Date de naissance (' + age + ' ans)');
    });
});
