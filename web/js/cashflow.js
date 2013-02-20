$(function () {
    // Collect column cells and build edge rows
    function buildEdgeCells(cells) {
        var colCells = [],
            newColRows = [];

        cells.each(function (i, el) {
            colCells.push({
                text: $(el).html(),
                height: $.browser.opera ? $(el).outerHeight() : $(el).height()
            });

            $(el).remove();
        });

        $.each(colCells, function (i, cell) {
            var row = '<tr><td style="height: ' + cell.height + 'px;">' + (cell.text || '&nbsp;') + '</td></tr>'
            newColRows.push(row)
        });

        return newColRows.join('');
    }

    var viewport = $('.scrollable-table-viewport'),
        wrap = viewport.find('.scrollable-table'),
        table = wrap.find('table'),
        cells = table.find('thead').find('th'),
        firstCol = $('#first-col'),
        lastCol = $('#last-col'),
        totalWidth = 0;

    // Set proper table width
    cells.each(function (i, el) {
        totalWidth += $(el).outerWidth();
    });

    wrap.width(totalWidth);

    // Build edge columns
    firstCol.find('tbody').append(
        buildEdgeCells(table.find('tr').find('td:first'))
    ).end().find('thead').append(
        buildEdgeCells(table.find('tr').find('th:first'))
    );

    lastCol.find('tbody').append(
        buildEdgeCells(table.find('tr').find('td:last'))
    ).end().find('thead').append(
        buildEdgeCells(table.find('tr').find('th:last'))
    );

    // Normalize table cells height
    table.find('tr').each(function(i, row) {
        var index = $(row).index(),
            $cells = $.merge(firstCol, lastCol,  table).find('tbody tr').eq(index).find('td:first'),
            heights = $cells.map(function () {
                return $(this).outerHeight();
            }).get(),
            maxHeight = Math.max.apply(null, heights);

        firstCol.find('tbody tr').eq(index).find('td:first').height(maxHeight);
        table.find('tbody tr').eq(index).find('td:first').height(maxHeight);
        lastCol.find('tbody tr').eq(index).find('td:first').height(maxHeight);
    });

    $('.table tbody').find('tr').hover(
        function() {
            var index = $(this).index();
            $('.table tbody').find('tr:eq(' + index + ')').addClass('hover');
        }, function() {
            var index = $(this).index();
            $('.table tbody').find('tr:eq(' + index + ')').removeClass('hover');
        }
    );

    $('#cashflow_start_date').datepicker({
        beforeShowDay: function (date) {
            return [date.getDay() > 0 && date.getDay() < 6, '']; // Disable weekends
        },
        firstDay: 1,
        dateFormat: 'yy-mm-dd',
        onSelect: function (date) {
            var col = $('#' + date);

            if (col.length) {
                viewport.scrollTo(col.position().left + 2, 0, { duration: 700 });
            }
        }
    });
});

function approveJoIp(id) {
    $.ajax({
        url: approve_income_payment_url,
        async: false,
        data: 'income_payment_id=' + id,
        success: function () {
            window.location = cashflow_index_url;
        }
    });
}

function approveJoOp(id) {
    $.ajax({
        url: approve_outcome_payment_url,
        async: false,
        data: 'outcome_payment_id=' + id,
        success: function () {
            window.location = cashflow_index_url;
        }
    });
}