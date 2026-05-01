<?php
/**
 * cron_day:
 *      This is the day of the week when order reminders are sent.
 *      The renewal day is set to the next cron_day, for example 'Monday' or 'Saturday'
 *
 * timespans:
 *      These are the time spans in weeks that can be set by the user to indicate how often they want to be reminded
 *      Example: [2, 4, 6, 8].
 */
return [
    'cron_day' => 'Monday',
    'timespans' => [2, 4, 6, 8, 10, 12]
];
