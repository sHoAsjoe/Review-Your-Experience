console.log('update_input_admin_edit.js');

const imgInput = document.querySelector('input[name="imgInput"]');
const trailerInput = document.querySelector('.trailerMS');
const videoInput = document.querySelector('.videoMS');

imgInput.oninput = function () {
    const img = document.querySelector('.imgMS');
    img.src = imgInput.value;
}
trailerInput.oninput = function () {
    const currentTrailer = document.querySelector('.trailer');
    const changedTrailer = document.querySelector('.changedtrailer');
    currentTrailer.classList.add('d-none');
    changedTrailer.innerHTML = trailerInput.value;
}
videoInput.oninput = function () {
    const video = document.querySelector('.video');
    const changedVideo = document.querySelector('.changedvideo');
    video.classList.add('d-none');
    changedVideo.innerHTML = videoInput.value;
}
