<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<?php 
if(isset($_GET['error']) && isset($_GET['type'])){
    $error = htmlspecialchars($_GET['error'], ENT_QUOTES, 'UTF-8');
    $type = htmlspecialchars($_GET['type'], ENT_QUOTES, 'UTF-8');

    if(in_array($type, ['error', 'success', 'info', 'warning'])) {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                toastr.$type('$error', {timeOut: 20000});
                var url = new URL(window.location.href);
                url.searchParams.delete('error');
                url.searchParams.delete('type');
                window.history.replaceState({}, document.title, url.toString());
            });
        </script>";
    }
}
?>
