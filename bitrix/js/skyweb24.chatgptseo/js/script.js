BX.ready(function () {
    let panel = document.querySelectorAll('.adm-detail-toolbar-right');
    if (panel.length) {
        panel = panel[0];
        let elementId = new URLSearchParams(location.href).get("ID");
        let btnHtml = `<a href="/bitrix/admin/skyweb24_chatgptseo_task_action.php?id=${elementId}&action=create_elements" class="adm-btn adm-btn-green" id="element_window_get">${BX.message('SKYWEB24_CHATGPTSEO_GENERATION')}</a>`;
        panel.insertAdjacentHTML('beforeend', btnHtml);
    }
})

BX.addCustomEvent('Grid::beforeRequest', function (grid, data) {
    const taskId = data.data.task_id;
    if (data.data && data.data.action) {
        for (let nextAction in data.data.action) {
            let checkedIds = [];
            if (data.data.action[nextAction] === 'addToChatGPT') {
                const idList = data.data.ID;
                idList.forEach(e => {
                    if (e.indexOf('S') > -1) {
                        return;
                    }
                    let id = parseInt(e.replace('E', ''));
                    checkedIds.push(id);
                });

                const params = checkedIds.map(id => 'element_id[]=' + id).join('&');
                const iblockId = (new URL(document.location)).searchParams.get('IBLOCK_ID');

                window.location.href = '/bitrix/admin/skyweb24_chatgptseo_task_action.php' +
                    '?iblock_id=' + iblockId +
                    '&action=add_elements_to' +
                    '&task_id=' + taskId + '&' + params;
            }
        }
    }
});


BX.ready(function () {
    const message = BX.message("SKYWEB24_CHATGPTSEO_ERROR")
    const rows = document.querySelectorAll('.main-grid-row-body')

    rows.forEach(function (row) {
        const content = row.querySelectorAll('.main-grid-cell-content')
        content.forEach(function (element) {
            if (element.textContent.trim() === message) {
                element.style.color = 'red'
            }
        })
    })
})