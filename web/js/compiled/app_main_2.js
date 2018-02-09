$(function() {
    function postingControl()
    {
        $('#postingControl').on('click', function(event) {
            event.preventDefault();

            if ($(this).attr('href') === '#newtopic') {
                $(this).toggleClass('open');

                $('#newtopic').slideToggle('fast', function() {
                    $('html, body').animate({
                        scrollTop: $('#newtopic').offset().top - 85
                    }, 500);
                });
            } else {
                $('html, body').animate({
                    scrollTop: $('#newpost').offset().top - 85
                }, 500);
            }
        });
    }

    function tabsSystem()
    {
        var currentTab   = $('.tabsSystem .current');

        if (currentTab.length) {
            var currentPos   = $(currentTab).position().left;
            var currentWidth = currentTab.outerWidth();

            var chevron = $('.tabsSystem li:last-of-type');
            chevron.css({left: currentPos, width: currentWidth});

            $('.tabsSystem li:not(:last-of-type)').each(function(index) {
                $(this)
                    .on('mouseenter', function(event) {
                        var newPos   = $(this).position().left;
                        var newWidth = $(this).outerWidth();

                        chevron.animate({left: newPos, width: newWidth}, 'fast');
                    })
                    .on('click', function(event) {
                        $('.tabsSystem .current').toggleClass('current');
                        $(this).toggleClass('current');

                        currentPos   = $(this).position().left;
                        currentWidth = $(this).outerWidth();

                        chevron.animate({left: currentPos, width: currentWidth}, 'fast');

                        var target = $(this).data('target');

                        if ($('.togPanel.active') !== $('#' + target)) {
                            $('.togPanel.active').slideToggle().toggleClass('active');
                            $('#' + target).slideToggle().toggleClass('active');
                        }
                    })
                ;
            });

            $('.tabsSystem').on('mouseleave', function(event) {
                chevron.animate({left: currentPos, width: currentWidth}, 'fast');
            });
        }
    }

    function dropdownSystem()
    {
        $('.dropdownSystem .glyphicon').on('mouseenter', function(event) {
            if (!$(this).parent().hasClass('user-menu-visible')) {
                $(this).parent().addClass('user-menu-visible');
                $(this).next('.user-menu').stop().slideDown();

                $(this).toggleClass('glyphicon-triangle-bottom glyphicon-triangle-top');
            }
        });

        $('.dropdownSystem').on('click', function(event) {
            $(this).removeClass('user-menu-visible');
            $(this).children('.user-menu').stop().slideUp();

            $(this).children('.glyphicon').toggleClass('glyphicon-triangle-bottom glyphicon-triangle-top');
        });
    }

    /**
     * Cette fonction contrôle la redirection vers un forum lors d'un clic sur le <div> de celui-ci
     * ainsi que l'affichage de ses sous-forums
     *
     * @return {Void}
     */
    function forumsControl()
    {
        // Ouvre les sous forums
        $('.forumsrow .showSubForums .glyphicon').on('mouseenter', function() {
            // Avant d'afficher les sous forums du forum survolé, on referme les éventuels sous forums déjà ouverts ailleurs
            if (!$(this).closest('.forum').hasClass('subForums-visible') && $('.forum').hasClass('subForums-visible')) {
                $('.forum').removeClass('subForums-visible');
                $('.forum').find('.subForums').stop().slideUp();

                $('.forum').find('.showSubForums').children('.glyphicon').toggleClass('glyphicon-triangle-bottom glyphicon-triangle-top');
            }

            if (!$(this).closest('.forum').hasClass('subForums-visible')) {
                $(this).closest('.forum').addClass('subForums-visible');
                $(this).next('.subForums').stop().slideDown();

                $(this).toggleClass('glyphicon-triangle-bottom glyphicon-triangle-top');
            }
        });

        // Referme les sous forums
        $('.forumsrow .showSubForums').on('click', function(event) {
            event.stopPropagation();

            $(this).closest('.forum').removeClass('subForums-visible');
            $(this).children('.subForums').stop().slideUp();

            $(this).children('.glyphicon').toggleClass('glyphicon-triangle-bottom glyphicon-triangle-top');
        });

        // Redirige vers le forum lors d'un clic sur celui-ci
        $('.forumsrow .forum').on('click', function(event) {
            event.stopPropagation();

            window.location.href = $(this).data('href');
        });
    }

    /**
     * Lors d'un clic sur le body, referme tous les modules ouverts
     *
     * @return {Void}
     */
    function closeModules()
    {
        $('body').on('click', function(event) {
            // dropdownSystem
            if ($('.dropdownSystem').hasClass('user-menu-visible')) {
                $('.dropdownSystem').removeClass('user-menu-visible');
                $('.dropdownSystem').find('.user-menu').stop().slideUp();

                $('.dropdownSystem').children('.glyphicon').toggleClass('glyphicon-triangle-bottom glyphicon-triangle-top');
            }

            // forumsControl
            if ($('.forum').hasClass('subForums-visible')) {
                $('.forum').removeClass('subForums-visible');
                $('.forum').find('.subForums').stop().slideUp();

                $('.forum').find('.showSubForums').children('.glyphicon').toggleClass('glyphicon-triangle-bottom glyphicon-triangle-top');
            }
        });
    }

    /**
     * Cette fonction contôle les interactions dans la section Qui est en ligne
     *
     * @return {Void}
     */
    function whosonlineControl()
    {
        $('.legend li')
        .on('mouseenter', function() {
            // Au survol d'un groupe de la légende, on met en évidence tous les membres connectés qui y appartiennent
            var targetColor = $(this).children('a').css('color');

            $('.whosonline li a').each(function() {
                if ($(this).css('color') === targetColor) {
                    $(this).css({
                        'text-shadow' : '0 0 7px ' + targetColor
                    });
                }
            });
        })
        .on('mouseleave', function() {
            // Au survol d'un groupe de la légende, on met en évidence tous les membres connectés qui y appartiennent
            var targetColor = $(this).children('a').css('color');

            $('.whosonline li a').each(function() {
                if ($(this).css('color') === targetColor) {
                    $(this).css({
                        'text-shadow' : ''
                    });
                }
            });
        });
    }

    function init()
    {
        postingControl();
        forumsControl();
        whosonlineControl();
        tabsSystem();
        dropdownSystem();
        closeModules();
    }

    init();
});
