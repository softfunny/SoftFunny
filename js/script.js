function show() {
    var menu = document.getElementById('menu');
    menu.className === 'toggle' ? menu.className = '' : menu.className = 'toggle';
}

function validate(form) {
    return validateForms(form, 'input') && validateForms(form, 'textarea');
}

// Validate forms
function validateForms(form, tag) {
    var error = 'formee-msg-error';
    var minValue = 3;
    var maxValue = 30000;
    var arrInputs = form.getElementsByTagName(tag);

    for (var i = 0; i < arrInputs.length; i++) {
        var currentInput = arrInputs[i];
        var currentValue = currentInput.value;
        var name = currentInput.getAttribute('placeholder') || '';

        // Validate text fields 
        if (currentInput.type === 'text' || currentInput.type === 'password' || tag === 'textarea') {

            if (currentValue.length < minValue) {
                displayMessage(currentInput.id, error,
                        ('Полето "<strong>' + name + '</strong>" трябва да съдържа най-малко ' + minValue + ' символа!'));
                return false;
            }
            else if (currentValue.length > maxValue) {
                displayMessage(currentInput.id, error,
                        ('Полето "<strong>' + name + '</strong>" съдържа твърде много символи!'));
            }
            else {
                currentInput.className = '';
            }
        }
        else if (currentInput.type === 'file') { // Validate file uploads
            var validFileExtensions = ['.jpg', '.jpeg', '.bmp', '.png'];

            if (currentValue.length > 0) {
                var isValidFormat = false;

                for (var j = 0; j < validFileExtensions.length; j++) {
                    var currentExtension = validFileExtensions[j];

                    if (currentValue.substr(currentValue.length - currentExtension.length,
                            currentExtension.length).toLowerCase() === currentExtension.toLowerCase()) {
                        isValidFormat = true;
                        break;
                    }
                }

                if (!isValidFormat) {
                    var name = currentValue.split('\\').pop();

                    displayMessage(currentInput.id, error,
                            ('Съжаляваме, <strong>' + name + '</strong> е с невалиден формат!<br>\n\
                        Позволените формати са: <small>' + validFileExtensions.join(' ') + '</small>'));
                    return false;
                }
                else {
                    currentInput.className = '';
                }
            }
            else {
                displayMessage(currentInput.id, error, 'Изберете файл за качване!');
                return false;
            }
        }
    }

    return true;
}

// Display error messages
function displayMessage(field, type, text) {

    var message = document.createElement('div');
    message.setAttribute('class', type);
    message.innerHTML = text;

    var input = document.getElementById(field);
    input.className = 'formee-error';

    var main = document.getElementsByTagName('main')[0];
    var form = document.getElementsByClassName('formee')[0];

    if (!document.getElementsByClassName('formee-msg-error')[0]) {
        main.insertBefore(message, form); // Before content  

        setTimeout(function() { // Remove message after 4 seconds
            main.removeChild(message);
        }, 4000);
    }
}

// Dynamically change forms in post page
function changeInputFormat() {
    var select = document.getElementById('category-select');
    var inputFiled = document.getElementById('input-field');
    var textField = document.getElementById('text-field');
    var form = document.getElementsByTagName('form')[0];

    var option = select.options[select.selectedIndex].value;

    while (inputFiled.firstChild) {
        inputFiled.removeChild(inputFiled.firstChild);
    }
    while (textField.firstChild) {
        textField.removeChild(textField.firstChild);
    }

    switch (option) {
        case 'jokes':
            form.removeAttribute('enctype');
            inputFiled.appendChild(createInput('input', 'text', 'title', 'Заглавие'));
            textField.appendChild(createInput('textarea', '', 'content', 'Публикация'));
            break;
        case 'pictures':
            form.setAttribute('enctype', 'multipart/form-data');
            inputFiled.appendChild(createInput('input', 'file', 'file', ''));
            textField.appendChild(createInput('input', 'text', 'pic-title', 'Заглавие'));
            break;
        case 'video':
            form.removeAttribute('enctype');
            inputFiled.appendChild(createInput('input', 'text', 'url', 'URL'));
            textField.appendChild(createInput('input', 'text', 'vid-title', 'Заглавие'));
            break;
    }
}

// Create input forms
function createInput(tag, type, name, placeholder) {
    var input = document.createElement(tag);

    if (tag !== 'textarea') {
        input.setAttribute('type', type);
    }

    input.setAttribute('name', name);
    input.setAttribute('id', name);
    input.setAttribute('placeholder', placeholder);

    return input;
}