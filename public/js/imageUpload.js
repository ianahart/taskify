const uploadBox = document.querySelector('.upload-box');
const uploadFile = document.querySelector('#upload');
const label = document.querySelector('label[for="upload"]');
const uploadIcon = document.querySelector('.upload-icon');
const uploadPlusIcon = document.querySelector('.upload-plus-icon');

const preventDefaults = (e) => {
  e.preventDefault();
  e.stopPropagation();
}

const highlightBox = () => {
  uploadBox.classList.add('highlight');
  uploadIcon.classList.add('hidden');
  uploadPlusIcon.classList.remove('hidden');
  label.textContent = 'Drop!'

}

const unhighlightBox = () => {
  uploadBox.classList.remove('highlight');
    uploadIcon.classList.remove('hidden');
  uploadPlusIcon.classList.add('hidden');
  label.textContent = 'Choose an image or drag it here';
}

['drop', 'dragenter', 'dragover', 'dragleave'].forEach((eventName) => {
  uploadBox.addEventListener(eventName, preventDefaults, false);
});

['dragenter', 'dragover'].forEach((eventName) => {
  uploadBox.addEventListener(eventName, highlightBox, false);
});

['dragleave', 'drop'].forEach((eventName) => {
  uploadBox.addEventListener(eventName, unhighlightBox, false);
});

uploadBox.addEventListener('drop', (e) => {
   uploadFile.files = e.dataTransfer.files;
   label.textContent = 'Upload success';
   uploadPlusIcon.classList.add('hidden');
});