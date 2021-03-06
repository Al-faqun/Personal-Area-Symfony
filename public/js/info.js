/**
 * Make clientinfo form values defaolt.
 */
function cleanClientInfo() {
    var title = document.getElementById('title');
    var companyName = document.getElementById('company_name');
    var inn = document.getElementById('inn');
    var address = document.getElementById('address');
    var email = document.getElementById('client_email');
    var tel = document.getElementById('client_tel');
    title.innerHTML = 'Название компании клиента: ';
    companyName.innerHTML = 'Название компании клиента: ';
    inn.innerHTML = 'Инн клиента: ';
    address.innerHTML = 'Адрес клиента: ';
    email.innerHTML = 'Электронная почта клиента: ';
    tel.innerHTML = 'Телефон клиента: ';
}

/**
 * Make managerinfo form values default.
 */
function cleanManagerInfo() {
    //заполнить поля о менеджере
    var title = document.getElementById('title');
    var surname = document.getElementById('surname');
    var name = document.getElementById('name');
    var email = document.getElementById('man_email');
    var tel = document.getElementById('man_tel');
    title.innerHTML = 'Фамилия, Имя менеджера';
    surname.innerHTML = 'Фамилия менеджера: ';
    name.innerHTML = 'Имя менеджера: ';
    email.innerHTML = 'Электронная почта менеджера: ';
    tel.innerHTML = 'Телефон менеджера: ';
}

/**
 * Fetch info from server AND post it into page.
 * @param id
 */
function getClientInfo(id) {
    id = parseInt(id);
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState === 4 && this.status === 200) {
            //очистим данные формы от старых данных
            cleanClientInfo();
            //ответ сервера
            var json = JSON.parse(this.responseText);
            if (json === false) {
                var errorText = 'Извините, не получилось получить данные об этом пользователе.';
                alert(errorText);
            } else {
                //заполнить поля о клиенте
                var title = document.getElementById('title');
                var companyName = document.getElementById('company_name');
                var inn = document.getElementById('inn');
                var address = document.getElementById('address');
                var email = document.getElementById('client_email');
                var tel = document.getElementById('client_tel');
                title.innerHTML = json.companyName;
                companyName.innerHTML = 'Название компании клиента: ' + json.companyName;
                inn.innerHTML = 'Инн клиента: ' + json.inn;
                address.innerHTML = 'Адрес клиента: ' + json.address;
                email.innerHTML = 'Электронная почта клиента: ' + json.email;
                tel.innerHTML = 'Телефон клиента: ' + json.tel;
            }
            openClientInfo();
        }
    };
    xhttp.open("GET", Routing.generate('info_client', {'id': id}));
    xhttp.send();
}

/**
 * Make page snippet visible.
 */
function openClientInfo(){
    $("#client_dialog").fadeIn(); //плавное появление блока
}

/**
 * Make page snippet invisible.
 */
function closeClientInfo(){
    $("#client_dialog").fadeOut(); //плавное исчезание блока
}

/**
 * Fetch info from server AND post it into page.
 * @param id
 */
function getManagerInfo(id) {
    id = parseInt(id);
    if (id > 0) {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState === 4 && this.status === 200) {
                //очистим форму от старых данных
                cleanManagerInfo();
                //ответ сервера
                var json = JSON.parse(this.responseText);
                if (json === false) {
                    var errorText = 'Извините, не получилось получить данные об этом пользователе.';
                } else {
                    //заполнить поля о менеджере
                    var title = document.getElementById('title');
                    var surname = document.getElementById('surname');
                    var name = document.getElementById('name');
                    var email = document.getElementById('man_email');
                    var tel = document.getElementById('man_tel');
                    title.innerHTML = json.surname + ' ' + json.name;
                    surname.innerHTML = 'Фамилия менеджера: ' + json.surname;
                    name.innerHTML = 'Имя менеджера: ' + json.name;
                    email.innerHTML = 'Электронная почта менеджера: ' + json.email;
                    tel.innerHTML = 'Телефон менеджера: ' + json.tel;
                }
                openManagerInfo();
            }
        };
        xhttp.open("GET", Routing.generate('info_manager', {'id': id}));
        xhttp.send();
    }
    
}

/**
 * Make page snippet visible.
 */
function openManagerInfo(){
    $("#manager_dialog").fadeIn(); //плавное появление блока
}

/**
 * Make page snippet invisible.
 */
function closeManagerInfo(){
    $("#manager_dialog").fadeOut(); //плавное исчезание блока
}

