let Config = {
    'attendanceUrl': '/queryJSON.php'
};

let Management = {};

Management.data = {};

Management.view = {};


Management.view.setTitle = function(){
    $('#title').text('Management: ' + Management.class);
};


Management.view.makeRow = function(userId, attendance) {
    let tr = $('<tr></tr>');
    let tdSId = $('<td></td>').text(userId);
    tr.append(tdSId);
    for (let week of attendance) {
        tdAttend = $('<td></td>').text(week == 1 ? 'v' : '');
        tr.append(tdAttend);
    }
    return tr;
};


Management.view.makeTable = function(attendanceTable) {
    let tbody = $('<tbody></tbody>');
    for (let entry of attendanceTable) {
        let tr = Management.view.makeRow(entry['sid'], entry['attendance']);
        tbody.append(tr);
    }
    return tbody;
};

Management.view.update = function() {    
    let tbody = Management.view.makeTable(Management.data);
    tbody.attr('id', 'attendance-table-body');
    $('#attendance-table-body').replaceWith(tbody);
}

Management.getManagementTable = function(callback) {
    $.get(Config.attendanceUrl,
          {class: Management.class},
          function(data) {
              Management.data = JSON.parse(data);
              callback();
          });          
};


Management.update = function(callback) {
    let oldData = Management.data;
    Management.getManagementTable(function() {
        if (JSON.stringify(oldData) !== JSON.stringify(Management.data)) {
            Management.view.update();
        }
        callback();
    });
};


Management.init = function() {
    let hash = window.location.hash.substr(1);
    Management.class = decodeURI(hash);
    Management.view.setTitle();
    update = function()  {
        Management.update(function() {
            setTimeout(update, 1000);
        });
    };
    Management.update(update);

    window.onhashchange = function () {
        location.reload();        
    };

}

$(document).ready(function() {
    Management.init();
});
