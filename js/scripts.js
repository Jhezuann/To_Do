document.addEventListener("DOMContentLoaded", function() {
    const taskItems = document.querySelectorAll(".task-item");

    taskItems.forEach(item => {
        item.addEventListener("click", function() {
            const taskId = this.getAttribute("data-id");
            window.location.href = `edit_task.php?id=${taskId}`;
        });
    });
});
