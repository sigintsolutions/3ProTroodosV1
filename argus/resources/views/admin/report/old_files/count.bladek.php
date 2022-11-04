<?php

if ($count==0){?>
<div id="datalable0"></div>

<?php }

for($i=0;$i<$count;$i++) { ?>
	<div style="width:100%;overflow-x:scroll;scrollbar-color: #cacaca white;scrollbar-width:thin;">
<div id="datalable<?php echo $i;?>" style="width:5000px;overflow-x:scroll;overflow-y:hidden;"></div></div>
<?php }?>