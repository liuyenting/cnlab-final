let Config = {
    'attendanceUrl': '/queryJSON.php'
};

let Attendance = {};

Attendance.data = {};

Attendance.view = {};


Attendance.view.setTitle = function(){
    $('#title').text('Attendence: ' + Attendance.class);
};


Attendance.view.makeRow = function(userId, attendance) {
    let tr = $('<tr></tr>');
    let tdSId = $('<td></td>').text(userId);
    tr.append(tdSId);
    for (let week of attendance) {
        let tdAttend = $('<td></td>');
        if (week == 1) {
            let allDone = $('<img src="/static/imgs/done_all.svg">');
            tdAttend.append(allDone);
        }        
        tr.append(tdAttend);
    }
    return tr;
};


Attendance.view.makeTable = function(attendanceTable) {
    let tbody = $('<tbody></tbody>');
    for (let entry of attendanceTable) {
        let tr = Attendance.view.makeRow(entry['sid'], entry['attendance']);
        tbody.append(tr);
    }
    return tbody;
};

Attendance.view.update = function() {    
    let tbody = Attendance.view.makeTable(Attendance.data);
    tbody.attr('id', 'attendance-table-body');
    $('#attendance-table-body').replaceWith(tbody);
}

Attendance.getAttendanceTable = function(callback) {
    $.get(Config.attendanceUrl,
          {class: Attendance.class},
          function(data) {
              Attendance.data = JSON.parse(data);
              callback();
          });          
};


Attendance.update = function(callback) {
    let oldData = Attendance.data;
    Attendance.getAttendanceTable(function() {
        if (JSON.stringify(oldData) !== JSON.stringify(Attendance.data)) {
            Attendance.view.update();
        }
        callback();
    });
};


Attendance.init = function() {
    let hash = window.location.hash.substr(1);
    Attendance.class = decodeURI(hash);
    Attendance.view.setTitle();
    update = function()  {
        Attendance.update(function() {
            setTimeout(update, 1000);
        });
    };
    Attendance.update(update);

    window.onhashchange = function () {
        location.reload();        
    };

}

$(document).ready(function() {
    Attendance.init();
});
