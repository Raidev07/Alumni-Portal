<?php if(isset($_SESSION['flash'])): ?>
<script>
document.addEventListener("DOMContentLoaded", function () {

    Swal.fire({
        icon: "<?= $_SESSION['flash']['type']; ?>",
        title: "<?= $_SESSION['flash']['title']; ?>",
        text: "<?= $_SESSION['flash']['message']; ?>",
        confirmButtonColor: "#3085d6"
    });

});
</script>
<?php unset($_SESSION['flash']); endif; ?>