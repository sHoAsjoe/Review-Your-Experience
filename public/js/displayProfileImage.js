const input = document.querySelector('.input');
const inputDiv = document.querySelector('.input-div');
const icon = document.querySelector('.icon');
const responseImage = document.querySelector('.response-image');
const imageContainer = document.querySelector('.img-container');

input.addEventListener('change', updateImageDisplay);

function updateImageDisplay() {
    const curFiles = input.files;
    for (const file of curFiles) {
        const para = document.querySelector('.info');

        if (validFileType(file)) {
            console.log(URL.createObjectURL(file))
            const image = `<img class="w-75 h-75 rounded-circle" src="${URL.createObjectURL(file)}" alt="">`;
            imageContainer.innerHTML = image;
            para.innerHTML = `<p class="fs-6">File name: ${file.name}<br>File size: ${returnFileSize(file.size)}.</p>`;
            document.querySelector('.getImage').value = URL.createObjectURL(file);
        } else {
            imageContainer.innerHTML = '';
            para.innerHTML = `<p class="fs-6">File name: ${file.name}<br><span class="bg-danger rounded">Not a valid file type. Update your selection.</span></p>`;
        }
    }
}
const fileTypes = [
    'image/jpeg',
    'image/pjpeg',
    'image/png',
    'image/svg',
];

function validFileType(file) {
    return fileTypes.includes(file.type);
}

function returnFileSize(number) {
    if (number < 1024) {
        return number + 'bytes';
    } else if (number >= 1024 && number < 1048576) {
        return (number / 1024).toFixed(1) + 'KB';
    } else if (number >= 1048576) {
        return (number / 1048576).toFixed(1) + 'MB';
    }
}