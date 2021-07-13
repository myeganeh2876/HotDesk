NProgress.start();
var interval = setInterval(function () {
    NProgress.inc();
}, 1000);
$(window).on('load', function () {
    clearInterval(interval);
    NProgress.done();
});
$(window).on('unload', function () {
    NProgress.start();
});
$(document).ready(function () {
    $('.layout .sidebar ul li button:not(.link)').click(function () {
        if ($(this).parents('li').hasClass('active') && $(this).parents('li').hasClass('open')) {
            $('.layout .sidebar').removeClass('open');
            $('.layout .sidebar ul li').removeClass('active').removeClass('open');
            return false;
        }
        $('.layout .sidebar').addClass('open');
        $('.layout .sidebar ul li').removeClass('active').removeClass('open');
        $(this).parents('li').addClass('active').addClass('open');
        $('.layout .sidebar .support').removeClass('open');
    });
    $('.layout .sidebar ul li button.link').click(function () {
        $('.layout .sidebar ul li').removeClass('active').removeClass('open');
        $(this).parents('li').addClass('active').addClass('open');
    });
    $('.layout .sidebar ul li .submenu .closemenu').click(function () {
        $('.layout .sidebar').removeClass('open');
        $('.layout .sidebar ul li').removeClass('active').removeClass('open');
    });
    $('.layout .sidebar .callsupport').click(function () {
        if ($('.layout .sidebar .support').hasClass('open')) {
            $('.layout .sidebar .support').removeClass('open');
            $('.layout .sidebar').removeClass('open');
            return false;
        }
        $('.layout .sidebar .support').addClass('open');
        $('.layout .sidebar').addClass('open');
        $('.layout .sidebar ul li').removeClass('active').removeClass('open');
    });
    $('.layout .sidebar .support .head .closesupport').click(function () {
        $('.layout .sidebar .support').removeClass('open');
        $('.layout .sidebar').removeClass('open');
    });
    /* Scrollbars */
    if ($(".layout .sidebar").length){
        $(".layout .sidebar").mCustomScrollbar({
            scrollbarPosition: 'outside',
            autoHideScrollbar: false,

        });

    }
    if ($(".layout .sidebar .support .messages").length) {
        $(".layout .sidebar .support .messages").mCustomScrollbar({
            autoHideScrollbar: true
        });
        $(".layout .sidebar .support .messages").mCustomScrollbar("scrollTo", ".layout .sidebar .support .messages .message:last-child");
    }
    if ($(".replaychat .template .templates .list").length) {
        $(".replaychat .template .templates .list").mCustomScrollbar({
            scrollbarPosition: 'outside',
            autoHideScrollbar: true
        });
    }
    if ($(".replaychat .chatbox .messages").length) {
        $(".replaychat .chatbox .messages").mCustomScrollbar({
            autoHideScrollbar: true,
            live: true,
            callbacks: {
                onTotalScrollBack: function () {
                    var morepage = $(".replaychat .chatbox .messages").data('morepage');
                    var page = $(".replaychat .chatbox .messages").data('page');
                    var id = $(".replaychat .chatbox .messages").data('id');
                    if (morepage == true) {
                        var loading = $('<div class="message me loading"><div style="width:100%"><p style="text-align:center">در حال بارگزاری ...</p></div></div>');
                        $('.replaychat .chatbox .messages .mCSB_container').prepend(loading);
                        $.get("/admin/support/getmessage", {
                            id: id,
                            page: page + 1
                        }, function (data) {
                            if (data.data.length) {
                                var length = data.data.length;
                                $('.replaychat .chatbox .messages .loading').fadeOut("slow", function () {
                                    $(this).remove()
                                });
                                $(".replaychat .chatbox .messages").data('morepage', data.meta.to < data.meta.total);
                                $(".replaychat .chatbox .messages").data('page', page + 1);
                                $.each(data.data, function (i, item) {
                                    var data = $('<div class="message ' + (item.is_admin == true ? 'me' : 'sup') + '"><div><p>' + item.message + '<button type="button" class="copymessage"></button></p><span>' + (($('body').hasClass('en')) ? item.date.en : item.date.fa) + '</span></div></div>');
                                    $('.replaychat .chatbox .messages .mCSB_container').prepend(data);
                                });
                            }
                        });
                    }
                }
            }
        });
        $(".replaychat .chatbox .messages").mCustomScrollbar("scrollTo", ".replaychat .chatbox .messages .message:last-child");
    }
    if ($(".layout .main .notes .notelist .list").length) {
        $(".layout .main .notes .notelist .list").mCustomScrollbar({
            autoHideScrollbar: true,
            live: true,
            scrollbarPosition: 'outside'
        });
    }
    if ($(".layout .main .dashboard .quickaccess .list").length) {
        $(".layout .main .dashboard .quickaccess .list").mCustomScrollbar({
            autoHideScrollbar: true,
            live: true,
            scrollbarPosition: 'outside'
        });
    }
    if ($(".layout .sidebar .support .messages").length) {
        $(".layout .sidebar .support .messages").mCustomScrollbar({
            autoHideScrollbar: true
        });
        $(".layout .sidebar .support .messages").mCustomScrollbar("scrollTo", ".layout .sidebar .support .messages .message:last-child");
    }
    if ($(".layout .main .content .support").length) {
        $(".layout .main .content .support .replay .box .messages").mCustomScrollbar({
            autoHideScrollbar: true,
            live: true,
            callbacks: {
                onTotalScrollBack: function () {
                    var morepage = $(".support .replay .box .messages").data('morepage');
                    var page = $(".support .replay .box .messages").data('page');
                    var id = $(".support .replay .box .messages").data('id');
                    if (morepage == 'True') {
                        var loading = $('<div class="message me loading"><div style="width:100%"><p style="text-align:center">در حال بارگزاری ...</p></div></div>');
                        $('.support .replay .box .messages .mCSB_container').prepend(loading);
                        $.get("/admin/support/getmessage", {
                            id: id,
                            page: page + 1
                        }, function (data) {
                            if (data.data.length) {
                                var length = data.data.length;
                                $('.support .replay .box .messages .loading').fadeOut("slow", function () {
                                    $(this).remove()
                                });
                                $(".support .replay .box .messages").data('morepage', data.meta.to < data.meta.total);
                                $(".support .replay .box .messages").data('page', page + 1);
                                $.each(data.data, function (i, item) {
                                    var data = $('<div class="message ' + (item.is_admin == true ? 'me' : 'sup') + '"><div><p>' + item.message + '<button type="button" class="copymessage"></button></p><span>' + (($('body').hasClass('en')) ? item.date.en : item.date.fa) + '</span></div></div>');
                                    $('.support .replay .box .messages .mCSB_container').prepend(data);
                                });
                            }
                        });
                    }
                }
            }
        });
        $(".layout .main .content .support .replay .box .messages").mCustomScrollbar("scrollTo", ".layout .main .content .support .replay .box .messages .message:last-child");
        $(".layout .main .content .support .template .templates .list").mCustomScrollbar({
            scrollbarPosition: 'outside',
            autoHideScrollbar: true
        });
    }
    /**/
    $('.replaychat .chatbox .messages,.content .support .replay .box .messages').on('click', 'p', function () {
        var $temp = $("<input>");
        $("body").append($temp);
        $temp.val($(this).text()).select();
        document.execCommand("copy");
        $temp.remove();
        $(this).addClass('copy');
    });
    $('.replaychat .chatbox .messages,.content .support .replay .box .messages').on('mouseleave', '.message', function () {
        $(this).find('p').removeClass('copy');
    });
    $('.replaychat .template .templates .list .item p').click(function () {
        var text = $(this).text();
        $('.replaychat .chatbox .sendbox').addClass('open');
        $('.replaychat .chatbox .messages').addClass('open');
        $('.replaychat .chatbox .sendbox textarea').val(text);
        $('.replaychat .chatbox .sendbox button').prop('disabled', false);
    });
    $('.replaychat .chatbox .head .action .closechat').click(function () {
        $('.replaychat').removeClass('open');
        $('.layout .sidebar').removeClass('opensupport');
    });
    /* replay */
    $('.layout .main .content .support .template .templates .list .item p').click(function () {
        var text = $(this).text();
        $('.layout .main .content .support .replay .form-group textarea').val(text);
        $('.layout .main .content .support .replay .box .button-group button').prop('disabled', false);
        $('html, body').animate({
            scrollTop: $(".layout .main .content .support .replay").offset().top
        }, 1000);
    });
    $('.layout .main .content .support .replay .box .form-group textarea').keyup(function () {
        var text = $(this).val();
        if (text != '') {
            $('.layout .main .content .support .replay .box .button-group button').prop('disabled', false);
        } else {
            $('.layout .main .content .support .replay .box .button-group button').prop('disabled', true);
        }
    });
    /**/
    if ($('#userchart').length) {
        var ctx = document.getElementById('userchart').getContext('2d');
        //ctx.canvas.width = 200;

        var options = {
            title: {
                display: false
            },
            legend: {
                display: false
            },
            tooltips: {
                mode: 'index',
                intersect: false,
                rtl: true,
                backgroundColor: "rgba(255,255,255,1)",
                borderColor: "rgba(217,217,217,1)",
                borderWidth: 1,
                displayColors: false,
                titleFontFamily: 'iranyekan',
                titleFontSize: 14,
                footerFontFamily: 'iranyekan',
                footerFontSize: 14,
                bodyFontFamily: 'iranyekan',
                bodyFontColor: '#676F74',
                bodyFontSize: 14,
                titleFontColor: '#676F74',
                footerFontColor: '#676F74',
                callbacks: {
                    label: function (tooltipItems, data) {
                        return data.datasets[0].label + ' : ' + tooltipItems.yLabel.toString().toFaDigit();
                    }
                }
            },
            responsive: true,
            maintainAspectRatio: false,
            spanGaps: false,
            elements: {
                line: {
                    tension: 0.4
                },
                point: {
                    radius: 0
                }
            },
            plugins: {
                filler: {
                    propagate: false
                }
            },
            scales: {
                xAxes: [{
                    display: false,
                    gridLines: {
                        display: false
                    },
                    ticks: {
                        display: false,
                        autoSkip: false,
                        maxRotation: 0,
                    }
                }],
                yAxes: [{
                    display: false,
                    gridLines: {
                        display: false
                    }
                }]
            }
        };
        var gradient = ctx.createLinearGradient(0, 0, 0, 400);
        gradient.addColorStop(0, 'rgba(82,192,239,1)');
        gradient.addColorStop(1, 'rgba(72,177,222,1)');
        var userchart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: [],
                datasets: [{
                    label: "کاربر",
                    backgroundColor: gradient,
                    borderColor: 'rgba(0,0,0,0)',
                    data: [],
                    fill: 'start'
                }]
            },
            options: options
        });
        var transactiondata = null;
        var userdata = null;
        $.get("/admin/chartdata", {
            model: 'transaction'
        }, function (data, status) {
            transactiondata = data.data.map(function (item) {
                return item["count"];
            });
        });
        $.get("/admin/chartdata", {
            model: 'user'
        }, function (data, status) {
            userdata = data.data.map(function (item) {
                return item["count"];
            });
            userchart.data.datasets[0].data = userdata;
            userchart.data.labels = data.data.map(function (item) {
                return item["month_fa"];
            });
            userchart.update();
        });
    }
    $('.layout .main .chart .box ul li').click(function () {
        if (transactiondata != null && userdata != null) {
            $('.layout .main .chart .box ul li').removeClass('active');
            $(this).addClass('active');
            $('.layout .main .chart .box span').text($(this).data('info'));
            if ($(this).data('id') == "orders") {
                userchart.data.datasets[0].label = "فروش";
                userchart.data.datasets[0].data = transactiondata;
            } else if ($(this).data('id') == "users") {
                userchart.data.datasets[0].label = "کاربر";
                userchart.data.datasets[0].data = userdata;
            }
            userchart.update();
        }
    });
    $(".layout .main .notes .textbox textarea").on('input', function () {
        if ($(this).val() !== "")
            $('.layout .main .notes .textbox .bottom button').prop('disabled', false);
        else
            $('.layout .main .notes .textbox .bottom button').prop('disabled', true);
    });
    $(".layout .main .notes .textbox textarea").focusin(function () {
        $(".layout .main .notes .textbox").addClass('open');
        $(".layout .main .notes .notelist .list").addClass('opentextbox');
        $(".layout .main .notes .notelist .list").mCustomScrollbar('update');
    });
    $(".layout .main .notes .textbox").click(function () {
        $(".layout .main .notes .textbox").addClass('open');
        $(".layout .main .notes .notelist .list").addClass('opentextbox');
        $(".layout .main .notes .notelist .list").mCustomScrollbar('update');
    });
    $('.layout .main .notes .textbox .bottom .notestatus ul li').click(function () {
        $('.layout .main .notes .textbox .bottom .notestatus ul li').removeClass('active');
        $(this).addClass('active');
        $('.layout .main .notes .textbox input[type=hidden]').val($(this).data('id'));
    });
    $('.layout .main .notes .notelist .notestatus ul li').click(function () {
        var className = $(this).data('id');
        if ($(this).hasClass('active')) {
            $('.layout .main .notes .notelist .notestatus ul li').removeClass('active');
            $('.layout .main .notes .notelist .list .mCSB_container .item').show();
            return false;
        }
        $('.layout .main .notes .notelist .notestatus ul li').removeClass('active');
        $(this).addClass('active');
        $('.layout .main .notes .notelist .list .mCSB_container .item.' + className).show();
        $('.layout .main .notes .notelist .list .mCSB_container .item').not('.' + className).fadeOut();
    });
    $('.layout .main .notes .notelist .list').on('click', '.deletenote', function () {
        var id = $(this).data('id');
        $.post("/admin/notes/delete", {
            id: id,
            _token: getMeta('csrf-token')
        });
        $(this).parents('.item').fadeOut(500, function () {
            $(this).remove();
            $(".layout .main .notes .notelist .list").mCustomScrollbar('update');
        });
    });
    $('.layout .main .notes .textbox .bottom button').click(function () {
        var text = $('.layout .main .notes .textbox textarea').val();

        var className = $('.layout .main .notes .textbox input[type=hidden]').val();
        var avatar = $('.layout .sidebar .avatar img').attr('src');
        var singlelettername = $('.layout .sidebar .avatar img').data('s');
        $.post("/admin/notes/set", {
            content: text,
            status: className,
            _token: getMeta('csrf-token')
        }, function (data, status) {
            var data = $('<div class="item ' + className + '"><div class="avatar"><img src="' + avatar + '" onerror="this.className=\'none\'" alt="' + singlelettername + '" title="' + singlelettername + '"><span>' + singlelettername + '</span></div><div class="notedata"><p>' + text + '</p><div class="action"><button type="button" class="deletenote" data-id="' + data.data.id + '"><span>حذف</span></button></div></div></div>');
            $('.layout .main .notes .notelist .list .mCSB_container').prepend(data);
        });
        // $('.layout .main .notes .textbox textarea').val('');
    });
    $(document).on('click', function (event) {
        if (!$(event.target).closest(".layout .main .notes .textbox").length) {
            $(".layout .main .notes .textbox").removeClass('open');
            $(".layout .main .notes .notelist .list").removeClass('opentextbox');
            $(".layout .main .notes .notelist .list").mCustomScrollbar('update');
        }
    });
    /* quick access */
    if ($(".layout .main .dashboard .quickaccess ul").length) {
        var receive = false;
        $(".layout .main .dashboard .quickaccess ul").sortable({
            connectWith: '.layout .main .dashboard .quickaccess .head span',
            placeholder: "placeholder",
            helper: 'clone',
            appendTo: ".itemdrag ul",
            revert: true,
            start: function (event, ui) {
                ui.item.startPos = ui.item.index();
            },
            over: function (ev, ui) {
                $('.layout .main .dashboard .quickaccess .list').addClass('itemover');
            },
            out: function (ev, ui) {
                $('.layout .main .dashboard .quickaccess .list').removeClass('itemover');
            },
            receive: function (ev, ui) {
                receive = true;
                $('.layout .main .dashboard .quickaccess .list').removeClass('itemover');
            },
            stop: function (ev, ui) {
                if (receive == true) {
                    var title = ui.item.find('a').text();
                    var link = ui.item.find('a').attr('href');
                    var target = ui.item.find('a').attr('target');
                    var position = ui.item.index();
                    $.post("/admin/personalizemenus/set", {
                        title: title,
                        link: link,
                        target: target,
                        position: position
                    });
                    receive = false;
                } else {
                    $.post("/admin/personalizemenus/update", {
                        startposition: ui.item.startPos,
                        newposition: ui.item.index(),
                    });
                }
            },
        }).disableSelection();
    }
    if ($("body.dashboard .layout .sidebar ul li .submenu").length) {
        $("body.dashboard .layout .sidebar ul li .submenu ul li").draggable({
            appendTo: ".itemdrag ul",
            connectToSortable: ".layout .main .dashboard .quickaccess ul",
            helper: "clone",
            revert: "invalid",
            zIndex: 99999,
            refreshPositions: true,
            start: function (event, ui) {
                $('.layout .sidebar').removeClass('open').removeClass('openmenu');
                $('.layout .sidebar ul li').removeClass('active').removeClass('open').addClass('stuck');
            }
        });
    }
    if ($(".layout .main .dashboard .quickaccess .head span").length) {
        $(".layout .main .dashboard .quickaccess .head span").droppable({
            accept: ".quickaccess ul > li",
            tolerance: "touch",
            activeClass: 'active',
            hoverClass: 'active',
            greedy: true,
            over: function (event, ui) {
                ui.helper.addClass('delete').removeClass('out');
            },
            out: function (event, ui) {
                ui.helper.addClass('out');
            },
            drop: function (event, ui) {
                console.log();
                $.post("/admin/personalizemenus/delete", {
                    index: ui.draggable.index()
                });
                ui.helper.addClass('delete');
                ui.draggable.remove();
                return false;
            }
        });
    }
    /* menu mobile */
    if ($(window).width() <= 1023) {
        $('.layout .main .header .openmenu').click(function () {
            $('.layout .sidebar').addClass('openmenu');
        });
        $('.layout .main .header .opennotes').click(function () {
            $('.layout .main .notes').addClass('open');
            $('.layout .sidebar').addClass('opennotes');
        });
        $('.layout .main .notes button.closenotes').click(function () {
            $('.layout .main .notes').removeClass('open');
            $('.layout .sidebar').removeClass('opennotes');
        });
        $("body").swipe({
            swipe: function (event, direction, distance, duration, fingerCount, fingerData) {
                if (direction == "left" && !$("body").hasClass('en')) {
                    event.stopPropagation();
                    if ($('.layout .main .notes').hasClass('open')) {
                        $('.layout .main .notes').removeClass('open');
                        $('.layout .sidebar').removeClass('opennotes');
                    } else {
                        $('.layout .sidebar').addClass('openmenu').removeClass('opennotes');
                    }
                }
                if (direction == "right" && $("body").hasClass('en')) {
                    event.stopPropagation();
                    if ($('.layout .main .notes').hasClass('open')) {
                        $('.layout .main .notes').removeClass('open');
                        $('.layout .sidebar').removeClass('opennotes');
                    } else {
                        $('.layout .sidebar').addClass('openmenu').removeClass('opennotes');
                    }
                }
                if (direction == "right" && !$("body").hasClass('en')) {
                    event.stopPropagation();
                    $('.layout .sidebar').removeClass('openmenu').removeClass('opennotes');
                }
                if (direction == "left" && $("body").hasClass('en')) {
                    event.stopPropagation();
                    $('.layout .sidebar').removeClass('openmenu').removeClass('opennotes');
                }
            }
        });

        $(".layout .sidebar").swipe({
            swipe: function (event, direction, distance, duration, fingerCount, fingerData) {
                if (direction == "right" && $('.layout .sidebar').hasClass('openmenu') && !$('.layout .sidebar li').hasClass('open') && !$("body").hasClass('en')) {
                    event.stopPropagation();
                    $('.layout .sidebar').removeClass('open').removeClass('openmenu').removeClass('opennotes');
                }
                if (direction == "right" && $('.layout .sidebar').hasClass('openmenu') && $('.layout .sidebar li').hasClass('open') && !$("body").hasClass('en')) {
                    event.stopPropagation();
                    $('.layout .sidebar li').removeClass('open');
                }
                if (direction == "left" && $('.layout .sidebar').hasClass('openmenu') && !$('.layout .sidebar li').hasClass('open') && $("body").hasClass('en')) {
                    event.stopPropagation();
                    $('.layout .sidebar').removeClass('open').removeClass('openmenu').removeClass('opennotes');
                }
                if (direction == "left" && $('.layout .sidebar').hasClass('openmenu') && $('.layout .sidebar li').hasClass('open') && $("body").hasClass('en')) {
                    event.stopPropagation();
                    $('.layout .sidebar li').removeClass('open');
                }
            }
        });
    }
    /* timer */
    var timer = null;
    $('.entrytimer .timer .actions button.start').click(function () {
        $(this).prop('disabled', true);
        $('.entrytimer .timer .actions button.finish').prop('disabled', false);
        localStorage.setItem("timerstart", +new Date());
        var timerstart = localStorage.getItem("timerstart");
        timer = setInterval(function () {
            var delta = Math.abs(timerstart - +new Date()) / 1000;
            var days = Math.floor(delta / 86400);
            delta -= days * 86400;
            var hours = Math.floor(delta / 3600) % 24;
            delta -= hours * 3600;
            if (hours <= 9) {
                hours = "0" + hours;
            }
            var minutes = Math.floor(delta / 60) % 60;
            delta -= minutes * 60;
            if (minutes <= 9) {
                minutes = "0" + minutes;
            }
            var seconds = Math.floor(delta % 60);
            if (seconds <= 9) {
                seconds = "0" + seconds;
            }
            $('.layout .main .dashboard .entrytimer .timer span.time').text(hours + ":" + minutes + ":" + seconds);
        }, 1000);
    });
    $('.entrytimer .timer .actions button.finish').click(function () {
        clearInterval(timer);
        $(this).prop('disabled', true);
        $('.entrytimer .timer .actions button.start').prop('disabled', false);
    });
    /* form group */
    $('.form-group .stepup').click(function (e) {
        e.preventDefault();
        $(this).parent().find('input[type=number]')[0].stepUp();
    });
    $('.form-group .stepdown').click(function (e) {
        e.preventDefault();
        $(this).parent().find('input[type=number]')[0].stepDown();
    });
    $(".form-group select").select2({
        width: '100%',
        dir: 'rtl',
        "language": {
            "noResults": function () {
                return "یافت نشد";
            }
        },
        escapeMarkup: function (markup) {
            return markup;
        }
    });
    $(".form-group select.popcornselect-ajax").select2({
        width: '100%',
        dir: 'rtl',
        "language": {
            "noResults": function () {
                return "یافت نشد";
            }
        },
        escapeMarkup: function (markup) {
            return markup;
        },
        ajax: {
            delay: 250,
            url: '/admin/artistdata/search',
            data: function (params) {
                var query = {
                    search: params.term,
                    category: $(this).data('category'),
                    page: params.page || 1
                }
                return query;
            },
            processResults: function (data, params) {
                params.page = params.page || 1;
                return {
                    results: data.data,
                    pagination: {
                        more: (params.page * 10) < data.total
                    }
                };
            }
        }
    });
    $(".form-group select.banneduser-ajax").select2({
        width: '100%',
        dir: 'rtl',
        "language": {
            "noResults": function () {
                return "یافت نشد";
            }
        },
        escapeMarkup: function (markup) {
            return markup;
        },
        ajax: {
            delay: 250,
            url: '/admin/support/messagesearch',
            data: function (params) {
                var query = {
                    search: params.term,
                    userid: $(this).data('userid'),
                    page: params.page || 1
                }
                return query;
            },
            processResults: function (data, params) {
                params.page = params.page || 1;
                return {
                    results: data.data,
                    pagination: {
                        more: (params.page * 10) < data.meta.total
                    }
                };
            }
        }
    });
    $('.form-group select').on('select2:opening', function (e) {
        $(this).parents('.form-group').addClass('open');
        $(this).data('select2').$dropdown.find(':input.select2-search__field').attr('placeholder', 'جستجو');
        if ($(this).parents('.form-group').hasClass('gray'))
            $(this).data('select2').$dropdown.addClass('gray');

    });
    $('.form-group select').on('select2:closing', function (e) {
        $(this).parents('.form-group').removeClass('open');
        if ($(this).parents('.form-group').hasClass('gray'))
            $(this).data('select2').$dropdown.removeClass('gray');
    });
    $('.form-group select').on('select2:open', function (e) {
        var width = $(this).parents('.form-group').outerWidth();
        var dropdownwidth = $(this).data('select2').$results.width();
        if (Math.ceil(dropdownwidth) == 170 && !$('body').hasClass('en')) {
            $(this).data('select2').$dropdown.css('marginLeft', '-' + Math.abs(width - 170) + 'px');
        } else {
            $(this).data('select2').$dropdown.css('marginLeft', 0);
        }
    });
    /* profile upload image */
    $('.imageupload button').on('click touchstart', function (e) {
        $(this).parent().find('input[type=file]').trigger('click');
        return false;
    });
    $(".imageupload input").change(function () {
        var _this = this;
        if (this.files && this.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $(_this).parent().find('img').attr('src', e.target.result);
                $(_this).parent().find('img').on('load', function () {
                    $(_this).parent().css('minHeight', $(this).height());
                });
            }
            reader.readAsDataURL(this.files[0]);
        } else {
            $(_this).parent().find('img').attr('src', '');
            $(_this).parent().css('height', '315px');
        }
    });
    $('.form-group input[type=password]').keyup(function () {
        var password = $(this).val();
        var strength = 0;

        if (password.length < 7) {
            $(this).parents('.form-group').find('.checklist .Strength ul li.message').text('غیر قابل قبول');
            $(this).parents('.form-group').find(".checklist .Strength ul li").removeClass('active');
            return;
        }

        if (password.length > 7) {
            strength += 1;
            $(this).parents('.form-group').find('.checklist .list li.c8').addClass('active');
        } else {
            $(this).parents('.form-group').find('.checklist .list li.c8').removeClass('active');
        }

        if (password.match(/([a-z].*[A-Z])|([A-Z].*[a-z])/)) {
            strength += 1
            $(this).parents('.form-group').find('.checklist .list li.bw').addClass('active');
        } else {
            $(this).parents('.form-group').find('.checklist .list li.bw').removeClass('active');
        }

        if (password.match(/([a-zA-Z])/) && password.match(/([0-9])/)) {
            strength += 1
            $(this).parents('.form-group').find('.checklist .list li.hn').addClass('active');
        } else {
            $(this).parents('.form-group').find('.checklist .list li.hn').removeClass('active');
        }

        if (password.match(/([!,%,&,@,#,$,^,*,?,_,~])/)) {
            strength += 1
            $(this).parents('.form-group').find('.checklist .list li.sc').addClass('active');
        } else {
            $(this).parents('.form-group').find('.checklist .list li.sc').removeClass('active');
        }

        if (password.match(/(.*[!,%,&,@,#,$,^,*,?,_,~].*[!,%,&,@,#,$,^,*,?,_,~])/)) strength += 1

        if (password.length > 15 && strength >= 4) {
            strength += 1;
        }
        if ($(this).data('re')) {
            var id = $(this).data('re');
            if ($('.form-group input[type=password]#' + id).length && $('.form-group input[type=password]#' + id).val() == password) {
                $(this).parents('.form-group').find('.checklist .list li.rp').addClass('active');
            } else {
                $(this).parents('.form-group').find('.checklist .list li.rp').removeClass('active');
            }
        }

        $(this).parents('.form-group').find(".checklist .Strength ul li").removeClass('active');
        $(this).parents('.form-group').find(".checklist .Strength ul li:lt(" + strength + ")").addClass('active');
        if (strength < 2) {
            $(this).parents('.form-group').find('.checklist .Strength ul li.message').text('ضعیف');
        } else if (strength == 2) {
            $(this).parents('.form-group').find('.checklist .Strength ul li.message').text('متوسط');
        } else if (strength <= 5) {
            $(this).parents('.form-group').find('.checklist .Strength ul li.message').text('قوی');
        } else {
            $(this).parents('.form-group').find('.checklist .Strength ul li.message').text('بسیار قوی');
        }
    });
    $('.form-group input[type=password]').focusin(function () {
        $(this).parents('.form-group').addClass('openchecklist');
    });
    $('.form-group input[type=password]').focusout(function () {
        $(this).parents('.form-group').removeClass('openchecklist');
    });
    /* date picker*/
    if ($(".form-group input.date").length) {
        $(".form-group input.date").pDatepicker({
            format: 'YYYY-MM-DD HH:mm:ss',
            responsive: false,
            formatPersian: false,
            initialValueType: 'gregorian'
        });
    }
    /* form group addable*/
    $('.form-addable button.add').click(function () {
        if ($(this).parents('.form-addable').find('.item').eq(0).length) {
            $(this).parents('.form-addable').find('select.select2').select2('destroy');
            var data = $(this).parents('.form-addable').find('.item').eq(0)[0].outerHTML;
            $(this).parents('.form-addable').find('.data').append($(data).hide());
            $(this).parents('.form-addable').find('.data .item:last-child').fadeIn();
            $(this).parents('.form-addable').find('.data .item:last-child input').val('');
            if ($(this).parents('.form-addable').find('select.select2').length) {
                $(this).parents('.form-addable').find('.data .item select.select2').select2({
                    width: '100%',
                    dir: 'rtl',
                    "language": {
                        "noResults": function () {
                            return "یافت نشد";
                        }
                    },
                    escapeMarkup: function (markup) {
                        return markup;
                    }
                });
                $(this).parents('.form-addable').find('.data .item select.select2').on('select2:opening', function (e) {
                    $(this).parents('.form-group').addClass('open');
                    $(this).data('select2').$dropdown.find(':input.select2-search__field').attr('placeholder', 'جستجو');
                    if ($(this).parents('.form-group').hasClass('gray'))
                        $(this).data('select2').$dropdown.addClass('gray');

                });
                $(this).parents('.form-addable').find('.data .item select.select2').on('select2:closing', function (e) {
                    $(this).parents('.form-group').removeClass('open');
                    if ($(this).parents('.form-group').hasClass('gray'))
                        $(this).data('select2').$dropdown.removeClass('gray');
                });
                $(this).parents('.form-addable').find('.data .item select.select2').on('select2:open', function (e) {
                    var width = $(this).parents('.form-group').outerWidth();
                    var dropdownwidth = $(this).data('select2').$results.width();
                    if (Math.ceil(dropdownwidth) == 170 && !$('body').hasClass('en')) {
                        $(this).data('select2').$dropdown.css('marginLeft', '-' + Math.abs(width - 170) + 'px');
                    } else {
                        $(this).data('select2').$dropdown.css('marginLeft', 0);
                    }
                });
            }
        }
    });
    $('.form-addable .data').on('click', 'button.deleteform', function () {
        if ($(this).parents('.form-addable').find('.item').length > 1)
            $(this).parents('.item').fadeOut(500, function () {
                $(this).remove()
            });
        else
            $(this).parents('.form-addable').find('input,textarea').val('');
    });
    /* form group limited */
    $('.form-group.limited').each(function () {
        var limit = $(this).data('limit');
        var _this = this;
        $(this).find('.limit').html('0/<b>' + limit + '</b>');
        $(this).find('textarea').keydown(function () {
            var text = $(this).val();
            if (text.length <= limit) {
                $(_this).find('.limit').html(text.length + '/<b>' + limit + '</b>');
            } else {
                var text = text.slice(0, limit);
                $(this).val(text);
            }
        });
    });
    /* closablelist */
    $('.closablelist li button').click(function () {
        $(this).parent().fadeOut(500, function () {
            $(this).remove()
        });
    });
    /* tablist */
    $('.tablist .tabs button:not(.more),.tablist .tabs .more li').click(function () {
        var id = $(this).data('id');
        $(this).parents('.tablist').removeClass('empty');
        $(this).parents('.tablist').find('.tabs button').removeClass('active');
        $(this).parents('.tablist').find('.tabs .more li').removeClass('active');
        $(this).addClass('active');
        $(this).parents('.tablist').find('.tab').hide();
        $(this).parents('.tablist').find('.tab.tab' + id).show();
        if (!$(this).parents('.tablist').find('.tab.tab' + id).length)
            $(this).parents('.tablist').addClass('empty');
    });
    $('.tablist .tabs .more li').click(function () {
        $(this).parents('.tablist').find('.tabs .more ul').fadeOut();
    });
    $('.tablist .tabs .more button.more').click(function () {
        $(this).parents('.tablist').find('.tabs .more ul').fadeToggle();
    });
    $('.tablesimple.tabs button:not(.more),.tablesimple.tabs .more li').click(function () {
        var id = $(this).data('id');
        $(this).parents('.databox').removeClass('empty');
        $(this).parents('.tablesimple.tabs').find('button').removeClass('active');
        $(this).addClass('active');
        $(this).parents('.databox').find('.tablesimple.tab').hide();
        $(this).parents('.databox').find('.tablesimple.tab.tab' + id).show();
        if (!$(this).parents('.databox').find('.tablesimple.tab.tab' + id).length)
            $(this).parents('.databox').addClass('empty');
    });
    $('.tablesimple.tabs .more li').click(function () {
        $(this).parents('.tablesimple').find('.more ul').fadeOut();
    });
    $('.tablesimple.tabs .more button.more').click(function () {
        $(this).parents('.tablesimple').find('.more ul').fadeToggle();
    });
    $('.tablesimple tr td button.delete').click(function () {
        $(this).parents('tr').fadeOut(500, function () {
            $(this).remove()
        });
    });
    /* sms pay */
    $('.layout .main .dashboard .smspack .box .actions input').keyup(function () {
        var count = $(this).val();
        $('.layout .main .dashboard .smspack .box .actions button.pay span').text('پرداخت ' + (count).toString().toFaDigit() + ' تومان');
    });
    /* body click hide replychat */
    $('body').click(function (e) {
        var target = $(e.target);
        if (!$(event.target).closest(".replaychat").length) {
            $('.replaychat').removeClass('open');
            $('.layout .sidebar').removeClass('opensupport');
        }
        if (!$(event.target).closest(".sidebar *").length) {
            $('.layout .sidebar').removeClass('open');
            $('.layout .sidebar ul li').removeClass('active').removeClass('open');
            $('.layout .sidebar .support').removeClass('open');
        }
    });
    /* active send button if inputs are not empty */
    $('.replaychat .chatbox .sendbox textarea').keyup(function () {
        var text = $(this).val();
        if (text != '') {
            $('.replaychat .chatbox .sendbox button').prop('disabled', false);
        } else {
            $('.replaychat .chatbox .sendbox button').prop('disabled', true);
        }
    });
    $('.replaychat .template .sendbox textarea').keyup(function () {
        var text = $(this).val();
        if (text != '') {
            $('.replaychat .template .sendbox button').prop('disabled', false);
        } else {
            $('.replaychat .template .sendbox button').prop('disabled', true);
        }
    });
    $('.layout .main .content .support .sendbox textarea').keyup(function () {
        var text = $(this).val();
        if (text != '') {
            $('.layout .main .content .support .sendbox button').prop('disabled', false);
        } else {
            $('.layout .main .content .support .sendbox button').prop('disabled', true);
        }
    });
    $('.layout .sidebar .support .sendmessage textarea').keyup(function () {
        var text = $(this).val();
        if (text != '') {
            $('.layout .sidebar .support .sendmessage button').prop('disabled', false);
        } else {
            $('.layout .sidebar .support .sendmessage button').prop('disabled', true);
        }
    });
    /* table selectall */
    $('table thead th .checkbox.select').click(function () {
        if ($(this).prop('checked') === true) {
            $(this).parents('table').find('tbody tr td input[type=checkbox]').prop('checked', true);
            $('.layout .main .header .action button.delete').prop('disabled', false);
            $('.layout .main .header .action button.delete').text('حذف دسته جمعی');
        } else {
            $(this).parents('table').find('tbody tr td input[type=checkbox]').prop('checked', false);
            $('.layout .main .header .action button.delete').prop('disabled', true);
            $('.layout .main .header .action button.delete').text('حذف');
        }
    });
    $('table tbody tr td input[type=checkbox]').click(function () {
        if ($(this).prop('checked') === true) {
            $('.layout .main .header .action button.delete').prop('disabled', false);
        } else {
            if ($(this).parents('table').find('tbody tr td input[type=checkbox]:checked').length == 0)
                $('.layout .main .header .action button.delete').prop('disabled', true);
        }
        if ($(this).parents('table').find('tbody tr td input[type=checkbox]:checked').length > 1)
            $('.layout .main .header .action button.delete').text('حذف دسته جمعی');
        else
            $('.layout .main .header .action button.delete').text('حذف');
    });
    $('.layout .main .header .actions button.delete').click(function () {
        if ($('table').length) {
            $('.layout .main .header .actions button.delete').prop('disabled', false);
            $('table tbody tr td input[type=checkbox]:checked').each(function () {
                $(this).parents('tr').fadeOut(500, function () {
                    $(this).remove();
                });
            });
        }
    });
    /* input type direction*/
    $('input[type=text],textarea').keyup(function () {
        if ($(this).val().length == 1) {
            var x = new RegExp("[\x00-\x80]+");
            var isAscii = x.test($(this).val());
            if (isAscii) {
                $(this).css("direction", "ltr");
            } else {
                $(this).css("direction", "rtl");
            }
        }
    });
    /* input only number */
    $('input[type=text],textarea').keyup(function () {
        if ($(this).val().length == 1) {
            var x = new RegExp("[\x00-\x80]+");
            var isAscii = x.test($(this).val());
            if (isAscii) {
                $(this).css("direction", "ltr");
            } else {
                $(this).css("direction", "rtl");
            }
        }
    });
    $('.form-group.onlynumber input').keypress(function (event) {
        var controlKeys = [8, 9, 13, 35, 36, 37, 39];
        var isControlKey = controlKeys.join(",").match(new RegExp(event.which));
        if (!event.which ||
            (48 <= event.which && event.which <= 57) || isControlKey) {
            return;
        } else {
            event.preventDefault();
        }
    });
    /* support open*/
    $('.layout .sidebar .support .sendmessage textarea').focusin(function () {
        $('.layout .sidebar .support .sendmessage').addClass('open');
    });
    $('.layout .sidebar .support .sendmessage textarea').focusout(function () {
        $('.layout .sidebar .support .sendmessage').removeClass('open');
    });
    $('.replaychat .sendbox textarea,.layout .main .content .support .sendbox textarea').focusin(function () {
        $(this).parents('.sendbox').addClass('open');
        if ($(this).parents('.template').find('.templates .list').length)
            $(this).parents('.template').find('.templates .list').addClass('open');
        if ($(this).parents('.chatbox').find('.messages').length)
            $(this).parents('.chatbox').find('.messages').addClass('open');
    });
    $('.replaychat .sendbox textarea,.layout .main .content .support .sendbox textarea').focusout(function () {
        $(this).parents('.sendbox').removeClass('open');
        if ($(this).parents('.template').find('.templates .list').length)
            $(this).parents('.template').find('.templates .list').removeClass('open');
        if ($(this).parents('.chatbox').find('.messages').length)
            $(this).parents('.chatbox').find('.messages').removeClass('open');
    });
    $('.layout .main .dashboard .smspack .box .actions button.pay').click(function () {
        var button = this;
        var price = parseInt($('.layout .main .dashboard .smspack .box .actions input').val());
        if (price != '') {
            price = price * 10;
            $(this).addClass('loading');
            $.post("/admin/chargesms", {
                price: price
            }, function (data) {
                if (data.success == true) {
                    window.open(data.data[0].link, "_blank");
                    $(button).removeClass('loading');
                }
            });
        }
    });
    $('.layout .main .dashboard .smspack .box .actions button:not(.pay)').click(function () {
        var button = this;
        var price = parseInt($(this).data('p'));
        if (price != '') {
            $(this).addClass('loading').addClass('loadingvis');
            $.post("/admin/chargesms", {
                price: price
            }, function (data) {
                if (data.success == true) {
                    window.open(data.data[0].link, "_blank");
                    $(button).removeClass('loading').removeClass('loadingvis');
                }
            });
        }
    });
    $('.replaychat .template .sendbox button').click(function () {
        var content = $('.replaychat .template .sendbox textarea').val();
        var data = $('<div class="item"><p>' + content + '</p><div class="action"><button type="button" class="deletetemplate" data-id=""></button></div></div>').hide();
        $('.replaychat .template .templates .list .mCSB_container').prepend(data);
        $('.replaychat .template .templates .list .mCSB_container .item:first-child').fadeIn();
        $.post("/admin/messagetemplate/set", {
            content: content
        }, function (data) {
            if (data.success == true) {
                $('.replaychat .template .templates .list .mCSB_container .item:first-child button.deletetemplate').data('id', data.data.id);
            }
            $('.replaychat .template .sendbox button').prop('disabled', true);
            $('.replaychat .template .sendbox textarea').val('');
        });
    });
    $('.layout .main .content .support .template .sendbox button').click(function () {
        var content = $('.layout .main .content .support .template .sendbox textarea').val();
        var data = $('<div class="item"><p>' + content + '</p><div class="action"><button type="button" class="deletetemplate" data-id=""></button></div></div>').hide();
        $('.layout .main .content .support .template .templates .list .mCSB_container').prepend(data);
        $('.layout .main .content .support .template .templates .list .mCSB_container .item:first-child').fadeIn();
        $.post("/admin/messagetemplate/set", {
            content: content
        }, function (data) {
            if (data.success == true) {
                $('.layout .main .content .support .template .templates .list .mCSB_container .item:first-child button.deletetemplate').data('id', data.data.id);
            }
            $('.layout .main .content .support .template .sendbox button').prop('disabled', true);
            $('.layout .main .content .support .template .sendbox textarea').val('');
        });
    });
    $('.replaychat .templates .list,.layout .main .content .support .template .templates .list').on('click', 'button.deletetemplate', function () {
        var id = $(this).data('id');
        $.post("/admin/messagetemplate/delete", {
            id: id
        });
        $(this).parents('.item').fadeOut(500, function () {
            $(this).remove();
            $(".replaychat .template .templates .list").mCustomScrollbar('update');
            $(".layout .main .content .support .template .templates .list").mCustomScrollbar('update');
        });
    });
    $('.table tbody tr td button.openchat').click(function () {
        var id = $(this).data('id');
        var name = $(this).data('name');
        var editurl = $(this).data('editurl');
        var locked = $(this).data('locked');
        var banned = $(this).data('banned');
        $('.replaychat .chatbox .messages .mCSB_container').html('');
        $('.replaychat .chatbox .head .action a.openchat').attr('href', editurl);
        $('.replaychat .chatbox .head .action button.lockchat').data('id', id);
        $('.replaychat .chatbox .head i').data('id', id);

        if (banned == true)
            $('.replaychat .chatbox .head i').addClass('active');
        else
            $('.replaychat .chatbox .head i').removeClass('active');
        $('.replaychat .chatbox .sendbox button').data('id', id);
        if (locked == true) {
            $('.replaychat .chatbox .head .action button.lockchat').addClass('active');
            $('.replaychat .chatbox .sendbox textarea').prop('disabled', true);
        } else {
            $('.replaychat .chatbox .head .action button.lockchat').removeClass('active');
            $('.replaychat .chatbox .sendbox textarea').prop('disabled', false);
        }

        $.post("/admin/support/readmessage", {
            id: id
        });
        $.get("/admin/support/getmessage", {
            id: id
        }, function (data) {
            if (data.data.length) {
                var length = data.data.length;
                $('.replaychat .chatbox .messages .mCSB_container').html('');
                $(".replaychat .chatbox .messages").data('morepage', data.meta.to < data.meta.total);
                $(".replaychat .chatbox .messages").data('page', 1);
                $(".replaychat .chatbox .messages").data('id', id);
                $.each(data.data, function (i, item) {
                    var data = $('<div class="message ' + (item.is_admin == true ? 'me' : 'sup') + '"><div><p>' + item.message + '<button type="button" class="copymessage"></button></p><span>' + (($('body').hasClass('en')) ? item.date.en : item.date.fa) + '</span></div></div>');
                    $('.replaychat .chatbox .messages .mCSB_container').prepend(data);
                    if (i == (length - 1)) {
                        $(".replaychat .chatbox .messages").mCustomScrollbar("scrollTo", "last");
                    }
                });
            }
        });
        $('.replaychat .chatbox .head span').text(name);
        $('.replaychat').addClass('open');
        $('.layout .sidebar').addClass('opensupport');
        return false;
    });
    $('.replaychat .chatbox .sendbox button').click(function () {
        var id = $(this).data('id');
        var content = $('.replaychat .chatbox .sendbox textarea').val();
        var data = $('<div class="message sup"><div><p>' + content + '<button type="button" class="copymessage"></button></p><span>الان</span></div></div>').hide();
        $('.replaychat .chatbox .messages .mCSB_container').append(data);
        $('.replaychat .chatbox .messages .mCSB_container .message:last-child').fadeIn();
        $.post("/admin/support/sendmessage", {
            id: id,
            content: content
        }, function (data) {
            if (data.success == true) {
                $('.replaychat .chatbox .messages .mCSB_container .message:last-child span').text(data.date_fa);
            } else {
                $('.replaychat .chatbox .messages .mCSB_container .message:last-child').remove();
            }
            $('.replaychat .chatbox .sendbox button').prop('disabled', true);
            $('.replaychat .chatbox .sendbox textarea').val('');
            $(".replaychat .chatbox .messages").mCustomScrollbar("scrollTo", ".replaychat .chatbox .messages .message:last-child");
        });
    });
    $('.layout .main .content .support .replay .box button.sendmessage').bind('click.send', function () {
        var id = $(this).data('id');
        var content = $('.layout .main .content .support .replay .box textarea').val();
        var data = $('<div class="message sup"><div><p>' + content + '<button type="button" class="copymessage"></button></p><span>الان</span></div></div>').hide();
        $('.layout .main .content .support .replay .box .messages .mCSB_container').append(data);
        $('.layout .main .content .support .replay .box .messages .mCSB_container .message:last-child').fadeIn();
        $.post("/admin/support/sendmessage", {
            id: id,
            content: content
        }, function (data) {
            if (data.success == true) {
                $('.layout .main .content .support .replay .box .messages .mCSB_container .message:last-child span').text(data.date_fa);
            } else {
                $('.layout .main .content .support .replay .box .messages .mCSB_container .message:last-child').remove();
            }
            $('.layout .main .content .support .replay .box button.sendmessage').prop('disabled', true);
            $('.layout .main .content .support .replay .box textarea').val('');
            $(".layout .main .content .support .replay .box .messages").mCustomScrollbar("scrollTo", ".layout .main .content .support .replay .box .messages .message:last-child");
        });
    });
    /*
    $('.layout .main .content .support .replay .box button.newmessage').bind('click.create', function() {
        var user_id = $('.layout .main .content .support .replay .box .form-group.username select option:selected').val();
        if (user_id == "")
            return false;
        var content = $('.layout .main .content .support .replay .box textarea').val();
        var data = $('<div class="message sup"><div><p>' + content + '<button type="button" class="copymessage"></button></p><span>الان</span></div></div>').hide();
        $('.layout .main .content .support .replay .box .messages .mCSB_container').append(data);
        $('.layout .main .content .support .replay .box .messages .mCSB_container .message:last-child').fadeIn();
        $.post("/admin/support/createmessage", {
            user_id: user_id,
            content: content
        }, function(data) {
            if (data.success == true) {
                $('.layout .main .content .support .replay .box button.sendmessage').data('id', data.data.id);
                $('.layout .main .content .support .replay .box .messages .mCSB_container .message:last-child span').text(data.date_fa);
            } else {
                $('.layout .main .content .support .replay .box .messages .mCSB_container .message:last-child').remove();
            }
            $('.layout .main .content .support .replay .box .form-group.username').remove();
            $('.layout .main .content .support .replay .box button.newmessage').remove();
            $('.layout .main .content .support .replay .box button.sendmessage').show().prop('disabled', true);
            $('.layout .main .content .support .replay .box textarea').val('');
            $(".layout .main .content .support .replay .box .messages").mCustomScrollbar("scrollTo", ".layout .main .content .support .replay .box .messages .message:last-child");
        });
    });
    */
    $('.replaychat .chatbox .head .action button.lockchat').click(function () {
        $(this).toggleClass('active');
        var id = $(this).data('id');
        $.post("/admin/support/lockmessage", {
            id: id
        }, function (data) {
            if (data.status == 'closed')
                $(this).addClass('active');
            else
                $(this).removeClass('active');
        });
        if ($(this).hasClass('active'))
            $('.replaychat .chatbox .sendbox textarea').prop('disabled', true);
        else
            $('.replaychat .chatbox .sendbox textarea').prop('disabled', false);
    });
    $('.replaychat .chatbox .head i').click(function () {
        $(this).toggleClass('active');
        var id = $(this).data('id');
        $.post("support/banuser", {
            id: id
        }, function (data) {
            if (data.success == true && data.banned == true)
                $(this).addClass('active');
            else
                $(this).removeClass('active');
        });
    });
    /* imdb */
    $('.layout .main .content .post .block .getimdbdata').click(function () {
        var imdbid = $.trim($('input[name=imdbid]').val());
        var patt = /^tt[0-9]+$/g;
        var btn = this;
        if (!patt.test(imdbid)) {
            toastr.error("شناسه imdb نا معتبر است", "خطا");
        } else {
            $(btn).addClass('loading');
            $('.layout .main .content .post .block.imdb .moviedata .avatar img').attr('src', '');
            $.get("/admin/imdb/init", {
                id: imdbid
            }, function (data) {
                $(btn).removeClass('loading');
                if (data.success == true) {
                    $('.layout .main .content .post .block.imdb .moviedata').fadeIn();
                    if (data.data.cover)
                        $('.layout .main .content .post .block.imdb .moviedata .avatar img').attr('src', data.data.cover);
                    else
                        $('.layout .main .content .post .block.imdb .moviedata .avatar img').attr('src', '');
                    $('.layout .main .content .post .block.imdb .moviedata .meta span.name').text(data.data.title);
                    $('.layout .main .content .post .block.imdb .moviedata .meta span.year').text("(" + data.data.year + ")");
                    if (data.data.genre)
                        $('.layout .main .content .post .block.imdb .moviedata .meta span.genre').text(data.data.genre.join(', '));
                    else
                        $('.layout .main .content .post .block.imdb .moviedata .meta span.genre').text('');
                } else {
                    $('.layout .main .content .post .block.imdb .moviedata').fadeOut();
                    if (data.message == 'http')
                        toastr.error("یافت نشد", "خطا");
                    else
                        toastr.error("عملیات نا موفق", "خطا");
                }
            });
        }
    });
    /*
    $('.name_content_belongstomany_genre_relationship select').val(["9", "10"]);
    if ($('.name_content_belongstomany_genre_relationship select').find("option[value='10']").length) {
        $('.name_content_belongstomany_genre_relationship select').val(10).trigger('change');
    } else {
        // Create a DOM Option and pre-select by default
        var newOption = new Option("'dv'", 10, true, true);
        // Append it to the select
        $('.name_content_belongstomany_genre_relationship select').append(newOption).trigger('change');
    }
    */
    $('.layout .main .content .post .block .getallimdbdata').click(function () {
        toastr.options.newestOnTop = false;
        $(this).addClass('loading');
        var imdbid = $.trim($('input[name=imdbid]').val());
        var patt = /^tt[0-9]+$/g;
        var btn = this;
        var step = 0;
        if (!patt.test(imdbid)) {
            toastr.error("شناسه imdb نا معتبر است", "خطا");
        } else {
            $('input[name=imdbid]').prop('disabled', true);
            var general = toastr.warning("در حال گرفتن اطلاعات", "", {
                timeOut: 0,
                extendedTimeOut: 0
            });
            $.get("/admin/imdb/general", {
                id: imdbid
            }, function (data) {
                step++;
                general.remove();
                if (data.success == true) {
                    toastr.success("اطلاعات دریافت شد", "");
                    $('input[name=name]').val(data.data.title);
                    $('select[name=type]').val(data.data.is_serial == true ? 'tv' : 'movie').trigger('change.select2');
                    tinymce.get('richtextinfo').setContent(data.data.plotoutline.toString());
                    $('input[name=year]').val(data.data.year);
                    $('select[name=color]').val(data.data.colors ? data.data.colors[0] : 'color').trigger('change.select2');
                    $('input[name=mpaa]').val(data.data.mpaa);
                    $('input[name=oscar_won]').val(data.data.awardsparse ? data.data.awardsparse['oscar_won'] : 0);
                    $('input[name=oscar_nominee]').val(data.data.awardsparse ? data.data.awardsparse['oscar_nominee'] : 0);
                    $('input[name=golden_globe_won]').val(data.data.awardsparse ? data.data.awardsparse['golden_globe_won'] : 0);
                    $('input[name=golden_globe_nominee]').val(data.data.awardsparse ? data.data.awardsparse['golden_globe_nominee'] : 0);
                    $('input[name=rating]').val(data.data.rating ? data.data.rating : 0);
                    $('input[name=votes]').val(data.data.votes ? data.data.votes : 0);
                    $('input[name=metacriticRating]').val(data.data.metacriticRating ? data.data.metacriticRating : 0);
                    $('select[name=top250]').val(data.data.top250 ? 1 : 0).trigger('change.select2');
                    $('input[name=top250pos]').val(data.data.top250 ? data.data.top250 : 0);
                    $('.form-addable.trailer .data').html('<div class="item"><div class="row"><div class="form-group gray"><label>لینک تریلر</label><input type="text" name="trailers[]" class="dir_ltr"></div><div class="action"><button type="button" name="button" class="deleteform"></button></div></div></div>');
                    if (data.data.trailers) {
                        var trailers = toastr.warning("در حال گرفتن تریلر ها", "", {
                            timeOut: 0,
                            extendedTimeOut: 0
                        });
                        $.post("/admin/imdb/trailer", {
                            id: imdbid
                        }, function (data) {
                            step++;
                            trailers.remove();
                            toastr.success("گرفتن تریلر ها با موفقیت انجام شد", "");
                            $('.form-addable.trailer .data').html('');
                            $.each(data.data, function (i, item) {
                                var dataitem = $('<div class="item"><div class="row"><div class="form-group gray"><label>لینک تریلر</label><input type="text" name="trailers[]" class="dir_ltr" value=""></div><div class="action"><button type="button" name="button" class="deleteform"></button></div></div></div>');
                                $('.form-addable.trailer .data').append(dataitem);
                                $('.form-addable.trailer .data .item:last-child input[type=text]').val(item.title + ',' + item.url + ',' + item.resolution + ',' + item.image);
                            });
                        });
                    }
                } else {
                    if (data.message == 'http')
                        toastr.error("یافت نشد", "خطا");
                    else
                        toastr.error("عملیات نا موفق", "خطا");
                }
            });
            var genre = toastr.warning("ثبت ژانر ها", "", {
                timeOut: 0,
                extendedTimeOut: 0
            });
            $('.name_content_belongstomany_genre_relationship select').val(0).trigger('change');
            $.post("/admin/imdb/genre", {
                id: imdbid
            }, function (data) {
                step++;
                genre.remove();
                if (data.success == true) {
                    toastr.success("ژانر ها ثبت شد", "");
                    var keys = [];
                    $.each(data.data, function (i, item) {
                        keys[i] = item.id;
                        if (!$('.name_content_belongstomany_genre_relationship select').find("option[value='" + item.id + "']").length) {
                            var newOption = new Option(item.name, item.id, true, true);
                            $('.name_content_belongstomany_genre_relationship select').append(newOption).trigger('change');
                        }
                    });
                    $('.name_content_belongstomany_genre_relationship select').val(keys).trigger('change');
                } else {
                    if (data.message == 'http')
                        toastr.error("یافت نشد", "ژانر ها");
                    else
                        toastr.error("عملیات نا موفق", "ژانر ها");
                }
            });
            var country = toastr.warning("ثبت کشور ها", "", {
                timeOut: 0,
                extendedTimeOut: 0
            });
            $('.name_content_belongstomany_country_relationship select').val(0).trigger('change');
            $.post("/admin/imdb/country", {
                id: imdbid
            }, function (data) {
                step++;
                country.remove();
                if (data.success == true) {
                    toastr.success("کشور ها ثبت شد", "");
                    var keys = [];
                    $.each(data.data, function (i, item) {
                        keys[i] = item.id;
                        if (!$('.name_content_belongstomany_country_relationship select').find("option[value='" + item.id + "']").length) {
                            var newOption = new Option(item.name, item.id, true, true);
                            $('.name_content_belongstomany_country_relationship select').append(newOption).trigger('change');
                        }
                    });
                    $('.name_content_belongstomany_country_relationship select').val(keys).trigger('change');
                } else {
                    if (data.message == 'http')
                        toastr.error("یافت نشد", "کشور ها");
                    else
                        toastr.error("عملیات نا موفق", "کشور ها");
                }
            });
            var language = toastr.warning("ثبت زبان ها", "", {
                timeOut: 0,
                extendedTimeOut: 0
            });
            $('.name_content_belongstomany_language_relationship select').val(0).trigger('change');
            $.post("/admin/imdb/language", {
                id: imdbid
            }, function (data) {
                step++;
                language.remove();
                if (data.success == true) {
                    toastr.success("زبان ها ثبت شد", "");
                    var keys = [];
                    $.each(data.data, function (i, item) {
                        keys[i] = item.id;
                        if (!$('.name_content_belongstomany_language_relationship select').find("option[value='" + item.id + "']").length) {
                            var newOption = new Option(item.name, item.id, true, true);
                            $('.name_content_belongstomany_language_relationship select').append(newOption).trigger('change');
                        }
                    });
                    $('.name_content_belongstomany_language_relationship select').val(keys).trigger('change');
                } else {
                    if (data.message == 'http')
                        toastr.error("یافت نشد", "زبان ها");
                    else
                        toastr.error("عملیات نا موفق", "زبان ها");
                }
            });
            var cover = toastr.warning("گرفتن کاور و ریسایز", "", {
                timeOut: 0,
                extendedTimeOut: 0
            });
            $('.layout .main .content .post .block.imageupload .thumbnail img').attr('src', '');
            $.post("/admin/imdb/poster", {
                id: imdbid
            }, function (data) {
                step++;
                cover.remove();
                if (data.success == true) {
                    toastr.success("گرفتن کاور و ریسایز با موفقیت انجام شد", "");
                    $('.layout .main .content .post .block.imageupload .thumbnail img').attr('src', "/storage/" + data.data.org);
                    $('input[name=picture]').val(JSON.stringify(data.data));
                } else {
                    if (data.message == 'http')
                        toastr.error("یافت نشد", "کاور");
                    else
                        toastr.error("عملیات نا موفق", "کاور");
                }
            });
            var casts = toastr.warning("ساخت صفحه هنرمندان", "", {
                timeOut: 0,
                extendedTimeOut: 0
            });
            $('.name_actors select').val(0).trigger('change');
            $.post("/admin/imdb/casts", {
                id: imdbid,
                type: 'cast'
            }, function (data) {
                step++;
                casts.remove();
                if (data.success == true) {
                    toastr.success("ساخت صفحه هنرمندان با موفقیت انجام شد", "");
                    var keys = [];
                    $.each(data.data, function (i, item) {
                        keys[i] = item.id;
                        if (!$('.name_actors select').find("option[value='" + item.id + "']").length) {
                            var newOption = new Option(item.name, item.id, true, true);
                            $('.name_actors select').append(newOption).trigger('change');
                        }
                    });
                    $('.name_actors select').val(keys).trigger('change');
                } else {
                    if (data.message == 'http')
                        toastr.error("یافت نشد", "هنرمندان");
                    else
                        toastr.error("عملیات نا موفق", "هنرمندان");
                }
            });
            var director = toastr.warning("ساخت صفحه کارگردان", "", {
                timeOut: 0,
                extendedTimeOut: 0
            });
            $('.name_director select').val(0).trigger('change');
            $.post("/admin/imdb/casts", {
                id: imdbid,
                type: 'director'
            }, function (data) {
                step++;
                director.remove();
                if (data.success == true) {
                    toastr.success("ساخت صفحه کارگردان با موفقیت انجام شد", "");
                    var keys = [];
                    $.each(data.data, function (i, item) {
                        keys[i] = item.id;
                        if (!$('.name_director select').find("option[value='" + item.id + "']").length) {
                            var newOption = new Option(item.name, item.id, true, true);
                            $('.name_director select').append(newOption).trigger('change');
                        }
                    });
                    $('.name_director select').val(keys).trigger('change');
                } else {
                    if (data.message == 'http')
                        toastr.error("یافت نشد", "کارگردان");
                    else
                        toastr.error("عملیات نا موفق", "کارگردان");
                }
            });
            var writing = toastr.warning("ساخت صفحه نویسنده", "", {
                timeOut: 0,
                extendedTimeOut: 0
            });
            $('.name_writing select').val(0).trigger('change');
            $.post("/admin/imdb/casts", {
                id: imdbid,
                type: 'writer'
            }, function (data) {
                step++;
                writing.remove();
                if (data.success == true) {
                    toastr.success("ساخت صفحه نویسنده با موفقیت انجام شد", "");
                    var keys = [];
                    $.each(data.data, function (i, item) {
                        keys[i] = item.id;
                        if (!$('.name_writing select').find("option[value='" + item.id + "']").length) {
                            var newOption = new Option(item.name, item.id, true, true);
                            $('.name_writing select').append(newOption).trigger('change');
                        }
                    });
                    $('.name_writing select').val(keys).trigger('change');
                } else {
                    if (data.message == 'http')
                        toastr.error("یافت نشد", "نویسندگان");
                    else
                        toastr.error("عملیات نا موفق", "نویسندگان");
                }
            });
            var composer = toastr.warning("ساخت صفحه آهنگساز", "", {
                timeOut: 0,
                extendedTimeOut: 0
            });
            $('.name_composer select').val(0).trigger('change');
            $.post("/admin/imdb/casts", {
                id: imdbid,
                type: 'composer'
            }, function (data) {
                step++;
                composer.remove();
                if (data.success == true) {
                    toastr.success("ساخت صفحه آهنگساز با موفقیت انجام شد", "");
                    var keys = [];
                    $.each(data.data, function (i, item) {
                        keys[i] = item.id;
                        if (!$('.name_composer select').find("option[value='" + item.id + "']").length) {
                            var newOption = new Option(item.name, item.id, true, true);
                            $('.name_composer select').append(newOption).trigger('change');
                        }
                    });
                    $('.name_composer select').val(keys).trigger('change');
                } else {
                    if (data.message == 'http')
                        toastr.error("یافت نشد", "آهنگساز");
                    else
                        toastr.error("عملیات نا موفق", "آهنگساز");
                }
            });
            var checkfinish = setInterval(function () {
                if (step == 10) {
                    $(btn).removeClass('loading');
                    $('input[name=imdbid]').prop('disabled', false);
                    toastr.success("گرفتن اطلاعات فیلم با موفقیت انجام شد", "");
                    clearInterval(checkfinish);
                }
            }, 10000);
        }
    });
    $('.layout .main .content .post .metabox:not(.' + $('.form-group.name_type select option:selected').val() + ') select').each(function () {
        $(this).data('name', $(this).attr('name'));
        $(this).attr('name', '');
    });
    $('.form-group.name_type select').change(function () {
        $('.layout .main .content .post .metabox').hide();
        $('.layout .main .content .post .metabox.' + $(this).val()).show();
        $('.layout .main .content .post .metabox.' + $(this).val() + ' select').each(function () {
            if ($(this).attr('name') == '')
                $(this).attr('name', $(this).data('name'));
        });
        $('.layout .main .content .post .metabox:not(.' + $(this).val() + ') select').each(function () {
            $(this).data('name', $(this).attr('name'));
            $(this).attr('name', '');
        });
    });
    $(".form-edit-add.contents").submit(function (e) {
        e.preventDefault();
        var imdbid = $.trim($('input[name=imdbid]').val());
        var patt = /^tt[0-9]+$/g;
        var form = this;
        if (patt.test(imdbid)) {
            $(".form-edit-add.contents button[type=submit]").prop('disabled', true);
            var general = toastr.warning("در حال به روز رسانی اطلاعات", "", {
                timeOut: 0,
                extendedTimeOut: 0
            });
            $.get("/admin/imdb/general", {
                id: imdbid
            }, function (data) {
                general.remove();
                if (data.success == true) {
                    toastr.success("اطلاعات به روز شد", "");
                    $('input[name=mpaa]').val(data.data.mpaa);
                    $('input[name=oscar_won]').val(data.data.awardsparse ? data.data.awardsparse['oscar_won'] : 0);
                    $('input[name=oscar_nominee]').val(data.data.awardsparse ? data.data.awardsparse['oscar_nominee'] : 0);
                    $('input[name=golden_globe_won]').val(data.data.awardsparse ? data.data.awardsparse['golden_globe_won'] : 0);
                    $('input[name=golden_globe_nominee]').val(data.data.awardsparse ? data.data.awardsparse['golden_globe_nominee'] : 0);
                    $('input[name=rating]').val(data.data.rating ? data.data.rating : 0);
                    $('input[name=votes]').val(data.data.votes ? data.data.votes : 0);
                    $('input[name=metacriticRating]').val(data.data.metacriticRating ? data.data.metacriticRating : 0);
                    $('select[name=top250]').val(data.data.top250 ? 1 : 0).trigger('change.select2');
                    $('input[name=top250pos]').val(data.data.top250 ? data.data.top250 : 0);
                    form.submit();
                }
            });
        } else {
            form.submit();
        }
    });
    $(".layout .main .content .filters .button-group button.update250").click(function (e) {
        $(this).addClass('loading');
        var btn = this;
        var general = toastr.warning("در حال به روزرسانی 250 فیلم و سریال برتر . این فرایند ممکن است طول بکشد", "", {
            timeOut: 0,
            extendedTimeOut: 0
        });
        $.get("/admin/imdb/update250", function (data) {
            general.remove();
            $(btn).removeClass('loading');
            if (data.success == true) {
                toastr.success("250 فیلم و سریال برتر به روز شد", "");
            }
        });
    });
    $(".layout .main .content .filters .button-group button.updatechart").click(function (e) {
        $(this).addClass('loading');
        var btn = this;
        var general = toastr.warning("در حال به روزرسانی جدول پخش سریال ها . این فرایند ممکن است طول بکشد", "", {
            timeOut: 0,
            extendedTimeOut: 0
        });
        $.get("/admin/imdb/updateplaylistchart", function (data) {
            general.remove();
            $(btn).removeClass('loading');
            if (data.success == true) {
                toastr.success("جدول پخش به روز شد", "");
            }
        });
    });
    $(".content.vitrin .form-group.vitrin_type select").on('change', function (e) {
        var type = $(this).val();
        $('.content.vitrin .formfor').fadeOut();
        $('.content.vitrin .formfor_' + type).fadeIn();
    });
    /*
    $( ".table-responsive.sortable table tbody" ).sortable({
      stop: function( event, ui ) {
    		var indexes = '';
    		var vides = '';
    		$('.table-responsive.sortable table tbody tr').each(function(){
    			indexes += $(this).index()+",";
    			vides += $(this).data('id')+",";
    		});
    		$.post("/admin/vitrin/updateindex",{ids:vides,index:indexes});
    	}
    });
    */
});
$(document).on('keyup', function (e) {
    if (e.key === "Escape") {
        $('.replaychat').removeClass('open');
        $('.layout .sidebar').removeClass('opensupport');
    }
});
String.prototype.toFaDigit = function () {
    return this.replace(/\d+/g, function (digit) {
        var ret = '';
        for (var i = 0, len = digit.length; i < len; i++) {
            ret += String.fromCharCode(digit.charCodeAt(i) + 1728);
        }

        return ret;
    });
};
