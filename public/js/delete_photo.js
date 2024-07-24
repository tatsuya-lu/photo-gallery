document.addEventListener('DOMContentLoaded', function() {
    const deleteButtons = document.querySelectorAll('.delete-photo');
    deleteButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            if (confirm('本当にこの写真を削除しますか？')) {
                this.closest('form').submit();
            }
        });
    });
});