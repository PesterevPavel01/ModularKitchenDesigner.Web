$('#blueprint-files').on('change', function(e) {
    
    const files = e.target.files;
    
    const filesList = $('#selected-files-list')[0];
    
    filesList.innerHTML = '';
    
    if (files.length > 0) {

        console.log(Array.from(files));

        Array.from(files).forEach((file, index) => {

            const fileElement = createFileElement(file, index);

            filesList.appendChild(fileElement);

        });
        
        if (!document.getElementById('clear-all-files')) {

            const clearAllBtn = document.createElement('button');
            clearAllBtn.type = 'button';
            clearAllBtn.id = 'clear-all-files';
            clearAllBtn.className = 'btn btn-outline-danger btn-sm mt-2';
            clearAllBtn.innerHTML = '<i class="bi bi-x-circle"></i> Очистить все файлы';
            clearAllBtn.onclick = clearAllFiles;
            filesList.appendChild(clearAllBtn);

        }

    } else {

        filesList.innerHTML = '<div class="text-muted">Файлы не выбраны</div>';

    }
});


$('#new-blueprint-files').on('change', function(e) {

    const files = e.target.files;

    if (files.length > 0) {

        addFilesIntoBlueprintFiles(files);
    }

})

function addFilesIntoBlueprintFiles(files) {
        
    const fileInput = $('#blueprint-files')[0];
    
    const existingFiles = Array.from(fileInput.files);
    
    const dt = new DataTransfer();
        
    existingFiles.forEach(x => dt.items.add(x));

    const newFiles = Array.from(files);

    newFiles.forEach(x => dt.items.add(x));
        
    fileInput.files = dt.files;
       
    fileInput.dispatchEvent(new Event('change'));
}


// Создание элемента для отображения файла
function createFileElement(file, index) {
    
    const fileSize = (file.size / 1024 / 1024).toFixed(2);

    const fileElement = document.createElement('div');

    fileElement.className = 'file-item alert alert-light d-flex justify-content-between align-items-center mb-2';

    fileElement.innerHTML = `
        <div class="file-info">
            <strong>${file.name}</strong>
            <small class="text-muted d-block">${fileSize} MB</small>
        </div>
        <button type="button" class="btn-close btn-sm" onclick="removeSingleFile(${index})"></button>
    `;
    return fileElement;
}

// Удаление одного файла из списка
function removeSingleFile($index) {

    const modal = $('#order-blueprints-modal');

    modal.find('#new-blueprint-files').val('');

    const fileInput = modal.find('#blueprint-files')[0];

    const files = Array.from(fileInput.files);
    
    files.splice($index, 1);
    
    const dt = new DataTransfer();

    files.forEach(x => dt.items.add(x));
    
    fileInput.files = dt.files;
    
    $(fileInput).trigger('change');
}

function addSingleFile(fileUrl) {

    const modal = $('#order-blueprints-modal');
        
    const fileInput = modal.find('#blueprint-files')[0];

    const file = new File([], fileUrl.split('/').pop());
    
    const files = Array.from(fileInput.files);
    
    const dt = new DataTransfer();
        
    files.forEach(x => dt.items.add(x));

    dt.items.add(file);
        
    fileInput.files = dt.files;
        
    $(fileInput).trigger('change');
}

document.addEventListener('DOMContentLoaded', function() {

    const modal = $('#order-blueprints-modal');

    modal.on('show.bs.modal', function(event) {
        
        resetModal();

        $('#order-blueprints-form-module-code').val(''); 

        var button = event.relatedTarget;

        var moduleCode = button.getAttribute('data-bs-module-code');

        var componentCode = button.getAttribute('data-bs-component-code');

        var blueprints = button.getAttribute('data-bs-blueprints');

        if(blueprints != ""){

            var existingFiles = JSON.parse(blueprints);
            
            var filesArray = Object.values(existingFiles);

            filesArray.forEach(file => addSingleFile(file.value));

        }

        $('#order-blueprints-form-component-code').val(componentCode);

        $('#order-blueprints-form-module-code').val(moduleCode);

        $('#order-blueprints-form-module-files').val(blueprints);

        $('#order-blueprints-form-component-code-vasible').text("Код компонента: " + componentCode);

        if (!$.trim(componentCode)){

            $('#order-blueprints-form-component-code-vasible').text("Новый компонент!");

        }else{

            $('#order-blueprints-form-component-code-vasible').text("Код компонента: " + componentCode);
            
        }
    });
    
    // Очистка при закрытии модального окна
    modal.on('hidden.bs.modal', function() {
        resetModal();
    });
});


function clearAllFiles() {

    const modal = $('#order-blueprints-modal');
    
    modal.find('input[type="file"]').val('');

    modal.find('#blueprint-files').trigger('change');

}

function resetModal() {

    clearAllFiles();

    const modal = $('#order-blueprints-modal');
    
    modal.find('#file-description').val('');

    //console.log(modal.find('#order-blueprints-form-modal-result'));

    modal.find('#order-blueprints-form-modal-result').text('');
    
    modal.find('#selected-files-list').innerHTML = '<div class="text-muted">Файлы не выбраны</div>';
    
    modal.find('#upload-result').innerHTML = '';
}