$.get('/islogin.php', function(data) {
    let res = JSON.parse(data);
    if (res['login'] != 1) {
        window.location = '/static/teacher/login.html';
    }
});
