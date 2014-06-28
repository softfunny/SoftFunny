<?php

if (isset($notice['error'])) {
    foreach ($notice['error'] as $m) {
        echo '<div class="formee-msg-error">' . $m . '</div>';
    }
}
if (isset($notice['warning'])) {

    foreach ($notice['warning'] as $m) {
        echo '<div class="formee-msg-warning">' . $m . '</div>';
    }
}
if (isset($notice['success'])) {

    foreach ($notice['success'] as $m) {
        echo '<div class="formee-msg-success">' . $m . '</div>';
    }
}