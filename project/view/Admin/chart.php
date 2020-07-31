<?php

/**
 * @param string $id id of the chart's container
 * @param array $tab datas to display
 * @param string|null $title chart's title
 * @param string|null $xTitle chart's x-axe title
 * @param string|null $yTitle chart's y-axe title
 */
?>
<script>
    google.charts.load('current', {
        'packages': ['corechart']
    });
    google.charts.setOnLoadCallback(<?= $id ?>);

    function <?= $id ?>() {
        var tab = <?= json_encode($tab) ?>;
        var data = google.visualization.arrayToDataTable(tab);

        var view = new google.visualization.DataView(data);
        view.setColumns([0, 1,
            {
                calc: "stringify",
                sourceColumn: 1,
                type: "string",
                role: "annotation"
            }
        ]);

        var options = {};
        <?php if (isset($title)) : ?>
            options.title = '<?= ucfirst($title) ?>';
        <?php endif; ?>

        <?php if (isset($yTitle)) : ?>
            options.vAxis = {};
            options.vAxis.title = '<?= ucfirst($yTitle) ?>';
        <?php endif; ?>

        <?php if (isset($xTitle)) : ?>
            options.hAxis = {};
            options.hAxis.title = '<?= ucfirst($xTitle) ?>';
        <?php endif; ?>

        options.seriesType = 'bars';
        options.series = {};
        options.series[5] = {};
        options.series[5].type = 'line';

        options.bar = {
            groupWidth: '10%'
        }

        options.width = $("#" + '<?= $id ?>').parent().width();
        options.height = 500;

        var chart = new google.visualization.ComboChart(document.getElementById('<?= $id ?>'));
        // chart.draw(data, options);
        chart.draw(view, options);
    }
    $(window).resize(() => {
        <?= $id ?>();
    });
</script>