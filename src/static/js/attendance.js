let Config = {
    'attendanceUrl': './tmp.json'
};

let Attendance = {};

Attendance.data = {};

Attendance.view = {};

Attendance.view.makeRow = function(userId, attendance) {
    let tr = $('<tr></tr>');
    let tdSId = $('<td></td>').text(userId);
    tr.append(tdSId);
    for (let week of attendance) {
        tdAttend = $('<td></td>').text(week == 1 ? 'v' : '');
        tr.append(tdAttend);
    }
    return tr;
};


Attendance.view.makeTable = function(attendanceTable) {
    console.log(attendanceTable);
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
    $.get(Config.attendanceUrl, function(data) {
        Attendance.data = data;
        callback();
    });          
};


Attendance.update = function(callback) {
    Attendance.getAttendanceTable(function() {
        Attendance.view.update();
        callback();
    });
};

Attendance.init = function() {
    update = function()  {
        Attendance.update(function() {
            setTimeout(update, 1000);
        });
    };
    Attendance.update(update);
}

$(document).ready(function() {
    Attendance.init();
});
