<?php
defined('APP') or exit('Access denied');

when_page('home', function () {
    database();
    load_page('home');
});

when_page('about', function () {
    load_page('about');
});
