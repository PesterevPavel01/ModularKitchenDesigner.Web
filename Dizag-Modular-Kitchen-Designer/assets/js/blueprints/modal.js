function InitBlueprintsModal(modalId){

    const modal = $(modalId);

    modal.find('input[name="BLUEPRINTS[]"]').off('change').on('change', function(e) {
        
        const files = e.target.files;
        
        const filesList = modal.find('.selected-files-list')[0];
        
        filesList.innerHTML = '';

        if (files.length > 0) {

            Array.from(files).forEach((file, index) => {

            const fileElement = createBlueprintFileElement(file, index, modal);

            filesList.appendChild(fileElement);});
            
            if (!document.getElementById('clear-all-milling-files')) {

                const clearAllBtn = document.createElement('button');

                clearAllBtn.type = 'button';

                clearAllBtn.id = 'clear-all-milling-files';

                clearAllBtn.className = 'btn btn-outline-danger btn-sm mt-2';

                clearAllBtn.innerHTML = '<i class="bi bi-x-circle"></i> Очистить все файлы';

                clearAllBtn.onclick = function() {

                    clearAllBluerintFiles(modal);

                };

                filesList.appendChild(clearAllBtn);

            }

        } else {

            filesList.innerHTML = '<div class="text-muted">Файлы не выбраны</div>';

        }
    });

    modal.on('show.bs.modal',  async function(event) {
        
        resetBlueprintModal(modal);

        var button = event.relatedTarget;

        var componentCode = button.getAttribute('data-bs-component-code');

        var blueprints = button.getAttribute('data-bs-blueprints');

        if(blueprints != ""){

            var existingFiles = JSON.parse(blueprints);
            
            var filesArray = Object.values(existingFiles);
    
            // Получаем массив URL
            const urls = filesArray.map(file => file.value);
    
            const files = await urlsToFiles(urls);
    
            addFilesIntoBlueprintFiles(files, modal);
        }

        modal.find('input[name="COMPONENT_CODE"]').val(componentCode);

        if (!$.trim(componentCode)){

            $(this).find('.component-code-vasible').text("Новый компонент!");

        }else{

            $(this).find('.component-code-vasible').text("Код компонента: " + componentCode);
            
        }
    });
    
    // Очистка при закрытии модального окна
    modal.on('hidden.bs.modal', function() {

        resetBlueprintModal(modal);

    })

    modal.find('input[name="NEW_BLUEPRINTS[]"]').on('change', function(e) {

        const files = e.target.files;
    
        if (files.length > 0) {
    
            addFilesIntoBlueprintFiles(files, modal);
        }
    
    })
}

function resetBlueprintModal(modal) {

    clearAllBluerintFiles(modal);
    
    modal.find('.order-blueprints-form-modal-result').text('');
    
    modal.find('.selected-files-list').innerHTML = '<div class="text-muted">Файлы не выбраны</div>';
}

function addFilesIntoBlueprintFiles(files, modal) {
        
    const fileInput = modal.find('input[name="BLUEPRINTS[]"]')[0];
    
    const existingFiles = Array.from(fileInput.files);
    
    const dt = new DataTransfer();
        
    existingFiles.forEach(x => dt.items.add(x));

    const newFiles = Array.from(files);

    newFiles.forEach(x => dt.items.add(x));
        
    fileInput.files = dt.files;
       
    fileInput.dispatchEvent(new Event('change'));
}

// Функция для загрузки одного файла по URL и преобразования в File
async function urlToFile(fileUrl) {

    const response = await fetch(fileUrl);

    const blob = await response.blob();

    return new File([blob], fileUrl.split('/').pop(), {

        type: blob.type,

        lastModified: new Date().getTime()

    });
}

// Функция для загрузки массива файлов
async function urlsToFiles(urls) {

    return Promise.all(urls.map(url => urlToFile(url)));

}

// Создание элемента для отображения файла
function createBlueprintFileElement(file, index, modal) {
    
    const fileSize = (file.size / 1024 / 1024).toFixed(2);

    const fileElement = $('<div>', {
        class: 'file-item alert alert-light d-flex justify-content-between align-items-center mb-2'
    });
    
    const fileInfo = $('<div>', { class: 'file-info' })
        .append($('<strong>').text(file.name))
        .append($('<small>', { 
            class: 'text-muted d-block' 
        }).text(fileSize + ' MB'));
    
    const removeBtn = $('<button>', {
        type: 'button',
        class: 'btn-close btn-sm'
    }).on('click', function() {
        removeBlueprintSingleFile(index, modal);
    });
    
    fileElement.append(fileInfo, removeBtn);

    return fileElement[0];
}

// Удаление одного файла из списка
function removeBlueprintSingleFile(index, modal) {

    //const modal = $('#' + modalId);

    modal.find('input[name="NEW_BLUEPRINTS[]"]').val('');

    const fileInput = modal.find('input[name="BLUEPRINTS[]"]')[0];

    const files = Array.from(fileInput.files);
    
    files.splice(index, 1);
    
    const dt = new DataTransfer();

    files.forEach(x => dt.items.add(x));
    
    fileInput.files = dt.files;
    
    $(fileInput).trigger('change');
}

function clearAllBluerintFiles(modal) {
    
    modal.find('input[type="file"]').val('');

    modal.find('input[name="BLUEPRINTS[]"]').trigger('change');
}