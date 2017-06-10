function login() {
    let username = $('#username').val();
    let password = $('#password').val();
    $.post('/login.php',
           {'name': username, 'pwd': password},
           function(data) {
               res = JSON.parse(data);
               if (res['success'] == 1) {
                   window.location = '/static/teacher/index.html';
               } else {
                   $('password').val('');
                   $('#error').show('flex').css('display', 'flex')
               }
           });
};
