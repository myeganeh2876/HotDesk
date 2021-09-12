
$(".sub-menu a").click(function () {
    $(this).parent(".sub-menu").children("ul").toggleClass("active");
    $(this).toggleClass("activete");


});
// ----------------------------------



const menu = document.querySelector('#nav-toggle');
const menuLinks = document.querySelector('.sidebar');
const overlay = document.querySelector('.overlay');


menu.addEventListener('click', function() {
    menuLinks.classList.toggle('active')
    menu.classList.toggle('active')
    $('.overlay').fadeToggle()
    $('body').css("position" , "fixed")

})
overlay.addEventListener('click', function() {
    menuLinks.classList.remove('active')
    menu.classList.remove('active')
    $('.overlay').fadeOut(100)
    $('body').css("position" , "relative")
})

// -------------------------------

$(".search-box .search-input").click(function (e) {
    $(this).parent().toggleClass("active");
    e.stopPropagation();


});

$(".search-box").click(function (e) {
    e.stopPropagation();
});
$(".search-box .search-details *").click(function (e) {
    e.stopPropagation();
});

$(document).click(function () {
    $(" .search-box ").removeClass("active")
});

$(".search-box ul a").click(function () {

    var sel = $(".search-box input");
    var textbx = $(this).children(".p-item").text();
    sel.attr("placeholder",textbx);
    $(" .search-box ").removeClass("active")

});
$("input[data-type='currency']").on({
    keyup: function() {
        formatCurrency($(this));

    },
    blur: function() {
        formatCurrency($(this), "blur");


    }
});


function formatNumber(n) {
    // format number 1000000 to 1,234,567
    return n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")


}


function formatCurrency(input, blur) {
    // appends $ to value, validates decimal side
    // and puts cursor back in right position.

    // get input value
    var input_val = input.val();

    // don't validate empty input
    if (input_val === "") { return; }

    // original length
    var original_len = input_val.length;

    // initial caret position
    var caret_pos = input.prop("selectionStart");

    // check for decimal
    if (input_val.indexOf(".") >= 0) {

        // get position of first decimal
        // this prevents multiple decimals from
        // being entered
        var decimal_pos = input_val.indexOf(".");

        // split number by decimal point
        var left_side = input_val.substring(0, decimal_pos);
        var right_side = input_val.substring(decimal_pos);

        // add commas to left side of number
        left_side = formatNumber(left_side);

        // validate right side
        right_side = formatNumber(right_side);

        // On blur make sure 2 numbers after decimal
        if (blur === "blur") {
            right_side += "00";

        }

        // Limit decimal to only 2 digits
        right_side = right_side.substring(0, 2);

        // join number by .
        input_val = "$" + left_side + "." + right_side;

    } else {
        // no decimal entered
        // add commas to number
        // remove all non-digits
        input_val = formatNumber(input_val);

        // final formatting
        if (blur === "blur") {

        }
    }

    // send updated string to input
    input.val(input_val);

    // put caret back in the right position
    var updated_len = input_val.length;
    caret_pos = updated_len - original_len + caret_pos;
    input[0].setSelectionRange(caret_pos, caret_pos);

}

$("#search-tag-row").keypress(function (e) {
    if(e.which == 13) {
        var filename = $(this).val();
        console.log(filename)
        $( ".search-tag-row" ).append( "<div class=\"acsses  files\">" +
            "<div class=\"flex-box\">" +
            "<img class='close-tag' src=\"assets/icon/clos.svg\">"
            + filename  +
            "</div>" +
            "</div>" );
        $('.close-tag').click(function(){
            $(this).parent().parent().fadeOut();
        });
        $(this).val('');
    }

})

$("#search-tag-row2").keypress(function (e) {
    if(e.which == 13) {
        var filename = $(this).val();
        console.log(filename)
        $( ".search-tag-row2" ).append( "<div class=\"acsses  files\">" +
            "<div class=\"flex-box\">" +
            "<img class='close-tag' src=\"assets/icon/clos.svg\">"
            + filename  +
            "</div>" +
            "</div>" );
        $('.close-tag').click(function(){
            $(this).parent().parent().fadeOut();
        });
        $(this).val('');
    }

})