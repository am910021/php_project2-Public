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


    var originalLineDraw = Chart.controllers.line.prototype.draw;
// Extend the line chart, in order to override the draw function.
    Chart.helpers.extend(Chart.controllers.line.prototype, {
        draw: function () {
            var chart = this.chart;
            // Get the object that determines the region to highlight.
            var yHighlightRange = chart.config.data.yHighlightRange;

            // If the object exists.
            if (yHighlightRange !== undefined) {
                for (var i = 0; i < yHighlightRange.length; i++) {


                    var ctx = chart.chart.ctx;

                    var yRangeBegin = yHighlightRange[i].begin;
                    var yRangeEnd = yHighlightRange[i].end;
                    var color = yHighlightRange[i].color;

                    var xaxis = chart.scales['x-axis-0'];
                    var yaxis = chart.scales['y-axis-0'];


                    var yRangeBeginPixel = yaxis.getPixelForValue(yRangeBegin);
                    var yRangeEndPixel = yaxis.getPixelForValue(yRangeEnd);

                    ctx.save();

                    // The fill style of the rectangle we are about to fill.
                    ctx.fillStyle = color;
                    // Fill the rectangle that represents the highlight region. The parameters are the closest-to-starting-point pixel's x-coordinate,
                    // the closest-to-starting-point pixel's y-coordinate, the width of the rectangle in pixels, and the height of the rectangle in pixels, respectively.
                    ctx.fillRect(xaxis.left, Math.min(yRangeBeginPixel, yRangeEndPixel), xaxis.right - xaxis.left, Math.max(yRangeBeginPixel, yRangeEndPixel) - Math.min(yRangeBeginPixel, yRangeEndPixel));

                    ctx.restore();
                }
            }

            // Apply the original draw function for the line chart.
            originalLineDraw.apply(this, arguments);
        }
    });
});