class Todolist {
    constructor() {
        this.hash = $('[data-hash]').attr('data-hash');
    }
}

var todolist = new Todolist();

$(function () {
    $('.update-name button[type="submit"]').on('click', function (e) {
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
})