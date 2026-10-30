<?php

// Copy for resources/views/apps/simple-alarm.blade.php; kept apart so the page owns its words.
return [
    'lead' => 'A simple, flexible, and customizable alarm app.',
    'play' => 'Open on Google Play',
    'privacy' => 'Privacy Policy',

    'next' => 'Next alarm',
    'next_fallback' => 'Every weekday morning',
    'alarm_name' => 'Work',
    'time' => '6:30 AM',

    'tab_screens' => 'Screens',
    'tab_settings' => 'Settings',
    'tab_morning' => 'A morning',
    'tab_set' => 'Set one',

    'screens_title' => 'Screens',
    'screens_text' => 'One job per screen: the alarm rings, lists, gets set, and wakes you with the view and sound you pick.',
    'screens' => [
        ['Ringing alarm', 'Full-screen alarm with snooze and swipe to dismiss', 'Full-screen ringing alarm: 6:30 AM over a sea view with a Snooze (10 min) button'],
        ['Alarm list', 'See your next alarm and how long until it rings', 'Alarm list: the next alarm, 6:30 AM, with time left, then the Work, Gym and Weekend alarms'],
        ['Setting an alarm', 'Weekdays, every day or once, it is up to you', 'Edit alarm screen: time picker, repeat days, alarm name, sound and volume'],
        ['Backgrounds', 'Choose a background for the alarm screen', 'Background gallery: a selected sea photograph among other photographs'],
        ['Sounds', '15 built-in tones or your own music', 'Sound list: Acoustic selected, the other built-in tones below and a My Tones button'],
    ],

    'settings_title' => 'Settings',
    'settings_shot_alt' => 'The app’s Edit Alarm screen',
    'settings' => [
        'Scheduling' => [
            ['Weekdays', 'Mon–Fri', 'Five working days in one tap.'],
            ['Every day', '7 days', 'Every morning, weekends included.'],
            ['Once', 'one time', 'Just for one morning.'],
            ['Skip next', 'one tap', 'Skip a morning without touching the schedule.'],
        ],
        'Waking up' => [
            ['Full-screen alarm', 'big clock', 'The time and the alarm’s name fill the screen.'],
            ['Snooze', '10 min', 'Ten more minutes in one tap.'],
            ['Swipe to dismiss', 'one move', 'It never switches off by accident.'],
            ['Time left', 'hr and min', 'How long until each alarm rings, right in the list.'],
        ],
        'Sound and look' => [
            ['Built-in tones', '15', 'From Acoustic to LostVoices.'],
            ['Your own music', 'My Tones', 'Wake up to a song on your phone.'],
            ['Volume', 'per alarm', 'Each alarm keeps its own volume.'],
            ['Background', 'photo', 'The view behind the ringing alarm.'],
        ],
    ],

    'morning_title' => 'Set it tonight, wake up',
    'morning_text' => 'You set the alarm once; it knows which mornings to ring all week.',
    'morning' => [
        'Sunday evening' => [
            ['Pick the time', '6:30 AM'],
            ['Pick the days', 'Mon–Fri'],
            ['Pick the sound', 'Acoustic'],
        ],
        'Monday morning' => [
            ['The alarm rings', '6:30 AM'],
            ['Snooze', '+10 min'],
            ['Swipe, done', '6:40 AM'],
        ],
        'Saturday' => [
            ['Work alarm', 'stays quiet'],
            ['Weekend alarm', '9:00 AM'],
        ],
    ],
    'morning_total' => ['One setup', 'five mornings'],

    'set_title' => 'Set tomorrow',
    'set_text' => 'Get it on Google Play; your first alarm takes less than a minute.',
    'dialog_title' => 'Edit Alarm',
    'dialog_time' => 'Time',
    'dialog_repeat' => 'Repeat',
    'dialog_name' => 'Alarm name',
    'preset_weekdays' => 'Weekdays',
    'preset_daily' => 'Every day',
    'preset_once' => 'Once',
    'rings_in' => 'Rings in',

    'more_apps' => 'More apps',
    'studio' => 'Zettelabs',
    'home' => 'Home',
    'pictures' => 'Pictures',
    'credit_photo' => 'Sunrise: Alexandru Panoiu, CC BY 2.0',
    'credit_video' => 'Waves: Alexander Grebenkov, CC BY 3.0',

    // Countdown words, read by the page script.
    'days' => ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
    'unit_day' => 'd',
    'unit_hour' => 'hr',
    'unit_min' => 'min',
];
