function show() {
    var menu = document.getElementById('menu');
    
    if(menu.className == 'toggle') {
        menu.className = '';
    }
    else {
        menu.className = 'toggle';
    }
}

function loginValidation() {
    if (validation('user', 'Въведете потребителско име!') &&
            validation('pass', 'Въведете парола')) {
        submit('login');
    }
}

function registrationValidation() {
    if (validation('user', 'Въведете потребителско име!') &&
            validation('pass', 'Въведете парола') &&
            validation('pass2', 'Въведете парола')) {
        submit('register');
    }
}

function postValidate() {
    var select = document.getElementById('category-select');
    var option = select.options[select.selectedIndex].value;

    switch (option) {
        case 'joke':
            if (validation('title', 'Заглавието трябва да е попълнено!') &&
                    validation('content', 'Напишете съдържание!')) {
                submit('post');
            }
            break;
        case 'picture':
            if (validation('file', 'Изберете файл за качване!') &&
                    validation('pic-title', 'Напишете заглавие за картинката!')) {
                submit('post');
            }
            break;
        case 'video':
            if (validation('url', 'Поставете URL на клипа [YouTube]!') &&
                    validation('vid-title', 'Напишете заглавие за клипа!')) {
                submit('post');
            }
            break;
    }
}

function validation(id, text) {
    var element = document.getElementById(id);
    var valid = true;

    if (element) {
        if (!element.value) {
            element.className = 'formee-error';
            displayMessage('formee-msg-error', text);

            remove('formee-msg-error', 4000);

            valid = false;
        }
        else {
            element.className = '';
        }
    }

    return valid;
}

function submit(id) { // TODO: Submit on Enter pressed
    var button = document.getElementById(id);
    button.setAttribute('type', 'submit');
    button.click();
}

function displayMessage(type, text) {
    var message = document.createElement('div');
    message.setAttribute('class', type);
    message.innerHTML = text;

    var main = document.getElementsByTagName('main')[0];
    var form = document.getElementsByClassName('formee')[0];
    main.insertBefore(message, form); // Before content
    
    //main.appendChild(message); // After content
}

function remove(name, time) {
    var elements = document.getElementsByClassName(name);

    setTimeout(function() {
        for (var i = 0; i < elements.length; i++) {
            if (elements[i] && elements[i].parentElement) {
                elements[i].parentElement.removeChild(elements[i]);
            }
        }
    }, time);
}

function changeInputFormat() {
    var select = document.getElementById('category-select');
    var inputFiled = document.getElementById('input-field');
    var textField = document.getElementById('text-field');

    var option = select.options[select.selectedIndex].value;

    while (inputFiled.firstChild) {
        inputFiled.removeChild(inputFiled.firstChild);
    }
    while (textField.firstChild) {
        textField.removeChild(textField.firstChild);
    }

    switch (option) {
        case 'joke':
            inputFiled.appendChild(createInput('text', 'title', 'Заглавие...'));
            textField.appendChild(createTextarea('content'));
            break;
        case 'picture':
            inputFiled.appendChild(createInput('file', 'file', ''));
            textField.appendChild(createInput('text', 'pic-title', 'Заглавие...'));
            break;
        case 'video':
            inputFiled.appendChild(createInput('text', 'url', 'URL...'));
            textField.appendChild(createInput('text', 'vid-title', 'Заглавие...'));
            break;
    }
}

function createInput(type, name, placeholder) {
    var input = document.createElement('input');

    input.setAttribute('type', type);
    input.setAttribute('name', name);
    input.setAttribute('id', name);
    input.setAttribute('placeholder', placeholder);

    return input;
}

function createTextarea(name) {
    var textarea = document.createElement('textarea');

    textarea.setAttribute('id', name);
    textarea.setAttribute('name', name);

    return textarea;
}