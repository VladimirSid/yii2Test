
function setPage(e) {

    let page = $(e).text();
    $.pjax.reload({
        url: '/backend/web/site/index',
        type: 'GET',
        data: {pageOn:page},
        container: '#appleTree_pjax'
    });
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
            console.log(data);
       // }
    })
    .fail(function () {
        alert("Произошла ошибка!")
    });
}


function createApple(){
    $.ajax({
        url: '/backend/web/apple/create',
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


function changePageOn(page, move) {
    if (move === "up") page++;
    else if (move === "down") page--;
    $.pjax.reload({
        url: '/backend/web/site/index',
        type: 'GET',
        data: {pageOn:page},
        container: '#appleTree_pjax'
    });
}
