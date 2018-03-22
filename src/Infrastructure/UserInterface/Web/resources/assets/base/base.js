/*
 * Copyright (c) 2018. Miguel Ángel Sánchez Fernández.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import "./bootstrap";
import "./fontawesome";
import "./style.scss";

$("#menu-toggle").click(function(e) {
  e.preventDefault();
  $("#wrapper").toggleClass("toggled");
});

$(document).ready(function () {
    let links = $('.navbar ul li a');
    $.each(links, function (key, va) {
        if (va.href === document.URL) {
            $(this).addClass('active');
            $(this).parent().parent().addClass('active');
        }
    });
});