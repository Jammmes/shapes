$(function() {

    // ТОВАРЫ

    $('#goodsList').each(function()
    {
        // Привяжем контекст к форме
        var $form = $(this);
        // Установим свой обработчик на нажатие кнопки
        $form.on('submit', '.addToCart', function(event)
        {
            event.preventDefault();
            // Получим значение ИД товара
            var $inputId = $(event.target).find('input[name = "id"]');
            var id = $inputId.val();

            $.ajax(
                {
                  'url': '/Cart/add/',
                  'method': 'post',
                  'data':
                  {
                    id: id,
                    AJAX: 'AJAX'
                  },
                success: function(data)
                {
                    //console.log(data);
                    var newData = JSON.parse(data);
                    // console.log(newData.summary);
                    //Обновляем корзину
                    var newContent = newData.summary.totalQ + '/' + newData.summary.totalS;
                    $('#cartCount').html(newContent);
                },
                error: function()
                {
                    console.log('Товар с ид = ', id, ' не был добавлен в корзину.');
                }
            });
        })
    });

    // ЗАКАЗЫ

    $('#ordersList').each(function()
    {
        var $orderForm = $(this);
        // Обработка проведения заказа
        $orderForm.on('submit', '.formConfirmOrder', function(event)
        {
            event.preventDefault();
            // Получим ИД заказа
            var $inputId = $(event.target).find('input[name = "id"]');
            var id = $inputId.val();
            // Получим DOM элемент отображения статуса
            var $divStatus = $(event.target).parents().siblings('.status');
            var $status = $divStatus.children('span');

            // Получим DOM элемент обеих кнопок
            var $buttonConfirm = $(event.target).find('button:submit');
            var $divCancel = $(event.target).parents().siblings('.cancel');
            var $formCancel = $divCancel.find('.formCancelOrder');
            var $buttonCancel = $formCancel.find('button:submit');

            $.ajax(
            {
               'url': '/admin/confirm/',
               'method': 'post',
               'data':
               {
                  id: id,
                  AJAX: 'AJAX'
               },
                success: function(data)
                {
                   //Получаем новый статус заказа                    
                  var newStatus = (JSON.parse(data))[0].title;

                  if (newStatus == 'Оплачен')
                  {
                    $status.html(newStatus);
                    $status.attr('class','badge badge-success');  
                    $buttonCancel.prop('disabled',true);
                    $buttonConfirm.prop('disabled',true);                  
                  }
                },
                error: function()
                {
                  console.log('Заказ не был обработан');
                }
            });
        })
        // Обработка отмены заказа
        $orderForm.on('submit', '.formCancelOrder', function(event)
        {
            event.preventDefault();
            // Получим ИД заказа
            var $inputId = $(event.target).find('input[name = "id"]');
            var id = $inputId.val();
            // Получим DOM элемент отображения статуса
            var $divStatus = $(event.target).parents().siblings('.status');
            var $status = $divStatus.children('span');

            // Получим DOM элемент обеих кнопок
            var $buttonCancel = $(event.target).find('button:submit');
            var $divConfirm = $(event.target).parents().siblings('.confirm');
            var $formConfirm = $divConfirm.find('.formConfirmOrder');
            var $buttonConfirm = $formConfirm.find('button:submit');

            $.ajax(
            {
               'url': '/admin/cancel/',
               'method': 'post',
               'data':
               {
                  id: id,
                  AJAX: 'AJAX'
               },
                success: function(data)
                {
                   //Получаем новый статус заказа                    
                  var newStatus = (JSON.parse(data))[0].title;

                  if (newStatus == 'Отменен')
                  {
                    $status.html(newStatus);
                    $status.attr('class','badge badge-danger');  
                    $buttonCancel.prop('disabled',true);
                    $buttonConfirm.prop('disabled',false);                  
                  }
                },
                error: function()
                {
                  console.log('Заказ не был обработан');
                }
            });
        })      
    })
    
    // РЕГИСТРАЦИЯ
 
    $('#regButt').click(function(event)
    {

        event.preventDefault();

        // Получим реквизиты формы
        var $form = $('#regForm');
        var $mainCont = $('#regContainer');
        var $title = $('#regTitle');
        var $name = $form.find('input[name = "name"]');
        var $login = $form.find('input[name = "login"]');
        var $password = $form.find('input[name = "password"]');
        var $address = $form.find('input[name = "address"]');
        var $email = $form.find('input[name = "email"]');
        var $phone = $form.find('input[name = "phone"]');
        var name = $name.val();
        var login = $login.val();
        var password = $password.val();
        var address = $address.val();
        var email = $email.val();
        var phone = $phone.val();

        $.ajax(
        {
            'url': '/Registration/add/',
            'method': 'post',
            'data':
            {
              name: name,
              login: login,
              password: password,
              address: address,
              email: email,
              phone: phone,
              AJAX: 'AJAX'
            },
            success: function(data)
            {
                var newData = JSON.parse(data);

                if(newData['success']== 1)
                {
                  $mainCont.html('');
                  $title.html("Новый пользователь успешно зарегистрирован!"); 
                  $title.append($('<div/>',{text:'Вы можете зайти в магазин под созданным пользователем или'}));
                  $title.append($('<div/>',{text:'зарегистрировать нового пользователя.'}));
                }else
                {
                    $title.html("При регистрации возникли ошибки:");
                    // Соберем все ошибки:
                    var $errList = $('<ul/>',{class:'list-group'});

                    for (key in newData[0])
                    { 

                       for(err in newData[0][key])
                       {
                            var errText = newData[0][key][err];
                            var $h5 = $('<h5/>',{class:'p-0 m-0'});
                            var $li = $('<li/>',{text:errText,
                                class:'list-group-item list-group-item-danger'});
                            $h5.append($li);
                            $errList.append($h5);
                       } 
                    }
                    $title.append($errList);
                }            
            },
            error: function()
            {
                $title.html("При передаче данных на сервер возникли ошибки.");
            }
        });     
    })      
});