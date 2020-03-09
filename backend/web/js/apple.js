
function setPage(e, type) {
    let page = $(e).text();
    let url = '/backend/web/site/index';
    if (type === "on")
        $.pjax.reload({
            url: url, type: 'GET', data: {pageOn:page}, container: '#applesOnTree_pjax'
        });
    else if(type === "fall")
        $.pjax.reload({
            url: url, type: 'GET', data: {pageFall:page}, container: '#applesDownTree_pjax'
        });
    else
        $.pjax.reload({ url: url, type: 'GET', data: {pageBad:page}, container: '#applesBad_pjax'});

}

function showMdl(e){
    let id = $(e).data('id');
    $.ajax({
        url: '/backend/web/apple/info',
        type: 'GET',
        data: {id: id}
    })
    .done(function (data) {
        //if (data.success){
            $('#appleMdlContent').html(data);
            $('#appleModal').modal();
            //console.log(data);
       // }
    })
    .fail(function () {
        alert("Произошла ошибка!")
    });
}


function appleAction(action){
    $.ajax({
        url: '/backend/web/apple/' + action,
        type: 'POST'
    })
    .done(function (data) {
        if (data.success){
            $.pjax.reload({container:"#appleTree_pjax"});
        }
    })
    .fail(function () {
        alert("Произошла ошибка!")
    });
}


function changePageOn(e, page, move, type) {
    if (!$(e).parent().hasClass('disabled')){
        if (move === "up") page++;
        else if (move === "down") page--;
    }
    else return;

    let url = '/backend/web/site/index';
    if (type === "on")
        $.pjax.reload({ url: url, type: 'GET', data: {pageOn:page}, container: '#applesOnTree_pjax' });
    else if (type === "fall")
        $.pjax.reload({ url: url, type: 'GET', data: {pageFall:page}, container: '#applesDownTree_pjax' });
    else
        $.pjax.reload({ url: url, type: 'GET', data: {pageBad:page}, container: '#applesBad_pjax' });
}
