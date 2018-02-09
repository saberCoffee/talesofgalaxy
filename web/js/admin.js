$(function() {
    /**
     * Déploie les sous forums dans la liste d'administration des forums
     *
     * @return {Void}
     */
    function deploySubForums()
    {
        $('.table.forumslist tr .deploy').on('click', function(event) {
            event.preventDefault();

            var row = $(this).closest('tr');
            row.toggleClass('deployed');

            var currentRowDepth = parseInt(row.attr('class').match(/\d+/));

            if (row.hasClass('deployed')) {
                openChildRows(row, currentRowDepth);
            } else {
                closeChildRows(row, currentRowDepth);
            }
        });

        function openChildRows(row, currentRowDepth)
        {
            var nextRow      = $(row).next();

            if (!nextRow.length) {
                return;
            }

            var nextRowDepth = parseInt(nextRow.attr('class').match(/\d+/));

            if (currentRowDepth + 1 == nextRowDepth) {
                nextRow.fadeIn().addClass('open');

                openChildRows(nextRow, currentRowDepth);
            }
        }

        function closeChildRows(row, currentRowDepth)
        {
            var openRows = $('.table.forumslist tr.open');

            openRows.each(function() {
                console.log(row[0])
                console.log($(this).prevAll('.depth-' + currentRowDepth)[0]);

                if (row[0] === $(this).prevAll('.depth-' + currentRowDepth)[0]) {
                    var rowDepth = parseInt($(this).attr('class').match(/\d+/));

                    if (currentRowDepth < rowDepth) {
                        $(this).removeClass('open deployed').fadeOut();
                    }
                }
            });
        }
    }

    function init()
    {
        deploySubForums();
    }

    init();
})
