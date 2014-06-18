$(function() {

    $('#side-menu').metisMenu();

});

//Loads the correct sidebar on window load,
//collapses the sidebar on window resize.
$(function() {
    $(window).bind("load resize", function() {
        width = (this.window.innerWidth > 0) ? this.window.innerWidth : this.screen.width;
        if (width < 768) {
            $('div.sidebar-collapse').addClass('collapse')
        } else {
            $('div.sidebar-collapse').removeClass('collapse')
        }
    })
})


$(function() {

    /**
     * Pulsante per mostrare/nascondere sidebar 
     */
    $("#sidebar-toggle a").click(function(e) {
        e.preventDefault();

        if ($('.navbar-static-side').is(":visible") ) {
            $('.navbar-static-side').hide();
            $('#page-wrapper').css( "margin-left", "0");
        } else {
            $('.navbar-static-side').show();
            $('#page-wrapper').css( "margin-left", "250px");           
        }
    });



});

