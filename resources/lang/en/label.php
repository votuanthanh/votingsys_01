<?php

return [
    'project_name' => 'Fpoll',
    'login' => 'Login',
    'logout' => 'Logout',
    'register' => 'Register',
    'create_poll' => 'Create poll',
    'forgot_password' => 'Forgot Your Password?',
    'remember' => 'Remember me',
    'email' => 'Email',
    'password' => 'Password',
    'avatar' => 'Avatar',
    'confirm_password' => 'Confirm password',
    'name' => 'Name',
    'label_gender' => 'Gender',
    'male' => 'Male',
    'female' => 'Female',
    'profile' => 'Profile',
    'edit' => 'Edit',
    'home' => 'Home',
    'admin_page' => 'ADMIN PAGE',
    'errors' => 'Message',

    /**
     * MASTER ADMIN
     */
    'placeholder_search' => 'START TYPING...',
    'name_admin_page' => 'ADMIN - VOTING',
    'main_menu' => 'MAIN MENU',
    'nav_menu' => [
        'user' => 'User',
        'poll' => 'Poll',
    ],

    /**
     * EMAIL
     */
    'mail' => [
        'head' => 'Fpoll',
        'link_vote' => 'Link to vote:',
        'link_admin' => 'Link manager vote:',
        'subject' => 'Fpoll',
        'delete_all_participant' => 'Admin of poll deleted all votes',
        'register_active_mail' => 'You registered sucessfully. Please click on the link to active account. Link here: ',
        'edit_poll' => [
            'subject' => 'Fpoll - Edit information of poll',
            'head' => 'Fpoll',
            'summary' => 'Your poll was changed!',
            'thead' => [
                'STT' => 'NO.',
                'info' => 'INFORMATION',
                'old_data' => 'OLD DATA',
                'new_data' => 'NEW DATA',
                'date' => 'DATE',
            ],
        ],
        'create_poll' => [
            'subject' => 'Fpoll - Create a poll',
            'title' => 'Poll',
            'head' => 'Fpoll',
            'dear' => 'Dear',
            'thank' => 'Thanks for your using our website . <br> Your poll created SUCCESSFULLY. Below is two links which sent your mail.',
            'link_vote' => 'Link to vote for this poll',
            'description_link_vote' => 'Send this link to your friends that you want to invite for participant.',
            'link_admin' => 'Link to administrate for this poll',
            'description_link_admin' => 'Access this link to change, close or delete your poll.',
            'password' => 'Password',
            'note' => '*<u>Note</u>: You can login our website without registering a new account. Let's click "Active account" to open your account',
            'active_account' => 'Active account',
            'end' => '-- END --',
        ],
        'backup_database' => [
            'subject' => 'Fpoll - Backup database',
            'head' => 'Hello Admin, The backup database file was sent at attachment',
        ],
        'participant_vote' => [
            'subject' => 'Fpoll - invite you vote a poll',
            'invite' => 'You have been invited to participant this poll. Let's clink the below link to vote',
        ],
        'edit_option' => [
            'subject' => 'Fpoll - Edit option of poll',
            'old_option' => 'OLD OPTION',
            'new_option' => 'NEW OPTION',
            'thank' => 'Thanks for your using our website',
            'title' => 'Change option',
        ],
        'edit_setting' => [
            'subject' => 'Fpoll - Edit setting of poll',
            'old_setting' => 'OLD SETTING',
            'new_setting' => 'NEW SETTING',
            'title' => 'Change setting',
        ],
        'register' => [
            'subject' => 'Fpoll - Register account',
            'thank' => 'Thanks for your using our website. <br> Your registered account was SUCCESSFUL. Below is the link to active account',
            'link_active' => 'Click to this link to active account',
        ],
        'edit_link' => [
            'subject' => 'Fpoll - Edit link of poll',
            'thank' => 'Thanks for your using our website. <br> You edited the link SUCCESSFULLY.',
            'link_edit' => 'Click to blow link for more detail',
        ],
        'close_poll' => [
            'subject' => 'Fpoll - Close poll',
            'thank' => 'Thanks for your using our website. <br> You closed the poll SUCCESSFULLY.',
            'link_admin' => 'Click to blow link to manage poll',
        ],
        'open_poll' => [
            'subject' => 'Fpoll - Open poll',
            'thank' => 'Thank you because you have used our website. <br> You open poll SUCCESS.',
            'link_admin' => 'Click to blow link to manage poll',
        ],
        'delete_participant' => [
            'subject' => 'Fpoll - Delete all participant of poll',
            'thank' => 'Thanks for your using our website. <br> You deleted all votes of poll SUCCESSFULLY.',
            'link_admin' => 'Click to blow link to manage poll',
        ],
    ],
    'footer' => [
        'location' => '13F Keangnam Landmark 72 Tower, Plot E6, Pham Hung Road, Nam Tu Liem, Ha Noi, Viet Nam',
        'copyright' => 'Copyright 2016 Framgia, Inc. <br>All rights reserved.',
        'email' => 'hr_team@framgia.com',
        'phone' => ' 84-4-3795-5417',
        'about' => 'Fpoll - a simple, convenient and powerful Poll System',
        'description_website' => 'Fpoll help to create a poll quickly and easily',
        'facebook' => 'https://www.facebook.com/FramgiaVietnam',
        'github' => 'https://github.com/framgia',
        'linkedin' => 'https://www.linkedin.com/company/framgia-vietnam',
    ],
    'paginations' => 'Showing :start to :finish of :numberOfRecords entry|Showing :start to :finish of :numberOfRecords entries',
    'gender' => [
        '' => '',
        '0' => 'Female',
        '1' => 'Male',
        '2' => 'Other',
    ],

    /*
     * Home page
     */
    'feature' => [
        'name' => 'FEATURES',
        'vote' => 'Create a poll fast and easily',
        'chart' => 'Result illustrated by bar chart and pie chart ',
        'security' => 'Guarantee security by password of poll',
        'export' => 'Export result to PDF file or EXCEL file',
        'share' => 'Share poll by facebook',
        'responsive' => 'Support multiple deceives: laptop or mobie',
    ],
    'tutorial' => 'Tutorial',
    'feedback' => 'Feedback',
    'top' => 'Top',
];
