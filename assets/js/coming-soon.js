/* =========== Document ready ==================== */
jQuery(document).ready(function($){
"use strict";
if ($('.countdown').length > 0) {
    $.countdown.regionalOptions[''] = {
        labels: [
            tradeace_countdown_l10n.years,
            tradeace_countdown_l10n.months,
            tradeace_countdown_l10n.weeks,
            tradeace_countdown_l10n.days,
            tradeace_countdown_l10n.hours,
            tradeace_countdown_l10n.minutes,
            tradeace_countdown_l10n.seconds
        ],
        labels1: [
            tradeace_countdown_l10n.year,
            tradeace_countdown_l10n.month,
            tradeace_countdown_l10n.week,
            tradeace_countdown_l10n.day,
            tradeace_countdown_l10n.hour,
            tradeace_countdown_l10n.minute,
            tradeace_countdown_l10n.second
        ],
        compactLabels: ['y', 'm', 'w', 'd'],
        whichLabels: null,
        digits: ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'],
        timeSeparator: ':',
        isRTL: true
    };

    $.countdown.setDefaults($.countdown.regionalOptions['']);
    
    $('.countdown').each(function () {
        var count = $(this);
        if (!$(count).hasClass('countdown-loaded')) {
            var austDay = new Date(count.data('countdown'));
            $(count).countdown({
                until: austDay,
                padZeroes: true
            });

            if($(count).hasClass('pause')) {
                $(count).countdown('pause');
            }

            $(count).addClass('countdown-loaded');
        }
    });
}
});