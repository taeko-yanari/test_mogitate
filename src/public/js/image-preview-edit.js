document.addEventListener("DOMContentLoaded", function () {
    const input = document.getElementById("image");
    const previewImg = document.getElementById("preview-image");
    const previewName = document.getElementById("file-name-display");

    if (!input || !previewImg || !previewName) return;

    input.addEventListener("change", function (e) {
        const file = e.target.files[0];
        if (!file) return;

        previewName.textContent = file.name;

        const reader = new FileReader();
        reader.onload = function (event) {
            previewImg.src = event.target.result;
        };
        reader.readAsDataURL(file);
    });
});
