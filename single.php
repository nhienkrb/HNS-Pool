<?php

if (in_category('tin-tuc')) {
    get_template_part('single', 'news');        
}

elseif (in_category('goc-tu-van')) {
    get_template_part('single', 'advisory');    
}

else {
    get_template_part('single', 'default');    
}
