const input = document.getElementById("image");
const previewArea = document.getElementById("preview-area");
const previewImg = document.getElementById("preview-image");
const previewName = document.getElementById("preview-name");

input.addEventListener("change", function (e) {
    const file = e.target.files[0];

    if (!file) {
        return;
    }

    previewName.textContent = file.name;

    const reader = new FileReader();
    reader.onload = function (event) {
        previewImg.src = event.target.result;
        previewArea.style.display = "block";
    };
    reader.readAsDataURL(file);
});
