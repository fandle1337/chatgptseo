class BuilderChartDiagram {
    createChart(nodeChart, data = [], currencyFormat) {
        if (data === null || data.length === 0) {
            return false
        }
        am4core.useTheme(am4themes_animated);
        const chart = am4core.create(nodeChart, am4charts.PieChart);
        chart.data = this.mergeData(data, currencyFormat);
        console.log(chart.data);
        const pieSeries = chart.series.push(new am4charts.PieSeries());
        pieSeries.dataFields.value = 'value';
        pieSeries.dataFields.category = 'name';
        pieSeries.labels.template.disabled = true;
        pieSeries.innerRadius = am4core.percent(35);
        chart.radius = am4core.percent(95);

        chart.legend = new am4charts.Legend();
        chart.legend.position = "left";
        chart.legend.maxHeight = 500;
        chart.legend.scrollable = true;
        chart.legend.maxWidth = undefined;

        chart.legend.labels.template.html = "{category} ({valueHTML})";

        return chart;
    }

    mergeData(data, currencyFormat) {
        BX.Currency.setCurrencyFormat('RUB', currencyFormat)
        const mergedData = {};
        data.forEach(item => {
            item.valueHTML = BX.Currency.currencyFormat(item.value, 'RUB', true)
            delete item.task_id
            delete item.date

            if (!item.name) {
                item.name = BX.message('SKYWEB24_CHATGPTSEO_SETTING_USER_NOT_FOUND')
            }
            const name = item.name
            if (mergedData[name]) {
                mergedData[name].value += item.value;
                mergedData[name].count += item.count;
                mergedData[name].valueHTML = BX.Currency.currencyFormat(mergedData[name].value, 'RUB', true)
            } else {
                mergedData[name] = { ...item };
            }
        });

        return Object.values(mergedData);
    }
}