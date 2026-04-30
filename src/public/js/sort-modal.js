document.addEventListener("DOMContentLoaded", () => {
    const resetBtn = document.querySelector("[data-sort-reset]");

    if (!resetBtn) return;

    resetBtn.addEventListener("click", () => {
        const url = new URL(window.location.href);

        url.searchParams.delete("sort");

        window.location.href = url.toString();
    });
});
