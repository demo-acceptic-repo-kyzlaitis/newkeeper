$(document).ready(function () {

    /**
     * Finds users by instagram username
     */
    $(function () {
        $('form').on('submit', function (e) {
            e.preventDefault();
            var instagramName = $('#instagramName').val();
            $.ajax({
                type: 'get',
                url: '/searchUsers',
                data: 'instaName=' + instagramName,
                success: function (data) {
                    handleSuccess(data);
                },
                error: function (xhr, status, error) {
                    logErrror(xhr, status, error);
                }
            });
        });
    }); //eof function


    /**
     * Starts following users
     */
    $(function () {
        var usersId;
        $('#follow-btn').on('click', function() {
            usersId = getAllCheckedUsers();

            $.ajax({
                type: 'get',
                url: '/socialNetwork/StartFollowingUsers',
                data: {usersId: usersId},
                success: function(data) {
                    console.log(data);
                },
                error: function (xhr, status, error) {
                    logErrror(xhr, status, error);
                }
            });
            //getUserFollowedBy
        });
    });//eof function

}); // end of document ready

/**
 * Returns ids of all checked users
 * @returns {*}
 */
function getAllCheckedUsers() {
    var usersId = new Array();

    $('#users-list > li input:checked.user-to-botted').each(function() {
        usersId.push($(this).data('id'));
    });
    return JSON.stringify(usersId);
}

/**
 * @param data users that were found by username
 */
function handleSuccess(data) {
    if($('#users-list li').length != 0) {
        $('#users-list').empty();
    }

    $.each(data.data, function (i, item) {
        $('#users-list').append('<li class="user-item" >' +  '<img class="image-preview" src="' +
        item.profile_picture + '"/>' + '<p>' + item.username + '</p>' + '<input class="user-to-botted"' + 'data-id="' + item.id  + '"'  + ' type="checkbox" >'  + '</li>');
    });

    //log user
    //console.log(Object.keys(data.data).length + "\n");
    //console.log(data.data[0].username + " \n" +
    //data.data[0].profile_picture + " \n" +
    //data.data[0].id + " \n" +
    //data.data[0].full_name);
}


/**
 * Logs error to console
 */
function logErrror(xhr, status, error) {
    var err = eval("" + xhr.responseText + "");
    console.log(err.Message + " " + status + " " + error);
}