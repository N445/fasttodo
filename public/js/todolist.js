class Todolist {
    constructor() {
        this.hash = $('[data-hash]').attr('data-hash');
    }
}

var todolist = new Todolist();

$(function () {
    $('form.update-name button[type="submit"]').on('click', function (e) {
        e.preventDefault();
        console.log('update-name');
        console.log(Routing.generate('UPDATE_NAME', {'hash': todolist.hash}));
        $.ajax({
            url: Routing.generate('UPDATE_NAME', {'hash': todolist.hash}),
            methos: "POST",
            data: $('.update-name').serialize()
        }).done(function (response) {
            console.log(response);
        })
    })

    $('form.add-item button[type="submit"]').on('click', function (e) {
        e.preventDefault();
        console.log('add-item');
        console.log(Routing.generate('ADD_ITEM', {'hash': todolist.hash}));
        $.ajax({
            url: Routing.generate('ADD_ITEM', {'hash': todolist.hash}),
            methos: "POST",
            data: $('.add-item').serialize()
        }).done(function (response) {
            console.log(response);
            $('.list').html(response.html);
        })
    })

    $('.update-item').on('change', function (e) {
        var isChecked = $(this).prop('checked');
        console.log('update-item');
        console.log(Routing.generate('UPDATE_ITEM', {'hash': todolist.hash, 'id': $(this).attr('id')}));
        $.ajax({
            url: Routing.generate('UPDATE_ITEM', {'hash': todolist.hash, 'id': $(this).attr('id')}),
            methos: "POST",
            data: {
                isChecked: isChecked
            }
        }).done(function (response) {
            console.log(response);
        })
    })
})