
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

/****** ПОЕДАНИЕ ЯБЛОКА ******/
/*** считаем что откусить можно от 2% до 17%
 *  всё что больше(равно) 100% - съедание яблока ****/
function eatApple(id, eat) {
    if (eat != null && !Number.isInteger(eat)) return;

    if (eat < 100  || (eat == null)) {
        eat = Math.random() * (17 - 2) + 2
    }
    let url = '/backend/web/site/index';
    let page = $('#applesDownTree_pjax').find('.active').text();

    $.ajax({
        url: '/backend/web/apple/eat',
        type: 'POST',
        data: {id: id, percent: Math.floor(eat)}
    })
    .done(function (data) {
        if (data.success){
            $('#appleModal').modal('toggle');
            $.pjax.reload({ url: url, type: 'GET', data: {pageFall:page}, container: '#applesDownTree_pjax' });
        }
        else{
            alert("Отказ!")
        }
    })
    .fail(function () {
        alert("Произошла ошибка!")
    });
}
