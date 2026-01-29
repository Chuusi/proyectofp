<?php
if (!empty($_SESSION['contentAlert'])) {
    $msg = $_SESSION['contentAlert'];
    echo "
            <script>
                Swal.fire({
                    icon: '{$msg['icon']}',
                    title: '{$msg['title']}',
                    text: '{$msg['text']}'
                });
            </script>
            ";
    unset($_SESSION['contentAlert']);
}
