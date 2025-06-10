<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<header class="farshid_terminal_header">
    <div class="farshid_logo"><?php bloginfo('name'); ?></div>
    <div class="farshid_header_controls">
        <input type="text" class="farshid_search" placeholder="Search...">
        <button id="farshid_daynight_btn" class="farshid_daynight_btn">&#9790;</button>
    </div>
</header>
<div class="farshid_terminal_help">Type 'help' to see available commands</div>
<div id="farshid_terminal_output" class="farshid_terminal_output"></div>
<div class="farshid_terminal_input_row">
    <div class="farshid_terminal_prompt">&gt;</div>
    <input id="farshid_terminal_input" class="farshid_terminal_input" type="text" placeholder="Type your command...">
</div>
