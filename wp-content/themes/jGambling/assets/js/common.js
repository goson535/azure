$(function () {
    $(".sandwich").on("click", function () {
        $(".mobiles-menu").toggleClass("active")
    }), $(".casino-page .top-info .links a").bind("click", function (a) {
        var e = $(this);
        $("html, body").stop().animate({scrollTop: $(e.attr("href")).offset().top}, 1e3), a.preventDefault()
    }), $(".casino-page .top-info .content .info p a").click(function () {
        $(this).toggleClass("active"), $(".casino-page .top-info .content .info p .hidden").toggle()
    }), $(".header .menu-button").click(function () {
        $(this).toggleClass("active"), $(".mobile-menu").slideToggle()
    }), $.fn.toggleText = function (a, e) {
        return this.text() == a ? this.text(e) : this.text(a), this
    }, $(".hide_show").on("click", function (a) {
        a.preventDefault(), $(".hidden").toggle(), $(this).toggleText(jgambling.param_9, jgambling.param_10)
    }), $(".lazy").Lazy({
        visibleOnly: !0,
        threshold: "",
        effect: "fadeIn"
    }), $(".index-rating img").Lazy({
        visibleOnly: !0,
        threshold: "",
        effect: "fadeIn"
    }), $(".subscribe-block button").on("click", function (a) {
        a.preventDefault();
        var e = $(".subscribe-block input").val(), t = {action: "subscribe_mailchimp", postmail: e};
        e ? $.ajax({
            url: custom_ajax_url, data: t, type: "POST", success: function (a) {
                "1" === a ? ($(".subscribe-block input").val(""), alert(jgambling.param_1)) : alert(jgambling.param_2)
            }
        }) : alert(jgambling.param_3)
    });
    var a = $(".loadmore.grid");
    $(a).click(function (e) {
        e.preventDefault(), $(this).text(jgambling.param_11);
        var t = {action: "loadmore_grid", query: posts, page: current_page};
        $.ajax({
            url: ajaxurl, data: t, type: "POST", success: function (e) {
                e ? ($(a).text(jgambling.param_4), current_page++, $(".flex2.grid_rating").append(e), current_page == max_pages && $(a).remove()) : $(a).remove()
            }
        })
    });
    var e = $(".load_more_commments");
    $(e).click(function (a) {
        a.preventDefault(), $(this).text(jgambling.param_4);
        var t = {action: "load_reviews", post: post_id, page: current_page};
        $.ajax({
            url: ajaxurl, data: t, type: "POST", success: function (a) {
                a ? ($(e).text(jgambling.param_4), current_page++, $(".ajax_items").append(a), current_page == max_pages && $(e).remove()) : $(e).remove()
            }
        })
    });
    var t = $(".load_more_category");
    $(t).click(function (e) {
        e.preventDefault(), $(this).text(jgambling.param_4);
        var n = {action: "loadmore_categories", query: posts, page: current_page};
        $.ajax({
            url: ajaxurl, data: n, type: "POST", success: function (e) {
                e ? ($(a).text(jgambling.param_4), current_page++, $(".article-items").append(e), current_page == max_pages && $(t).remove()) : $(t).remove()
            }
        })
    });
    var n = $(".reviews-form button");
    $(n).click(function (a) {
        a.preventDefault();
        var e = $(".review-name").val(), t = $(".review-email").val(), n = $(".plus").val(), o = $(".minus").val(),
            i = $(".set_rating .selected").data("note"),
            s = {action: "add_reviews", post: post_id, name: e, email: t, rating: i, plus: n, minus: o};
        e && t && i && (n || o) ? /^([^@\s]+)@((?:[-a-z0-9]+\.)+[a-z]{2,})$/i.test(t) ? $("#ch2").is(":checked") ? ($(this).text(jgambling.param_5), $.ajax({
            url: ajaxurl,
            data: s,
            type: "POST",
            success: function (a) {
                a && $(".reviews-form").html('<div style="font-size: 17px;">' + jgambling.param_6 + "</div>")
            }
        })) : alert(jgambling.param_7) : alert(jgambling.param_7_1) : alert(jgambling.param_8)
    }), $(".set_rating input").change(function () {
        var a = $(this);
        $(".set_rating .selected").removeClass("selected"), a.closest("label").addClass("selected")
    });
    var o = $(".loadmore.slotoload");

    function i() {
        var a, e = $(".sort_slots_input").val(), t = [];
        $(".sort1 .checkbox").each(function () {
            this.checked && t.push($(this).val())
        });
        var n = 0, o = 0, i = 0, s = 0;
        a = $("input.bonus_s").is(":checked") ? 0 : 1, n = $("input.free_spin_s").is(":checked") ? 0 : 1, o = $("input.scatter_s").is(":checked") ? 0 : 1, i = $("input.wild_s").is(":checked") ? 0 : 1, s = $("input.fast_speed_s").is(":checked") ? 0 : 1;
        var l = {
            action: "search_slots",
            s: e,
            soft: t,
            bonus_s: a,
            free_spin_s: n,
            scatter_s: o,
            wild_s: i,
            fast_speed_s: s
        };
        $.ajax({
            url: custom_ajax_url, data: l, type: "POST", success: function (a) {
                a && $(".slots.small.ajax_block").html("").append(a)
            }
        })
    }

    $(document).on("click", ".loadmore.slotoload", function (a) {
        a.preventDefault(), $(o).text(jgambling.param_4);
        var e = {action: "loadmore_slots", query: posts, page: current_page};
        $.ajax({
            url: ajaxurl, data: e, type: "POST", success: function (a) {
                a ? ($(o).text(jgambling.param_4), current_page++, $(".lazy").Lazy({
                    visibleOnly: !0,
                    threshold: "",
                    effect: "fadeIn"
                }),$(".slots.small.ajax_block .flex2").append(a), current_page == max_pages && $(".loadmore.slotoload").remove()) : $(o).remove()
            }
        })
    }), $(".sort_slots").on("change", function () {
        i()
    }), $(".sort_slots_input").on("input", function () {
        i()
    }), $(".add_comment").on("submit", function (a) {
        "" == $('input[name="imya"]').val() || "" == $('input[name="mail"]').val() || "" == $('input[name="text"]').val() ? (alert(jgambling.param_8), a.preventDefault()) : $("#new_comment").submit()
    });
    var s = $(".loadmore.bonusload");

    function l() {
        var a = $(".sort_bonus_input").val(), e = [];
        $(".sort2 .checkbox").each(function () {
            this.checked || e.push($(this).val())
        });
        var t = {action: "search_bonus", s: a, type: e};
        $.ajax({
            url: custom_ajax_url, data: t, type: "POST", success: function (a) {
                a && $(".ajax_block_bonus").html("").append(a)
            }
        })
    }

    $(document).on("click", ".loadmore.bonusload", function (a) {
        a.preventDefault(), $(s).text(jgambling.param_4);
        var e = {action: "loadmore_bonus", query: posts, page: current_page};
        $.ajax({
            url: ajaxurl, data: e, type: "POST", success: function (a) {
                a ? ($(s).text(jgambling.param_4), current_page++, $(".bonus-list .flex2").append(a), current_page == max_pages && $(".loadmore.bonusload").remove()) : $(s).remove()
            }
        })
    })

        , $('.sort2 input[type="checkbox"]').on("input", function () {
        l()
    }), $(".sort_bonus_input").on("input", function () {
        l()
    })
}), $(function () {
    $(".tac_span").webuiPopover({
        content: "Content",
        width: 220,
        closeable: !0
    }),$(".tac_span_no_deposit").webuiPopover({
        content: "Content",
        width: 220,
        trigger:'hover',
    }), $(".slot-game .links a.a2").click(function () {
        $(".slot-game .iframe").fadeIn(), $(".slot-game .links").fadeOut()
    }), $(".casino-page .top-info .links a").bind("click", function (a) {
        var e = $(this);
        $("html, body").stop().animate({scrollTop: $(e.attr("href")).offset().top}, 1e3), a.preventDefault()
    }), $(".casino-page .top-info .content .info p a").click(function () {
        $(this).toggleClass("active"), $(".casino-page .top-info .content .info p .hidden").toggle()
    })
});