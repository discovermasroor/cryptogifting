jQuery(document).ready(function ($) {
    $('#button-addon1').on('click', function () {
        $('#search-form').submit();
    });
    $('.signup-slider').owlCarousel({
        loop: true,
        margin: 10,
        nav: false,
        dots: true,
        autoplay: true,
        autoplayTimeout: 2500,
        autoplayHoverPause: true,
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 1
            },
            1000: {
                items: 1
            }
        }
    });
    
    let go_back=document.querySelector(".back-btn")
    if(go_back){
        go_back.addEventListener("click",()=>{
            window.history.go(-1)
        })
    }

    var alertLength = $('body').find('div.alert.custom-alert').length;
    if (alertLength > 0) {
        setTimeout(function(){ $('body').find('div.alert.custom-alert').remove(); }, 5000);
    }

    function displayError(message, single = true) {
        var html = ''
        html += '<div class="alert custom-alert alert-danger d-flex align-items-center" role="alert">';
        html += '<ul>';

        if (single) {
            html += '<li><i class="uis uis-exclamation-triangle"></i>'+message+'</li>';

        } else {
            $.each(message, function(index, value){
                html += '<li><i class="uis uis-exclamation-triangle"></i>'+value+'</li>';
            });

        }

        html += '</ul>';
        html += '</div>';
        $('body').append(html);
        setTimeout(function(){ $('body').find('div.alert.custom-alert').remove(); }, 5000);
    }

    function displaySuccess(message) {
        var html = ''
        html += '<div class="alert custom-alert alert-success d-flex align-items-center" role="alert">';
        html += '<ul>';
        html += '<li><i class="uil uil-check-circle"></i>'+message+'</li>';
        html += '</ul>';
        html += '</div>';
        $('body').append(html);
        setTimeout(function(){ $('body').find('div.alert.custom-alert').remove(); }, 5000);
    }
});