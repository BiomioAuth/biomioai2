App.Views.Wizard = Backbone.View.extend({
    el: $("#content"),
    initialize:function () {
    },
    render:function (type) {
        var template = render('Wizard', {});
        this.$el.html( template );

        this.get_email();
    },
    events: {
        //View-2
        "click .wizard .next-1"                    : "next_1",
        "click .wizard .next-2"                    : "next_2",
        "click .wizard .next-3"                    : "next_3",
        "click .wizard .next-4"                    : "next_4",
        "click .wizard .next-5"                    : "next_5",
        "click .wizard .update-qr-code"            : "generate_code",
        "click .wizard .activate-biometrics"       : "check_biometrics_verification",
        "click .wizard .extention-new-code"        : "generate_extention_code",

        "click .wizard .prev-2"                    : "prev_2",
        "click .wizard .prev-3"                    : "prev_3",
        "click .wizard .prev-4"                    : "prev_4",
    },
    get_email: function (e) {
        $.ajax({
            type: 'POST',
            url: 'php/login.php',
            dataType: "json",
            data: {cmd: "get_user_emails", extention: 1},
            success: function(data) {
                if (data != null)
                    jQuery.each(data, function(i, email) {
                        $('.welcome-email').text(email.email);
                    });
            }
        });
    },

    // View - 2

    next_1: function(e) {
        e.preventDefault(e);
        console.log('next_1');
        var first_name = $('#wizard_first_name').val();
        var last_name = $('#wizard_last_name').val();

        $.ajax({
            type: 'POST',
            url: 'php/login.php',
            data: {cmd: "update_name", first_name: first_name, last_name: last_name},
            success: function(data) {
                if (data == '#success') {
                    $('.div-1').addClass('hide');
                    $('.div-2').removeClass('hide');
                    $('.menu-1 span').removeClass('hide');
                    $('.menu').removeClass('menu-active');
                    $('.menu-2').addClass('menu-active');
                    window.profileFirstName = first_name;
                    window.profileLastName = last_name;
                }
            }
        });
    },
    next_2: function(e) {
        e.preventDefault(e);
        console.log('next_2');
        
        if (!$('.div-2-1').hasClass('hide')) {
            $('.div-2-1').addClass('hide');
            $('.div-2-2').removeClass('hide');
        } else if (!$('.div-2-2').hasClass('hide')) {
            console.log('saving device name');

            var name = $('.div-2-2 .phone').val();
            that = this;
            if (name.length < 2) message('danger', 'Error: ', "Device name should be at least 2 symbols");
            else 
                $.ajax({
                    type: 'POST',
                    url: 'php/login.php',
                    data: {cmd: "add_mobile_device", name: name},
                    success: function(data) {
                        $('.device-id').val(data);
                        $('.div-2-2').addClass('hide');
                        $('.div-2-3').removeClass('hide');
                        that.generate_code();

                        $('.next_2').removeClass('btn-primary');
                    }
                });
        } else if (!$('.div-2-3').hasClass('hide')) {
            
        } else if (!$('.div-2-4').hasClass('hide')) {
            $('.div-2').addClass('hide');
            $('.div-3').removeClass('hide');
            $('.menu').removeClass('menu-active');
            $('.menu-3').addClass('menu-active');
            this.register_biometrics();
            $('.next_3').removeClass('btn-primary');
        }
    },
    next_3: function(e) {
        e.preventDefault(e);
        console.log('next_3');
        
        if (!$('.div-3-1').hasClass('hide')) {
            
        } else if (!$('.div-3-2').hasClass('hide')) {
            $('.div-3').addClass('hide');
            $('.div-4').removeClass('hide');
            $('.menu').removeClass('menu-active');
            $('.menu-4').addClass('menu-active');
        }
    },
    next_4: function(e) {
        e.preventDefault(e);
        console.log('next_4');
        
        if (!$('.div-4-1').hasClass('hide')) {
            $('.div-4-1').addClass('hide');
            $('.div-4-2').removeClass('hide');

            this.generate_extention_code();
            $('.next_4').removeClass('btn-primary');

        } else if (!$('.div-4-3').hasClass('hide')) {
            $('.div-4').addClass('hide');
            $('.div-5').removeClass('hide');
        }
    },
    next_5: function(e) {
        e.preventDefault(e);
        console.log('next_4');
        
        if (!$('.div-5-1').hasClass('hide')) {
            window.location.hash = 'user-info';
        } 
    },
    prev_2: function(e) {
        e.preventDefault(e);
        
    },
    prev_3: function(e) {
        e.preventDefault(e);
        
    },
    prev_4: function(e) {
        e.preventDefault(e);
        
    },
    generate_code: function (e) {
        that = this;
        var id = $('.device-id').val();
        $('.update-qr-code').addClass('disabled');
        $('#qr_code').html('');
        $('#qr_code_text strong').text('');
        $.ajax({
            type: 'POST',
            url: 'php/login.php',
            data: {cmd: "generate_qr_code", id: id, application: 1},
            success: function(data) {
                // returns 8 symbol code which we present as a text and as a qr image
                $('#qr_code').qrcode({
                    "width": 150,
                    "height": 150,
                    "color": "#3a3",
                    "text": data
                });
                $('#qr_code_text strong').text(data);
                $('.update-qr-code').removeClass('disabled');

                that.check_device_verification();
            }
        });
    },
    register_biometrics: function(e) {
        var that = this;

        var device_id = $('.device-id').val();

        // create session code
        $.ajax({
            type: 'POST',
            url: 'php/login.php',
            data: {cmd: "generate_biometrics_code", application: 0, device_id: device_id},
            success: function(data) {
                $('#biometrics_code').text(data);
                $('.next_2').addClass('btn-primary');
                // send rest here
                that.check_biometrics_verification();
            }
        });
    },
    check_device_verification: function () {
        that = this;
        var check = setInterval(function(){ 
            var code = $('#qr_code_text strong').text();
            console.log('verification call for ' + code);
            if (code != '' && code != undefined && !$('.div-2-3').hasClass('hide'))
                $.ajax({
                    type: 'POST',
                    url: 'php/login.php',
                    data: {cmd: "check_status", code: code},
                    success: function(data) {
                        if (data == '#verified') {
                            clearInterval(check);
                            $('.div-2-3').addClass('hide');
                            $('.div-2-4').removeClass('hide');
                            $('.menu-2 span').removeClass('hide');
                        }
                    }
                });
            else clearInterval(check);
        }, 3000);
    },
    check_biometrics_verification: function () {
        clearInterval(check);
        check = setInterval(function() { 
            var code = $('#biometrics_code').text();
            console.log('verification call for ' + code);
            if (code != '' && code != undefined)
                $.ajax({
                    type: 'POST',
                    url: 'php/login.php',
                    data: {cmd: "check_status", code: code},
                    success: function(data) {
                        if (data == '#verified') {
                            clearInterval(check);
                            $('.div-3-1').addClass('hide');
                            $('.div-3-2').removeClass('hide');
                            $('.menu-3 span').removeClass('hide');
                            $('.next_3').addClass('btn-primary');
                        }
                    }
                });
            else clearInterval(check);
        }, 3000);
    },
    generate_extention_code: function () {
        var that = this;
        var context = 0;
        $.ajax({
            type: 'POST',
            url: 'php/login.php',
            dataType: "json",
            data: {cmd: "verify_extention"},
            success: function(data) {
                //var img = new Image();
                //img.onload = function () {
                 //   context.drawImage(this, 0, 0, canvas.width, canvas.height);
                //}
                //img.src = "data:image/png;base64," + data.image;
                //$('.extention-verifcation-image').html(img);

                $('.extention-verifcation h2').text(data.code);
                $('.extention-verifcation-code').val(data.code);

                that.check_extension_verification();
            }
        });
    },
    check_extension_verification: function () {
        that = this;
        clearInterval(check);
        check = setInterval(function(){ 
            var code = $('.extention-verifcation-code').val();
            console.log('verification call for ' + code);
            if (code != '' && code != undefined)
                $.ajax({
                    type: 'POST',
                    url: 'php/login.php',
                    data: {cmd: "check_status", code: code},
                    success: function(data) {
                        if (data == '#verified') {
                            clearInterval(check);
                            $('.div-4-2').addClass('hide');
                            $('.div-4-3').removeClass('hide');
                            $('.menu-4 span').removeClass('hide');
                            $('.next-4').text('Finish');
                            $('.next_4').addClass('btn-primary');
                        }
                    }
                });
            else clearInterval(check);
        }, 3000);
    }

});