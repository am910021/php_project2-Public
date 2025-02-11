$(document).ready(function () {
    // datePicker zh-hant
    $.fn.datepicker.dates['zh-hant'] = {
        days: ["星期日", "星期一", "星期二", "星期三", "星期四", "星期五", "星期"],
        daysShort: ["日", "一", "二", "三", "四", "五", "六"],
        daysMin: ["日", "一", "二", "三", "四", "五", "六"],
        months: ["一月", "二月", "三月", "四月", "五月", "六月", "七月", "八月", "九月", "十月", "十一月", "十二月"],
        monthsShort: ["一月", "二月", "三月", "四月", "五月", "六月", "七月", "八月", "九月", "十月", "十一月", "十二月"],
        today: "今天",
        clear: "清楚",
        format: 'yyyy-mm-dd',
        titleFormat: "MM yyyy", /* Leverages same syntax as 'format' */
        weekStart: 0
    };

});