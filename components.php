<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if(!function_exists('add_button')){
    function add_button($link, $label = "Add New",$show_mobile=true) {
        if (!isset($_SESSION['role'])) return;
        $allowed_roles = ['admin','teacher','professor','principal','director'];
        if (!in_array($_SESSION['role'], $allowed_roles)) return;

       // Desktop Add Button
echo '
<a href="'.htmlspecialchars($link).'" 
   class="hidden sm:inline-flex items-center gap-2 bg-gradient-to-r from-blue-600 to-collegeblue 
          text-white font-semibold text-sm px-6 py-2.5 rounded-full shadow-md hover:shadow-lg 
          hover:from-blue-700 hover:to-blue-900 transition-all duration-300">
  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" 
       stroke-width="2" stroke="currentColor" class="w-5 h-5">
    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
  </svg>
  '.htmlspecialchars($label).'
</a>
';

//  Mobile Floating Button — show only if $show_mobile is true
if ($show_mobile) {
  echo '
  <a href="'.htmlspecialchars($link).'" 
     class="sm:hidden fixed bottom-6 right-6 flex items-center justify-center w-14 h-14 
            bg-gradient-to-r from-blue-600 to-collegeblue text-white rounded-full shadow-lg 
            hover:shadow-xl hover:scale-110 transition-all duration-300 z-50">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" 
         stroke-width="2" stroke="currentColor" class="w-7 h-7">
      <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
    </svg>
  </a>
  ';
}
    }
}
?>
