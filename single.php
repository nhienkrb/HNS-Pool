<?php

if (in_category('tin-tuc')) {
    get_template_part('single', 'news');        
}

elseif (in_category('dich-vu')) {
    get_template_part('single', 'service');    
}

elseif (in_category('du-an')) {
    get_template_part('single', 'project');    
}

else {
    get_template_part('single', 'default');    
}
