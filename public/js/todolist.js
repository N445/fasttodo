class Item {
    constructor(element) {
        element = $(element);
        this.id = element.find('input').attr('id');
        this.text = element.find('label').html();
        this.isChecked = element.find('input').prop('checked');
        this.element = element;
    }
}

class Todolist {
    constructor() {
        this.hash = $('[data-hash]').attr('data-hash');
        this.items = [];
    }

    addItem(item) {
        this.items.push(item);
    }

    clearItem() {
        this.items = [];
    }
}

var todolist = new Todolist();

$(function () {

    $.each($('.items .item'), function (key, item) {
        todolist.addItem(new Item(item));
    });
    console.log(todolist);

    $(".items").sortable({
        update: function (event, ui) {
            var i = 1;
            $.each($('.items .item'), function (key, item) {
                $(item).attr('data-order', i * 10);
                i++;
            });
        }
    });

    $('form.update-name button[type="submit"]').on('click', function (e) {
        e.preventDefault();
        console.log('update-name');
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
        $.ajax({
            url: Routing.generate('ADD_ITEM', {'hash': todolist.hash}),
            methos: "POST",
            data: $('.add-item').serialize()
        }).done(function (response) {
            console.log(response);
            $('.list').html(response.html);
            todolist.clearItem();
            $.each($('.items .item'), function (key, item) {
                todolist.addItem(new Item(item));
            })
            $(".items").sortable();
            console.log(todolist);
        })
    })

    $('body').on('change', '.update-item', function (e) {
        var isChecked = $(this).prop('checked');
        console.log('update-item');
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