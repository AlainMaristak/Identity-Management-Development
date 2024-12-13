<?php
$current_page = basename($_SERVER['PHP_SELF']);
if ($current_page !== 'index.php' && $current_page !== 'index_original.php') {
echo ("
    </div>
</div>
<script src='./assets/bootstrap/js/bootstrap.bundle.min.js'></script>
<script src='./assets/js/gpt.js'></script>
<script src='./assets/js/main.js'></script>
");
} 
footerjs();
echo "</body> </html>";
