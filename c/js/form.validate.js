$(document).ready(function(){
    $('.form-horizontal').validate({
        rules: {
            email: {
                required: true
            },
            password: {
                required: true
            }
        },
        messages: {
            email: {
                required: 'Пожалуйста введите Логин/email'
            },
            password: {
                required: 'Пожалуйста введите Пароль'
            }
        }
    })

    $('.form-registration-js').validate({
        rules: {
            email: {
                required: true
            },
            firstname: {
                required: true
            },
            lastname: {
                required: true
            },
            pass: {
                required: true,
                minlength: 5
            },
            pass_replay: {
                required: true,
                minlength: 5
            }
        },
        messages: {
            email: {
                required: 'Пожалуйста введите Логин/email'
            },
            firstname: {
                required: 'Пожалуйста введите Имя'
            },
            lastname: {
                required: 'Пожалуйста введите Фамилию'
            },
            pass: {
                required: 'Пожалуйста введите Пароль',
                minlength:'Минимальный пароль 5 символов'
            },
            pass_replay: {
                required: 'Пожалуйста введите Повторно пароль',
                minlength:'Минимальный пароль 5 символов'
            }
        }
    })

    $('.form-addTask-js' ).validate({
        rules:{
            title: {
                required: true
            }
        },
        messages: {
            title: {
                required: 'Это поле должно быть заполнено'
            }
        }
    });

    $('.form-updateTask-js' ).validate({
        rules:{
            title: {
                required: true
            }
        },
        messages: {
            title: {
                required: 'Это поле должно быть заполнено'
            }
        }
    });
});