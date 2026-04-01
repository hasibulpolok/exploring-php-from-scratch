<?php

function getProfile() {
    return [
        'name' => 'Md Hasibul Bashar Polok',
        'nickname' => 'Don',
        'role' => 'Full Stack Web Developer',
        'location' => 'Kaliganj, Dhaka, Bangladesh',
        'email' => 'hasibulpolok.bdn@gmail.com',
        'about' => 'I am a professional full-stack developer specializing in ReactJS.',
        'address' => 'Kaliganj, Dhaka',
        'phone' => '',
        'whatsapp' => '8801XXXXXXXXX',
        'open_to_work' => true
    ];
}

function getSkills() {
    return [
        ['name' => 'HTML', 'level' => 90, 'category' => 'Frontend'],
        ['name' => 'CSS', 'level' => 85, 'category' => 'Frontend'],
        ['name' => 'JavaScript', 'level' => 88, 'category' => 'Frontend'],
        ['name' => 'ReactJS', 'level' => 85, 'category' => 'Frontend'],
        ['name' => 'PHP', 'level' => 80, 'category' => 'Backend'],
        ['name' => 'MySQL', 'level' => 75, 'category' => 'Database'],
    ];
}

function getExperience() {
    return [
        [
            'title' => 'Full Stack Developer',
            'company' => 'Freelance',
            'period' => '2022 - Present',
            'description' => 'Working on web applications and client projects.'
        ]
    ];
}

function getProjects() {
    return [
        [
            'title' => 'Portfolio Website',
            'description' => 'Personal portfolio with PHP & JS',
            'tech_stack' => 'HTML, CSS, JS, PHP',
            'url' => '#'
        ]
    ];
}

function getSocialLinks() {
    return [
        ['platform' => 'YouTube', 'url' => '#', 'icon_class' => 'fab fa-youtube'],
        ['platform' => 'GitHub', 'url' => '#', 'icon_class' => 'fab fa-github'],
        ['platform' => 'LinkedIn', 'url' => '#', 'icon_class' => 'fab fa-linkedin'],
    ];
}