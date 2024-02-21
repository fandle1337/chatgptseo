class BuilderChartGraph {
    createGraph(nodeGraph, data = [], currencyFormat) {
        if (data.length === 0) {
            return false;
        }

        const chart = am4core.create(nodeGraph, am4charts.XYChart);
        chart.data = this.prepareData(data, currencyFormat);

        const dateAxis = chart.xAxes.push(new am4charts.DateAxis());
        dateAxis.dataFields.date = 'date';
        dateAxis.title.text = BX.message('SKYWEB24_CHATGPTSEO_SETTING_CHRONOLOGY_DATE');
        dateAxis.dateFormats.setKey("day", "dd MMM yyyy");

        const valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
        valueAxis.title.text = BX.message('SKYWEB24_CHATGPTSEO_SETTING_CHRONOLOGY_SUM');

        const series = chart.series.push(new am4charts.ColumnSeries());
        series.dataFields.valueY = 'value';
        series.dataFields.dateX = 'date';

        const date = BX.message('SKYWEB24_CHATGPTSEO_SETTING_CHRONOLOGY_DATE')
        const count = BX.message('SKYWEB24_CHATGPTSEO_SETTING_CHRONOLOGY_COUNT')
        const summ = BX.message('SKYWEB24_CHATGPTSEO_SETTING_CHRONOLOGY_SUMM')

        series.columns.template.tooltipHTML = `
            <div>${date}: <b>{formatDate}</b></div>
            <div>${count}: <b>{count}</b></div>
            <div>${summ}: <b>{formatValue}</b></div>
        `;

        return chart;
    }

    prepareData(data, currencyFormat) {
        BX.Currency.setCurrencyFormat('RUB', currencyFormat)
        const mergedData = {};
        data.forEach(item => {
            item.formatValue = BX.Currency.currencyFormat(item.value, 'RUB', true)
            item.formatDate = this.formatDate(item.date)
            delete item['name']
            const date = item.date;
            if (mergedData[date]) {
                mergedData[date].value += item.value;
                mergedData[date].count += item.count;
                mergedData[date].formatValue = BX.Currency.currencyFormat(mergedData[date].value, 'RUB', true)
                mergedData[date].formatDate = this.formatDate(item.date)
            } else {
                mergedData[date] = { ...item };
            }
        });

        return Object.values(mergedData);
    }

    formatDate(date) {
        const timestamp = new Date(Date.parse(date))
        const day = timestamp.getDate().toString().padStart(2, '0');
        const month = (timestamp.getMonth() + 1).toString().padStart(2, '0');
        const year = timestamp.getFullYear();

        return `${month}.${year}`;
    }
}